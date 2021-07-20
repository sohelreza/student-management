import React, { Component } from "react";
import { Link } from "react-router-dom";

import NoDataFound from "../NoDataFound/NoDataFound";
import { Header } from "../Header/Header";
import Footer from "../Footer/Footer";
import ExamQus from "../../models/ExamQus";
import Loading from "../Loading/Loading";
import { SideBar } from "../SideBar/SideBar";
import paymentInfo from "../../models/paymentInfo";

class CqExamList extends Component {
    constructor(props) {
        if (
            !localStorage.getItem("token") &&
            localStorage.getItem("expire") > 86400
        ) {
            window.location.href = "/login";
        }
        super(props);
        var today = new Date(),
            // time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        time =
            ((today.getHours() < 10) ? "0" : "") +
            today.getHours() +
            ":" +
            ((today.getMinutes() < 10) ? "0" : "") + today.getMinutes() +
            ":" +
            ((today.getSeconds() < 10) ? "0" : "") + today.getSeconds();
        this.state = {
            student_id: "",
            examList: null,
            time: time,
            date: new Date().toJSON().slice(0, 10),
        };
        window.scrollTo(0, 0);
    }


    componentWillUnmount() {
        clearInterval(this.timerID);
      }
    
      tick() {
        this.setState({
          time: ((new Date().getHours()<10) ? ('0'+new Date().getHours()) : (new Date().getHours())) +
                ":" +
                (new Date().getMinutes()<10 ? '0'+new Date().getMinutes():new Date().getMinutes()) +
                ":" +
                (new Date().getSeconds()<10 ? '0'+new Date().getSeconds():new Date().getSeconds())
        });
      }

    componentDidMount() {
        // checking for the student information using token
        if (localStorage.getItem("token")) {
            var x = JSON.parse(localStorage.getItem("token"));
            axios
                .get("http://127.0.0.1:8000/student/student_profile/", {
                    headers: {
                        Authorization: `Bearer${x}`
                    }
                })
                // setting up the student id to state
                .then(res => {
                    this.setState({
                        student_id: res.data.id
                    });
                    let data = {
                        student_id: res.data.id,
                    }
                    paymentInfo.checkTxId(data).then(res => {
                        if (res.data.admin_transaction_id === null) {
                            window.location.href = "/dashboard";
                        }
                    });
                    // console.log(
                    //     this.state.student_id + "is updated to the state"
                    // );

                    // if no user profile found, then push back to the profile page
                    if (res.data.profile === null) {
                        window.location.href = "/profile";
                    }
                    else if (res.data.next_payment_date === null || res.data.next_payment_date < this.state.date) {
                        window.location.href = "/dashboard";
                    }
                    else {
                        //getting the ExamList information using student id
                        let data = {
                            student_id: this.state.student_id
                        };
                        ExamQus.getCqExamList(data).then(res => {
                            this.setState({ examList: res.data });
                        });
                    }
                });
        }

        this.timerID = setInterval(
            () => this.tick(),
            1000
          );

        // console.log(
        //     "component did mount end and the student id is",
        //     this.state.student_id
        // );
    }

    // getting the name of the day from the date
    getTheDay(dateParam) {
        let fullDate = new Date(dateParam);
        let day = fullDate.toDateString();
        return day;
    }

    // getting the formatted time from the full time
    getTheTime(dateParam) {
        let fullTime = new Date(dateParam);
        let time = fullTime.toLocaleTimeString();
        return time;
    }

    // rendering the loading or no exam data
    noDataAvailable() {
        return (
            <>
                <p>No Exam Data</p>
            </>
        );
    }
    //start time end time convert to am pm
    convertTime(time) {
        var time = time.split(":");
        var hours = time[0];
        var minutes = time[1];
        var ampm = hours >= 12 ? "pm" : "am";
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? "0" + minutes : minutes;
        var strTime = hours + ":" + minutes + " " + ampm;
        return strTime;
    }
    // rendering the live class data
    getTheClassData() {
        return (
            <>
                {this.state.examList.length === 0 ? (
                    <NoDataFound noDataFoundMessage="No Exam Available yet" />
                ) : (
                        <div className="horizontal-scroll table-responsive">
                            <table className="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Exam Title</th>
                                        <th scope="col">Subject Name</th>
                                        <th scope="col">Day & Date</th>
                                        <th scope="col">Start time</th>
                                        <th scope="col">End time</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Exam mark</th>
                                        <th scope="col">Action</th>
                                        {/* <th scope="col">Class</th>
                                                <th scope="col">Batch</th>
                                                <th scope="col">Teacher</th> */}
                                    </tr>
                                </thead>
                                <tbody>
                                    {this.state.examList.map(data => {
                                        return (
                                            <tr key={data.id}>
                                                <td>{data.name}</td>
                                                <td>{data.subject_name}</td>
                                                <td>
                                                    {this.getTheDay(data.exam_date)}
                                                </td>
                                                <td>
                                                    {this.convertTime(
                                                        data.start_time
                                                    )}
                                                </td>
                                                <td>
                                                    {this.convertTime(
                                                        data.end_time
                                                    )}
                                                </td>
                                                <td>
                                                    {data.total_exam_duration
                                                        ? data.total_exam_duration +
                                                        " minutes"
                                                        : ""}
                                                </td>
                                                <td className="text-center">
                                                    {data.total_exam_marks}
                                                </td>
                                                <td>
                                                    <Link
                                                        className={
                                                            "btn btn-primary class-join-action " +
                                                            (data.exam_date ==
                                                                this.state.date &&
                                                                data.start_time <=
                                                                this.state.time &&
                                                                data.end_time >=
                                                                this.state.time &&
                                                                data.attendance == null
                                                                ? ""
                                                                : "disabled")
                                                        }
                                                        to={{
                                                            pathname: "/cq-exam",
                                                            state: {
                                                                id: data.id,
                                                                student_id: this
                                                                    .state
                                                                    .student_id
                                                            }
                                                        }}
                                                    >
                                                        Exam
                                                </Link>
                                                    {/* <a
                                                    className={
                                                        "btn btn-primary class-join-action " +
                                                        (data.exam_date
                                                            ? ""
                                                            : "disabled")
                                                    }
                                                    href="`/exam/+${data.id}`"
                                                    // onClick={this.handleClick.bind(this,data.id)}
                                                    role="button"
                                                >
                                                   Exam
                                                </a> */}
                                                </td>

                                                {/* <td>
                                                                {data.class}
                                                            </td>
                                                            <td>
                                                                {data.batch}
                                                            </td> */}
                                            </tr>
                                        );
                                    })}
                                </tbody>
                            </table>
                        </div>
                    )}
            </>
        );
    }

    render() {
        return (
            <div className="join-class-background">
                <Header />
                <div className="height-top"></div>
                <div className="container-fluid">
                    <div className="app-margin">
                        <div className="row">
                            <div className="col-md-3 d-none d-md-block d-lg-block d-xl-block">
                                <SideBar />
                            </div>
                            <div className="col-md-9">
                                <div className="live-class-content"></div>
                                <div className="app-background mb-3">
                                    <h2 className="text-center component-header">
                                        Exam List
                                    </h2>
                                    <div className="heading-underline"></div>
                                    <p className="text-center">
                                        Here you can see all of your Exam List.
                                    </p>
                                </div>
                                <div className="app-background">
                                    <h4 className="text-center mt-2 component-sub-header">
                                        Exam List
                                    </h4>
                                    <div className="content-underline mb-4"></div>

                                    {this.state.examList ? (
                                        this.getTheClassData()
                                    ) : (
                                            <Loading />
                                        )}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <Footer />
            </div>
        );
    }
}
export default CqExamList;

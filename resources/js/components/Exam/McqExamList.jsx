import React, { Component } from "react";
import { Link } from "react-router-dom";

import NoDataFound from "../NoDataFound/NoDataFound";
import { Header } from "../Header/Header";
import Footer from "../Footer/Footer";
import ExamQus from "../../models/ExamQus";
import Loading from "../Loading/Loading";
import { SideBar } from "../SideBar/SideBar";

class McqExamList extends Component {
    constructor(props) {
        if (
            !localStorage.getItem("token") &&
            localStorage.getItem("expire") > 86400
        ) {
            window.location.href = "/login";
        }
        super(props);
        var today = new Date(),
            time =
                today.getHours() +
                ":" +
                today.getMinutes() +
                ":" +
                today.getSeconds();
        this.state = {
            student_id: "",
            mcqExamList: null,
            // date:
            //     new Date().getFullYear() +
            //     "-" +
            //     (new Date().getMonth() + 1) +
            //     "-" +
            //     new Date().getDate(),.replace(/-/g, '/')
            date: new Date().toJSON().slice(0, 10),
            time: time
        };
        window.scrollTo(0, 0);
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

                    // console.log(
                    //     this.state.student_id + "is updated to the state"
                    // );

                    // if no user profile found, then push back to the profile page
                    if (res.data.profile === null) {
                        window.location.href = "/profile";
                    } else {
                        //getting the ExamList information using student id
                        let data = {
                            student_id: this.state.student_id
                        };
                        ExamQus.getMcqResult(data).then(res => {
                            this.setState({ mcqExamList: res.data });
                        });
                    }
                });
        }

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
                {this.state.mcqExamList.length === 0 ? (
                    <NoDataFound noDataFoundMessage="No Result Available yet" />
                ) : (
                    <div className="horizontal-scroll table-responsive">
                        <table className="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Exam title</th>
                                    <th scope="col">Subject Name</th>
                                    <th scope="col">Day & Date</th>
                                    {/* <th scope="col">Start time</th>
                                        <th scope="col">End time</th>
                                        <th scope="col">Duration</th> */}
                                    <th scope="col">Exam mark</th>
                                    <th scope="col">Mark</th>
                                    <th scope="col">Rank Sheet</th>
                                    <th scope="col">Answer Sheet</th>
                                    {/* <th scope="col">Class</th>
                                                <th scope="col">Batch</th>
                                                <th scope="col">Teacher</th> */}
                                </tr>
                            </thead>
                            <tbody>
                                {this.state.mcqExamList.map(data => {
                                    return (
                                        <tr key={data.id}>
                                            <td>{data.name}</td>
                                            <td>{data.subject_name}</td>
                                            <td>
                                                {this.getTheDay(data.exam_date)}
                                            </td>
                                            <td className="text-center">
                                                {data.total_exam_marks}
                                            </td>
                                            <td className="text-center">
                                                {data.score}
                                            </td>
                                            <td>
                                                <Link
                                                    className={
                                                        "btn btn-primary class-join-action " +
                                                        (data.publish_answer ==
                                                        1
                                                            ? ""
                                                            : "disabled")
                                                    }
                                                    to={{
                                                        pathname: "/mcq-rank",
                                                        state: {
                                                            id: data.id,
                                                            student_id: this
                                                                .state
                                                                .student_id,
                                                            examTitle:
                                                                data.name,
                                                            subjectName:
                                                                data.subject_name,
                                                            examDate:
                                                                data.exam_date,
                                                            class:
                                                                data.class_name
                                                        }
                                                    }}
                                                >
                                                    show
                                                </Link>
                                            </td>
                                            <td>
                                                <Link
                                                    className={
                                                        "btn btn-primary class-join-action " +
                                                        (data.publish_answer ==
                                                        1
                                                            ? ""
                                                            : "disabled")
                                                    }
                                                    to={{
                                                        pathname: "/mcq-answer",
                                                        state: {
                                                            id: data.id,
                                                            student_id: this
                                                                .state
                                                                .student_id
                                                        }
                                                    }}
                                                >
                                                    show
                                                </Link>
                                            </td>
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
                                        MCQ Exam Result List
                                    </h2>
                                    <div className="heading-underline"></div>
                                    <p className="text-center">
                                        Here you can see all of your MCQ Exam
                                        Result List.
                                    </p>
                                </div>
                                <div className="app-background">
                                    <h4 className="text-center mt-2 component-sub-header">
                                        MCQ Exam Result List
                                    </h4>
                                    <div className="content-underline mb-4"></div>

                                    {this.state.mcqExamList ? (
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
export { McqExamList };

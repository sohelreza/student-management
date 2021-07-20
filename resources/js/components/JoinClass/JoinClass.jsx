import React, { Component } from "react";
import { Link } from "react-router-dom";

import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import Loading from "../Loading/Loading";
import { SideBar } from "../SideBar/SideBar";

import paymentInfo from "../../models/paymentInfo";
import Common from "../../models/Common";

import "./JoinClass.css";

class JoinClass extends Component {
    constructor(props) {
        if (
            !localStorage.getItem("token") &&
            localStorage.getItem("token") > 86400
        ) {
            window.location.href = "/login";
        }

        super(props);

        this.state = {
            liveClassData: null,
            student_id: null,
            date: new Date().toJSON().slice(0, 10)
        };

        this.getData();
        this.getTheDay.bind(this);
        this.getTheTime.bind(this);
        this.getTheClassData.bind(this);
        this.noDataAvailable.bind(this);
    }

    getData() {
        window.scrollTo(0, 0);

        // checking for the student information using token
        if (localStorage.getItem("token")) {
            var x = JSON.parse(localStorage.getItem("token"));

            axios
                .get("student/student_profile/", {
                    headers: {
                        Authorization: `Bearer${x}`
                    }
                })
                .then(res => {
                    let data = {
                        student_id: res.data.id
                    };

                    paymentInfo.checkTxId(data).then(res => {
                        if (res.data.admin_transaction_id === null) {
                            window.location.href = "/dashboard";
                        }
                    });

                    this.setState({
                        student_id: res.data.id
                    });

                    // if no user profile found, then push back to the profile page
                    if (res.data.profile === null) {
                        window.location.href = "/profile";
                    } else if (
                        res.data.next_payment_date == null ||
                        res.data.next_payment_date < this.state.date
                    ) {
                        window.location.href = "/dashboard";
                    } else {
                        //getting the meetings information using student id
                        return (
                            axios
                                .post("student/class_live_meetings", {
                                    student_id: this.state.student_id
                                })

                                // setting up the meetings information to the state
                                .then(res => {
                                    this.setState({
                                        liveClassData: res.data
                                    });
                                })
                        );
                    }
                });
        }
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

    // rendering the live class data
    getTheClassData() {
        return (
            <>
                {this.state.liveClassData.length === 0 ? (
                    this.noDataAvailable()
                ) : (
                    <>
                        <div className="horizontal-scroll table-responsive">
                            <table className="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Course Name</th>

                                        <th scope="col">Class Title</th>

                                        <th scope="col">Day & Date</th>

                                        <th scope="col">Time</th>

                                        <th scope="col">Action</th>

                                        <th scope="col">Duration</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    {this.state.liveClassData.map(data => {
                                        return (
                                            <tr key={data.id}>
                                                <td>{data.name}</td>

                                                <td>{data.topic}</td>

                                                <td>
                                                    {data.join_url
                                                        ? this.getTheDay(
                                                              data.when
                                                          )
                                                        : ""}
                                                </td>

                                                <td>
                                                    {data.join_url
                                                        ? this.getTheTime(
                                                              data.when
                                                          )
                                                        : ""}
                                                </td>

                                                <td>
                                                    <a
                                                        className={
                                                            "btn btn-primary class-join-action" +
                                                            (data.live_status ==
                                                            2
                                                                ? ""
                                                                : " disabled")
                                                        }
                                                        // href={data.join_url}
                                                        href="http://localhost:3000/"
                                                        // href={
                                                        //     Common.api +
                                                        //     "zoom-class"
                                                        // }
                                                        role="button"
                                                        target="_blank"
                                                    >
                                                        Join Class
                                                    </a>
                                                </td>

                                                <td>
                                                    {data.duration
                                                        ? data.duration +
                                                          " minutes"
                                                        : ""}
                                                </td>
                                            </tr>
                                        );
                                    })}
                                </tbody>
                            </table>
                        </div>

                        <div className="row justify-content-center pt-4">
                            <Link
                                student_id={this.state.student_id}
                                to={
                                    "/live-class-history/" +
                                    this.state.student_id
                                }
                            >
                                <button
                                    type="button"
                                    className="btn btn-success live-class-history-button"
                                >
                                    Live Class History
                                </button>
                            </Link>
                        </div>
                    </>
                )}
            </>
        );
    }

    // rendering the loading or no class data
    noDataAvailable() {
        return (
            <>
                <p>No Class Data</p>
            </>
        );
    }

    render() {
        // console.log("render join class and updated state is", this.state);

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
                                        Live Class Room
                                    </h2>

                                    <div className="heading-underline"></div>

                                    <p className="text-center">
                                        Here you can see all of your live
                                        classes status.
                                    </p>
                                </div>

                                <div className="app-background">
                                    <h4 className="text-center mt-2 component-sub-header">
                                        Live Classes Details
                                    </h4>

                                    <div className="content-underline mb-4"></div>

                                    {this.state.liveClassData ? (
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

export default JoinClass;

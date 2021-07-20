import React, { Component } from "react";

import { Link } from "react-router-dom";

import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import { SideBar } from "../SideBar/SideBar";
import Loading from "../Loading/Loading";

import { liveClassData } from "../../models/Common";

import "./LiveClassHistory.css";

class LiveClassHistory extends Component {
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
            student_id: null
        };
        this.getTheDay.bind(this);
        this.getTheTime.bind(this);
        this.getTheClassData.bind(this);
        this.noDataAvailable.bind(this);
    }

    componentDidMount() {
        window.scrollTo(0, 0);
        console.log("the props is", this.props);
        // console.log(
        //     "component did mount start and the student id in the state is",
        //     this.state.student_id
        // );

        // console.log(
        //     "the student id from parameter is",
        //     this.props.match.params.student_id
        // );

        if (this.state.student_id == null) {
            axios
                .post("http://127.0.0.1:8000/student/meetings", {
                    student_id: this.props.match.params.student_id
                })

                // setting up the meetings information to the state
                .then(res => {
                    // console.log(
                    //     "got the class data and waiting to update and the data is",
                    //     res.data
                    // );

                    this.setState({
                        student_id: this.props.match.params.student_id,
                        liveClassData: res.data
                    });

                    // console.log("live class data is updated to the state");
                });
        } else {
            console.log(this.state.student_id);
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
                                        <th scope="col">Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {this.state.liveClassData.map(data => {
                                        return (
                                            <tr key={data.id}>
                                                <td>{data.subjectname.name}</td>
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
                            <Link to={"/join-class"}>
                                <button
                                    type="button"
                                    className="btn btn-success live-class-history-button"
                                >
                                    Back To Join Class
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
                    <div className="live-class-margin">
                        <div className="row">
                            <div className="col-md-3">
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
                                    <h4 className="text-center mt-2 component-header">
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

export default LiveClassHistory;

import React, { Component } from "react";
import { Link } from "react-router-dom";

import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import Loading from "../Loading/Loading";
import { SideBar } from "../SideBar/SideBar";
import NoDataFound from "../NoDataFound/NoDataFound";

import CommonFunction from "../../helpers/CommonFunction";
import ClassRoutineApi from "../../models/ClassRoutineApi";
import paymentInfo from "../../models/paymentInfo";

import "./ClassRoutine.css";

class ClassRoutine extends Component {
    constructor(props) {
        if (
            !localStorage.getItem("token") &&
            localStorage.getItem("token") > 86400
        ) {
            window.location.href = "/login";
        }
        super(props);
        this.state = {
            classRoutineData: null,
            student_id: null
        };
    }

    componentDidMount() {
        // scrolling window screen to the top
        window.scrollTo(0, 0);
        // console.log(
        //     "component did mount start and the student id is",
        //     this.state.student_id
        // );

        // checking for the student information using token
        if (localStorage.getItem("token")) {
            let x = JSON.parse(localStorage.getItem("token"));

            let token = { headers: { Authorization: `Bearer${x}` } };

            ClassRoutineApi.getProfile(token)

                // setting up the student id to state
                .then(res1 => {
                    // console.log(
                    //     "got the student id and waiting to update and the data is",
                    //     res1.data
                    // );

                    let data = {
                        student_id: res1.data.id
                    };

                    paymentInfo.checkTxId(data).then(res2 => {
                        if (res2.data.admin_transaction_id === null) {
                            window.location.href = "/dashboard";
                        }
                    });

                    this.setState({ student_id: res1.data.id });
                    // console.log("student_id is updated to the state");

                    // if no user profile found, then push back to the profile page
                    if (res1.data.profile === null) {
                        window.location.href = "/profile";
                        // if payment date is over, then push back to the dashboard page
                    } else if (
                        res1.data.next_payment_date == null ||
                        res1.data.next_payment_date < this.state.date
                    ) {
                        window.location.href = "/dashboard";
                    } else {
                        let id = { student_id: this.state.student_id };
                        this.setState({
                            classRoutineData: ClassRoutineApi.getClassRoutine(
                                id
                            )
                        });
                        //getting the routine using student id
                        // return (
                        //     ClassRoutineApi.getClassRoutine(id)
                        //         // setting up the routine to the state
                        //         .then(res3 => {
                        //             console.log(
                        //                 "got the routine and waiting to update and the data is",
                        //                 res3.data
                        //             );

                        //             this.setState({
                        //                 classRoutineData: res3.data
                        //             });

                        //             console.log(
                        //                 "routines are updated to the state"
                        //             );
                        //         })
                        // );
                    }
                });
        }

        // console.log(
        //     "component did mount end and the student id is",
        //     this.state.student_id
        // );
    }

    getTheRoutine() {
        return (
            <>
                {this.state.classRoutineData.length === 0 ? (
                    <NoDataFound noDataFoundMessage="No Message Yet" />
                ) : (
                    <>
                        <table className="table table-bordered table-hover table-responsive-sm text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Topics</th>
                                    <th scope="col">Day</th>
                                    <th scope="col">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Physics</th>
                                    <td>Force</td>
                                    <td>10-01-2021, Sunday</td>
                                    <td>03:00 PM</td>
                                </tr>
                                <tr>
                                    <th>Chemistry</th>
                                    <td>Organic Chemistry</td>
                                    <td>11-01-2021, Monday</td>
                                    <td>05:00 PM</td>
                                </tr>
                                <tr>
                                    <th>Biology</th>
                                    <td>Cell</td>
                                    <td>12-01-2021, Tuesday</td>
                                    <td>07:00 PM</td>
                                </tr>
                            </tbody>
                        </table>
                    </>
                )}
            </>
        );
    }

    render() {
        // console.log("class routine data is", this.state.classRoutineData);

        return (
            <div style={{ backgroundColor: "#f1f1f1" }}>
                <Header />
                <div style={{ height: "70px" }}></div>
                <div className="container-fluid">
                    <div className="app-margin">
                        <div className="row">
                            <div className="col-md-3 d-none d-md-block d-lg-block d-xl-block">
                                <SideBar />
                            </div>
                            <div className="col-md-9">
                                <div className="content"></div>
                                <div className="app-background mb-3 ">
                                    <h2 className="text-center component-header">
                                        Class Routine
                                    </h2>
                                    <div className="heading-underline"></div>
                                    <p className="text-center">
                                        You can see your class routine here.
                                    </p>
                                </div>
                                <div className="app-background">
                                    <h4 className="text-center mt-2 component-sub-header">
                                        Class Routine
                                    </h4>
                                    <div className="content-underline mb-3"></div>
                                    {this.state.classRoutineData ? (
                                        this.getTheRoutine()
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

export default ClassRoutine;

import React, { Component } from "react";
import { Link } from "react-router-dom";

import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import Loading from "../Loading/Loading";
import NoDataFound from "../NoDataFound/NoDataFound";
import { SideBar } from "../SideBar/SideBar";

import CommonFunction from "../../helpers/CommonFunction";
import paymentInfo from "../../models/paymentInfo";
import Message from "../../models/Message";
// import { StudentContext } from "../../Context/StudentContext";

import "./Inbox.css";

class Inbox extends Component {
    constructor(props) {
        if (
            !localStorage.getItem("token") &&
            localStorage.getItem("token") > 86400
        ) {
            window.location.href = "/login";
        }
        super(props);
        this.state = {
            message: null,
            date: new Date().toJSON().slice(0, 10),
            student_id: null
        };
        this.getData();
    }

    getData() {
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

            Message.getProfile(token)

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
                        // if payment data is over, then push back to the dashboard page
                    } else if (
                        res1.data.next_payment_date == null ||
                        res1.data.next_payment_date < this.state.date
                    ) {
                        window.location.href = "/dashboard";
                    } else {
                        let id = { student_id: this.state.student_id };
                        //getting the messages using student id
                        return (
                            Message.getMessage(id)
                                // setting up the messages to the state
                                .then(res3 => {
                                    // console.log(
                                    //     "got the messages and waiting to update and the data is",
                                    //     res3.data
                                    // );

                                    this.setState({ message: res3.data });

                                    // console.log(
                                    //     "messages are updated to the state"
                                    // );
                                })
                        );
                    }
                });
        }

        // console.log(
        //     "component did mount end and the student id is",
        //     this.state.student_id
        // );
    }

    // rendering the live class data
    getTheMessage() {
        return (
            <>
                {this.state.message.length === 0 ? (
                    <NoDataFound noDataFoundMessage="No Message Yet" />
                ) : (
                    <>
                        <div id="accordion">
                            {this.state.message.map((data, index) => {
                                const uniqueId = CommonFunction.uniqueText(6);
                                const dayName = data.date
                                    ? CommonFunction.getTheDay(data.date)
                                    : "";
                                const monthName = data.date
                                    ? CommonFunction.getTheMonth(data.date)
                                    : "";
                                const onlyDate = data.date
                                    ? CommonFunction.getTheDate(data.date)
                                    : "";
                                const onlyYear = data.date
                                    ? CommonFunction.getTheYear(data.date)
                                    : "";
                                const fullDate =
                                    dayName +
                                    ", " +
                                    onlyDate +
                                    " " +
                                    monthName +
                                    ", " +
                                    onlyYear;
                                return (
                                    <div className="card" key={index}>
                                        <div
                                            className="card-header"
                                            id={"a" + uniqueId}
                                        >
                                            <button
                                                className="submit-button mr-3"
                                                data-toggle="collapse"
                                                data-target={"#" + uniqueId}
                                                aria-expanded="true"
                                                aria-controls="collapseOne"
                                            >
                                                Details
                                            </button>
                                            <span className="message-header">
                                                {data.title}
                                            </span>
                                            <p className="card-text float-right">
                                                <small className="text-muted">
                                                    {fullDate}
                                                </small>
                                            </p>
                                        </div>
                                        <div
                                            id={uniqueId}
                                            className="collapse show"
                                            aria-labelledby={"a" + uniqueId}
                                            data-parent="#accordion"
                                        >
                                            <div className="card-body">
                                                {data.message}
                                            </div>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    </>
                )}
            </>
        );
    }

    render() {
        // console.log(this.state.message);
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
                                        Inbox
                                    </h2>
                                    <div className="heading-underline"></div>
                                    <p className="text-center">
                                        You can see all messages for your
                                        profile here.
                                    </p>
                                </div>
                                <div className="app-background">
                                    <h4 className="text-center mt-2 component-sub-header">
                                        Message List
                                    </h4>
                                    <div className="content-underline mb-3"></div>
                                    {/* <NoDataFound noDataFoundMessage="coming soon" /> */}
                                    {this.state.message ? (
                                        this.getTheMessage()
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

export default Inbox;

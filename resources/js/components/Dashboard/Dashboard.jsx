import React, { Component } from "react";
import { Link } from "react-router-dom";

import paymentInfo from "../../models/paymentInfo";
import ProfileUpdate from "../../models/ProfileUpdate";
import DashboardApi from "../../models/DashboardApi";

import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import Loading from "../Loading/Loading";
import { SideBar } from "../SideBar/SideBar";

import "./Dashboard.css";

class Dashboard extends Component {
    constructor(props) {
        if (!localStorage.getItem("token")) {
            window.location.href = "/login";
        }
        super(props);
        this.state = {
            firstName: "",
            lastName: "",
            className: "",
            branchName: "",
            batchName: "",
            instituteName: "",
            phoneNumber: "",
            studentType: "",
            regId: "",
            nextPaymentDate: "",
            messageCount: null,
            liveClassCount: null,
            mcqExamCount: null,
            cqExamCount: null
        };
    }

    componentDidMount() {
        window.scrollTo(0, 0);
        if (localStorage.getItem("token")) {
            var x = JSON.parse(localStorage.getItem("token"));
            axios
                .get("http://127.0.0.1:8000/student/student_profile/", {
                    headers: {
                        Authorization: `Bearer${x}`
                    }
                })
                .then(res => {
                    // check transaction id is exists
                    let id = {
                        student_id: res.data.id
                    };
                    paymentInfo.checkTxId(id).then(res => {
                        //set transaction id
                        if (
                            res.data.transaction_id == null ||
                            res.data.transaction_id == "" ||
                            res.data.transaction_id == undefined
                        ) {
                            // this.props.history.push("/payment");
                            window.location.href = "/payment";
                        }
                    });

                    // let data = {
                    //     student_id: res.data.id
                    // };

                    ProfileUpdate.studentInfo(id).then(res => {
                        this.setState({
                            className: res.data.classname.name,
                            branchName: res.data.branch.name,
                            batchName: res.data.batch.name
                        });
                    });

                    DashboardApi.getMessageCount(id).then(res => {
                        // console.log("message count is", res);
                        this.setState({ messageCount: res.data });
                    });

                    DashboardApi.getLiveClass(id).then(res => {
                        // console.log("live class count is", res.data);
                        this.setState({ liveClassCount: res.data.length });
                    });

                    DashboardApi.getMcqExam(id).then(res => {
                        // console.log("mq exam count is", res.data);

                        let unattended = 0;
                        for (let i = 0; i < res.data.length; i++) {
                            if (res.data[i].attendance === null) {
                                unattended++;
                            }
                        }

                        this.setState({ mcqExamCount: unattended });
                    });

                    DashboardApi.getCqExam(id).then(res => {
                        // console.log("cq exam count is", res.data.length);

                        let unattended = 0;
                        for (let i = 0; i < res.data.length; i++) {
                            if (res.data[i].attendance === null) {
                                unattended++;
                            }
                        }

                        this.setState({ cqExamCount: unattended });
                    });

                    // check profile info
                    if (
                        res.data.profile == null ||
                        res.data.user_profile == null
                    ) {
                        window.location.href = "/profile";
                    } else {
                        this.setState({
                            student_id: res.data.id,
                            firstName: res.data.first_name,
                            lastName: res.data.last_name,
                            mobileNumber: res.data.phone,
                            // image: res.data.profile.image,
                            instituteName: res.data.user_profile.institution,
                            regId: res.data.registration_id,
                            nextPaymentDate: res.data.next_payment_date
                        });
                    }
                });
        }
    }

    studentType() {
        if (this.state.studentType === 0) {
            return <div>Offline</div>;
        } else {
            return <div>Online</div>;
        }
    }

    getAnnouncement() {
        return (
            <div className="col-sm-6 pt-0 card-1">
                <div className="card h-100">
                    <div className="card-body">
                        <h5 className="card-title">Announcements</h5>
                        {this.state.messageCount === null ? (
                            <Loading />
                        ) : (
                            <>
                                {this.state.messageCount ? (
                                    <>
                                        <p className="card-text dashboard-text-alert">
                                            You have {this.state.messageCount}{" "}
                                            announcements.
                                        </p>
                                        <Link to={"/inbox"}>
                                            <button className="btn btn-success dashboard-card-alert-button">
                                                See More...
                                            </button>
                                        </Link>
                                    </>
                                ) : (
                                    <>
                                        <p>No New Announcements.</p>
                                        <Link to={"/inbox"}>
                                            <button className="btn btn-success dashboard-card-button">
                                                See More...
                                            </button>
                                        </Link>
                                    </>
                                )}
                            </>
                        )}
                    </div>
                </div>
            </div>
        );
    }

    getLiveClass() {
        return (
            <div className="col-sm-6 pt-0 card-2">
                <div className="card h-100">
                    <div className="card-body">
                        <h5 className="card-title">Live Class</h5>
                        {this.state.liveClassCount === null ? (
                            <Loading />
                        ) : (
                            <>
                                {this.state.liveClassCount ? (
                                    <>
                                        <p className="card-text dashboard-text-alert">
                                            You have {this.state.liveClassCount}{" "}
                                            Live/Upcoming classes.
                                        </p>
                                        <Link to={"/join-class"}>
                                            <button className="btn btn-success dashboard-card-alert-button">
                                                See More...
                                            </button>
                                        </Link>
                                    </>
                                ) : (
                                    <>
                                        <p>No Live/Upcoming class.</p>
                                        <Link to={"/join-class"}>
                                            <button className="btn btn-success dashboard-card-button">
                                                See More...
                                            </button>
                                        </Link>
                                    </>
                                )}
                            </>
                        )}
                    </div>
                </div>
            </div>
        );
    }

    getMcqExam() {
        return (
            <div className="col-sm-6 pt-0 card-1">
                <div className="card h-100">
                    <div className="card-body">
                        <h5 className="card-title">MCQ Exam</h5>
                        {this.state.mcqExamCount === null ? (
                            <Loading />
                        ) : (
                            <>
                                {this.state.mcqExamCount ? (
                                    <>
                                        <p className="card-text dashboard-text-alert">
                                            You have {this.state.mcqExamCount}{" "}
                                            Upcoming MCQ Exam.
                                        </p>
                                        <Link to={"/exam-list"}>
                                            <button className="btn btn-success dashboard-card-alert-button">
                                                See More...
                                            </button>
                                        </Link>
                                    </>
                                ) : (
                                    <>
                                        <p>No MCQ Exam now.</p>
                                        <Link to={"/exam-list"}>
                                            <button className="btn btn-success dashboard-card-button">
                                                See More...
                                            </button>
                                        </Link>
                                    </>
                                )}
                            </>
                        )}
                    </div>
                </div>
            </div>
        );
    }

    getCqExam() {
        return (
            <div className="col-sm-6 pt-0 card-2">
                <div className="card h-100">
                    <div className="card-body">
                        <h5 className="card-title">CQ Exam</h5>
                        {this.state.cqExamCount === null ? (
                            <Loading />
                        ) : (
                            <>
                                {this.state.cqExamCount ? (
                                    <>
                                        <p className="card-text dashboard-text-alert">
                                            You have {this.state.cqExamCount}{" "}
                                            Upcoming CQ Exam.
                                        </p>
                                        <Link to={"/cq-exam-list"}>
                                            <button className="btn btn-success dashboard-card-alert-button">
                                                See More...
                                            </button>
                                        </Link>
                                    </>
                                ) : (
                                    <>
                                        <p>No CQ Exam now.</p>
                                        <Link to={"/cq-exam-list"}>
                                            <button className="btn btn-success dashboard-card-button">
                                                See More...
                                            </button>
                                        </Link>
                                    </>
                                )}
                            </>
                        )}
                    </div>
                </div>
            </div>
        );
    }

    render() {
        // console.log("Live class from state is", this.state.liveClassCount);

        return (
            <div style={{ backgroundColor: "#f1f1f1" }}>
                <Header />
                <div style={{ height: "70px" }}></div>
                <div className="">
                    <div className="app-margin">
                        <div className="row">
                            <div className="col-md-3 d-none d-md-block d-lg-block d-xl-block">
                                <SideBar />
                            </div>
                            <div className="col-md-9">
                                <div className="content"></div>
                                <div className="app-background mb-3">
                                    <h2 className="text-center component-header">
                                        Student Dashboard
                                    </h2>
                                    <div className="heading-underline"></div>
                                    <p className="text-center">
                                        Prominent notices for you are shown
                                        here.
                                    </p>
                                    {(this.state.nextPaymentDate == null ||
                                        this.state.nextPaymentDate == "") && (
                                        <h4 className="text-center">
                                            Within 24 Hours Your Account will
                                            verify
                                        </h4>
                                    )}
                                </div>
                                <div className="row">
                                    {this.getAnnouncement()}
                                    {this.getLiveClass()}
                                </div>
                                <div className="row">
                                    {this.getMcqExam()}
                                    {this.getCqExam()}
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

export default Dashboard;

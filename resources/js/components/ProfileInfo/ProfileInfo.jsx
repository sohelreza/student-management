import React, { Component } from "react";
import { Link } from "react-router-dom";

import paymentInfo from "../../models/paymentInfo";
import ProfileUpdate from "../../models/ProfileUpdate";

import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import Loading from "../Loading/Loading";
import { SideBar } from "../SideBar/SideBar";

import "./ProfileInfo.css";

class ProfileInfo extends Component {
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
            nextPaymentDate: ""
        };
        // this.getData();
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
                    let data = {
                        student_id: res.data.id
                    };
                    paymentInfo.checkTxId(data).then(res => {
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

                    ProfileUpdate.studentInfo(data).then(res => {
                        this.setState({
                            className: res.data.classname.name,
                            branchName: res.data.branch.name,
                            batchName: res.data.batch.name
                        });
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

    studentDetails() {
        return (
            <>
                <div className="container d-flex dashboard-content">
                    <table className="table table-hover table-borderless">
                        <tbody>
                            <tr>
                                <th scope="row">Registration Id</th>
                                <td>{this.state.regId}</td>
                            </tr>
                            <tr>
                                <th scope="row">Student's Name</th>
                                <td>
                                    {this.state.firstName} {this.state.lastName}
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Institution Name</th>
                                <td>{this.state.instituteName}</td>
                            </tr>
                            <tr>
                                <th scope="row">Class</th>
                                <td>{this.state.className}</td>
                            </tr>
                            <tr>
                                <th scope="row">Mobile Number</th>
                                <td>{this.state.mobileNumber}</td>
                            </tr>
                            <tr>
                                <th scope="row">Student Type</th>
                                <td>{this.studentType()}</td>
                            </tr>
                            <tr>
                                <th scope="row">Branch</th>
                                <td>{this.state.branchName}</td>
                            </tr>
                            <tr>
                                <th scope="row">Batch</th>
                                <td>{this.state.batchName}</td>
                            </tr>
                            {this.state.nextPaymentDate && (
                                <tr>
                                    <th scope="row">Next Payment Date</th>
                                    <td>{this.state.nextPaymentDate}</td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
                {/* <div className="row justify-content-center pb-4">
                    <Link to="/profile">
                        <button
                            type="button"
                            className="btn btn-success update-button"
                        >
                            Update Profile
                        </button>
                    </Link>
                </div> */}
            </>
        );
    }

    render() {
        return (
            <div style={{ backgroundColor: "#f1f1f1" }}>
                <Header />
                <div style={{ height: "70px" }}></div>
                <div className="">
                    <div className="app-margin">
                        {/* <div
                            className="alert alert-info alert-dismissible notification-margin"
                            role="alert"
                        >
                            You have new announcements
                            <button
                                type="button"
                                className="close"
                                data-dismiss="alert"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div
                            className="alert alert-info alert-dismissible notification-margin mt-3"
                            role="alert"
                        >
                            You have 2 unread messages
                            <button
                                type="button"
                                className="close"
                                data-dismiss="alert"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div> */}
                        <div className="row">
                            <div className="col-md-3 d-none d-md-block d-lg-block d-xl-block">
                                <SideBar />
                            </div>
                            <div className="col-md-9">
                                <div className="content"></div>
                                <div className="app-background mb-3">
                                    <h2 className="text-center component-header">
                                        Profile Information
                                    </h2>
                                    <div className="heading-underline"></div>
                                    <p className="text-center">
                                        You can see your basic information here.
                                    </p>
                                </div>
                                <div className="app-background">
                                    <h4 className="text-center mt-2 component-sub-header">
                                        Student's Details
                                    </h4>
                                    <div className="content-underline"></div>
                                    {this.state.regId ? (
                                        this.studentDetails()
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

export default ProfileInfo;

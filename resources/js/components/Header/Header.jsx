import React, { Component } from "react";
import { Link, NavLink } from "react-router-dom";
import decode from "jwt-decode";

import { Logo } from "./Logo";

import Auth from "../../models/Auth";

import "./Header.css";

class Header extends Component {
    constructor(props) {
        super(props);
        this.state = {
            student_id: "",
            width: 0,
            height: 0,
            studentType: "",
            date: new Date().toJSON().slice(0, 10)
        };
        this.updateWindowDimensions = this.updateWindowDimensions.bind(this);
        this.checkLogin();
    }

    checkLogin() {
        if (localStorage.getItem("token")) {
            var x = JSON.parse(localStorage.getItem("token"));
            const decoded = decode(x);
            console.log(decoded);
            console.log(Date.now() / 1000);
            var validate = decoded.exp < Date.now() / 1000;
            console.log(validate);
            if (decoded.exp < Date.now() / 1000) {
                localStorage.clear();
                window.location.href = "/login";
            }
        }
    }

    componentDidMount() {
        if (localStorage.getItem("token")) {
            var x = JSON.parse(localStorage.getItem("token"));
            axios
                .get("http://127.0.0.1:8000/student/student_profile/", {
                    headers: {
                        Authorization: `Bearer${x}`
                    }
                })
                .then(res => {
                    this.setState({
                        student_id: res.data.id,
                        firstName: res.data.first_name,
                        lastName: res.data.last_name,
                        mobileNumber: res.data.phone,
                        nextPaymentDate: res.data.next_payment_date,
                        studentType: res.data.student_type
                    });
                });
        }
        this.updateWindowDimensions();
        window.addEventListener("resize", this.updateWindowDimensions);
    }

    componentWillUnmount() {
        window.removeEventListener("resize", this.updateWindowDimensions);
    }

    updateWindowDimensions() {
        this.setState({ width: window.innerWidth, height: window.innerHeight });
    }

    logOut() {
        if (localStorage.getItem("token")) {
            let data = {
                token: JSON.parse(localStorage.getItem("token"))
            };
            Auth.logout(data).then(res => {
                localStorage.clear();
                window.location.href = "/login";
            });
        }
    }

    headerLogin() {
        if (localStorage.getItem("token")) {
            if (this.state.image) {
                return (
                    <div>
                        <img
                            src={this.state.image}
                            className="rounded-circle mx-auto d-block"
                            style={{ objectFit: "cover", maxWidth: "100%" }}
                            width="45"
                            height="45"
                        />
                    </div>
                );
            } else {
                return (
                    <div className="dropdown">
                        <div
                            className=" dropdown-toggle"
                            data-toggle="dropdown"
                        >
                            <img
                                src={require("../../../assests/images/apple.png")}
                                className="rounded-circle mx-auto d-block"
                                style={{
                                    objectFit: "cover",
                                    maxWidth: "100%"
                                }}
                                width="30"
                                height="30"
                            />
                        </div>
                        <div
                            className="dropdown-menu text-center"
                            style={{ left: "-110px" }}
                        >
                            <Link
                                className="dropdown-item"
                                onClick={this.logOut.bind(this)}
                                to={""}
                            >
                                LogOut
                            </Link>
                        </div>
                    </div>
                );
            }
        } else {
            return (
                <>
                    <li className="nav-item">
                        <NavLink
                            activeClassName="active"
                            to={"/login"}
                            className="nav-link"
                            style={{ color: "white!important" }}
                        >
                            Login
                        </NavLink>
                    </li>
                    <li className="nav-item">
                        <NavLink
                            to={"/registration"}
                            className="nav-link"
                            activeClassName="active"
                        >
                            Registration
                        </NavLink>
                    </li>
                </>
            );
        }
    }

    dropdownMenu() {
        if (localStorage.getItem("token")) {
            return (
                <>
                    <li className="nav-item">
                        <NavLink
                            activeClassName="active"
                            to="/dashboard"
                            className="text-left dropdown-link"
                        >
                            Student Dashboard
                        </NavLink>
                    </li>
                    <li className="nav-item">
                        <NavLink
                            activeClassName="active"
                            to="/profile-info"
                            className="text-left dropdown-link"
                        >
                            Profile
                        </NavLink>
                    </li>
                    <li className="nav-item">
                        <NavLink
                            activeClassName="active"
                            to="/profile"
                            className="text-left dropdown-link"
                        >
                            Update Profile
                        </NavLink>
                    </li>
                    <li className="nav-item">
                        <NavLink
                            activeClassName="active"
                            to="/manage-course"
                            className="text-left dropdown-link"
                        >
                            Manage Courses
                        </NavLink>
                    </li>
                    {this.state.nextPaymentDate >= this.state.date && (
                        <>
                            <li className="nav-item">
                                <NavLink
                                    activeClassName="active"
                                    to="/inbox"
                                    className="text-left dropdown-link"
                                >
                                    Inbox
                                </NavLink>
                            </li>
                            <li className="nav-item">
                                <NavLink
                                    activeClassName="active"
                                    to="/payment-history"
                                    className="text-left dropdown-link"
                                >
                                    Payment History
                                </NavLink>
                            </li>
                            <li className="nav-item">
                                <NavLink
                                    activeClassName="active"
                                    to="/content"
                                    className="text-left dropdown-link"
                                >
                                    Contents
                                </NavLink>
                            </li>
                            {this.state.studentType == 1 && (
                                <li className="nav-item">
                                    <NavLink
                                        activeClassName="active"
                                        to="/join-class"
                                        className="text-left dropdown-link"
                                    >
                                        Join Class
                                    </NavLink>
                                </li>
                            )}
                            <li className="nav-item">
                                <NavLink
                                    activeClassName="active"
                                    to="/homework-upload"
                                    className="text-left dropdown-link"
                                >
                                    Homework Upload
                                </NavLink>
                            </li>
                            <li className="nav-item">
                                <NavLink
                                    activeClassName="active"
                                    to="/class-lecture"
                                    className="text-left dropdown-link"
                                >
                                    Class Lectures
                                </NavLink>
                            </li>
                            <li className="nav-item">
                                <NavLink
                                    activeClassName="active"
                                    to="/exam-list"
                                    className="text-left dropdown-link"
                                >
                                    MCQ Exam
                                </NavLink>
                            </li>
                            <li className="nav-item">
                                <NavLink
                                    activeClassName="active"
                                    to="/mcq-result-list"
                                    className="text-left dropdown-link"
                                >
                                    MCQ Exam Result
                                </NavLink>
                            </li>

                            <li className="nav-item">
                                <NavLink
                                    activeClassName="active"
                                    to="/cq-exam-list"
                                    className="text-left dropdown-link"
                                >
                                    CQ Exam
                                </NavLink>
                            </li>

                            <li className="nav-item">
                                <NavLink
                                    activeClassName="active"
                                    to="/class-routine"
                                    className="text-left dropdown-link"
                                >
                                    Class Routine
                                </NavLink>
                            </li>

                            <li className="nav-item">
                                <NavLink
                                    activeClassName="active"
                                    to="/change-password"
                                    className="text-left dropdown-link"
                                >
                                    Change password
                                </NavLink>
                            </li>
                        </>
                    )}
                    <li className="nav-item">
                        <Link
                            className="text-left dropdown-link"
                            onClick={this.logOut.bind(this)}
                            to={""}
                        >
                            LogOut
                        </Link>
                    </li>
                </>
            );
        } else {
            return (
                <>
                    <li className="nav-item">
                        <NavLink
                            activeClassName="active"
                            to={"/login"}
                            className="text-left dropdown-link"
                        >
                            Login
                        </NavLink>
                    </li>
                    <li className="nav-item">
                        <NavLink
                            activeClassName="active"
                            to={"/registration"}
                            className="text-left dropdown-link"
                        >
                            Registration
                        </NavLink>
                    </li>
                </>
            );
        }
    }

    render() {
        return (
            <div className="container-fluid">
                <nav className="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
                    <Logo />
                    <button
                        className="navbar-toggler"
                        type="button"
                        data-toggle="collapse"
                        data-target="#navbarResponsive"
                    >
                        <span className="navbar-toggler-icon"></span>
                    </button>

                    {this.state.width >= 768 ? (
                        <>
                            <div
                                className="collapse navbar-collapse"
                                id="navbarResponsive"
                            >
                                <ul className="navbar-nav ml-auto text-center container">
                                    {this.headerLogin()}
                                </ul>
                            </div>
                        </>
                    ) : (
                        <>
                            <div
                                className="collapse navbar-collapse navbar-scroll"
                                id="navbarResponsive"
                            >
                                <ul className="navbar-nav ml-auto text-center container">
                                    {this.dropdownMenu()}
                                </ul>
                            </div>
                        </>
                    )}
                </nav>
            </div>
        );
    }
}
export { Header };

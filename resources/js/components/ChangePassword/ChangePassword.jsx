import React, { Component } from "react";
import ProfileUpdate from "../../models/ProfileUpdate";
import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import { SideBar } from "../SideBar/SideBar";
class ChangePassword extends Component {
    constructor(props) {
        super(props);
        this.state = {
            oldPassword: "",
            newChangePassword: "",
            confirmChangePassword: "",
            error: "",
            user_profile: "",
            type: "password",
            type1: "password",
            type2: "password",
            type3: "password",
            date: new Date().toLocaleString()
        };
        this.getData();
    }
    getData() {
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
                    this.setState({
                        student_id: res.data.id,
                        user_profile: res.data.user_profile
                    });
                });
        }
    }

    updateChange(type, e) {
        var obj = {};
        obj[type] =
            e.target.type == "checkbox" ? e.target.checked : e.target.value;
        this.setState(obj);
    }

    handleClick(i) {
        var type = {};
        this.state.type =
            i == "type1"
                ? this.state.type1
                : i == "type2"
                ? this.state.type2
                : i == "type3"
                ? this.state.type3
                : this.state.type;
        type[i] = this.state.type === "password" ? "text" : "password";
        this.setState(type);
    }
    handleSubmit(e) {
        e.preventDefault();
        if (this.state.oldPassword == "") {
            this.setState({ error: "Please enter your password" });
        } else if (this.state.newChangePassword == "") {
            this.setState({ error: "Please enter your new password" });
        } else if (this.state.confirmChangePassword == "") {
            this.setState({ error: "Please enter your new confirm password" });
        } else if (
            this.state.oldPassword.length < 8 ||
            this.state.newChangePassword.length < 8 ||
            this.state.confirmChangePassword.length < 8
        ) {
            this.setState({ error: "Password must be 8 character" });
        } else if (
            this.state.newChangePassword != this.state.confirmChangePassword
        ) {
            this.setState({
                error: "Confirm password and new password must match"
            });
        } else {
            var data = {
                student_id: this.state.student_id,
                old_password: this.state.oldPassword,
                new_password: this.state.newChangePassword,
                confirm_password: this.state.confirmChangePassword
            };
            ProfileUpdate.postChangePassword(data)
                .then(res => {
                    this.setState({
                        response: "Your password has been successfully changed",
                        oldPassword: "",
                        newChangePassword: "",
                        confirmChangePassword: "",
                        error: ""
                    });
                })
                .catch(err => {
                    this.setState({ error: err.response.data.error });
                });
        }
    }
    render() {
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
                                <div className="app-background mb-3">
                                    <h2 className="text-center component-header">
                                        Change Password
                                    </h2>
                                    <div className="heading-underline"></div>
                                    <p className="text-center">
                                        Here you can change your password.
                                    </p>
                                </div>
                                {(this.state.error || this.state.response) && (
                                    <div className="app-background mb-3">
                                        <div className="text-danger">
                                            {this.state.error}
                                        </div>
                                        <div className="text-success">
                                            {this.state.response}
                                        </div>
                                    </div>
                                )}
                                <div className="app-background">
                                    <h4 className="text-center mt-2 component-sub-header">
                                        Change Password
                                    </h4>
                                    <div className="content-underline"></div>

                                    <form
                                        className=" col-12 col-md-12 login-form"
                                        style={{ border: "2px solid #ccc" }}
                                        onSubmit={this.handleSubmit.bind(this)}
                                    >
                                        <div className="">
                                            <div className="col-xs-12 col-sm-12 col-md-12 p-1">
                                                <div className="form-group">
                                                    <div className="form-group">
                                                        <input
                                                            // type="text"
                                                            type={
                                                                this.state.type1
                                                            }
                                                            className="form-control"
                                                            placeholder="Enter old password"
                                                            value={
                                                                this.state
                                                                    .oldPassword
                                                            }
                                                            onChange={this.updateChange.bind(
                                                                this,
                                                                "oldPassword"
                                                            )}
                                                        />
                                                        <span
                                                            className="password_show"
                                                            onClick={this.handleClick.bind(
                                                                this,
                                                                "type1"
                                                            )}
                                                        >
                                                            {this.state
                                                                .type1 ===
                                                            "text"
                                                                ? "Hide"
                                                                : "Show"}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="col-xs-12 col-sm-12 col-md-12 p-1">
                                                <div className="form-group">
                                                    <div className="form-group">
                                                        <input
                                                            // type="text"
                                                            type={
                                                                this.state.type2
                                                            }
                                                            className="form-control"
                                                            placeholder="Enter New password"
                                                            value={
                                                                this.state
                                                                    .newChangePassword
                                                            }
                                                            onChange={this.updateChange.bind(
                                                                this,
                                                                "newChangePassword"
                                                            )}
                                                        />
                                                        <span
                                                            className="password_show"
                                                            onClick={this.handleClick.bind(
                                                                this,
                                                                "type2"
                                                            )}
                                                        >
                                                            {this.state
                                                                .type2 ===
                                                            "text"
                                                                ? "Hide"
                                                                : "Show"}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="col-xs-12 col-sm-12 col-md-12 p-1">
                                                <div className="form-group">
                                                    <input
                                                        // type="text"
                                                        type={this.state.type3}
                                                        className="form-control"
                                                        placeholder="Confirm change password"
                                                        value={
                                                            this.state
                                                                .confirmChangePassword
                                                        }
                                                        onChange={this.updateChange.bind(
                                                            this,
                                                            "confirmChangePassword"
                                                        )}
                                                    />
                                                    <span
                                                        className="password_show"
                                                        onClick={this.handleClick.bind(
                                                            this,
                                                            "type3"
                                                        )}
                                                    >
                                                        {this.state.type3 ===
                                                        "text"
                                                            ? "Hide"
                                                            : "Show"}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="text-center">
                                            <button
                                                type="submit"
                                                className="btn btn-success btn-lg login-button"
                                                style={{
                                                    borderRadius: "6px",
                                                    marginTop: "0px"
                                                }}
                                            >
                                                Submit
                                            </button>
                                        </div>
                                    </form>
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
export default ChangePassword;

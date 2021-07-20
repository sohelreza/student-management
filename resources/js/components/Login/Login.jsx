import React, { Component } from "react";

import { Link } from "react-router-dom";

import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import Auth from "../../models/Auth";

// import "./Login.css";
// import "./fixed.css";
class Login extends Component {
    constructor(props) {
        super(props);
        this.state = {
            registrationId: "",
            password: "",
            type: "password",
            error: "",
            reqSuccess: ""
        };
        this.getData();
    }

    getData() {
        if (this.props.location.state == 1) {
            this.state.reqSuccess =
                "Your registration is successfully Done. Please login with ID and password which is given in your mobile number";
        } else {
            this.state.reqSuccess = "";
        }
    }

    updateChange(type, e) {
        var obj = {};
        obj[type] =
            e.target.type === "checkbox" ? e.target.checked : e.target.value;
        this.setState(obj);
    }

    handleSubmit(e) {
        e.preventDefault();
        if (this.state.registrationId == "" || this.state.password == "") {
            this.setState({
                error: "please enter your registration Id or password"
            });
        } else {
            let data = {
                registration_id: this.state.registrationId,
                password: this.state.password
            };

            Auth.login(data)
                .then(res => {
                    window.localStorage.setItem(
                        "token",
                        JSON.stringify(res.data.access_token)
                    );

                    window.localStorage.setItem(
                        "expire",
                        JSON.stringify(res.data.expires_in)
                    );

                    this.props.history.push("/dashboard");
                })
                .catch(err => {
                    this.setState({
                        error: err.response.data.error,
                        registrationId: "",
                        password: ""
                    });
                });
        }
    }

    handleClick(type) {
        // console.log(this.state.type);
        // this.state.type = !this.state.type;
        this.setState({
            type: this.state.type === "password" ? "text" : "password"
        });
    }

    render() {
        return (
            <div>
                <Header />
                <div className="container-fluid">
                    <div className="container">
                        <div style={{ height: "100px" }}></div>
                        <div className="row">
                            <div className="col-md-6">
                                <img
                                    src={require("../../../assests/images/apple.png")}
                                    height="auto"
                                    width="100%"
                                />
                            </div>
                            <div className="col-md-6">
                                <div className=" text-center input-box">
                                    <h2 className="sign">Login</h2>
                                    {this.state.reqSuccess && (
                                        <div
                                            className="text-success"
                                            style={{ color: "green" }}
                                        >
                                            {this.state.reqSuccess}
                                        </div>
                                    )}
                                    {this.state.error && (
                                        <div className="app-background mb-3 ">
                                            <div className="text-danger text-center">
                                                {this.state.error}
                                            </div>
                                        </div>
                                    )}

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
                                                            type="text"
                                                            className="form-control"
                                                            placeholder="Enter Student ID"
                                                            value={
                                                                this.state
                                                                    .registrationId
                                                            }
                                                            onChange={this.updateChange.bind(
                                                                this,
                                                                "registrationId"
                                                            )}
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="col-xs-12 col-sm-12 col-md-12 p-1">
                                                <div className="form-group">
                                                    <input
                                                        type={this.state.type}
                                                        // type="password"
                                                        className="form-control password_input"
                                                        placeholder="Password"
                                                        value={
                                                            this.state.password
                                                        }
                                                        onChange={this.updateChange.bind(
                                                            this,
                                                            "password"
                                                        )}
                                                    />
                                                    {/* <span class="p-viewer" onClick={this.handleClick.bind(this)}>
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </span> */}
                                                    <span
                                                        className="password_show"
                                                        onClick={this.handleClick.bind(
                                                            this
                                                        )}
                                                    >
                                                        {this.state.type ===
                                                        "text"
                                                            ? "Hide"
                                                            : "Show"}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <button
                                            type="submit"
                                            className="btn btn-success btn-lg login-button"
                                            style={{ borderRadius: "6px" }}
                                        >
                                            Submit
                                        </button>
                                    </form>

                                    <div className="next-line">
                                        {/* <div className="d-inline-block p-2 next-line">
                                            <a
                                                href="#"
                                                className="register-anchor small-text"
                                            >
                                                Forgot Student ID?
                                            </a>
                                        </div> */}
                                        <div className="d-inline-block p-2 next-line">
                                            <Link
                                                to={"/forget-password"}
                                                className="register-anchor small-text"
                                            >
                                                Forgot Password?
                                            </Link>
                                        </div>
                                        <p className="small-text next-line">
                                            New Here?&nbsp;&nbsp;
                                            <Link
                                                to={"/registration"}
                                                href=""
                                                className="register-anchor"
                                            >
                                                register now
                                            </Link>
                                        </p>
                                    </div>
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
export default Login;

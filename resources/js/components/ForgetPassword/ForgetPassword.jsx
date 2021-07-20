import React, { Component } from 'react';
import Auth from '../../models/Auth';
import Footer from '../Footer/Footer';
import { Header } from '../Header/Header';
class ForgetPassword extends Component {
    constructor(props) {
        super(props);
        this.state = {
            mobileNumber: '',
            error: '',
            message: ''
        }
    }
    updateChange(type, e) {
        var obj = {};
        obj[type] = e.target.type == 'checkbox' ? e.target.checked : e.target.value;
        this.setState(obj);
    }
    handleSubmit(e) {
        e.preventDefault();
        console.log(this.state.mobileNumber)
        if (this.state.mobileNumber == '') {
            this.setState({ error: "Please enter your mobile number" });
        }
        else if (this.state.mobileNumber.length < 11) {
            this.setState({ error: "Please enter your mobile number minimum 11 characters" });
        }
        else {
            let data = {
                phone: this.state.mobileNumber,
            }
            Auth.forgotPassword(data).then(res => {
                console.log(res.data)
                this.setState({
                    message: "Your password has been send to your mobile number",
                    mobileNumber: "",
                    error: ""
                })
            }).catch(err => {
                this.setState({
                    error: err.response.data.error,
                    mobileNumber: ''
                })
            })
        }

    }
    render() {
        return (
            <div className="join-class-background">
                <Header />
                <div className="height-top"></div>
                <div className="">
                    <div className="app-margin">
                        <div className="row">
                            <div className="col-md-12">
                                <div className="live-class-content"></div>
                                <div className="app-background mb-3">
                                    <h2 className="text-center component-header">
                                        Forget Password
                                    </h2>
                                    <p className="text-center">
                                        Please input your mobile number which is registered
                                    </p>
                                    <div className="heading-underline"></div>
                                </div>
                                {(this.state.error || this.state.message) &&
                                    (<div className="app-background mb-3">
                                        <div className="text-danger">
                                            {this.state.error}
                                        </div>
                                        <div className="text-success">
                                            {this.state.message}
                                        </div>
                                    </div>
                                    )
                                }
                                <div className="app-background">
                                    <h4 className="text-center mt-2 component-header">
                                        Forget Password
                                    </h4>
                                    <div className="content-underline mb-4"></div>
                                    <div className="row">
                                        <div className="col-xs-2 col-md-2"></div>
                                        <form
                                            className=" col- col-md-8 login-form"
                                            style={{ border: "2px solid #ccc" }}
                                            onSubmit={this.handleSubmit.bind(this)}
                                        >
                                            <div className="">
                                                <div className="col-xs-12 col-sm-12 col-md-12 p-1">
                                                    <div className="form-group">
                                                        <div className="form-group">
                                                            <input
                                                                type="number"
                                                                className="form-control"
                                                                placeholder="Enter your mobile number"
                                                                value={
                                                                    this.state
                                                                        .mobileNumber
                                                                }
                                                                onChange={this.updateChange.bind(
                                                                    this,
                                                                    "mobileNumber"
                                                                )}
                                                            />
                                                        </div>
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
                                        <div className="col-md-2 col-xs-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <Footer />
            </div>
        )
    }
}
export default ForgetPassword
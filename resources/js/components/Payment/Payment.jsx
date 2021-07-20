import React, { Component } from "react";
import paymentInfo from "../../models/paymentInfo";
import ProfileUpdate from "../../models/ProfileUpdate";
import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import { SideBar } from "../SideBar/SideBar";
class Payment extends Component {
    constructor(props) {
        super(props);
        this.state = {
            transactionId: "",
            student_id: "",
            confirmTransactionId: "",
            error: "",
            user_profile: "",
            totalAmount: "",
            instruction: "",
            TransId: "",
            subjects: [],
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
                    let data = {
                        student_id: res.data.id,
                    }
                    paymentInfo.checkTxId(data).then(res => {
                        if (res.data.transaction_id !== null) {
                            window.location.href = "/dashboard";
                        }
                    });
                    this.setState({
                        student_id: res.data.id,
                        user_profile: res.data.user_profile,
                        totalAmount: res.data.user_payments[0].total_amount,
                    });
                    //get subjects name

                    ProfileUpdate.studentSubjects(data).then(res => {
                        // console.log(res.data)
                        this.setState({ subjects: res.data })
                    })

                    //get payment instruction
                    paymentInfo.paymentInstruction().then(res => {
                        this.setState({ instruction: res.data.instruction })
                    })
                });
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
        if (this.state.transactionId) {
            // console.log(this.state.transactionId)
            if (this.state.transactionId === this.state.confirmTransactionId) {
                let data = {
                    transaction_id: this.state.transactionId,
                    student_id: this.state.student_id
                };
                paymentInfo.postTxId(data).then(res => {
                    if (this.state.user_profile === null) {
                        window.location.href = "/profile";
                    } else {
                        this.props.history.push("/dashboard");
                    }
                });
            } else {
                this.setState({ error: "Transaction Id doesn't match" });
            }
        } else {
            this.setState({ error: "Please enter Transaction Id" });
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
                            <div className="col-md-3 d-none d-md-block d-lg-block d-xl-block">
                                <SideBar />
                            </div>
                            <div className="col-md-9">
                                <div className="live-class-content"></div>
                                <div className="app-background mb-3">
                                    <h2 className="text-center component-header">
                                        Payment
                                    </h2>
                                    <div className="heading-underline"></div>
                                    <p className="text-center">
                                        Here you can upload your payment.
                                    </p>
                                </div>
                                <div className="app-background mb-3">
                                    <div className="text-center component-header mb-1">
                                        You have chosen these subjects:
                                            {this.state.subjects.map((res, i) =>
                                        <div className="row justify-content-center" key={i}>
                                            {i + 1}.
                                                    {res.subject.name}
                                        </div>
                                    )}
                                    </div>
                                    <div className="text-center component-header mb-1">
                                        And total amount is:{this.state.totalAmount}
                                    </div>
                                    <div className="text-center component-header mb-1">{this.state.instruction}</div>
                                </div>
                                <div className="app-background">
                                    <h4 className="text-center mt-2 component-header">
                                        Payment
                                    </h4>
                                    <div className="content-underline mb-4"></div>
                                    <div className="text-danger">
                                        {this.state.error}
                                    </div>
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
                                                            placeholder="Enter txID"
                                                            value={
                                                                this.state
                                                                    .transactionId
                                                            }
                                                            onChange={this.updateChange.bind(
                                                                this,
                                                                "transactionId"
                                                            )}
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="col-xs-12 col-sm-12 col-md-12 p-1">
                                                <div className="form-group">
                                                    <input
                                                        type="text"
                                                        className="form-control"
                                                        placeholder="Confirm txID"
                                                        value={
                                                            this.state
                                                                .confirmTransactionId
                                                        }
                                                        onChange={this.updateChange.bind(
                                                            this,
                                                            "confirmTransactionId"
                                                        )}
                                                    />
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
export default Payment;

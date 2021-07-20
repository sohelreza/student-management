import React, { Component } from "react";
import Auth from "../../models/Auth";

import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import { SideBar } from "../SideBar/SideBar";
import Loading from "../Loading/Loading";

import "./PaymentHistory.css";
import NoDataFound from "../NoDataFound/NoDataFound";

class PaymentHistory extends Component {
    constructor(props) {
        if (
            !localStorage.getItem("token") &&
            localStorage.getItem("token") > 86400
        ) {
            window.location.href = "/login";
        }
        super(props);
        this.state = {
            studentPayment: null,
            branchName: ""
        };
        this.getData();
    }
    getData() {
        window.scrollTo(0, 0);
        // console.log("getData function called");
        if (localStorage.getItem("token")) {
            var x = JSON.parse(localStorage.getItem("token"));
            axios
                .get("http://127.0.0.1:8000/student/student_profile/", {
                    headers: {
                        Authorization: `Bearer${x}`
                    }
                })
                .then(res => {
                    // console.log(res.data);
                    if (res.data.user_profile === null) {
                        window.location.href = "/profile";
                    }
                    this.setState({
                        student_id: res.data.id,
                        studentPayment: res.data.user_payments
                    });
                });
        }
    }
    getBranchName(id) {
        let data = {};
        data = {
            student_type: id
        };
        Auth.getBranchName(data).then(res => {
            this.setState({ branchName: res.data });
        });
        return <span>{this.state.branchName}</span>;
    }

    allPaymentList() {
        return (
            <>
                {this.state.studentPayment.length ? (
                    <table
                        className="table table-bordered table-striped mb-none table-responsive"
                        id="datatable-default"
                    >
                        <thead>
                            <tr>
                                <th>Branch Name</th>
                                <th>Class</th>
                                <th>Batch</th>
                                <th>Total amount</th>
                                <th>Paid Amount</th>
                                <th>Due Amount</th>
                                <th>Payment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            {/*</tbody>*/}
                            {this.state.studentPayment.map(res => (
                                <tr key={res.id}>
                                    <td>{res.branch_id}</td>
                                    <td>{res.class_id}</td>
                                    <td>{res.batch_id}</td>
                                    <td>{res.total_amount}</td>
                                    <td>{res.paid_amount}</td>
                                    <td>{res.due_amount}</td>
                                    <td>{res.payment_date}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                ) : (
                    <NoDataFound noDataFoundMessage="no payment history yet" />
                )}
            </>
        );
    }

    render() {
        // console.log(
        //     "inside render method and the state is",
        //     this.state.studentPayment
        // );

        return (
            <div style={{ backgroundColor: "#f1f1f1" }}>
                <Header />
                <div style={{ minHeight: "70px" }}></div>
                <div className="container-fluid">
                    <div className="app-margin">
                        <div className="row">
                            <div className="col-md-3 d-none d-md-block d-lg-block d-xl-block">
                                <SideBar />
                            </div>
                            <div className="col-md-9">
                                <div className="live-class-content"></div>
                                <div className="app-background mb-3">
                                    <h2 className="text-center component-header">
                                        Payment History
                                    </h2>
                                    <div className="heading-underline"></div>
                                    <p className="text-center">
                                        Here you can see all of your Payment
                                        History.
                                    </p>
                                </div>
                                <div className="app-background">
                                    <h4 className="text-center mt-2 component-sub-header">
                                        All Payment List
                                    </h4>
                                    <div className="content-underline mb-4"></div>
                                    {this.state.studentPayment ? (
                                        this.allPaymentList()
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
export default PaymentHistory;

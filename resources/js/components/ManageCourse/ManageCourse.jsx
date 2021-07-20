import React, { Component } from "react";

import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import { SideBar } from "../SideBar/SideBar";
import AddCourse from "../../models/AddCourse";
import Auth from "../../models/Auth";

import "./ManageCourse.css";
import Loading from "../Loading/Loading";
import NoDataFound from "../NoDataFound/NoDataFound";
import paymentInfo from "../../models/paymentInfo";

class ManageCourse extends Component {
    // state = {};
    constructor(props) {
        if (!localStorage.getItem("token")) {
            window.location.href = "/login";
        }
        super(props);
        this.state = {
            branch: "",
            std_type: "",
            class: "",
            batch: "",
            batchName: "",
            subjectName: "",
            amount: 0,
            first_name: "",
            last_name: "",
            mobileNumber: "",
            paidAmount: 0,
            validDate: "",
            className: "",
            date: new Date().toJSON().slice(0, 10),
            checkedItems: []
        };
        window.scrollTo(0, 0);
    }

    componentWillMount() {
        if (localStorage.getItem("token")) {
            var x = JSON.parse(localStorage.getItem("token"));
            axios
                .get("http://127.0.0.1:8000/student/student_profile/", {
                    headers: {
                        Authorization: `Bearer${x}`
                    }
                })
                .then(res => {
                    console.log(res.data);
                    let data = {
                        student_id: res.data.id
                    };
                    paymentInfo.checkTxId(data).then(res => {
                        if (res.data.admin_transaction_id === null) {
                            window.location.href = "/dashboard";
                        }
                    });
                    if (res.data.user_profile === null) {
                        window.location.href = "/profile";
                    }
                    // else if (res.data.student_type === 0 || res.data.next_payment_date == null ) {
                    //     window.location.href = "/dashboard";
                    // }
                    this.getBranch(res.data.student_type);
                    this.setState({
                        id: res.data.id,
                        student_type: res.data.student_type,
                        batch_id: res.data.batch_id,
                        branch_id: res.data.branch_id,
                        class_id: res.data.class_id,
                        student_id: res.data.student_id,
                        firstName: res.data.first_name,
                        lastName: res.data.last_name,
                        mobileNumber: res.data.phone,
                        image: res.data.profile.image,
                        instituteName: res.data.user_profile.institution,
                        regId: res.data.registration_id
                    });
                });
        }
    }

    getBranch(id) {
        let data = {};
        data = {
            student_type: id
        };
        Auth.getBranchName(data).then(res => {
            this.setState({ branchName: res.data });
        });
    }

    getClass(id) {
        // console.log(data);
        let data = {};
        data = {
            branch_id: id
        };
        Auth.getClass(data).then(res => {
            console.log(res.data);
            this.setState({ className: res.data });
        });
    }
    getBatch(id) {
        console.log(id);
        let data = {};
        data = {
            class_id: id,
            student_type: this.state.student_type,
            branch_id: this.refs.branch.value
        };
        Auth.getBatchName(data).then(res => {
            this.setState({ batchName: res.data });
        });
    }
    getSubject() {
        // console.log(data);
        let data = {};
        data = {
            class_id: this.refs.class.value,
            student_type: this.state.student_type
        };
        Auth.getSubjectName(data).then(res => {
            // console.log(res.data);
            this.setState({ subjectName: res.data });
        });
    }

    getAmount() {
        let data = {};
        if (this.state.checkedItems != null) {
            this.state.checkedItems.map(res => {
                console.log(res);
            });
        }
        data = {
            // subject_id: id
        };
        Auth.getSubjectAmount(data).then(res => {
            console.log(res.data.amount);
            var amount =
                parseInt(this.state.amount) + parseInt(res.data.amount);
            this.setState({ amount: amount });
        });
    }

    handleChange(e) {
        this.getBranch(this.state.student_type);
        this.setState({
            std_type: this.state.student_type
        });
    }

    handleChangeBranch(e) {
        this.getClass(e.target.value ? e.target.value : this.state.branch_id);
        this.setState({
            branch: this.refs.branch.value
                ? this.refs.branch.value
                : this.state.branch_id,
            subjectName: "",
            amount: 0
        });
    }

    handleChangeClass(e) {
        // console.log(this.state.class_id)
        console.log(this.refs.class.value);
        this.getBatch(e.target.value ? e.target.value : this.state.class_id);
        this.setState({
            class: this.refs.class.value
                ? this.refs.class.value
                : this.state.class_id,
            subjectName: "",
            amount: 0
        });
    }

    handleChangeBatch(e) {
        console.log(e.target.value);
        this.getSubject(e.target.value ? e.target.value : this.state.batch_id);
        this.setState({
            batch: this.refs.batch.value
                ? this.refs.batch.value
                : this.state.batch_id,
            amount: 0
        });
    }

    handleSubmit(e) {
        e.preventDefault();
        let data = {};
        data = {
            id: this.state.id,
            student_id: this.state.student_id,
            student_type: this.state.student_type,
            class_id: this.refs.class.value,
            branch_id: this.refs.branch.value,
            batch_id: this.refs.batch.value,
            total_amount: this.state.amount,
            subject_id: this.state.checkedItems
        };
        console.log(data);
        AddCourse.addCourse(data).then(res => {
            // console.log(res.data);
            this.props.history.push("/payment");
        });
    }

    updateValue(type, e) {
        var isChecked = e.target.checked;
        var item = e.target.value;
        if (isChecked === true) {
            // this.state.checkedItems.push(e.target.value)
            this.setState({
                checkedItems: this.state.checkedItems.concat(item)
            });
            var data = {
                subject_id: item
            };
            Auth.getSubjectAmount(data).then(res => {
                console.log(res.data.amount);
                var amount =
                    parseInt(this.state.amount) + parseInt(res.data.amount);
                this.setState({ amount: amount });
            });
            console.log(this.state.amount);
            // this.state.checkedItems[item] = item;
        } else {
            // this.state.checkedItems.splice(item, 1);
            var array = [...this.state.checkedItems]; // make a separate copy of the array
            var index = array.indexOf(e.target.value);
            console.log(array);
            console.log(index);
            if (index !== -1) {
                array.splice(index, 1);
                this.setState({ checkedItems: array });
            }
            var data = {
                subject_id: item
            };
            Auth.getSubjectAmount(data).then(res => {
                console.log(res.data.amount);
                var amount =
                    parseInt(this.state.amount) - parseInt(res.data.amount);
                this.setState({ amount: amount });
            });

            console.log(this.state.amount);
        }
        // this.state.checkedItems = e.target.value;
    }

    updateChange(type, e) {
        var obj = {};
        obj[type] =
            e.target.type === "checkbox" ? e.target.checked : e.target.value;
        this.setState(obj);
        // console.log(e.target.value);
    }

    branchSelect() {
        if (this.state.branchName == "" || this.state.branchName == null) {
            return (
                <select className="form-control" id="inputGroupSelect02">
                    <option disabled selected>
                        Choose Your Branch
                    </option>
                </select>
            );
        } else {
            return (
                <select
                    className="form-control"
                    id="inputGroupSelect02"
                    name="branch"
                    ref="branch"
                    onChange={this.handleChangeBranch.bind(this)}
                >
                    <option value="">Choose Your Branch</option>
                    {this.state.branchName.map(rp => (
                        <option value={rp.id} key={rp.id} name={rp.name}>
                            {rp.name}
                        </option>
                    ))}
                </select>
            );
        }
    }

    classSelect() {
        if (this.state.className == "" || this.state.className == null) {
            return (
                <select className="form-control" id="inputGroupSelect02">
                    <option disabled selected>
                        Choose Your Class
                    </option>
                </select>
            );
        } else {
            return (
                <select
                    className="form-control"
                    id="inputGroupSelect02"
                    name="class"
                    ref="class"
                    onChange={this.handleChangeClass.bind(this)}
                >
                    <option value="">Choose Your Class</option>
                    {this.state.className.map(rp => (
                        <option value={rp.id} key={rp.id} name={rp.name}>
                            {rp.name}
                        </option>
                    ))}
                </select>
            );
        }
    }

    batchSelect() {
        if (this.state.batchName == "" || this.state.batchName == null) {
            return (
                <select className="form-control" id="inputGroupSelect02">
                    <option disabled selected>
                        Choose Your Batch
                    </option>
                </select>
            );
        } else {
            return (
                <select
                    className="form-control"
                    id="inputGroupSelect02"
                    name="batch"
                    ref="batch"
                    onChange={this.handleChangeBatch.bind(this)}
                >
                    <option value="">Choose Your Batch</option>
                    {this.state.batchName.map(rp => (
                        <option value={rp.id} key={rp.id} name={rp.name}>
                            {rp.name}
                        </option>
                    ))}
                </select>
            );
        }
    }

    subjectSelect() {
        if (this.state.subjectName == "" || this.state.subjectName == null) {
            return <NoDataFound noDataFoundMessage="No Courses Found" />;
        } else {
            return (
                <>
                    {this.state.subjectName.length ? (
                        <>
                            <h4 className="text-center mt-2 component-header">
                                Select Your Course
                            </h4>
                            <div className="content-underline"></div>
                            <div className="row">
                                <div className="col-md-3"></div>
                                <div className="col-md-7">
                                    <div>
                                        {this.state.subjectName.map(res => (
                                            <div
                                                key={res.id}
                                                className="form-check mt-1 float-left pl-5"
                                            >
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    value={res.id}
                                                    id="defaultCheck5"
                                                    style={{
                                                        backgroundColor: "#ccc"
                                                    }}
                                                    onChange={this.updateValue.bind(
                                                        this,
                                                        res.id
                                                    )}
                                                />
                                                <label
                                                    className="form-check-label pl-1"
                                                    htmlFor="defaultCheck5"
                                                >
                                                    {res.name} &nbsp;-&nbsp;{" "}
                                                    {res.amount} Taka
                                                </label>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                                <div className="col-md-2"></div>
                            </div>
                        </>
                    ) : (
                        <Loading />
                    )}
                </>
            );
        }
    }

    render() {
        // console.log("subject name is", this.state.subjectName);
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
                                        Manage Your Courses
                                    </h2>
                                    <div className="heading-underline"></div>
                                    <p className="text-center">
                                        To add or edit your courses, first you
                                        have to fill up the form below.
                                    </p>
                                </div>
                                <div className="app-background">
                                    <form
                                        className="manage-course-form"
                                        onSubmit={this.handleSubmit.bind(this)}
                                    >
                                        <div className="form-group row">
                                            <label
                                                htmlFor="student-type"
                                                className="col-sm-3 col-form-label my-auto"
                                            >
                                                Student Type
                                            </label>
                                            <div className="col-sm-9">
                                                <input
                                                    type="text"
                                                    className="form-control"
                                                    id="student-type"
                                                    name="student-type"
                                                    placeholder="Your Subscription Type..."
                                                    value="Online"
                                                    disabled
                                                    // value={this.state.institution}
                                                    // onChange={this.updateChange.bind(this, "institution")}
                                                />
                                            </div>
                                        </div>
                                        <div className="form-group row">
                                            <label
                                                htmlFor="branch"
                                                className="col-sm-3 col-form-label my-auto"
                                            >
                                                Branch
                                            </label>
                                            <div className="col-sm-9">
                                                {this.branchSelect()}
                                            </div>
                                        </div>

                                        <div className="form-group row">
                                            <label
                                                htmlFor="class"
                                                className="col-sm-3 col-form-label my-auto"
                                            >
                                                Class
                                            </label>
                                            <div className="col-sm-9">
                                                {this.classSelect()}
                                            </div>
                                        </div>

                                        <div className="form-group row">
                                            <label
                                                htmlFor="batch"
                                                className="col-sm-3 col-form-label my-auto"
                                            >
                                                Batch
                                            </label>
                                            <div className="col-sm-9">
                                                {this.batchSelect()}
                                            </div>
                                        </div>

                                        {this.subjectSelect()}
                                        {this.state.subjectName.length ? (
                                            <div className="row justify-content-center pb-4">
                                                <input
                                                    className="submit-button"
                                                    type="submit"
                                                    defaultValue="Submit"
                                                />
                                            </div>
                                        ) : (
                                            <></>
                                        )}
                                    </form>
                                    {this.state.subjectName.length ? (
                                        <div className="row justify-content-center">
                                            <div className="col-md-3" />
                                            <div className="col-md-6  total-amount text-center">
                                                <span className="course-fee-text">
                                                    Total Course Fee :
                                                </span>{" "}
                                                {""}
                                                <span className="course-fee-amount-text">
                                                    {this.state.amount}
                                                </span>{" "}
                                                <span className="course-fee-text">
                                                    TK
                                                </span>
                                            </div>
                                            <div className="col-md-3" />
                                        </div>
                                    ) : (
                                        <></>
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

export default ManageCourse;

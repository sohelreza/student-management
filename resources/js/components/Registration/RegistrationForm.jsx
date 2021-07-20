import React, { Component } from "react";
import { Link } from "react-router-dom";

import Footer from "../Footer/Footer";
import NoDataFound from "../NoDataFound/NoDataFound";
import { Header } from "../Header/Header";

import Auth from "../../models/Auth";
import validation from "../../Validation/Registration";

import SimpleReactValidator from "simple-react-validator";
import "./RegistrationForm.css";

class Registration extends Component {
    constructor(props) {
        super(props);
        this.state = {
            branch: "",
            std_type: "",
            class: "",
            batch: "",
            branchName: "",
            batchName: "",
            subjectName: "",
            amount: 0,
            first_name: "",
            last_name: "",
            mobileNumber: "",
            paidAmount: 0,
            validDate: "",
            className: "",
            checkedItems: [],
            errors: {},
            error: [],
            validInput: {},
            canSubmit: true
            // checkedItems: new Map(),
        };
        this.validator = new SimpleReactValidator({ autoForceUpdate: this });
        // this.getBranch();
        // this.getAmount();
    }

    getBranch(id) {
        // console.log(data);
        let data = {};
        data = {
            student_type: id
        };
        Auth.getBranchName(data).then(res => {
            // console.log(res.data);
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
            // console.log(res.data);
            this.setState({ className: res.data });
        });
    }

    getBatch(id) {
        let data = {};
        data = {
            class_id: id,
            // student_type: this.refs.std_type.value,
            student_type: this.state.std_type,
            // branch_id: this.refs.branch.value,
            branch_id: this.state.branch
        };
        Auth.getBatchName(data).then(res => {
            this.setState({ batchName: res.data });
        });
    }

    getSubject(id) {
        // console.log(data);

        let data = {};
        data = {
            // class_id: this.refs.class.value,
            class_id: this.state.class,
            // student_type: this.refs.std_type.value,
            student_type: this.state.std_type
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
                // console.log(res);
            });
        }

        data = {
            // subject_id: id
        };

        Auth.getSubjectAmount(data).then(res => {
            // console.log(res.data.amount);
            var amount =
                parseInt(this.state.amount) + parseInt(res.data.amount);
            this.setState({ amount: amount });
        });
    }

    handleChange(e) {
        this.getBranch(e.target.value);
        this.setState({
            std_type: e.target.value,
            // std_type: this.refs.std_type.value,
            subjectName: ""
        });
    }

    handleChangeBranch(e) {
        if (e.target.value) {
            console.log("value found");
        } else {
            console.log("no value found");
        }
        this.getClass(e.target.value);
        this.setState({
            // branch: this.refs.branch.value,
            branch: e.target.value,
            subjectName: "",
            amount: 0
        });
    }

    handleChangeClass(e) {
        if (e.target.value) {
            console.log("value found");
        } else {
            console.log("no value found");
        }
        this.getBatch(e.target.value);
        this.setState({
            // class: this.refs.class.value,
            class: e.target.value,
            subjectName: "",
            amount: 0
        });
    }

    handleChangeBatch(e) {
        if (e.target.value) {
            console.log("value found");
        } else {
            console.log("no value found");
        }
        // console.log(e.target.value);
        this.getSubject(e.target.value);
        this.setState({
            // batch: this.refs.batch.value,
            batch: e.target.value
            // amount: 0
        });
    }

    updateValue(type, e) {
        var isChecked = e.target.checked;
        var item = e.target.value;
        if (isChecked === true) {
            // this.focusOut.bind(this, "checkedItems");
            this.setState({
                checkedItems: this.state.checkedItems.concat(item)
            });

            var data = {
                subject_id: item
            };

            Auth.getSubjectAmount(data).then(res => {
                // console.log(res.data.amount);
                var amount =
                    parseInt(this.state.amount) + parseInt(res.data.amount);
                this.setState({ amount: amount });
            });

            // console.log(this.state.amount);
            // this.state.checkedItems[item] = item;
        } else {
            // this.focusOut.bind(this, "checkedItems");
            // this.state.checkedItems.splice(item, 1);
            var array = [...this.state.checkedItems]; // make a separate copy of the array
            var index = array.indexOf(e.target.value);
            // console.log(array);
            // console.log(index);

            if (index !== -1) {
                array.splice(index, 1);
                this.setState({ checkedItems: array });
            }

            var data = {
                subject_id: item
            };

            Auth.getSubjectAmount(data).then(res => {
                // console.log(res.data.amount);
                var amount =
                    parseInt(this.state.amount) - parseInt(res.data.amount);
                this.setState({ amount: amount });
            });

            // console.log(this.state.amount);
        }
    }

    updateChange(type, e) {
        this.setState(prevState => ({
            validInput: {
                ...prevState.validInput,
                [type]: value
            }
        }));
        let isOk = this.checkProperties(this.state.validInput);
        var obj = {};
        // var validInput = {};
        obj[type] =
            e.target.type === "checkbox" ? e.target.checked : e.target.value;
        obj["canSubmit"] = isOk;
        let value = e.target.value ? true : false;
        // obj["validInput"] = validInput;
        this.setState(obj);

        // first_name
        // console.log(obj);
    }

    handleSubmit(e) {
        e.preventDefault();
        if (this.validator.allValid()) {
            // let validInputLength = this.checkObjectLength(this.state.validInput);

            // if (validInputLength === 8 && this.state.canSubmit) {
            let data = {};
            data = {
                first_name: this.state.first_name,
                last_name: this.state.last_name,
                phone: this.state.mobileNumber,
                // class_id: this.refs.class.value,
                class_id: this.state.class,
                // branch_id: this.refs.branch.value,
                branch_id: this.state.branch,
                // batch_id: this.refs.batch.value,
                batch_id: this.state.batch,
                // student_type: this.refs.std_type.value,
                student_type: this.state.std_type,
                total_amount: this.state.amount,
                paid_amount: this.state.paidAmount,
                due_date: this.state.validDate,
                subject_id: this.state.checkedItems
            };
            // console.log(data);

            Auth.registration(data)
                .then(res => {
                    // console.log(res.data);
                    this.props.history.push({ pathname: "/login", state: 1 });
                })
                .catch(err => {
                    this.setState({ error: err.response.data.errors.phone[0] });
                    window.scrollTo(0, 0);
                });
        } else {
            this.validator.showMessages();
            this.forceUpdate();
        }
        //     });
        // } else {
        //     console.log("All Field Required");
        // }
    }

    checkObjectLength(obj) {
        let size = 0;
        for (let k in obj) {
            size++;
        }
        return size;
    }

    branchSelect() {
        if (this.state.branchName == "" || this.state.branchName == null) {
            return (
                <select
                    className="custom-select"
                    id="inputGroupSelect02"
                    style={{ backgroundColor: "#ccc" }}
                    onBlur={this.focusOut.bind(this, "branch")}
                >
                    <option disabled selected>
                        Choose Your Branch
                    </option>
                </select>
            );
        } else {
            return (
                <>
                    <select
                        className="custom-select"
                        id="inputGroupSelect02"
                        ref="branch"
                        value={this.state.branch}
                        style={{ backgroundColor: "#ccc" }}
                        onChange={this.handleChangeBranch.bind(this)}
                        onBlur={this.focusOut.bind(this, "branch")}
                    >
                        <option value="">Choose Your Branch</option>
                        {this.state.branchName.map(rp => (
                            <option value={rp.id} key={rp.id} name={rp.name}>
                                {rp.name}
                            </option>
                        ))}
                    </select>
                </>
            );
        }
    }

    classSelect() {
        if (this.state.className == "" || this.state.className == null) {
            return (
                <select
                    className="custom-select"
                    id="inputGroupSelect02"
                    style={{ backgroundColor: "#ccc" }}
                    onBlur={this.focusOut.bind(this, "class")}
                >
                    <option disabled selected>
                        Choose Your Class
                    </option>
                </select>
            );
        } else {
            return (
                <select
                    className="custom-select"
                    id="inputGroupSelect02"
                    ref="class"
                    value={this.state.class}
                    style={{ backgroundColor: "#ccc" }}
                    onChange={this.handleChangeClass.bind(this)}
                    onBlur={this.focusOut.bind(this, "class")}
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
                <select
                    className="custom-select"
                    id="inputGroupSelect02"
                    style={{ backgroundColor: "#ccc" }}
                    // onChange={this.handleChangeBatch.bind(this)}
                    onBlur={this.focusOut.bind(this, "batch")}
                >
                    <option disabled selected>
                        Choose Your Batch
                    </option>
                </select>
            );
        } else {
            return (
                <select
                    className="custom-select"
                    id="inputGroupSelect02"
                    ref="batch"
                    value={this.state.batch}
                    style={{ backgroundColor: "#ccc" }}
                    onChange={this.handleChangeBatch.bind(this)}
                    onBlur={this.focusOut.bind(this, "batch")}
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
            return <div></div>;
        } else {
            return (
                <div>
                    {this.state.subjectName.map(res => (
                        <table className="col-md-12 form-check mt-1 subject-checkbox p-0">
                            <tbody key={res.id}>
                                <tr>
                                    <td>
                                        <input
                                            className=""
                                            type="checkbox"
                                            value={res.id}
                                            id="defaultCheck5"
                                            style={{ backgroundColor: "#ccc" }}
                                            onChange={this.updateValue.bind(
                                                this,
                                                res.id
                                            )}
                                        />
                                    </td>
                                    <td>
                                        <label
                                            className="form-check-label pl-1"
                                            htmlFor="defaultCheck5"
                                        >
                                            {res.name} &nbsp;-&nbsp;{" "}
                                            {res.amount} Taka
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    ))}
                    {!this.state.checkedItems.length ? (
                        <span className="text-danger  checked-validation">
                            Please Select A Subject
                        </span>
                    ) : (
                        <></>
                    )}
                </div>
            );
        }
    }

    offlinePayment() {
        if (this.state.std_type !== "" || this.state.std_type !== null) {
            if (this.state.std_type != "0") {
                return <div></div>;
            } else {
                return (
                    <div>
                        <div className="row">
                            <div className="col-xs-6 col-sm-6 col-md-6 p-1">
                                <div className="form-group">
                                    <input
                                        type="number"
                                        name="paid_amount"
                                        id="paid_amount"
                                        className="form-control input-sm"
                                        placeholder="paid amount"
                                        style={{ backgroundColor: "#ccc" }}
                                        value={this.state.paidAmount}
                                        onChange={this.updateChange.bind(
                                            this,
                                            "paidAmount"
                                        )}
                                    />
                                </div>
                            </div>
                            <div className="col-xs-6 col-sm-6 col-md-6 p-1">
                                <div className="form-group">
                                    <input
                                        type="date"
                                        name="valid_date"
                                        id="valid_date"
                                        className="form-control input-sm"
                                        placeholder="Valid Date"
                                        style={{ backgroundColor: "#ccc" }}
                                        value={this.state.validDate}
                                        onChange={this.updateChange.bind(
                                            this,
                                            "validDate"
                                        )}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                );
            }
        }
    }

    focusOut(x) {
        // console.log("from focus out function and x is", x);
        const message = validation.requiredField(x);
        this.setState(prevState => ({
            errors: {
                ...prevState.errors,
                [x]: message
            }
        }));
    }

    checkProperties(obj) {
        let x = false;
        for (var key in obj) {
            if (obj[key] !== null && obj[key] !== "" && true) {
                x = true;
            }
        }
        return x;
    }

    render() {
        // console.log(this.state);

        return (
            <div>
                <Header />
                <div style={{ height: "100px" }}></div>
                <div className="container-fluid">
                    <div className="">
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
                                    <h2 className="registration-heading">
                                        Registration
                                    </h2>
                                    {this.state.error && (
                                        <div className="text-danger text-center">
                                            {this.state.error}
                                        </div>
                                    )}
                                    <form
                                        className=" col-12 col-md-12 registration-form"
                                        style={{ border: "2px solid #ccc" }}
                                        onSubmit={this.handleSubmit.bind(this)}
                                    >
                                        <div className="row">
                                            <div className="col-xs-6 col-sm-6 col-md-6 p-1">
                                                <div className="form-group">
                                                    <input
                                                        type="text"
                                                        name="first_name"
                                                        id="first_name"
                                                        className="form-control input-sm"
                                                        placeholder="First Name"
                                                        style={{
                                                            backgroundColor:
                                                                "#ccc"
                                                        }}
                                                        value={
                                                            this.state
                                                                .first_name
                                                        }
                                                        onChange={this.updateChange.bind(
                                                            this,
                                                            "first_name"
                                                        )}
                                                        // onBlur={this.focusOut.bind(
                                                        //     this,
                                                        //     "first_name"
                                                        // )}
                                                    />
                                                    {this.validator.message(
                                                        "First name",
                                                        this.state.first_name,
                                                        "required",
                                                        {
                                                            className:
                                                                "text-danger"
                                                        }
                                                    )}
                                                    {/* {this.state.first_name ? (
                                                        <></>
                                                    ) : (
                                                            <span className="validation-text-error">
                                                                {
                                                                    this.state
                                                                        .errors
                                                                        .first_name
                                                                }
                                                            </span>
                                                        )} */}
                                                </div>
                                            </div>

                                            <div className="col-xs-6 col-sm-6 col-md-6 p-1">
                                                <div className="form-group">
                                                    <input
                                                        type="text"
                                                        name="last_name"
                                                        id="last_name"
                                                        className="form-control input-sm"
                                                        style={{
                                                            backgroundColor:
                                                                "#ccc"
                                                        }}
                                                        placeholder="Last Name"
                                                        value={
                                                            this.state.last_name
                                                        }
                                                        onChange={this.updateChange.bind(
                                                            this,
                                                            "last_name"
                                                        )}
                                                        onBlur={this.focusOut.bind(
                                                            this,
                                                            "last_name"
                                                        )}
                                                    />
                                                    {this.validator.message(
                                                        "Last name",
                                                        this.state.last_name,
                                                        "required",
                                                        {
                                                            className:
                                                                "text-danger"
                                                        }
                                                    )}
                                                    {/* {this.state.last_name ? (
                                                        <></>
                                                    ) : (
                                                            <span className="validation-text-error">
                                                                {
                                                                    this.state
                                                                        .errors
                                                                        .last_name
                                                                }
                                                            </span>
                                                        )} */}
                                                </div>
                                            </div>
                                        </div>
                                        <div className="form-group p-1">
                                            <input
                                                type="number"
                                                name="mobileNumber"
                                                id="email"
                                                className="form-control input-sm"
                                                placeholder="Mobile Number"
                                                style={{
                                                    backgroundColor: "#ccc"
                                                }}
                                                value={this.state.mobileNumber}
                                                onChange={this.updateChange.bind(
                                                    this,
                                                    "mobileNumber"
                                                )}
                                                onBlur={this.focusOut.bind(
                                                    this,
                                                    "mobileNumber"
                                                )}
                                            />
                                            {this.validator.message(
                                                "mobile number",
                                                this.state.mobileNumber,
                                                "required|min:11",
                                                { className: "text-danger" }
                                            )}
                                            {/* {this.state.mobileNumber ? (
                                                <></>
                                            ) : (
                                                    <span className="validation-text-error">
                                                        {
                                                            this.state.errors
                                                                .mobileNumber
                                                        }
                                                    </span>
                                                )} */}
                                        </div>
                                        <div className="row">
                                            <div className="col-6 p-1">
                                                <div className="input-group">
                                                    <select
                                                        className="custom-select"
                                                        id="inputGroupSelect01"
                                                        ref="std_type"
                                                        value={
                                                            this.state.std_type
                                                        }
                                                        style={{
                                                            backgroundColor:
                                                                "#ccc"
                                                        }}
                                                        onChange={this.handleChange.bind(
                                                            this
                                                        )}
                                                        onBlur={this.focusOut.bind(
                                                            this,
                                                            "std_type"
                                                        )}
                                                    >
                                                        <option
                                                            value=""
                                                            disabled
                                                            selected
                                                        >
                                                            Choose Student Type
                                                        </option>
                                                        {/* <option value="0">
                                                            Offline
                                                        </option> */}
                                                        <option value="1">
                                                            Online
                                                        </option>
                                                    </select>
                                                </div>
                                                {this.validator.message(
                                                    "choose student type",
                                                    this.state.std_type,
                                                    "required",
                                                    { className: "text-danger" }
                                                )}
                                                {/* {this.state.std_type ? (
                                                    <></>
                                                ) : (
                                                        <span className="validation-text-error">
                                                            {
                                                                this.state.errors
                                                                    .std_type
                                                            }
                                                        </span>
                                                    )} */}
                                            </div>
                                            <div className="col-6 p-1">
                                                <div className="input-group">
                                                    {this.branchSelect()}
                                                </div>
                                                {this.validator.message(
                                                    "choose branch",
                                                    this.state.branch,
                                                    "required",
                                                    { className: "text-danger" }
                                                )}
                                                {/* {this.state.branch ? (
                                                    <></>
                                                ) : (
                                                        <span className="validation-text-error">
                                                            {
                                                                this.state.errors
                                                                    .branch
                                                            }
                                                        </span>
                                                    )} */}
                                            </div>
                                        </div>
                                        <div className="row">
                                            <div className="col-6 p-1">
                                                <div className="input-group">
                                                    {this.classSelect()}
                                                </div>
                                                {this.validator.message(
                                                    "choose class",
                                                    this.state.class,
                                                    "required",
                                                    { className: "text-danger" }
                                                )}
                                                {/* {this.state.class ? (
                                                    <></>
                                                ) : (
                                                        <span className="validation-text-error">
                                                            {
                                                                this.state.errors
                                                                    .class
                                                            }
                                                        </span>
                                                    )} */}
                                            </div>
                                            <div className="col-6 p-1">
                                                <div className="input-group">
                                                    {this.batchSelect()}
                                                </div>
                                                {this.validator.message(
                                                    "choose batch",
                                                    this.state.batch,
                                                    "required",
                                                    { className: "text-danger" }
                                                )}
                                                {/* {this.state.batch ? (
                                                    <></>
                                                ) : (
                                                        <span className="validation-text-error">
                                                            {
                                                                this.state.errors
                                                                    .batch
                                                            }
                                                        </span>
                                                    )} */}
                                            </div>
                                        </div>
                                        <div className="row justify-content-center">
                                            <div className="col-lg-2"></div>
                                            <div className="col-lg-8">
                                                {this.subjectSelect()}
                                            </div>
                                            <div className="col-lg-2"></div>
                                        </div>
                                        {/* {this.validator.message('choose subjectName', this.state.subjectName, 'required', { className: 'text-danger' })} */}
                                        {this.state.subjectName.length ? (
                                            <div className="form-group p-1">
                                                <div className="row justify-content-center">
                                                    <div className="col-md-3"></div>
                                                    <div className="col-md-6 total-amount">
                                                        <span className="course-fee-text">
                                                            Total Fee :
                                                        </span>{" "}
                                                        {""}
                                                        <span className="course-fee-amount-text">
                                                            {this.state.amount}
                                                        </span>{" "}
                                                        <span className="course-fee-text">
                                                            TK
                                                        </span>
                                                    </div>
                                                    <div className="col-md-3"></div>
                                                </div>
                                            </div>
                                        ) : (
                                            <NoDataFound noDataFoundMessage="No Courses Found" />
                                        )}
                                        {this.offlinePayment()}
                                        <button
                                            type="submit"
                                            className="btn btn-success btn-lg registration-button"
                                            style={{ borderRadius: "5px" }}
                                        >
                                            Submit
                                        </button>
                                        {this.state.canSubmit ? (
                                            <></>
                                        ) : (
                                            <div className="validation-text-error submit-text-error mt-3">
                                                Please Fill Up All required
                                                Field
                                            </div>
                                        )}
                                    </form>

                                    <div className="forgot-caption">
                                        <p className="small-text">
                                            Have an ID?{" "}
                                            <Link
                                                to={"./login"}
                                                href="#"
                                                className="register-anchor"
                                            >
                                                Login Here
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
export default Registration;

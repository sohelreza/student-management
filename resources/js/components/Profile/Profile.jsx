import React, { Component } from "react";
import DatePicker from "react-datepicker";
import SimpleReactValidator from "simple-react-validator";

import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import { SideBar } from "../SideBar/SideBar";
import Loading from "../Loading/Loading";

import ProfileUpdate from "../../models/ProfileUpdate";
import paymentInfo from "../../models/paymentInfo";

import "./Profile.css";
import "react-datepicker/dist/react-datepicker.css";

class Profile extends Component {
    constructor(props) {
        if (
            !localStorage.getItem("token") &&
            localStorage.getItem("token") > 86400
        ) {
            window.location.href = "/login";
        }
        super(props);
        this.state = {
            userProfile: "",
            file: "",
            firstName: "",
            lastName: "",
            mobileNumber: "",
            dateOfBirth: "",
            gender: "",
            zoom_id: "",
            fatherName: "",
            fatherNumber: "",
            motherName: "",
            motherNumber: "",
            presentAddress: "",
            permanentAddress: "",
            institution: "",
            guardianName: "",
            guardianRelation: "",
            guardianNumber: "",
            guardianAddress: ""
        };
        this.getData();
        this.validator = new SimpleReactValidator({ autoForceUpdate: this });
    }

    getData() {
        window.scrollTo(0, 0);
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
                if (res.data.profile != null || res.data.user_profile != null) {
                    this.setState({
                        student_id: res.data.id,
                        firstName: res.data.first_name,
                        lastName: res.data.last_name,
                        mobileNumber: res.data.phone,
                        userProfile: res.data.user_profile,
                        dateOfBirth: res.data.profile.date_of_birth,
                        gender: res.data.profile.gender,
                        zoom_id: res.data.profile.zoom_id,
                        presentAddress: res.data.profile.present_address,
                        permanentAddress: res.data.profile.permanent_address,
                        fatherName: res.data.profile.father_name,
                        fatherNumber: res.data.profile.father_phone,
                        motherName: res.data.profile.mother_name,
                        motherNumber: res.data.profile.mother_phone,
                        institution: res.data.profile.institution,
                        guardianName: res.data.profile.gaurdian_name,
                        guardianNumber: res.data.profile.gaurdian_phone,
                        guardianRelation: res.data.profile.gaurdian_relation,
                        guardianAddress: res.data.profile.gaurdian_address
                    });
                } else {
                    this.setState({
                        student_id: res.data.id,
                        firstName: res.data.first_name,
                        lastName: res.data.last_name,
                        mobileNumber: res.data.phone
                    });
                }
            });
    }

    updateChange(type, e) {
        var obj = {};
        obj[type] =
            e.target.type === "checkbox" ? e.target.checked : e.target.value;
        this.setState(obj);
    }

    handleChange(e) {
        this.setState({
            // gender: this.refs.gender.value,
            gender: e.target.value ? e.target.value : this.state.gander
        });
    }

    handleChangeFile(e) {
        let reader = new FileReader();
        let file = e.target.files[0];
        reader.onloadend = () => {
            this.setState({
                file: file,
                imagePreviewUrl: reader.result
            });
        };
        reader.readAsDataURL(file);
    }

    handleSubmit(e) {
        e.preventDefault();
        if (this.validator.allValid()) {
            let data = {
                student_id: this.state.student_id,
                first_name: this.state.firstName,
                last_name: this.state.lastName,
                phone: this.state.mobileNumber,
                date_of_birth: this.state.dateOfBirth,
                gender: this.refs.gender.value,
                zoom_id: this.state.zoom_id,
                father_name: this.state.fatherName,
                father_phone: this.state.fatherNumber,
                mother_name: this.state.motherName,
                mother_phone: this.state.motherNumber,
                present_address: this.state.presentAddress,
                permanent_address: this.state.permanentAddress,
                institution: this.state.institution,
                gaurdian_name: this.state.guardianName,
                gaurdian_relation: this.state.guardianRelation,
                gaurdian_phone: this.state.guardianNumber,
                gaurdian_address: this.state.guardianAddress
            };
            if (this.state.userProfile) {
                // console.log(this.state.firstName);
                // const formData = new FormData();
                // formData.append('first_name', this.state.firstName);
                // formData.append("last_name", this.state.lastName);
                // console.log(formData);
                // axios({
                //     method: "patch",
                //     // url: 'http://192.168.1.110/sharework_back_v2/public/backend/upload-product',
                //     url: `http://127.0.0.1:8000/student/student_profile/${this.state.student_id}`,
                //     data: formData,
                //     config: {
                //         headers: {
                //             "content-type": "multipart/form-data"
                //         }
                //     }
                // })
                ProfileUpdate.updateStudentData(
                    this.state.student_id,
                    data
                ).then(res => {
                    window.scrollTo(0, 0);
                    this.setState({ message: "Your profile has been updated" });
                });
            } else {
                ProfileUpdate.addProfile(data).then(res => {
                    console.log(res);
                    this.props.history.push("/dashboard");
                });
            }
        } else {
            this.validator.showMessages();
            this.forceUpdate();
        }
    }

    profileUpdateForm() {
        let { imagePreviewUrl } = this.state;
        return (
            <form
                className="profile-update-form"
                action=""
                onSubmit={this.handleSubmit.bind(this)}
            >
                <div className="form-row">
                    <div className="form-group col-md-6">
                        <label htmlFor="fname">First Name</label>
                        <input
                            type="text"
                            id="fname"
                            name="firstname"
                            placeholder="Your first name..."
                            value={this.state.firstName}
                            disabled
                        />
                    </div>
                    <div className="form-group col-md-6">
                        <label htmlFor="lname">Last Name</label>
                        <input
                            type="text"
                            id="lname"
                            name="lastname"
                            placeholder="Your last name..."
                            value={this.state.lastName}
                            disabled
                        />
                    </div>
                </div>
                <div className="form-row">
                    <div className="form-group col-lg-5">
                        <label htmlFor="mobile-number">Mobile Number</label>
                        <input
                            type="text"
                            id="mobile-number"
                            name="mobile-number"
                            placeholder="Your Unique Mobile Number..."
                            value={this.state.mobileNumber}
                            disabled
                        />
                    </div>
                    <div className="form-group col-lg-4">
                        <label
                            htmlFor="date-of-birth"
                            style={{ display: "block" }}
                        >
                            Date Of Birth
                        </label>

                        <input
                            type="text"
                            id="date-of-birth"
                            name="date-of-birth"
                            placeholder="Choose Your Date Of Birth... date/month/year"
                            value={this.state.dateOfBirth}
                            onChange={this.updateChange.bind(
                                this,
                                "dateOfBirth"
                            )}
                        />
                        {this.validator.message(
                            "Date of Birth",
                            this.state.dateOfBirth,
                            "required",
                            { className: "text-danger" }
                        )}
                    </div>
                    <div className="form-group col-lg-3">
                        <label htmlFor="gender">Gender</label>
                        <select
                            id="gender"
                            name="gender"
                            ref="gender"
                            // value={this.state.gender}
                            value={this.state.gender}
                            onChange={this.handleChange.bind(this)}
                        >
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        {this.validator.message(
                            "gender",
                            this.state.gender,
                            "required",
                            { className: "text-danger" }
                        )}
                    </div>
                </div>
                {/* <div className="">
                    <label htmlFor="zoom id" style={{ display: "block" }}>
                        Profile Image
                    </label>
                    <input
                        type="file"
                        onChange={this.handleChangeFile.bind(
                            this
                        )}
                        accept="image/*"
                        style={{ overflow: 'hidden' }}
                    />
                </div> */}
                <div className="form-group">
                    <label htmlFor="zoom id" style={{ display: "block" }}>
                        Zoom Id{" "}
                        <span style={{ fontSize: "12px" }}>(optional)</span>
                    </label>
                    <input
                        type="text"
                        id="zoom-id"
                        name="zoom-id"
                        placeholder="Input your zoom id"
                        value={this.state.zoom_id}
                        onChange={this.updateChange.bind(this, "zoom_id")}
                    />
                </div>
                <div className="form-group">
                    <label htmlFor="present-address">Present Address</label>
                    <textarea
                        id="present-address"
                        name="present-address"
                        placeholder="Your Present Resident Address..."
                        rows={4}
                        value={this.state.presentAddress}
                        onChange={this.updateChange.bind(
                            this,
                            "presentAddress"
                        )}
                    />
                    {this.validator.message(
                        "present address",
                        this.state.presentAddress,
                        "required",
                        { className: "text-danger" }
                    )}
                </div>
                <div className="form-group">
                    <label htmlFor="permanent-address">Permanent Address</label>
                    <textarea
                        id="permanent-address"
                        name="permanent-address"
                        placeholder="Your Permanent Address..."
                        rows={4}
                        value={this.state.permanentAddress}
                        onChange={this.updateChange.bind(
                            this,
                            "permanentAddress"
                        )}
                    />
                    {this.validator.message(
                        "permanent address",
                        this.state.permanentAddress,
                        "required",
                        { className: "text-danger" }
                    )}
                </div>
                <div className="form-row">
                    <div className="form-group col-xl-7">
                        <label htmlFor="father-name">Father's Name</label>
                        <input
                            type="text"
                            id="father-name"
                            name="father-name"
                            placeholder="Your Father's Name..."
                            value={this.state.fatherName}
                            onChange={this.updateChange.bind(
                                this,
                                "fatherName"
                            )}
                        />
                        {this.validator.message(
                            "father name",
                            this.state.fatherName,
                            "required",
                            { className: "text-danger" }
                        )}
                    </div>
                    <div className="form-group col-xl-5">
                        <label htmlFor="father-phone-no">
                            Father's Phone Number
                        </label>
                        <input
                            type="number"
                            id="father-phone-no"
                            name="father-phone-no"
                            placeholder="Your Father's Phone Number..."
                            value={this.state.fatherNumber}
                            onChange={this.updateChange.bind(
                                this,
                                "fatherNumber"
                            )}
                        />
                        {this.validator.message(
                            "father number",
                            this.state.fatherNumber,
                            "required|min:11",
                            { className: "text-danger" }
                        )}
                    </div>
                </div>
                <div className="form-row">
                    <div className="form-group col-xl-7">
                        <label htmlFor="mother-name">Mother's Name</label>
                        <input
                            type="text"
                            id="mother-name"
                            name="mother-name"
                            placeholder="Your Mother's Name..."
                            value={this.state.motherName}
                            onChange={this.updateChange.bind(
                                this,
                                "motherName"
                            )}
                        />
                        {this.validator.message(
                            "mother name",
                            this.state.motherName,
                            "required",
                            { className: "text-danger" }
                        )}
                    </div>
                    <div className="form-group col-xl-5">
                        <label htmlFor="mother-phone-no">
                            Mother's Phone Number
                        </label>
                        <input
                            type="number"
                            id="mother-phone-no"
                            name="mother-phone-no"
                            placeholder="Your Mother's Phone Number..."
                            value={this.state.motherNumber}
                            onChange={this.updateChange.bind(
                                this,
                                "motherNumber"
                            )}
                        />
                        {this.validator.message(
                            "mother number",
                            this.state.motherNumber,
                            "required|min:11",
                            { className: "text-danger" }
                        )}
                    </div>
                </div>
                <div className="form-group">
                    <label htmlFor="institution">Institution</label>
                    <input
                        type="text"
                        id="institution"
                        name="institution"
                        placeholder="Your School/College Name..."
                        value={this.state.institution}
                        onChange={this.updateChange.bind(this, "institution")}
                    />
                    {this.validator.message(
                        "institution",
                        this.state.institution,
                        "required",
                        { className: "text-danger" }
                    )}
                </div>
                <div className="form-group">
                    <label htmlFor="guardian-name">Guardian Name</label>
                    <input
                        type="text"
                        id="guardian-name"
                        name="guardian-name"
                        placeholder="Your Guardian's Name..."
                        value={this.state.guardianName}
                        onChange={this.updateChange.bind(this, "guardianName")}
                    />
                    {this.validator.message(
                        "guardian name",
                        this.state.guardianName,
                        "required",
                        { className: "text-danger" }
                    )}
                </div>
                <div className="form-row">
                    <div className="form-group col-md-6">
                        <label htmlFor="guardian-phone-no">
                            Guardian's Phone Number
                        </label>
                        <input
                            type="number"
                            id="guardian-phone-no"
                            name="guardian-phone-no"
                            placeholder="Your Guardian's Phone Number..."
                            value={this.state.guardianNumber}
                            onChange={this.updateChange.bind(
                                this,
                                "guardianNumber"
                            )}
                        />
                        {this.validator.message(
                            "guardian number",
                            this.state.guardianNumber,
                            "required|min:11",
                            { className: "text-danger" }
                        )}
                    </div>
                    <div className="form-group col-md-6">
                        <label htmlFor="guardian-relation">
                            Guardian's Relation
                        </label>
                        <input
                            type="text"
                            id="guardian-relation"
                            name="guardian-relation"
                            placeholder="Guardian's Relation With You..."
                            value={this.state.guardianRelation}
                            onChange={this.updateChange.bind(
                                this,
                                "guardianRelation"
                            )}
                        />
                        {this.validator.message(
                            "guardian relation",
                            this.state.guardianRelation,
                            "required",
                            { className: "text-danger" }
                        )}
                    </div>
                </div>
                <div className="form-group">
                    <label htmlFor="guardian-address">Guardian's Address</label>
                    <textarea
                        type="text"
                        id="guardian-address"
                        name="guardian-address"
                        placeholder="Your Guardian's Present Address..."
                        rows="5"
                        value={this.state.guardianAddress}
                        onChange={this.updateChange.bind(
                            this,
                            "guardianAddress"
                        )}
                    />
                    {this.validator.message(
                        "guardian address",
                        this.state.guardianAddress,
                        "required",
                        { className: "text-danger" }
                    )}
                </div>
                <div className="row justify-content-center">
                    <input
                        type="submit"
                        defaultValue="Submit"
                        className="submit-button"
                    />
                </div>
            </form>
        );
    }

    render() {
        return (
            <div style={{ backgroundColor: "#f1f1f1" }}>
                <Header />
                <div style={{ height: "70px" }}></div>
                <div className="container-fluid">
                    <div className="app-margin">
                        <div className="row">
                            <div className="col-md-3 d-none d-md-block d-lg-block">
                                <SideBar />
                            </div>
                            <div className="col-md-9">
                                <div className="content"></div>
                                <div className="app-background mb-3 ">
                                    <h2 className="text-center component-header">
                                        Update Profile
                                    </h2>
                                    <div className="heading-underline"></div>
                                    <p className="text-center">
                                        You can edit your profile information
                                        here.
                                    </p>
                                </div>
                                {this.state.message && (
                                    <div className="app-background mb-3 ">
                                        <div className="text-success text-center">
                                            {this.state.message}
                                        </div>
                                    </div>
                                )}
                                <div className="app-background">
                                    {this.state.firstName ? (
                                        this.profileUpdateForm()
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

export default Profile;

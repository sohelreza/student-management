import React, { Component } from "react";
import { NavLink } from "react-router-dom";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { Button, Modal, ModalHeader, ModalBody, ModalFooter } from "reactstrap";
import {
    faBorderAll,
    faUser,
    faUserEdit,
    faBook,
    faInbox,
    faMoneyCheckAlt,
    faFilePowerpoint,
    faChalkboardTeacher,
    faUpload,
    faBookOpen,
    faCheckSquare,
    faPoll,
    faPenAlt,
    faKey,
    faBars
} from "@fortawesome/free-solid-svg-icons";
import paymentInfo from "../../models/paymentInfo";
import "./SideBar.css";

class SideBar extends Component {
    constructor(props) {
        super(props);
        this.state = {
            student_id: "",
            nextPaymentDate: "",
            studentType: "",
            profileImage: "",
            userProfile: "",
            adminTransId: "",
            date: new Date().toJSON().slice(0, 10),
            width: 0,
            height: 0
        };
        this.updateWindowDimensions = this.updateWindowDimensions.bind(this);
    }

    componentDidMount() {
        this.updateWindowDimensions();
        window.addEventListener("resize", this.updateWindowDimensions);
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
                        student_id: res.data.id
                    };
                    paymentInfo.checkTxId(data).then(res => {
                        this.setState({
                            adminTransId: res.data.admin_transaction_id
                        });
                    });

                    this.setState({
                        student_id: res.data.id,
                        nextPaymentDate: res.data.next_payment_date,
                        studentType: res.data.student_type,
                        profileImage: res.data.profile.image,
                        userProfile: res.data.profile
                    });
                });
        }
    }
    componentWillUnmount() {
        window.removeEventListener("resize", this.updateWindowDimensions);
    }
    updateWindowDimensions() {
        this.setState({ width: window.innerWidth, height: window.innerHeight });
    }

    checkWindowWidth() {
        if (this.state.width >= 768) {
            return "";
        } else {
            return " d-none";
        }
    }

    toggle() {
        this.setState(prevState => ({
            modal: !prevState.modal
        }));
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
        if (this.state.profileImage) {
            const formData = new FormData();
            formData.append("image", this.state.file);
            formData.append("student_id", this.state.student_id);
            axios({
                method: "post",
                // url: 'http://192.168.1.110/sharework_back_v2/public/backend/upload-product',
                url: "http://127.0.0.1:8000/student/student_image_update",
                data: formData,
                config: {
                    headers: {
                        "content-type": "multipart/form-data"
                    }
                }
            }).then(res => {
                window.location.reload();
                // this.setState({
                //     message: "Your Home work is successfully uploaded",
                //     title: "",
                //     teacher: "",
                //     subject: "",
                //     pictures: [],
                // })
            });
        } else {
            const formData = new FormData();
            formData.append("image", this.state.file);
            formData.append("student_id", this.state.student_id);
            axios({
                method: "post",
                // url: 'http://192.168.1.110/sharework_back_v2/public/backend/upload-product',
                url: "http://127.0.0.1:8000/student/student_image_add",
                data: formData,
                config: {
                    headers: {
                        "content-type": "multipart/form-data"
                    }
                }
            }).then(res => {
                window.location.reload();
            });
        }
    }

    photoUpload() {
        return (
            <div className="">
                <Button
                    color=""
                    className="ml-4 mt-3"
                    onClick={this.toggle.bind(this)}
                    style={{
                        color: "#444",
                        cursor: "pointer",
                        height: "35px",
                        border: "1px solid #ccc"
                    }}
                >
                    Photo Upload
                </Button>
                <Modal
                    isOpen={this.state.modal}
                    toggle={this.toggle.bind(this)}
                >
                    <ModalHeader toggle={this.toggle.bind(this)}>
                        Image Upload
                    </ModalHeader>
                    <button
                        type="button"
                        className="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    ></button>
                    <ModalBody>
                        <div>
                            <form>
                                <div className="">
                                    <input
                                        type="file"
                                        onChange={this.handleChangeFile.bind(
                                            this
                                        )}
                                        accept="image/*"
                                        style={{ overflow: "hidden" }}
                                    />
                                </div>
                            </form>
                        </div>
                    </ModalBody>
                    <ModalFooter>
                        <Button
                            onClick={this.handleSubmit.bind(this)}
                            style={{
                                borderRadius: "4px",
                                border: "1px solid",
                                backgroundColor: "#1eb2ef",
                                color: "white",
                                padding: "1%"
                            }}
                        >
                            Upload
                        </Button>
                        <Button
                            color="secondary"
                            data-dismiss="modal"
                            onClick={this.toggle.bind(this)}
                            style={{
                                borderRadius: "4px",
                                border: "1px solid gray",
                                backgroundColor: "white",
                                color: "black",
                                padding: "1%"
                            }}
                        >
                            Cancel
                        </Button>
                    </ModalFooter>
                </Modal>
            </div>
        );
    }

    profileImage() {
        if (this.state.profileImage) {
            return (
                <div className="pb-2">
                    <img
                        src={
                            "../../../../studentImage/" +
                            this.state.profileImage
                        }
                        className="rounded-circle d-block profile-pic"
                    />
                </div>
            );
        } else {
            return (
                <img
                    src={require("../../../assests/images/person4.jpg")}
                    className="rounded-circle d-block profile-pic"
                />
            );
        }
    }

    render() {
        let showSideBar = this.checkWindowWidth();

        return (
            <div className={"sidebar sidebar-padding" + showSideBar}>
                <div className="pb-2">
                    {this.profileImage()}
                    {this.state.userProfile && this.photoUpload()}
                </div>
                <div className="text-left">
                    <NavLink
                        to="/dashboard"
                        className="text-left"
                        activeClassName="active"
                    >
                        <FontAwesomeIcon className="mr-3" icon={faBorderAll} />
                        Dashboard
                    </NavLink>
                    <NavLink
                        to="/profile-info"
                        className="text-left"
                        activeClassName="active"
                    >
                        <FontAwesomeIcon className="mr-3" icon={faUser} />
                        Profile
                    </NavLink>
                    <NavLink
                        to="/profile"
                        className="text-left"
                        activeClassName="active"
                    >
                        <FontAwesomeIcon
                            icon={faUserEdit}
                            style={{ marginRight: 10 }}
                        />
                        Update Profile
                    </NavLink>
                    {this.state.adminTransId !== null && (
                        <>
                            {this.state.studentType == 1 && (
                                <NavLink
                                    to="/manage-course"
                                    className="text-left"
                                    activeClassName="active"
                                >
                                    <FontAwesomeIcon
                                        className="mr-3"
                                        icon={faBook}
                                    />
                                    Manage Courses
                                </NavLink>
                            )}
                            {this.state.nextPaymentDate >= this.state.date && (
                                <>
                                    <NavLink
                                        to="/inbox"
                                        className="text-left"
                                        activeClassName="active"
                                    >
                                        <FontAwesomeIcon
                                            style={{ marginRight: 10 }}
                                            icon={faInbox}
                                        />
                                        Inbox
                                    </NavLink>
                                    <NavLink
                                        to="/payment-history"
                                        className="text-left"
                                        activeClassName="active"
                                    >
                                        <FontAwesomeIcon
                                            style={{ marginRight: 10 }}
                                            icon={faMoneyCheckAlt}
                                        />
                                        Payment History
                                    </NavLink>
                                    <NavLink
                                        to="/content"
                                        className="text-left"
                                        activeClassName="active"
                                    >
                                        <FontAwesomeIcon
                                            className="mr-3"
                                            icon={faFilePowerpoint}
                                        />
                                        Contents
                                    </NavLink>
                                    {/* {this.state.studentType == 1 && ( */}
                                    <NavLink
                                        to="/join-class"
                                        className="text-left"
                                        activeClassName="active"
                                    >
                                        <FontAwesomeIcon
                                            style={{ marginRight: 10 }}
                                            icon={faChalkboardTeacher}
                                        />
                                        Join Class
                                    </NavLink>
                                    {/* )} */}
                                    <NavLink
                                        to="/homework-upload"
                                        className="text-left"
                                        activeClassName="active"
                                    >
                                        <FontAwesomeIcon
                                            style={{ marginRight: 10 }}
                                            icon={faUpload}
                                        />
                                        Homework Upload
                                    </NavLink>
                                    <NavLink
                                        to="/class-lecture"
                                        className="text-left"
                                        activeClassName="active"
                                    >
                                        <FontAwesomeIcon
                                            style={{ marginRight: 10 }}
                                            icon={faBookOpen}
                                        />
                                        Class Lectures
                                    </NavLink>
                                    <NavLink
                                        to="/exam-list"
                                        className="text-left"
                                        activeClassName="active"
                                    >
                                        <FontAwesomeIcon
                                            className="mr-3"
                                            icon={faCheckSquare}
                                        />
                                        MCQ Exam
                                    </NavLink>
                                    <NavLink
                                        to="/mcq-result-list"
                                        className="text-left"
                                        activeClassName="active"
                                    >
                                        <FontAwesomeIcon
                                            className="mr-3"
                                            icon={faPoll}
                                        />
                                        MCQ Exam Result
                                    </NavLink>
                                    <NavLink
                                        to="/cq-exam-list"
                                        className="text-left"
                                        activeClassName="active"
                                    >
                                        <FontAwesomeIcon
                                            className="mr-3"
                                            icon={faPenAlt}
                                        />
                                        CQ Exam
                                    </NavLink>
                                    <NavLink
                                        to="/cq-result-list"
                                        className="text-left"
                                        activeClassName="active"
                                    >
                                        <FontAwesomeIcon
                                            className="mr-3"
                                            icon={faPoll}
                                        />
                                        CQ Exam Result
                                    </NavLink>
                                    <NavLink
                                        to="/class-routine"
                                        className="text-left"
                                        activeClassName="active"
                                    >
                                        <FontAwesomeIcon
                                            className="mr-3"
                                            icon={faBars}
                                        />
                                        Class Routine
                                    </NavLink>
                                    <NavLink
                                        to="/change-password"
                                        className="text-left"
                                        activeClassName="active"
                                    >
                                        <FontAwesomeIcon
                                            className="mr-3"
                                            icon={faKey}
                                        />
                                        Change password
                                    </NavLink>
                                </>
                            )}
                        </>
                    )}
                </div>
            </div>
        );
    }
}

export { SideBar };

import React from "react";
import { Component } from "react";
import HomeWorkUpload from "../../models/HomeWorkUpload";
import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import { SideBar } from "../SideBar/SideBar";
import SimpleReactValidator from "simple-react-validator";
import "./HomeWork.css";
import ProfileUpdate from "../../models/ProfileUpdate";

class HomeWork extends Component {
    constructor(props) {
        if (
            !localStorage.getItem("token") &&
            localStorage.getItem("token") > 86400
        ) {
            window.location.href = "/login";
        }

        super(props);

        this.state = {
            file: null,
            student_id: "",
            title: "",
            teacher: "",
            subject: "",
            message: "",
            pictures: [],
            subjects: [],
            teachers: [],
            multiplePictures: [],
            counter: 0,
            files: []
        };

        window.scrollTo(0, 0);
        this.validator = new SimpleReactValidator({ autoForceUpdate: this });
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
                    if (res.data.user_profile === null) {
                        window.location.href = "/profile";
                    }

                    let data = {
                        student_id: res.data.id
                    };

                    ProfileUpdate.studentSubjects(data).then(res2 => {
                        // console.log(res2.data.subject);
                        this.setState({
                            subjects: res2.data
                        });
                    });

                    ProfileUpdate.studentTeachers().then(res3 => {
                        // console.log(res3.data);
                        this.setState({
                            teachers: res3.data
                        });
                    });

                    this.setState({
                        student_id: res.data.id
                    });
                });
        }
    }

    updateChange(type, e) {
        let obj = {};

        obj[type] =
            e.target.type === "checkbox" ? e.target.checked : e.target.value;

        this.setState(obj);
    }

    handleSubjectChange(e) {
        this.setState({
            // class: this.refs.class.value,
            subject: e.target.value
        });
    }

    handleTeacherChange(e) {
        this.setState({
            // class: this.refs.class.value,
            teacher: e.target.value
        });
    }

    handleChange(e) {
        let reader = new FileReader();
        let file = e.target.files[0];
        var pictures = this.state.pictures;
        var counter = this.state.counter;
        var multiplePictures = this.state.multiplePictures.push(
            this.state.file
        );

        console.log(multiplePictures);

        reader.onloadend = () => {
            pictures.push({
                //multiple Image
                id: pictures.length,
                file: file,
                imagePreviewUrl: reader.result
            });
            this.setState({
                pictures,
                counter: this.state.counter + 1
            }); //multiple image
        };

        reader.readAsDataURL(file);
    }

    imagePreview(x, id, i) {
        const isMobile = window.innerWidth <= 500;
        const isDesktop = window.innerWidth >= 1200;

        if (isMobile) {
            if (i < 3) {
                return (
                    <div>
                        <div
                            className="imgPreview"
                            style={{
                                position: "relative",
                                marginRight: "5px",
                                marginTop: "0px"
                            }}
                        >
                            <div
                                className="btn"
                                onClick={this.deleteImage.bind(this, id)}
                            >
                                <span
                                    onClick={this.deleteImage.bind(this, id)}
                                    style={{ fontSize: "15px", color: "red" }}
                                >
                                    x
                                </span>
                            </div>

                            <img src={x} className="imgPreview" />
                        </div>
                    </div>
                );
            } else if (i >= 3 && i <= 5) {
                return (
                    <div
                        className="imgPreview"
                        style={{
                            position: "relative",
                            marginRight: "5px",
                            marginTop: "10px"
                        }}
                    >
                        <div
                            className="btn"
                            onClick={this.deleteImage.bind(this, id)}
                        >
                            <span
                                onClick={this.deleteImage.bind(this, id)}
                                style={{ fontSize: "15px", color: "red" }}
                            >
                                x
                            </span>
                        </div>

                        <img src={x} className="imgPreview" />
                    </div>
                );
            } else if (i >= 6 && i <= 8) {
                return (
                    <div
                        className="imgPreview"
                        style={{
                            position: "relative",
                            marginRight: "5px",
                            marginTop: "10px"
                        }}
                    >
                        <div
                            className="btn"
                            onClick={this.deleteImage.bind(this, id)}
                        >
                            <span
                                onClick={this.deleteImage.bind(this, id)}
                                style={{ fontSize: "15px", color: "red" }}
                            >
                                x
                            </span>
                        </div>

                        <img src={x} className="imgPreview" />
                    </div>
                );
            } else if (i >= 9 && i <= 10) {
                return (
                    <div
                        className="imgPreview"
                        style={{
                            position: "relative",
                            marginRight: "5px",
                            marginTop: "10px"
                        }}
                    >
                        <div
                            className="btn"
                            onClick={this.deleteImage.bind(this, id)}
                        >
                            <span
                                onClick={this.deleteImage.bind(this, id)}
                                style={{ fontSize: "15px", color: "red" }}
                            >
                                x
                            </span>
                        </div>

                        <img src={x} className="imgPreview" />
                    </div>
                );
            }
        } else if (isDesktop) {
            if (i < 5) {
                return (
                    <div>
                        <div
                            className="imgPreview"
                            style={{
                                position: "relative",
                                marginRight: "5px",
                                marginTop: "0px"
                            }}
                        >
                            <div
                                className="btn"
                                onClick={this.deleteImage.bind(this, id)}
                            >
                                <span
                                    onClick={this.deleteImage.bind(this, id)}
                                    style={{ fontSize: "15px", color: "red" }}
                                >
                                    x
                                </span>
                            </div>

                            <img src={x} className="imgPreview" />
                        </div>
                    </div>
                );
            } else if (i >= 5 && i <= 10) {
                return (
                    <div
                        className="imgPreview"
                        style={{
                            position: "relative",
                            marginRight: "5px",
                            marginTop: "10px"
                        }}
                    >
                        <div
                            className="btn"
                            onClick={this.deleteImage.bind(this, id)}
                        >
                            <span
                                onClick={this.deleteImage.bind(this, id)}
                                style={{ fontSize: "15px", color: "red" }}
                            >
                                x
                            </span>
                        </div>

                        <img src={x} className="imgPreview" />
                    </div>
                );
            }
        } else {
            if (i < 5) {
                return (
                    <div>
                        <div
                            className="imgPreview"
                            style={{
                                position: "relative",
                                marginRight: "5px",
                                marginTop: "0px"
                            }}
                        >
                            <div
                                className="btn"
                                onClick={this.deleteImage.bind(this, id)}
                            >
                                <span
                                    onClick={this.deleteImage.bind(this, id)}
                                    style={{ fontSize: "15px", color: "red" }}
                                >
                                    x
                                </span>
                            </div>

                            <img src={x} className="imgPreview" />
                        </div>
                    </div>
                );
            } else if (i >= 5 && i <= 10) {
                return (
                    <div
                        className="imgPreview"
                        style={{
                            position: "relative",
                            marginRight: "5px",
                            marginTop: "10px"
                        }}
                    >
                        <div
                            className="btn"
                            onClick={this.deleteImage.bind(this, id)}
                        >
                            <span
                                onClick={this.deleteImage.bind(this, id)}
                                style={{ fontSize: "15px", color: "red" }}
                            >
                                x
                            </span>
                        </div>

                        <img src={x} className="imgPreview" />
                    </div>
                );
            }
        }
    }

    deleteImage(i) {
        let pictures = this.state.pictures;
        const removeIndex = pictures.findIndex(e => e.id === i);

        const filteredPictures = this.state.pictures.filter(
            (e, index) => index !== removeIndex
        );

        this.setState({
            pictures: filteredPictures,
            counter: this.state.counter - 1
        });
    }

    handleSubmit(e) {
        e.preventDefault();

        let data = {
            homework_image: this.state.pictures,
            student_id: this.state.student_id
        };

        if (this.validator.allValid()) {
            const formData = new FormData();

            this.state.pictures.map(file => {
                formData.append("homework_image[]", file.file);
                // formData.append('file_string[]', file.image);
            });

            formData.append("student_id", this.state.student_id);
            formData.append("title", this.state.title);
            formData.append("teacher_id", this.state.teacher);
            formData.append("subject_id", this.state.subject);

            axios({
                method: "post",
                // url: 'http://192.168.1.110/sharework_back_v2/public/backend/upload-product',
                url: "http://127.0.0.1:8000/student/homeworks",
                data: formData,
                config: {
                    headers: {
                        "content-type": "multipart/form-data"
                    }
                }
            }).then(res => {
                window.scrollTo(0, 0);
                this.setState({
                    message: "Your Home work is successfully uploaded",
                    title: "",
                    teacher: "",
                    subject: "",
                    pictures: []
                });
            });
        } else {
            this.validator.showMessages();
            this.forceUpdate();
        }
    }

    render() {
        return (
            <div className="join-class-background">
                <Header />
                <div className="height-top"></div>
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
                                        Home Work
                                    </h2>
                                    <div className="heading-underline"></div>
                                    <p className="text-center">
                                        Here you can upload your home work.
                                    </p>
                                </div>
                                {this.state.message && (
                                    <div className="app-background mb-3">
                                        <div className="text-center text-success">
                                            {this.state.message}
                                        </div>
                                    </div>
                                )}
                                <div className="app-background">
                                    <h4 className="text-center mt-2 component-sub-header">
                                        Home work
                                    </h4>
                                    <div className="content-underline mb-4"></div>
                                    <div className="form-group">
                                        <label
                                            htmlFor="zoom id"
                                            style={{ display: "block" }}
                                        >
                                            Title
                                        </label>
                                        <input
                                            type="text"
                                            id="title"
                                            name="title"
                                            placeholder="Input Home work title"
                                            value={this.state.title}
                                            onChange={this.updateChange.bind(
                                                this,
                                                "title"
                                            )}
                                        />
                                        {this.validator.message(
                                            "title",
                                            this.state.title,
                                            "required",
                                            { className: "text-danger" }
                                        )}
                                    </div>
                                    <div className="row">
                                        <div className="col-md-6 col-6 col-lg-6 col-sm-6 p-0">
                                            <label htmlFor="subject">
                                                Subjects
                                            </label>
                                            <select
                                                id="subject"
                                                name="subject"
                                                ref="subject"
                                                // value={this.state.gender}
                                                value={this.state.subject}
                                                onChange={this.handleSubjectChange.bind(
                                                    this
                                                )}
                                            >
                                                <option value="">
                                                    Choose Your subject
                                                </option>
                                                {this.state.subjects.map(rp => (
                                                    <option
                                                        value={rp.subject.id}
                                                        key={rp.id}
                                                        name={rp.subject.name}
                                                    >
                                                        {rp.subject.name}
                                                    </option>
                                                ))}
                                            </select>
                                            {this.validator.message(
                                                "subject",
                                                this.state.subject,
                                                "required",
                                                { className: "text-danger" }
                                            )}
                                        </div>
                                        <div className="col-md-6 col-6 col-lg-6 col-sm-6 pr-0 pt-0 pb-0">
                                            <label htmlFor="subject">
                                                Teachers
                                            </label>
                                            <select
                                                id="subject"
                                                name="subject"
                                                ref="subject"
                                                // value={this.state.gender}
                                                value={this.state.teacher}
                                                onChange={this.handleTeacherChange.bind(
                                                    this
                                                )}
                                            >
                                                <option value="">
                                                    Choose Your teacher
                                                </option>
                                                {this.state.teachers.map(rp => (
                                                    <option
                                                        value={rp.id}
                                                        key={rp.id}
                                                        name={rp.name}
                                                    >
                                                        {rp.name}
                                                    </option>
                                                ))}
                                            </select>
                                            {this.validator.message(
                                                "teacher",
                                                this.state.teacher,
                                                "required",
                                                { className: "text-danger" }
                                            )}
                                        </div>
                                    </div>
                                    <div className="">
                                        <label
                                            htmlFor="zoom id"
                                            style={{ display: "block" }}
                                        >
                                            Image
                                        </label>
                                        <input
                                            type="file"
                                            onChange={this.handleChange.bind(
                                                this
                                            )}
                                            // accept="image/*"
                                            accept="image/x-png,image/gif,image/jpeg,image/jpg,image/svg"
                                            style={{ overflow: "hidden" }}
                                        />
                                        {this.validator.message(
                                            "pictures",
                                            this.state.pictures,
                                            "required",
                                            { className: "text-danger" }
                                        )}
                                    </div>

                                    <div
                                        className="row col-md-12 pl-0 "
                                        style={{
                                            marginLeft: "0px",
                                            marginTop: "20px",
                                            marginRight: "5px"
                                        }}
                                    >
                                        <div
                                            className=""
                                            style={{ marginTop: "0px" }}
                                        >
                                            <div
                                                className="row multiple_image_upload"
                                                style={{
                                                    marginLeft: "0px",
                                                    width: "450px!important",
                                                    marginRight: "5px"
                                                }}
                                            >
                                                {this.state.pictures.map(
                                                    (p, i) =>
                                                        this.imagePreview(
                                                            p.imagePreviewUrl,
                                                            p.id,
                                                            i
                                                        )
                                                )}
                                            </div>
                                        </div>
                                        <div
                                            className=""
                                            style={{
                                                marginLeft: "5px",
                                                marginTop: "0px"
                                            }}
                                        ></div>
                                        <div
                                            className=""
                                            style={{
                                                marginLeft: "5px",
                                                marginTop: "0px"
                                            }}
                                        ></div>
                                        <div
                                            className=""
                                            style={{
                                                marginLeft: "5px",
                                                marginTop: "0px"
                                            }}
                                        ></div>
                                        <div
                                            className=""
                                            style={{
                                                marginLeft: "5px",
                                                marginTop: "0px"
                                            }}
                                        ></div>
                                        <div
                                            className=""
                                            style={{ marginTop: "10px" }}
                                        ></div>
                                        <div
                                            className=""
                                            style={{
                                                marginLeft: "5px",
                                                marginTop: "10px"
                                            }}
                                        ></div>
                                        <div
                                            className=""
                                            style={{
                                                marginLeft: "5px",
                                                marginTop: "10px"
                                            }}
                                        ></div>
                                        <div
                                            className=""
                                            style={{
                                                marginLeft: "5px",
                                                marginTop: "10px"
                                            }}
                                        ></div>
                                        <div
                                            className=""
                                            style={{
                                                marginLeft: "5px",
                                                marginTop: "10px"
                                            }}
                                        ></div>
                                    </div>

                                    {/* <img src={this.state.file} /> */}
                                    <div className="">
                                        <button
                                            className="btn btn-success update-button"
                                            onClick={this.handleSubmit.bind(
                                                this
                                            )}
                                        >
                                            Submit
                                        </button>
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
export { HomeWork };

import React, { Component } from "react";
import ExamQus from "../../models/ExamQus";
import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import SimpleReactValidator from "simple-react-validator";
import { Link } from "react-router-dom";
import "./CqExam.css";
class CqExam extends Component {
    constructor(props) {
        super(props);
        var today = new Date(),
            time =
                today.getHours() +
                ":" +
                today.getMinutes() +
                ":" +
                today.getSeconds();
        this.state = {
            currentIndex: 0,
            disable: false,
            allQuestions: [],
            answers: [],
            exam_id: "",
            subject_id: "",
            question_id: "",
            question_title: "",
            time: {},
            seconds: "",
            end_time: "",
            start_time: "",
            file: null,
            student_id: "",
            pictures: [],
            multiplePictures: [],
            counter: 0,
            final_result: 0,
            files: [],
            timesOut: 0,
            currentTime: time
        };
        this.timer = 0;
        this.loadQuiz();
        this.validator = new SimpleReactValidator({ autoForceUpdate: this });
    }

    loadQuiz() {
        const { currentIndex } = this.state;
        let data = {
            // exam_id: 2,

            exam_id: this.props.location.state.id,
            student_id: this.props.location.state.student_id
        };
        ExamQus.getCqQuestion(data).then(res => {
            this.setState({
                exam_id: res.data.id,
                subject_id: res.data.subject_id,
                // question_id: res.data.exam_questions[currentIndex].id,
                allQuestions: res.data.questions,
                // options: res.data.exam_questions[currentIndex].options,
                totalQuestion: res.data.total_questions,
                seconds: res.data.total_exam_duration,
                // seconds: 10,
                end_time: res.data.end_time,
                start_time: res.data.start_time
                // answer: res.data.exam_questions[currentIndex].options
            });
            this.startTimer();
            if (this.state.start_time <= this.state.currentTime) {
                let currentTime = this.state.currentTime.split(":");
                let endTime = this.state.end_time.split(":");
                if (endTime[0] == currentTime[0]) {
                    let sec = endTime[1] - currentTime[1];
                    let timeLeftVar = this.secondsToTime(sec);
                    this.setState({ time: timeLeftVar });
                } else if (endTime[0] > currentTime[0]) {
                    let sec =
                        parseInt(endTime[0] * 60) +
                        parseInt(endTime[1]) -
                        (parseInt(currentTime[0] * 60) +
                            parseInt(currentTime[1]));
                    let timeLeftVar = this.secondsToTime(sec);
                    this.setState({ time: timeLeftVar });
                } else {
                    console.log("before" + this.state.currentTime);
                }
            } else {
                console.log("before" + this.state.currentTime);
                let timeLeftVar = this.secondsToTime(this.state.seconds);
                this.setState({ time: timeLeftVar });
            }
        });
    }

    secondsToTime(secs) {
        // console.log(secs);
        let hours = Math.floor(secs / (60 * 60));

        let divisor_for_minutes = secs % (60 * 60);
        let minutes = Math.floor(divisor_for_minutes / 60);

        let divisor_for_seconds = divisor_for_minutes % 60;
        let seconds = Math.ceil(divisor_for_seconds);

        let obj = {
            h: hours,
            m: minutes,
            s: seconds
        };
        return obj;
    }

    startTimer() {
        this.timer = 0;
        if (this.timer == 0 && this.state.seconds > 0) {
            this.timer = setInterval(this.countDown.bind(this), 60000);
        }
    }

    countDown() {
        // Remove one second, set state so a re-render happens.

        if (this.state.start_time <= this.state.currentTime) {
            let currentTime = this.state.currentTime.split(":");
            // console.log(currentTime[1]);
            let endTime = this.state.end_time.split(":");
            let sec = endTime[1] - currentTime[1];
            let seconds = sec - 1;
            this.setState({
                time: this.secondsToTime(seconds),
                seconds: seconds,
                currentIndex: this.state.currentIndex + 1
            });

            // Check if we're at zero.
            if (seconds == 0) {
                clearInterval(this.timer);
                if (this.state.end_time > this.state.currentTime) {
                    this.answer();
                } else {
                    this.setState({
                        timesOut: 1
                    });
                }
            }
            // this.setState({

            // })
        }
    }

    componentDidUpdate(prevProps, prevState) {
        const { currentIndex } = this.state;
        if (this.state.currentIndex !== prevState.currentIndex) {
            var today = new Date(),
                time =
                    today.getHours() +
                    ":" +
                    today.getMinutes() +
                    ":" +
                    today.getSeconds();
            this.state.currentTime = time;
            this.startTimer();
            let currentTime = this.state.currentTime.split(":");
            let endTime = this.state.end_time.split(":");
            if (endTime[0] == currentTime[0]) {
                let sec = endTime[1] - currentTime[1];
                let timeLeftVar = this.secondsToTime(sec);
                this.setState({ time: timeLeftVar });
            } else if (endTime[0] > currentTime[0]) {
                let sec =
                    parseInt(endTime[0] * 60) +
                    parseInt(endTime[1]) -
                    (parseInt(currentTime[0] * 60) + parseInt(currentTime[1]));
                let timeLeftVar = this.secondsToTime(sec);
                this.setState({ time: timeLeftVar });
            } else {
                console.log("before" + this.state.currentTime);
            }
        }
    }

    handleChange(e) {
        let reader = new FileReader();
        let file = e.target.files[0];
        var pictures = this.state.pictures;
        var counter = this.state.counter;
        var multiplePictures = this.state.multiplePictures.push(
            this.state.file
        );
        // console.log(multiplePictures);
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
            } else if (i >= 9) {
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
                            <img
                                src={x}
                                className="imgPreview"
                                style={{ height: "50px" }}
                            />
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
                            marginTop: "5px"
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
                        <img
                            src={x}
                            className="imgPreview"
                            style={{ height: "50px" }}
                        />
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
                            {}
                            <img
                                src={x}
                                className="imgPreview"
                                style={{ height: "50px" }}
                            />
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
                        <img
                            src={x}
                            className="imgPreview"
                            style={{ height: "50px" }}
                        />
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
        if (this.validator.allValid()) {
            let data = {
                exam_image: this.state.pictures,
                student_id: this.state.student_id
            };

            this.state.disable = true;

            const formData = new FormData();
            this.state.pictures.map(file => {
                formData.append("exam_image[]", file.file);
                // formData.append('file_string[]', file.image);
            });
            formData.append("student_id", this.props.location.state.student_id);
            formData.append("exam_id", this.props.location.state.id);
            // formData.append("student_id", this.state.student_id);
            // formData.append("exam_id", this.props.location.state.id);
            axios({
                method: "post",
                url: "http://127.0.0.1:8000/student/cq_exam_answer_submit",
                data: formData,
                config: {
                    headers: {
                        "content-type": "multipart/form-data"
                    }
                }
            }).then(res => {
                this.setState({
                    message: "Your answer Image is successfully uploaded",
                    final_result: 1,
                    pictures: []
                });
            });
        } else {
            this.validator.showMessages();
            this.forceUpdate();
        }
    }

    answer() {
        return (
            <div className="app-background">
                <h4 className="text-center mt-2 component-header">Answer</h4>
                <div className="content-underline mb-4"></div>
                <div className="">
                    <input
                        type="file"
                        onChange={this.handleChange.bind(this)}
                        // accept="image/*"
                        accept="image/x-png,image/gif,image/jpeg,image/jpg,image/svg"
                        style={{ overflow: "hidden" }}
                    />
                </div>
                {this.validator.message(
                    "answer image",
                    this.state.pictures,
                    "required",
                    { className: "text-danger" }
                )}

                <div
                    className="row col-md-12 pl-0 "
                    style={{
                        marginLeft: "0px",
                        marginTop: "20px",
                        marginRight: "5px"
                    }}
                >
                    <div className="" style={{ marginTop: "0px" }}>
                        <div
                            className="row multiple_image_upload"
                            style={{
                                marginLeft: "0px",
                                width: "450px!important",
                                marginRight: "5px"
                            }}
                        >
                            {this.state.pictures.map((p, i) =>
                                this.imagePreview(p.imagePreviewUrl, p.id, i)
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
                    <div className="" style={{ marginTop: "10px" }}></div>
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

                <div className="">
                    {this.state.end_time > this.state.currentTime && (
                        <button
                            className="btn btn-success update-button"
                            onClick={this.handleSubmit.bind(this)}
                            disable={this.state.disable}
                        >
                            Submit
                        </button>
                    )}
                </div>
            </div>
        );
    }

    render() {
        const { allQuestions, currentIndex } = this.state;
        const renderHTML = rawHTML =>
            React.createElement("div", {
                dangerouslySetInnerHTML: { __html: rawHTML }
            });
        return (
            <div style={{ backgroundColor: "#f1f1f1" }}>
                <Header />
                <div style={{ height: "70px" }}></div>
                <div className="">
                    <div className="">
                        <div className="row">
                            {/* <div className="col-md-3">
                                <SideBar />
                            </div> */}
                            <div className="col-md-12">
                                <div className="content"></div>
                                <div className="app-background mb-3 ">
                                    <h2 className="text-center component-header">
                                        Student ExamBoard
                                    </h2>
                                    <div className="heading-underline"></div>
                                </div>
                                {this.state.final_result == 0 &&
                                    this.state.timesOut == 0 && (
                                        <div className="app-background">
                                            <div className="row">
                                                <div className="col-md-12 text-right">
                                                    <b>
                                                        {" "}
                                                        {this.state.time.m}{" "}
                                                        hours{" "}
                                                        {this.state.time.s}{" "}
                                                        minutes
                                                    </b>
                                                </div>
                                            </div>
                                            {allQuestions.map((res, id) => (
                                                <div className="row">
                                                    <div className="col-11 col-md-11 pl-0">
                                                        <div className="row">
                                                            <div className="">
                                                                {id + 1}
                                                            </div>
                                                            <div className="">
                                                                {" "}
                                                                .{" "}
                                                            </div>
                                                            <div
                                                                className="card"
                                                                style={{
                                                                    border:
                                                                        "0px solid"
                                                                }}
                                                            >
                                                                {renderHTML(
                                                                    res.question_title
                                                                )}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        className="col-1 col-md-1 pl-0"
                                                        style={{
                                                            float: "left"
                                                        }}
                                                    >
                                                        {res.mark}
                                                    </div>
                                                </div>
                                            ))}

                                            <div className="">
                                                {this.answer()}
                                            </div>
                                        </div>
                                    )}
                                {this.state.final_result == 1 &&
                                    this.state.timesOut == 0 && (
                                        <div className="app-background">
                                            {/* <div className="row">
                                        Your Score is = {this.state.score}
                                    </div> */}
                                            <div className="text-center">
                                                Congratulations!
                                            </div>
                                            <div className="text-center">
                                                You Have successfully completed
                                                your exam.
                                            </div>
                                            <div className="text-center">
                                                To see your result please click
                                                the button
                                            </div>
                                            <div className="text-center">
                                                <button className="btn btn-md btn-success">
                                                    <Link
                                                        to={"/cq-result-list"}
                                                        style={{
                                                            color: "#fff"
                                                        }}
                                                    >
                                                        Result
                                                    </Link>
                                                </button>
                                            </div>
                                        </div>
                                    )}
                                {this.state.final_result == 0 &&
                                    this.state.timesOut == 1 && (
                                        <div className="app-background">
                                            <div className="text-center">
                                                Unfortunately!
                                            </div>
                                            <div className="text-center">
                                                Your exam has been ended for
                                                times out.
                                            </div>
                                            <div className="text-center">
                                                To see your result please click
                                                the button
                                            </div>
                                            <div className="text-center">
                                                <button className="btn btn-md btn-success">
                                                    <Link
                                                        to={"/cq-result-list"}
                                                        style={{
                                                            color: "#fff"
                                                        }}
                                                    >
                                                        Result
                                                    </Link>
                                                </button>
                                            </div>
                                        </div>
                                    )}
                            </div>
                        </div>
                    </div>
                </div>
                <Footer />
            </div>
        );
    }
}
export default CqExam;

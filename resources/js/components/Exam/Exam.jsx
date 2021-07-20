import React, { Component } from "react";
import { Link } from "react-router-dom";
import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import { SideBar } from "../SideBar/SideBar";
import ExamQus from "../../models/ExamQus";

import "./Exam.css";

class Exam extends Component {
    constructor(props) {
        if (
            !localStorage.getItem("token") &&
            localStorage.getItem("token") > 86400
        ) {
            window.location.href = "/login";
        }
        super(props);
        var today = new Date(),
            time =
                (today.getHours() < 10 ? "0" : "") +
                today.getHours() +
                ":" +
                (today.getMinutes() < 10 ? "0" : "") +
                today.getMinutes() +
                ":" +
                (today.getSeconds() < 10 ? "0" : "") +
                today.getSeconds();
        this.state = {
            userAnswer: [],
            currentIndex: 0,
            options: [],
            quizEnd: false,
            score: 0,
            final_result: 0,
            forceReload: 0,
            final_questions: [],
            disable: true,
            allQuestions: [],
            questions: [],
            // question_title: "",
            answers: [],
            exam_id: "",
            subject_id: "",
            question_id: "",
            time: {},
            seconds: "",
            exam_duration: "",
            end_time: "",
            currentTime: time
        };

        this.timer = 0;

        // this.startTimer = this.startTimer.bind(this);
        // this.countDown = this.countDown.bind(this);
        // if(this.props.location.state.student_id){
        // console.log(this.props.location.state.student_id);
        // }
        // if (window.performance) {
        //     if (performance.navigation.type == 1) {
        //         alert("This page is reloaded");
        //     } else {
        //         alert("This page is not reloaded");
        //     }
        // }
        this.loadQuiz();
    }

    loadQuiz() {
        const { currentIndex } = this.state;
        let data = {
            // exam_id: 12
            student_id: this.props.location.state.student_id,
            exam_id: this.props.location.state.id
        };
        ExamQus.getQuestion(data).then(res => {
            if (res.data.exam_enroll == null || res.data.exam_enroll == 0) {
                this.setState({
                    exam_id: res.data.exam.id,
                    subject_id: res.data.exam.subject_id,
                    questions: res.data.exam_questions,
                    // question_id: res.data.exam_questions[currentIndex].id,
                    // questions: res.data.exam_questions[currentIndex].question_title,
                    // options: res.data.exam_questions[currentIndex].options,
                    totalQuestion: res.data.total_questions,
                    seconds: res.data.exam.duration_per_question,
                    exam_duration: res.data.exam.duration_per_question,
                    enrollScore: res.data.exam_enroll,
                    // seconds: 10,
                    end_time: res.data.exam.end_time
                    // answer: res.data.exam_questions[currentIndex].options
                });
                this.startTimer();
                let timeLeftVar = this.secondsToTime(this.state.seconds);
                this.setState({ time: timeLeftVar });
            } else {
                this.setState({ forceReload: 1, final_result: 1 });
            }
        });
    }

    secondsToTime(secs) {
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
        if (this.state.currentIndex <= this.state.totalQuestion - 1) {
            this.timer = 0;
            if (this.timer == 0 && this.state.seconds > 0) {
                this.timer = setInterval(this.countDown.bind(this), 1000);
            }
        } else {
            this.timer = 1;
            if (this.timer == 0 && this.state.seconds > 0) {
                this.timer = setInterval(this.countDown(), 1000);
            }
        }
    }

    countDown() {
        // Remove one second, set state so a re-render happens.
        let seconds = this.state.seconds - 1;
        this.setState({
            time: this.secondsToTime(seconds),
            seconds: seconds
        });

        // Check if we're at zero.
        if (seconds == 0) {
            clearInterval(this.timer);
            if (this.state.end_time > this.state.currentTime) {
                if (this.state.currentIndex < this.state.totalQuestion - 1) {
                    this.nextQuestionHandler();
                } else {
                    this.result(0);
                }
            } else {
                this.result(1);
            }
        }
    }

    nextQuestionHandler() {
        clearInterval(this.timer);
        // console.log(this.state.end_time)
        // console.log(this.state.currentTime)
        if (this.state.end_time > this.state.currentTime) {
            let answers = [];
            const { userAnswer, answer, score } = this.state;
            if (this.state.userAnswer.length == 0) {
                answers[this.state.currentIndex] = ["0"];
            } else {
                answers[this.state.currentIndex] = this.state.userAnswer;
            }
            this.state.userAnswer = [];
            let data = {
                answers: answers[this.state.currentIndex],
                exam_id: this.state.exam_id,
                force: 0,
                // student_id: 66,
                student_id: this.props.location.state.student_id,
                question_id: this.state.questions[this.state.currentIndex].id
            };
            ExamQus.postAnswer(data).then(res => {
                console.log(res.data.total_questions);
            });
            this.setState({
                currentIndex: this.state.currentIndex + 1,
                seconds: this.state.exam_duration
            });
            console.log(this.state.exam_duration);
        } else {
            this.result(1);
        }
    }

    result(flag) {
        clearInterval(this.timer);
        let answers = [];
        const { userAnswer, answer, score } = this.state;
        if (this.state.userAnswer.length == 0) {
            answers[this.state.currentIndex] = ["0"];
        } else {
            answers[this.state.currentIndex] = this.state.userAnswer;
        }
        this.state.userAnswer = [];
        let data = {
            answers: answers[this.state.currentIndex],
            exam_id: this.state.exam_id,
            force: flag != undefined ? flag : 0,
            // student_id: 66,
            student_id: this.props.location.state.student_id,
            question_id: this.state.questions[this.state.currentIndex].id
        };
        ExamQus.postAnswer(data).then(res => {
            console.log(res.data.total_questions);
        });
        let resultData = {
            exam_id: this.state.exam_id,
            // student_id: 66,
            student_id: this.props.location.state.student_id
        };
        ExamQus.getAllAnswer(resultData).then(res => {
            this.setState({
                final_result: 1,
                score: res.data.enroll.score,
                final_questions: res.data.questions
            });
        });
    }

    componentDidUpdate(prevProps, prevState) {
        const { currentIndex } = this.state;
        if (this.state.currentIndex !== prevState.currentIndex) {
            let data = {
                // exam_id: 12
                student_id: this.props.location.state.student_id,
                exam_id: this.props.location.state.id
            };
            // console.log(this.state.seconds)
            // ExamQus.getQuestion(data).then(res => {
            // this.setState({
            //     disabled: true,
            //     exam_id: res.data.exam.id,
            //     subject_id: res.data.exam.subject_id,
            //     question_id: res.data.exam_questions[currentIndex].id,
            //     questions:
            //         res.data.exam_questions[currentIndex].question_title,
            //     options: res.data.exam_questions[currentIndex].options,
            //     totalQuestion: res.data.total_questions,
            //     seconds: res.data.exam.duration_per_question,
            //     end_time: res.data.exam.end_time,
            //     currentTime: this.state.currentTime
            //     // seconds: 11,
            // });
            var today = new Date(),
                time =
                    (today.getHours() < 10 ? "0" : "") +
                    today.getHours() +
                    ":" +
                    (today.getMinutes() < 10 ? "0" : "") +
                    today.getMinutes() +
                    ":" +
                    (today.getSeconds() < 10 ? "0" : "") +
                    today.getSeconds();
            this.state.currentTime = time;
            this.startTimer();
            let timeLeftVar = this.secondsToTime(this.state.seconds);
            this.setState({ time: timeLeftVar });
            // });
        }
    }

    updateChange(type, e) {
        const { currentIndex } = this.state;
        var isChecked = e.target.checked;
        var item = e.target.value;
        if (isChecked === true) {
            this.setState({
                userAnswer: this.state.userAnswer.concat(item)
            });
        } else {
            var array = [...this.state.userAnswer];
            var index = array.indexOf(e.target.value);
            if (index !== -1) {
                array.splice(index, 1);
                this.setState({ userAnswer: array });
            }
        }
    }

    nextQuestion(currentIndex) {
        if (currentIndex < this.state.totalQuestion - 1) {
            return (
                <div className="text-center">
                    <button
                        className="btn btn-success update-button"
                        onClick={this.nextQuestionHandler.bind(this)}
                    >
                        Next {">"}
                    </button>
                </div>
            );
        } else {
            return (
                <div className="text-center">
                    <button
                        className="btn btn-success update-button"
                        onClick={this.result.bind(this, 0)}
                    >
                        Finish
                    </button>
                </div>
            );
        }
        // } else {
        //     return (
        //         <div className="text-center">
        //             <button className="btn btn-success" onClick={this.result.bind(this)}>Finish</button>
        //         </div>
        //     )
        // }
    }

    render() {
        const { questions, options, currentIndex, quizEnd } = this.state;
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
                                {this.state.final_result == 0 && (
                                    <div className="app-background">
                                        <div className="row">
                                            <div className="col-md-6 col-6 pl-0">
                                                Question No : {currentIndex + 1}{" "}
                                                / {this.state.totalQuestion}
                                            </div>
                                            <div className="col-md-6 col-6 text-right">
                                                <b>
                                                    {" "}
                                                    {
                                                        this.state.time.m
                                                    } mins {this.state.time.s}{" "}
                                                    secs
                                                </b>
                                            </div>
                                        </div>
                                        <div className="row">
                                            <div className="">
                                                {currentIndex + 1}
                                            </div>
                                            <div className="">.</div>
                                            <div
                                                className="card"
                                                style={{ border: "0px solid" }}
                                            >
                                                {questions[currentIndex] &&
                                                    renderHTML(
                                                        questions[currentIndex]
                                                            .question_title
                                                    )}
                                                {/* {console.log((questions[currentIndex].question_title)&&)} */}
                                                {/* {console.log(questions)} */}
                                                {/* {renderHTML(exam_questions[currentIndex].question_title)} */}
                                            </div>
                                        </div>
                                        {questions[currentIndex] &&
                                            questions[currentIndex].options.map(
                                                res => (
                                                    <div
                                                        className="row from-check col-md-12 pl-5"
                                                        key={res.id}
                                                    >
                                                        {/* {res.data} */}
                                                        <input
                                                            type="checkbox"
                                                            className="form-check-input"
                                                            id="exampleCheck1"
                                                            value={
                                                                res.option_number
                                                            }
                                                            onClick={this.updateChange.bind(
                                                                this,
                                                                currentIndex
                                                            )}
                                                        />
                                                        <div className="form-check-label">
                                                            {renderHTML(
                                                                res.option_title
                                                            )}
                                                        </div>
                                                    </div>
                                                )
                                            )}
                                        <div className="">
                                            {questions[currentIndex] &&
                                                this.nextQuestion(currentIndex)}
                                        </div>
                                    </div>
                                )}
                                {this.state.final_result == 1 &&
                                    this.state.forceReload == 0 && (
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
                                                        to={"/mcq-result-list"}
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
                                {this.state.forceReload == 1 &&
                                    this.state.final_result == 1 && (
                                        <div className="app-background">
                                            <div className="text-center">
                                                Unfortunately!
                                            </div>
                                            <div className="text-center">
                                                Your exam has been ended for
                                                reloading.
                                            </div>
                                            <div className="text-center">
                                                To see your result please click
                                                the button
                                            </div>
                                            <div className="text-center">
                                                <button className="btn btn-md btn-success">
                                                    <Link
                                                        to={"/mcq-result-list"}
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
export { Exam };

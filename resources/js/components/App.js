import React, { Component } from "react";
import { Router, Route, Switch } from "react-router-dom";
import ReactDOM from "react-dom";

import ChangePassword from "./ChangePassword/ChangePassword";
import ClassLecture from "./ClassLecture/ClassLecture";
import ClassRoutine from "./ClassRoutine/ClassRoutine";
import Contents from "./Contents/Contents";
import CqExam from "./CqExam/CqExam";
import CqExamList from "./CqExam/CqExamList";
import CqExamRankList from "./CqExam/CqExamRankList";
import { CqExamResultList } from "./CqExam/CqExamResultList";
import Dashboard from "./Dashboard/Dashboard";
import { Exam } from "./Exam/Exam";
import { ExamList } from "./Exam/ExamList";
import ForgetPassword from "./ForgetPassword/ForgetPassword";
import { HomeWork } from "./HomeWork/HomeWork";
import Inbox from "./Inbox/Inbox";
import JoinClass from "./JoinClass/JoinClass";
import LiveClassHistory from "./LiveClassHistory/LiveClassHistory";
import Login from "./Login/Login";
import ManageCourse from "./ManageCourse/ManageCourse";
import { McqExam } from "./Exam/McqExam";
import McqExamAnswer from "./Exam/McqExamAnswer";
import { McqExamList } from "./Exam/McqExamList";
import McqExamRank from "./Exam/McqExamRank";
import Payment from "./Payment/Payment";
import PaymentHistory from "./PaymentHistory/PaymentHistory";
import PdfViewer from "./PdfViewer/PdfViewer";
import Profile from "./Profile/Profile";
import ProfileInfo from "./ProfileInfo/ProfileInfo";
import Registration from "./Registration/RegistrationForm";
// import { ZoomClass } from "./ZoomClass";

import { history } from "../helpers/history";

import "bootstrap";
import "../../assests/css/style.css";
import "bootstrap/dist/css/bootstrap.css";

class App extends Component {
    constructor(props) {
        super(props);
        this.state = {
            public_url: "/"
        };
    }

    render() {
        return (
            <Router history={history}>
                <Switch>
                    {/* <StudentContextProvider> */}
                    {/* <Route path={`${this.state.public_url}login`}  component={Login} />*/}
                    <Route path="/dashboard" component={Dashboard} />
                    <Route path="/profile-info" component={ProfileInfo} />
                    <Route path="/class-lecture" component={ClassLecture} />
                    <Route path="/content" component={Contents} />

                    {/* Cq exam  start*/}
                    <Route path="/cq-exam" component={CqExam} />
                    <Route path="/cq-exam-list" component={CqExamList} />
                    <Route
                        path="/cq-result-list"
                        component={CqExamResultList}
                    />
                    <Route path="/cq-rank" component={CqExamRankList} />
                    {/* Cq exam  end*/}

                    {/* Mcq exam start*/}
                    <Route path="/exam" component={Exam} />
                    <Route path="/mcq-exam" component={McqExam} />
                    <Route path="/exam-list" component={ExamList} />
                    <Route path="/mcq-result-list" component={McqExamList} />
                    <Route path="/mcq-answer" component={McqExamAnswer} />
                    <Route path="/mcq-rank" component={McqExamRank} />
                    {/* Mcq exam end*/}

                    {/* Home work start*/}
                    <Route path="/homework-upload" component={HomeWork} />
                    {/* Home work end*/}

                    <Route path="/inbox" component={Inbox} />

                    {/* join class start*/}
                    <Route path="/join-class" component={JoinClass} />
                    <Route
                        path="/live-class-history/:student_id"
                        component={LiveClassHistory}
                    />
                    {/* <Route path="/zoom-class" component={ZoomClass} /> */}
                    {/* join class end*/}

                    {/* manage course start*/}
                    <Route path="/manage-course" component={ManageCourse} />
                    {/* manage course end*/}

                    <Route path="/login" component={Login} />
                    <Route path="/payment" component={Payment} />
                    <Route path="/payment-history" component={PaymentHistory} />
                    <Route path="/pdf-viewer" component={PdfViewer} />
                    <Route path="/profile" component={Profile} />
                    <Route path="/registration" component={Registration} />
                    <Route path="/change-password" component={ChangePassword} />
                    <Route path="/class-routine" component={ClassRoutine} />
                    <Route path="/forget-password" component={ForgetPassword} />
                    {/* </StudentContextProvider> */}
                </Switch>
            </Router>
        );
    }
}

export default App;

if (document.getElementById("app")) {
    ReactDOM.render(<App />, document.getElementById("app"));
}

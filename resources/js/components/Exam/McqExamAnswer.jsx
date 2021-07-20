import React, { Component } from "react";
import ReactDOM from "react-dom";
import ExamQus from "../../models/ExamQus";
import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import NoDataFound from "../NoDataFound/NoDataFound";
import { SideBar } from "../SideBar/SideBar";
import { jsPDF } from "jspdf";
import html2canvas from "html2canvas";
import ReactDOMServer from "react-dom/server";
import { Document, Page } from "react-pdf";
import domtoimage from "dom-to-image";
import domToPdf from "dom-to-pdf";
class McqExamAnswer extends Component {
    constructor(props) {
        super(props);
        this.state = {
            answers: []
        };
    }
    componentDidMount() {
        // checking for the student information using token
        if (localStorage.getItem("token")) {
            var x = JSON.parse(localStorage.getItem("token"));
            axios
                .get("http://127.0.0.1:8000/student/student_profile/", {
                    headers: {
                        Authorization: `Bearer${x}`
                    }
                })
                // setting up the student id to state
                .then(res => {
                    this.setState({
                        student_id: res.data.id
                    });

                    // console.log(
                    //     this.state.student_id + "is updated to the state"
                    // );

                    // if no user profile found, then push back to the profile page
                    if (res.data.profile === null) {
                        window.location.href = "/profile";
                    } else {
                        //getting the ExamList information using student id
                        let data = {
                            student_id: this.state.student_id,
                            exam_id: this.props.location.state.id
                        };
                        ExamQus.getAllAnswer(data).then(res => {
                            this.setState({ answers: res.data.questions });
                        });
                    }
                });
        }

        // console.log(
        //     "component did mount end and the student id is",
        //     this.state.student_id
        // );
    }
    handleDownload() {
        // const input = document.getElementById('divToPrint');
        // // html2canvas(input).then((canvas) => {
        // // const imgData = canvas.toDataURL('image/png');
        // const pdf = new jsPDF();
        // if (pdf) {
        //     domtoimage.toPng(input)
        //         .then(imgData => {
        //             pdf.addImage(imgData, 'PNG', 10, 10);
        //             pdf.save('download.pdf');
        //         });
        // }
        //     pdf.addImage(imgData, 'JPEG', 10, 100);
        //     // pdf.output('dataurlnewwindow');
        // pdf.save("download.pdf");
        // });

        // const domElement = document.getElementById('divToPrint');
        //     html2canvas(domElement, {
        //     //   onclone: (document) => {
        //     //     document.getElementById("print").style.visibility = "hidden";
        //     //   }
        //     }).then((canvas) => {
        //       const imgData = canvas.toDataURL("image/png");
        //       const pdf = new jsPDF();
        //       pdf.addImage(imgData, "JPEG", 10,-5);
        //       pdf.save(`${new Date().toISOString()}.pdf`);
        //     });

        // var hq1 = document.getElementById('divToPrint')
        // var doc = new jsPDF({
        //     orientation: 'p',
        //     unit: 'px',
        // });
        // // doc.setFontSize(10);

        // doc.html(hq1,
        //     {
        //         callback: function (doc) {
        //             doc.save();
        //         },
        //         html2canvas:{
        //             scale:0.6
        //         },
        //         x: 10
        //     }
        // );

        const element = document.querySelector("#divToPrint");

        const options = {
            filename: "test.pdf"
        };

        return domToPdf(element, options, () => {
            // callback function
        });
    }
    getAnswers() {
        const renderHTML = rawHTML =>
            React.createElement("div", {
                dangerouslySetInnerHTML: { __html: rawHTML }
            });
        return (
            <>
                {this.state.answers.length === 0 ? (
                    <NoDataFound noDataFoundMessage="No Result Available yet" />
                ) : (
                    this.state.answers.map((res, i = 1) => (
                        <div
                            className=" from-check col-md-12 pl-2"
                            key={res.id}
                        >
                            <b>
                                <div className="row">
                                    {i + 1} .{" "}
                                    <div
                                        className="card"
                                        style={{ border: "0px" }}
                                    >
                                        {renderHTML(res.question_title)}
                                    </div>
                                </div>
                            </b>
                            <div className="form-check-label">
                                Ans:{" "}
                                {res.mcq_right_answers.map(data => (
                                    <div className="" key={data.id}>
                                        {renderHTML(data.option_title)}
                                    </div>
                                ))}
                            </div>
                        </div>
                    ))
                )}
            </>
        );
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
                                        MCQ Exam Answer
                                    </h2>
                                    <div className="heading-underline"></div>
                                    <p className="text-center">
                                        Here you can see all of your MCQ Exam
                                        Answer.
                                    </p>
                                </div>
                                <div className="app-background" id="divToPrint">
                                    <h4 className="text-center mt-2 component-sub-header">
                                        MCQ Exam Answer
                                    </h4>
                                    <div className="content-underline mb-4"></div>
                                    <div
                                        className=""
                                        style={{
                                            backgroundColor: "#ffffff",
                                            width: "100%",
                                            Height: "100%",
                                            marginLeft: "auto",
                                            marginRight: "auto"
                                        }}
                                    >
                                        <div
                                            className="row"
                                            style={{ fontSize: "12px" }}
                                        >
                                            {this.state.answers ? (
                                                this.getAnswers()
                                            ) : (
                                                <Loading />
                                            )}
                                        </div>
                                    </div>
                                </div>
                                <div className=" text-right">
                                    <button
                                        className="btn btn-md btn-success"
                                        onClick={this.handleDownload.bind(this)}
                                    >
                                        {" "}
                                        download
                                    </button>
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
export default McqExamAnswer;

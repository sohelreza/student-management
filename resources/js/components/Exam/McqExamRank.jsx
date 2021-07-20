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
import Loading from "../Loading/Loading";
class McqExamRank extends Component {
    constructor(props) {
        super(props);
        this.state = {
            Rank: []
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
                            // student_id: this.state.student_id,
                            exam_id: this.props.location.state.id
                        };
                        ExamQus.getMcqRank(data).then(res => {
                            // console.log(res.data)
                            this.setState({ Rank: res.data });
                        });
                    }
                });
        }

        // console.log(
        //     "component did mount end and the student id is",
        //     this.state.student_id
        // );
    }
    // getting the name of the day from the date
    getTheDay(dateParam) {
        let fullDate = new Date(dateParam);
        let day = fullDate.toDateString();
        return day;
    }
    handleDownload() {
        // const input = document.getElementById("divToPrint");
        // // html2canvas(input).then((canvas) => {
        // // const imgData = canvas.toDataURL('image/png');
        // const pdf = new jsPDF();
        // if (pdf) {
        //     domtoimage.toPng(input).then(imgData => {
        //         pdf.addImage(imgData, "PNG", 10, 10);
        //         pdf.save("download.pdf");
        //     });
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
        var hq1 = document.getElementById("divToPrint");
        var doc = new jsPDF({
            orientation: "p",
            unit: "px",
            format: "a4"
        });

        doc.html(hq1, {
            callback: function(doc) {
                doc.save();
            },
            html2canvas: {
                scale: 0.57
            },
            x: 10
        });
        // doc.viewerPreferences({'FitWindow': true}, true)
        // doc.fromHTML(ReactDOMServer.renderToStaticMarkup(this.render()));
        // doc.save("myDocument.pdf");
    }
    getRanks() {
        const renderHTML = rawHTML =>
            React.createElement("div", {
                dangerouslySetInnerHTML: { __html: rawHTML }
            });
        return (
            <>
                {this.state.Rank.length === 0 ? (
                    <NoDataFound noDataFoundMessage="No Result Available yet" />
                ) : (
                    <div className="">
                        <div className="text-center mb-2">
                            <div className="">
                                <b>
                                    Exam Title :{" "}
                                    {this.props.location.state.examTitle}
                                </b>
                            </div>
                            <div className="">
                                <b>Class : {this.props.location.state.class}</b>
                            </div>
                            <div className="">
                                <b>
                                    Subject Name :{" "}
                                    {this.props.location.state.subjectName}
                                </b>
                            </div>
                            <div className="">
                                <b>
                                    Exam Date :{" "}
                                    {this.getTheDay(
                                        this.props.location.state.examDate
                                    )}
                                </b>
                            </div>
                        </div>
                        <div className="horizontal-scroll table-responsive">
                            <table className="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Registration Id</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Score</th>
                                        {/* <th scope="col">Start time</th>
                                    <th scope="col">End time</th>
                                    <th scope="col">Duration</th> */}
                                        <th scope="col">Rank</th>
                                        {/* <th scope="col">Mark</th>
                                            <th scope="col">Rank Sheet</th>
                                            <th scope="col">Answer Sheet</th> */}
                                        {/* <th scope="col">Class</th>
                                            <th scope="col">Batch</th>
                                            <th scope="col">Teacher</th> */}
                                    </tr>
                                </thead>
                                <tbody>
                                    {this.state.Rank.map((data, i) => {
                                        return (
                                            <tr key={data.id}>
                                                <td>{data.registration_id}</td>
                                                <td>
                                                    {data.first_name}{" "}
                                                    {data.last_name}
                                                </td>
                                                <td className="">
                                                    {data.score}
                                                </td>
                                                <td>
                                                    {i + 1 == 1
                                                        ? "1st"
                                                        : i + 1 == 2
                                                        ? "2nd"
                                                        : i + 1 == 3
                                                        ? "3rd"
                                                        : i + "th"}
                                                </td>
                                            </tr>
                                        );
                                    })}
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                                        MCQ Exam Result sheet
                                    </h2>
                                    <div className="heading-underline"></div>
                                    <p className="text-center">
                                        Here you can see all of your MCQ Exam
                                        Result sheet.
                                    </p>
                                </div>
                                <div className="app-background" id="divToPrint">
                                    <h4 className="text-center mt-2 component-sub-header">
                                        MCQ Exam Result sheet
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
                                            className=""
                                            style={{ fontSize: "16px" }}
                                        >
                                            {this.state.Rank ? (
                                                this.getRanks()
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
export default McqExamRank;

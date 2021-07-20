import React, { Component } from "react";
import { Link } from "react-router-dom";

import Footer from "../Footer/Footer";
import { Header } from "../Header/Header";
import Loading from "../Loading/Loading";
import NoDataFound from "../NoDataFound/NoDataFound";
import { SideBar } from "../SideBar/SideBar";

import "./Contents.css";

class Contents extends Component {
    constructor(props) {
        if (
            !localStorage.getItem("token") &&
            localStorage.getItem("token") > 86400
        ) {
            window.location.href = "/login";
        }
        super(props);
        this.state = {
            contentsData: null,
            student_id: null
        };
        // this.getTheDay.bind(this);
        // this.getTheTime.bind(this);
        this.getTheContents.bind(this);
        // this.noDataAvailable.bind(this);
    }

    componentDidMount() {
        window.scrollTo(0, 0);
        // checking for the student information using token
        if (localStorage.getItem("token")) {
            var x = JSON.parse(localStorage.getItem("token"));

            axios
                .get("student/student_profile/", {
                    headers: {
                        Authorization: `Bearer${x}`
                    }
                })
                // setting up the student id to state
                .then(res => {

                    this.setState({
                        student_id: res.data.id
                    });
                    // this.props.match.params.student_id

                    // console.log("student_id is updated to the state");

                    // if no user profile found, then push back to the profile page
                    if (res.data.profile === null) {
                        window.location.href = "/profile";
                    } else {
                        //getting the meetings information using student id
                        return (
                            axios
                                .post("student/contents", {
                                    student_id: this.state.student_id
                                })

                                // setting up the meetings information to the state
                                .then(res => {
                                    // console.log(
                                    //     "got the contents data and waiting to update and the data is",
                                    //     res.data
                                    // );

                                    this.setState({
                                        contentsData: res.data
                                    });

                                    // console.log(
                                    //     "content data is updated to the state"
                                    // );
                                })
                        );
                    }
                });
        }

        // console.log(
        //     "component did mount end and the student id is",
        //     this.state.student_id
        // );
    }

    // rendering the content data
    getTheContents() {
        return (
            <>
                {this.state.contentsData.length === 0 ? (
                    <NoDataFound noDataFoundMessage="no contents found" />
                ) : (
                    <>
                        <div className="horizontal-scroll table-responsive">
                            <table className="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Content Type</th>
                                        <th scope="col">Content Title</th>
                                        <th scope="col">File</th>
                                        <th scope="col">Uploaded Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {this.state.contentsData.map(data => {
                                        return (
                                            <tr key={data.id}>
                                                <td>
                                                    {data.content_type.name}
                                                </td>
                                                <td>{data.title}</td>
                                                {/* <td>{data.file}</td> */}
                                                {/* <td>
                                                    <Link
                                                        to={{
                                                            pathname:
                                                                "/content",
                                                            aboutProps: PDF
                                                        }}
                                                        className="btn btn-success content-view-button"
                                                        onClick={() =>
                                                            window.open(
                                                                "/pdf-viewer"
                                                            )
                                                        }
                                                    >
                                                        View PDF
                                                        <button
                                    type="button"
                                    className="btn btn-success live-class-history-button"
                                >
                                    Live Class History
                                </button>
                                                    </Link>
                                                </td> */}
                                                <td>
                                                    <a
                                                        // to={
                                                        //     "/pdf-viewer/" +
                                                        //     data.file
                                                        // }
                                                        href={
                                                            window.location
                                                                .origin +
                                                            "/content/" +
                                                            data.file
                                                        }
                                                        download
                                                        className="btn btn-success content-view-button"
                                                    >
                                                        Download File
                                                    </a>
                                                </td>
                                                <td>{data.date}</td>
                                            </tr>
                                        );
                                    })}
                                </tbody>
                            </table>
                        </div>

                        {/* <div className="row justify-content-center pt-4">
                            <Link
                                student_id={this.state.student_id}
                                to={
                                    "/live-class-history/" +
                                    this.state.student_id
                                }
                            >
                                <button
                                    type="button"
                                    className="btn btn-success live-class-history-button"
                                >
                                    Live Class History
                                </button>
                            </Link>
                        </div> */}
                    </>
                )}
            </>
        );
    }

    render() {
        // console.log(
        //     "render content component and updated state is",
        //     this.state
        // );

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
                                        Contents
                                    </h2>
                                    <div className="heading-underline"></div>
                                    <p className="text-center">
                                        Here you can see all of your contents.
                                    </p>
                                </div>
                                <div className="app-background">
                                    <h4 className="text-center mt-2 component-sub-header">
                                        Contents Details
                                    </h4>
                                    <div className="content-underline mb-4"></div>

                                    {this.state.contentsData ? (
                                        this.getTheContents()
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

export default Contents;

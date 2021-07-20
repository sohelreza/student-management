import React, { Component, createContext } from "react";
import Common from "../models/Common";
import paymentInfo from "../models/paymentInfo";
import ProfileUpdate from "../models/ProfileUpdate";
// import ProfileUpdate from "../../models/ProfileUpdate";

export const StudentContext = createContext();

class StudentContextProvider extends Component {
    constructor(props) {
        // if (!localStorage.getItem("token")) {
        //     window.location.href = "/login";
        // }
        // window.scrollTo(0, 0);
        super(props);
        this.state = { studentProfile: "", studentInfo: "", paymentInfo: "" };
    }

    componentDidMount() {
        // window.scrollTo(0, 0);
        if (localStorage.getItem("token")) {
            var x = JSON.parse(localStorage.getItem("token"));
            axios
                .get(Common.api + "student/student_profile", {
                    headers: {
                        Authorization: `Bearer${x}`
                    }
                })
                .then(res1 => {
                    let data = {
                        student_id: res1.data.id
                    };
                    if (res1.data.user_profile === null) {
                        window.location.href = "/profile";
                    }
                    paymentInfo.checkTxId(data).then(res3 => {
                        //set transaction id
                        if (
                            res3.data.transaction_id == null ||
                            res3.data.transaction_id == "" ||
                            res3.data.transaction_id == undefined
                        ) {
                            // this.props.history.push("/payment");
                            window.location.href = "/payment";
                        }
                        this.setState({ paymentInfo: res3.data });
                    });

                    ProfileUpdate.studentInfo(data).then(res2 => {
                        // console.log(
                        //     "student context profile update",
                        //     res2.data
                        // );
                        this.setState({
                            studentInfo: res2.data
                        });
                    });

                    this.setState({
                        studentProfile: res1.data
                    });
                });
            // console.log("student context component did mount", data);
        }
    }

    render() {
        // console.log("student context render", this.state);
        return (
            <StudentContext.Provider value={{ ...this.state }}>
                {this.props.children}
            </StudentContext.Provider>
        );
    }
}

export default StudentContextProvider;

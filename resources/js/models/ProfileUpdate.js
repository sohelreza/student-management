import axios from "axios";
import Common from "./Common";

export default {
    getProfile(token) {
        return axios.get(Common.api + "student/student_profile", token);
    },
    addProfile(data) {
        return axios.post(Common.api + "student/student_profile", data);
    },
    updateStudentData(id, data) {
        return axios.patch(Common.api + "student/student_profile/" + id, data);
    },
    postChangePassword(data) {
        return axios.post(Common.api + "student/change_password", data);
    },
    studentInfo(data) {
        return axios.post(Common.api + "student/student_info", data);
    },
    studentSubjects(data) {
        return axios.post(Common.api + "student/student_subject", data);
    },
    studentTeachers() {
        return axios.get(Common.api + "student/student_teacher");
    },
};
import axios from "axios";
import Common from "./Common";

export default {
    getProfile(token) {
        return axios.get(Common.api + "student/student_profile", token);
    },
    getMessageCount(id) {
        return axios.post(Common.api + "student/message_count", id);
    },
    getLiveClass(id) {
        return axios.post(Common.api + "student/class_live_dashboard", id);
    },
    getMcqExam(id) {
        return axios.post(Common.api + "student/mcq_exams", id);
    },
    getCqExam(id) {
        return axios.post(Common.api + "student/cq_exams", id);
    }
};
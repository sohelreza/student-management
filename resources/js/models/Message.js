import axios from "axios";
import Common from "./Common";

export default {
    // getting the profile information using token
    getProfile(token) {
        return axios.get(Common.api + "student/student_profile", token);
    },

    // getting the sms using student id
    getSms(id) {
        return axios.post(Common.api + "student/sms", id);
    },

    // getting the message using student id
    getMessage(id) {
        return axios.post(Common.api + "student/message", id);
    }
};
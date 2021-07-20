import axios from "axios";

import Common from "./Common";

export default {
    addCourse(data) {
        return axios.post(Common.api + "student/payments", data);
    },
    getPayment(id) {
        return axios.get(Common.api + "student/payments/" + id);
    }
};
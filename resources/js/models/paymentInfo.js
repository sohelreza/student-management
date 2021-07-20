import Common from "./Common";

export default {
    postTxId(data) {
        return axios.post(Common.api + "student/add_transaction_id", data);
    },
    checkTxId(data) {
        return axios.post(Common.api + "student/last_payment", data);
    },
    paymentInstruction() {
        return axios.get(Common.api + "student/payment_instruction");
    }
};
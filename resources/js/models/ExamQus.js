import axios from 'axios';

import Common from './Common';
export default {
    getExamList(data) {
        return axios.post(Common.api + 'student/mcq_exams',data);
    },
    getCqExamList(data) {
        return axios.post(Common.api + 'student/cq_exams',data);
    },
    getQuestion(data) {
        return axios.post(Common.api + 'student/mcq_exam_show',data);
    },
    getCqQuestion(data) {
        return axios.post(Common.api + 'student/cq_exam_show',data);
    },
    getPayment(id) {
        return axios.get(Common.api + 'student/payments/'+id);
    },
    postAnswer(data){
        return axios.post(Common.api + 'student/mcq_exam_answer_submit',data);
    },
    getResult(data){
        return axios.post(Common.api + 'student/mcq_exam_show_result',data);
    },
    getAllAnswer(data){
        return axios.post(Common.api + 'student/mcq_exam_show_answer',data);
    },
    getMcqResult(data){
        return axios.post(Common.api + 'student/mcq_exam_results',data);
    },
    getMcqRank(data){
        return axios.post(Common.api + 'student/mcq_exam_rank',data);
    },
    getCqResultList(data){
        return axios.post(Common.api + 'student/cq_exam_results',data);
    },
    getCqRankList(data){
        return axios.post(Common.api + 'student/cq_exam_rank',data);
    },
}
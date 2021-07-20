import axios from 'axios';

import { data } from 'jquery';

import Common from './Common';
export default {
    // login() {
    //     return axios.get(Common.api + 'top-slider');
    // },
    getBranchName(data){
        return axios.post(Common.api + 'student/search_branch', data);
    },
    getClass(data){
        return axios.post(Common.api + 'student/search_class', data);
    },
    getBatchName(data){
        return axios.post(Common.api + 'student/search_batch', data);
    },
    getSubjectName(data){
        return axios.post(Common.api + 'student/search_subject', data);
    },
    getSubjectAmount(data){
        return axios.post(Common.api + 'student/search_subject_amount', data);
    },
    registration(data){
        return axios.post(Common.api + 'auth/registration', data);
    },
    login(data){
        return axios.post(Common.api + 'auth/login', data);
    },
    forgotPassword(data){
        return axios.post(Common.api + 'auth/forgotpassword', data);
    },
    logout(data){
        return axios.post(Common.api + 'auth/logout', data);
    },
}
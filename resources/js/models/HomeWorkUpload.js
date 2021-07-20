import Common from './Common';
export default {
    postHomeWork(data){
        return axios.post(Common.api + 'student/homeworks',data);
    },
}
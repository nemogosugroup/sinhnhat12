import request from '@frontend/utils/request';
const resource = 'user/2048';

export default {
    list(query) {
        return request({
            url: `${resource}` + '/list',
            method: 'get',
            params: query
        });
    },

    create(data) {
        return request({
            url: `${resource}` + '/create',
            method: 'post',
            data
        });
    },

    getRanks() {
        return request({
            url: `${resource}` + '/ranks-list',
            method: 'get'
        });
    },

    getLogs() {
        return request({
            url: `${resource}` + '/logs-list',
            method: 'get'
        });
    },

    setFirstTimeToFalse() {
        return request({
            url: `${resource}` + '/set-first-time-to-false',
            method: 'post'
        });
    },
};

import request from '@frontend/utils/request';
const resource = '/2048';

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
    createLog(data) {
        return request({
            url: `${resource}` + '/create-log',
            method: 'post',
            data
        });
    }

    // update(query) {
    //     let data = query['data'];
    //     return request({
    //         url: `${resource}` + "/update/"+`${query.id}`,
    //         method: 'post',
    //         data
    //     })
    // },
};

import request from "@frontend/utils/request";

const resource = "/language";

export default {
    change(data) {
        return request({
            url: `${resource}` + "/language",
            method: 'post',
            data
        })
    }
};

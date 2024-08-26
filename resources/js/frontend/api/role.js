import request from "@frontend/utils/request";

const resource = "/role";

export default {
    list() {
        return request.get(`${resource}` + "/list");
    },
};

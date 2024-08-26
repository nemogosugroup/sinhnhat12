import request from "@backend/utils/request";

const resource = "/role";

export default {
    list() {
        return request.get(`${resource}` + "/list");
    },
};

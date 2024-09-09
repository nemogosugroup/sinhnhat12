import request from '@frontend/utils/request';
const resource = 'user/quest';

export default {
    receiveReward(id) {
        return request({
            url: `${resource}` + `/receive-reward/${id}`,
            method: "post",
        });
    },
    handleInviteCode(code) {
        return request({
            url: `${resource}` + `/invite-code/${code}`,
            method: "post",
        });
    },
};

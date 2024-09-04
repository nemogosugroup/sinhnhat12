const getters = {
    sidebar: (state) => state.app.sidebar,
    size: (state) => state.app.size,
    device: (state) => state.app.device,
    visitedViews: (state) => state.tagsView.visitedViews,
    cachedViews: (state) => state.tagsView.cachedViews,
    token: (state) => state.user.token,
    avatar: (state) => state.user.avatar,
    name: (state) => state.user.name,
    introduction: (state) => state.user.introduction,
    roles: (state) => state.user.roles,
    permission_routes: (state) => state.permission.routes,
    errorLogs: (state) => state.errorLog.logs,
    user: (state) => state.user.user,
    training: (state) => state.user.training,
    courses: (state) => state.user.courses,
    equipments: (state) => state.user.equipments,
    userEquipments: (state) => state.userEquipment.userEquipments,
    gold: (state) => state.user.gold,
    experience: (state) => state.user.experience,
    level_user: (state) => state.user.level,
    data_medal: (state) => state.user.data_medal,
    data_achievement: (state) => state.user.data_achievement,
    kimto: (state) => state.user.kimto,
    mochi: (state) => state.user.mochi,
    bestscore: (state) => state.user.bestscore,
    locale: (state) => state.locale.locale
};
export default getters;

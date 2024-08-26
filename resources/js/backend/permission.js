import router from "./router";
import store from "./store";
import { ElMessage } from 'element-plus'
import NProgress from "nprogress"; // progress bar
import "nprogress/nprogress.css"; // progress bar style
import { getAccessToken, removeToken, setLayout } from "@backend/utils/auth"; // get token from cookie
import getPageTitle from "@backend/utils/get-page-title";

NProgress.configure({ showSpinner: false }); // NProgress Configuration

const whiteList = ["/admin/login","/logout", "/auth-redirect"]; // no redirect whitelist
router.beforeEach(async (to, from, next) => {
    // start progress bar
    NProgress.start();    
    // set page title
    document.title = getPageTitle(to.meta.title);
    // determine whether the user has logged in
    //removeToken();
    const hasToken = getAccessToken();
    //const hasToken = null;
    let currentRoles = [];
    if (hasToken && hasToken != "undefined") {
        const hasRoles = store.getters.roles && store.getters.roles.length > 0;
        setLayout(to.meta.active);
        if (hasRoles) {
            let roles = store.getters.roles;
            currentRoles = roles.map(role => role);
            const accessRoutes = await store.dispatch(
                "permission/generateRoutes",
                currentRoles
            );
            accessRoutes.forEach(route => {
                router.addRoute(route);
            });
            next();
        } else {
            var roles = await store.dispatch("user/getRoles");
            currentRoles = roles.map(role => role);
            //var info = await store.dispatch("user/getInfo");            
            // generate accessible routes map based on roles
            const accessRoutes = await store.dispatch(
                "permission/generateRoutes",
                currentRoles
            );            
            accessRoutes.forEach(route => {
                router.addRoute(route);
            });
            if (to.path === "/admin/login") {
                next();
                NProgress.done();
            } else {
                next({ ...to, replace: true });
            }
        }
    } else {
        /* has no token*/
        if (whiteList.indexOf(to.path) !== -1) {
            // in the free login whitelist, go directly
            next();
        } else {
            // other pages that do not have permission to access are redirected to the login page.
            //next(`/login?redirect=${to.path}`);
            // console.log('router', router);
            next(`/admin/login`);
            NProgress.done();
        }
    }
});

router.afterEach(() => {
    // finish progress bar
    NProgress.done();
});

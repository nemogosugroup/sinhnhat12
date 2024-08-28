import { createRouter, createWebHistory } from 'vue-router';
/* Layout */
import Login from '@frontend/views/login';
import Home from '@frontend/views/birthday12';
import Page404 from '@frontend/views/error-page/404';
import Page401 from '@frontend/views/error-page/401';
import Profile from '@frontend/views/profile/index';
import Layout from '@frontend/layout';
import layoutFront from '@frontend/views/layoutFront';
import moonWalk from '@frontend/views/moonWalk';
// import Medal from '@/backend/views/medal'
import { getAccessToken } from '@frontend/utils/auth';
// import CategoryMedal from '@/backend/views/medal/category'
/**
 * constantRoutes
 * a base page that does not have permission requirements
 * all roles can be accessed
 */
/**
 * asyncRoutes
 * the routes that need to be dynamically loaded based on user roles
 */
import store from '../store';
export const constantRoutes = [
    {
        path: '/login',
        component: layoutFront,
        hidden: true,
        redirect: '',
        children: [
            {
                path: '',
                component: Login,
                name: 'Login',
                meta: {
                    title: 'Gosu',
                    affix: true
                },
                beforeEnter(to, from, next) {
                    // Kiểm tra xem người dùng đã đăng nhập hay chưa
                    // Lấy các query parameters từ URL
                    const queryParams = to.query;
                    if (getAccessToken()) {
                        if (queryParams.redirect_uri) {
                            window.location.href =
                                queryParams.redirect_uri +
                                '?token=' +
                                getAccessToken() +
                                '&state=' +
                                queryParams.state;
                        } else {
                            next({ path: '/' });
                        }
                    } else {
                        next();
                    }
                }
            }
        ]
    },
    {
        path: '/404',
        component: Page404,
        hidden: true
    },
    {
        path: '/401',
        component: Page401,
        hidden: true
    },
    {
        path: '/',
        component: layoutFront,
        hidden: true,
        redirect: '',
        children: [
            {
                path: '',
                component: Home,
                name: 'Home',
                meta: {
                    title: 'GOSU',
                    icon: 'ri-home-4-fill',
                    affix: true
                }
            }
        ]
    },
    {
        path: '/moonwalk',
        component: layoutFront,
        hidden: true,
        redirect: '',
        children: [
            {
                path: '',
                component: moonWalk,
                name: 'moonWalk',
                meta: {
                    title: 'Cổng mặt trời',
                    icon: 'ri-home-4-fill',
                    affix: true
                }
            },
            {
                path: 'map',
                component: Map,
                name: 'Map',
                meta: {
                    title: 'Game Map',
                    icon: 'ri-home-4-fill',
                    affix: true
                }
            }
        ]
    },
    {
        path: '/profile',
        component: Layout,
        redirect: '/profile/index',
        hidden: true,
        children: [
            {
                path: 'index',
                component: Profile,
                name: 'Profile',
                meta: {
                    title: 'Profile',
                    icon: 'ri-user-3-fill',
                    noCache: true
                }
            }
        ]
    },
    {
        path: '/logout',
        name: 'Logout',
        async beforeEnter(to, from, next) {
            // Kiểm tra xem người dùng đã đăng nhập hay chưa
            // Lấy các query parameters từ URL
            const queryParams = to.query;
            if (getAccessToken()) {
                try {
                    // Thực hiện hàm đăng xuất
                    // await logout();
                    await store.dispatch('user/logout');
                    // Chuyển hướng người dùng đến trang đăng nhập
                    next({ path: '/login', query: queryParams });
                } catch (error) {
                    console.error('Error logging out:', error);
                    // Nếu có lỗi, vẫn chuyển hướng người dùng đến trang đăng nhập
                    next({ path: '/login', query: queryParams });
                }
            } else {
                next({ path: '/login', query: queryParams });
            }
        },
        hidden: true // Ẩn router này khỏi thanh menu nếu cần
    },
    { path: '/:pathMatch(.*)*', redirect: '/404', hidden: true }
];
export const asyncRoutes = [
    //{ path: "/:pathMatch(.*)*", redirect: "/404", hidden: true },
];

// export default router;
const createCustomRouter = () =>
    createRouter({
        //mode: 'history', // require service support
        history: createWebHistory(),
        scrollBehavior: () => ({ y: 0 }),
        routes: constantRoutes
    });

const router = createCustomRouter();
export function resetRouter() {
    const newRouter = createCustomRouter();
    router.matcher = newRouter.matcher; // reset router
}

export default router;

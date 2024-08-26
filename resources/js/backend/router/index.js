import { createRouter, createWebHistory } from 'vue-router';
/* Layout */
import Login from "@backend/views/login";
import Dashboard from "@backend/views/dashboard";
import Home from "@backend/views/home";
import DetailMap from "@backend/views/map";
import Redirect from "@backend/views/redirect";
import Page404 from "@backend/views/error-page/404";
import Page401 from "@backend/views/error-page/401";
import Profile from "@backend/views/profile/index";
import ListProjects from "@backend/views/project/index";
import CreateProject from "@backend/views/project/create";
import EditProject from "@backend/views/project/edit";
import Users from "@backend/views/users";
import Layout from "@backend/layout";
import layoutFront from "@backend/views/layoutFront";
// import Medal from '@backend/backend/views/medal'
import { getAccessToken } from "@backend/utils/auth";
// import CategoryMedal from '@backend/backend/views/medal/category'
/**
 * constantRoutes
 * a base page that does not have permission requirements
 * all roles can be accessed
 */
/**
 * asyncRoutes
 * the routes that need to be dynamically loaded based on user roles
 */
import store from "../store";
export const adminRoute = [
    {
        path: '/admin/users',
        component: Layout,
        redirect: "/admin/users/index",
        children: [
            {
                path: 'index',
                component: Users,
                name: 'Users',
                meta: { title: 'Users', icon: 'ri-group-fill', affix: true }
            }
        ]
    },
    { path: "/admin/:pathMatch(.*)*", redirect: "/404", hidden: true },
]
export const constantRoutes = [
    {
        path: '/admin',
        component: Layout,
        redirect: "/admin/dashboard",
        children: [
            {
                path: 'dashboard',
                component: Dashboard,
                name: 'Dashboard',
                meta: { title: 'Dashboard', icon: 'ri-dashboard-fill', affix: true }
            },
        ]
    },    
    {        
        path: "/admin/login",
        component: Login,
        hidden: true,
        beforeEnter(to, from, next) {
            // Kiểm tra xem người dùng đã đăng nhập hay chưa
            // Lấy các query parameters từ URL
            const queryParams = to.query;
            if(getAccessToken()){
                if(queryParams.redirect_uri){
                    window.location.href = queryParams.redirect_uri+'?token='+getAccessToken()+'&state='+queryParams.state;
                }else{
                    next({ path: '/' });
                }
            }
            else{
                next();
            }
            
        },
    },
    {
        path: "/admin/login",
        component: Login,
        hidden: true,
        beforeEnter(to, from, next) {
            // Kiểm tra xem người dùng đã đăng nhập hay chưa
            // Lấy các query parameters từ URL
            const queryParams = to.query;
            if(getAccessToken()){
                if(queryParams.redirect_uri){
                    window.location.href = queryParams.redirect_uri+'?token='+getAccessToken()+'&state='+queryParams.state;
                }else{
                    next({ path: '/' });
                }
            }
            else{
                next();
            }
            
        },
    },
    {
        path: "/404",
        component: Page404,
        hidden: true,
    },
    {
        path: "/401",
        component: Page401,
        hidden: true,
    },    
    {
        path: "/map",
        component: layoutFront,
        hidden: true,
        redirect: "/map/:id(\\d+)",
        children: [
            {
                path: "/map/:id(\\d+)",
                component: DetailMap,
                name: "DetailMap",
                meta: {
                    title: "Gosu",
                    noCache: true,
                },
                hidden: true,
            },
        ],
    },
    // {
    //     path: "/project",
    //     component: Layout,
    //     redirect: "/project/list",
    //     name: "Project",
    //     meta: {
    //         title: "Dự Án",
    //         icon: "ri-questionnaire-fill",
    //     },
    //     children: [
    //         {
    //             path: "create",
    //             component: CreateProject,
    //             name: "CreateProject",
    //             meta: { title: "Tạo dự án", icon: "ri-edit-box-fill" },
    //         },
    //         {
    //             path: "edit/:id(\\d+)",
    //             component: EditProject,
    //             name: "EditProject",
    //             meta: {
    //                 title: "Chỉnh sửa dự án",
    //                 noCache: true,
    //                 activeMenu: "/project/list",
    //             },
    //             hidden: true,
    //         },
    //         {
    //             path: "list",
    //             component: ListProjects,
    //             name: "ListProjects",
    //             meta: { title: "Dự Án", icon: "ri-list-indefinite" },
    //         },
    //     ],
    // },
    {
        path: "/profile",
        component: Layout,
        redirect: "/profile/index",
        hidden: true,
        children: [
            {
                path: "index",
                component: Profile,
                name: "Profile",
                meta: {
                    title: "Profile",
                    icon: "ri-user-3-fill",
                    noCache: true,
                },
            },
        ],
    },
    {
        path: "/admin/logout",
        name: "Logout",
        async beforeEnter(to, from, next) {
            // Kiểm tra xem người dùng đã đăng nhập hay chưa
            // Lấy các query parameters từ URL
            const queryParams = to.query;
            console.log('Query parameters:', queryParams);
            console.log("check getAccessToken",getAccessToken());
            if(getAccessToken()){
                try {
                    // Thực hiện hàm đăng xuất
                    // await logout();
                    await store.dispatch("user/logout");
                    // Chuyển hướng người dùng đến trang đăng nhập
                    next({ path: '/admin/login', query: queryParams });
                } catch (error) {
                    console.error('Error logging out:', error);
                    // Nếu có lỗi, vẫn chuyển hướng người dùng đến trang đăng nhập
                    next({ path: '/admin/login', query: queryParams });
                }
            }else{
                next({ path: '/admin/login', query: queryParams });
            }
            
        },
        hidden: true // Ẩn router này khỏi thanh menu nếu cần
    },
   
];
export const asyncRoutes = [
    { path: "/admin/:pathMatch(.*)*", redirect: "/404", hidden: true }
]

  
// export default router;
const createCustomRouter = () => createRouter({
    //mode: 'history', // require service support
    history: createWebHistory(),
    scrollBehavior: () => ({ y: 0 }),
    routes: constantRoutes
  })
  
  const router = createCustomRouter()
  // Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
  export function resetRouter() {
    const newRouter = createCustomRouter()
    router.matcher = newRouter.matcher // reset router
  }
  
  export default router
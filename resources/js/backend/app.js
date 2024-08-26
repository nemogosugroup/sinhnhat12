import { createApp } from 'vue';
import Cookies from 'js-cookie';
import 'normalize.css/normalize.css';
import 'remixicon/fonts/remixicon.css';
import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css';
import App from './App.vue';
import store from '@backend/store';
import router from '@backend/router';
//import '@/icons'; // icon
import '@backend/permission'; // permission control
import SvgIcon from '@backend/components/SvgIcon'; // svg component
import mitt from 'mitt';
const emitter = mitt();
const app = createApp(App);
app.config.globalProperties.emitter = emitter;
app.component('svg-icon', SvgIcon); // Bạn có thể bật dòng này nếu bạn đang sử dụng component SvgIcon
import * as ElementPlusIconsVue from '@element-plus/icons-vue';
for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
    app.component(key, component);
}
// app.config.productionTip = false;
import RepositoryFactory from '@backend/utils/RepositoryFactory';
import AdminRepositoryFactory from '@backend/respository/index';
app.provide('$RepositoryFactory', RepositoryFactory);
app.provide('$AdminRepositoryFactory', AdminRepositoryFactory);

const GOOGLE_MAP_KEY = process.env.MIX_GOOGLE_MAP_KEY;
app.config.globalProperties.GOOGLE_MAP_KEY = GOOGLE_MAP_KEY;

app.use(ElementPlus, {
    size: Cookies.get('size') || 'default' // set element-plus default size
});
app.use(store).use(router).mount('#app');

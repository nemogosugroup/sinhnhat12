//import RepositoryFactory from "@/utils/RepositoryFactory";
import {getAccessToken, setAccessToken, removeToken, setAuth, getAuth, setLocale, getLocale} from '@backend/utils/auth'
import router, { resetRouter } from "@backend/router";
import cnLang from 'element-plus/es/locale/lang/zh-cn'
import viLang from 'element-plus/es/locale/lang/vi'
import enLang from 'element-plus/es/locale/lang/en'
//const langRepository = RepositoryFactory.get('lang');
const state = {
    locale: viLang ,
};

const mutations = {
    SET_LOCALE: (state, lang) => {
        state.locale = lang;
    },
};

const actions = {
    changeLocale({commit}, lang) {
        let language = viLang;
        switch (lang) {
            case "zh-cn":
                language = cnLang;
                break;
            case "en":
                language = enLang;
                break;
            default:
                language = viLang;
        }
        commit('SET_LOCALE', language);
        setLocale(language.name);
        // return new Promise((resolve, reject) => {
        //     langRepository.change(state.token)
        //         .then((response) => {
        //             const { data } = response;
        //             if (data.success) {
        //                 let language = data.data.language;
        //                 commit('SET_LOCALE', language);
        //             }
        //             resolve(response)
        //         })
        //         .catch((error) => {
        //             reject(error);
        //         });
        // });
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
};

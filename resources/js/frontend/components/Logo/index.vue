<template>
    <div class="logo">
        <transition name="sidebarLogoFade">
            <el-row :gutter="20" align="middle" justify="center">
                <el-col :span="8">
                    <router-link class="sidebar-logo-link" to="/">
                        <span class="wrap-logo">
                            <img :src="Logo" class="icon-logo"  alt=""/>
                             <img :src="Gosu12" class="icon-birthday"  alt=""/>
                        </span>
                    </router-link>
                </el-col>
                <el-col :span="16" v-if="isLoginSuccess">
                    <Profile />
                </el-col>
            </el-row>
        </transition>
    </div>
</template>

<script>
import Gosu12 from "@/assets/images/eventBirthday2024/gosu12.svg";
import Logo from "@/assets/images/eventBirthday2024/icon_logo.svg";
// import Logo from "@/assets/images/logo/GOSU_full.png";
import Profile from "../Profile";
import {mapGetters} from "vuex";
export default {
    props: {
        isLogin: {
            required: true,
            type: Boolean,
            default: false
        }
    },
    name: 'Logo',
    components: { Profile },
    data() {
        return {
            Logo: Logo,
            isBachNhat: false,
            Gosu12: Gosu12,
            isLoginSuccess: false
        }
    },
    created() {
        this.emitter.off("is-login-success");
        this.emitter.off("clicked-logout");
        this.checkLoginSuccess();
    },
    computed: {
        ...mapGetters(["user"]),
        isWhiteColor() {
            return this.$router.currentRoute.value.name === "BachNhat" || this.isLogin;
        }
    },
    mounted() {
        this.isBachNhat = this.$router.currentRoute.value.name === "BachNhat";
        this.emitter.on("is-login-success", () => {
            this.isLoginSuccess = true;
        });
        this.emitter.on("clicked-logout", () => {
            this.isLoginSuccess = false;
        });
    },
    methods: {
        checkLoginSuccess() {
            if (typeof this.user !== "undefined") {
                this.isLoginSuccess = true;
            }
            if (this.user.id === null || this.user.id === undefined) {
                this.isLoginSuccess = false;
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.sidebarLogoFade-enter-active {
    transition: opacity 1.5s;
}

.sidebarLogoFade-enter,
.sidebarLogoFade-leave-to {
    opacity: 0;
}

.logo {
    position: relative;
    width: auto;
    display: inline-block;
    // height: 50px;
    // line-height: 50px;
    //background: #2b2f3a;
    text-align: center;
    // overflow: hidden;

    & .sidebar-logo-link {
        height: 100%;
        width: 100%;

        & .sidebar-logo {
            max-width: 180px;
            vertical-align: middle;
            margin-right: 12px;
        }

        & .sidebar-title {
            display: inline-block;
            margin: 0;
            color: #fff;
            font-weight: 600;
            line-height: 50px;
            font-size: 14px;
            font-family: Avenir, Helvetica Neue, Arial, Helvetica, sans-serif;
            vertical-align: middle;
        }
    }

    &.collapse {
        .sidebar-logo {
            margin-right: 0px;
        }
    }
}

.wrap-logo {
    display: flex;
    align-items: center;
    height: 100%;

    .icon-logo {
        margin-right: 15px;
        max-width: 170px;
    }
}
</style>

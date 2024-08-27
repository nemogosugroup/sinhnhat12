<template>
    <div class="app-wrapper">
        <el-dialog v-model="showDialog" :show-close="false" width="1070" align-center>
            <template #header="{ close, titleId }">
                <div class="my-header">
                    <h4 :id="titleId" :class="`title-form`">Đăng nhập Email Gosu tại đây</h4>
                    <span class="button-close" @click="close"></span>
                </div>
            </template>
            <div class="login-container">
                <el-form ref="loginForm" :model="loginForm" :rules="loginRules" class="login-form" autocomplete="on"
                    label-position="left">
                    <el-form-item prop="email">
                        <span class="svg-container">
                            <i class="ri-user-line"></i>
                        </span>
                        <el-input ref="email" v-model="loginForm.email" placeholder="Nhập Email Gosu tại đây"
                            name="email" type="email" tabindex="1" autocomplete="on" />
                    </el-form-item>

                    <el-tooltip v-model="capsTooltip" content="Caps lock is On" placement="right" manual>
                        <el-form-item prop="password">
                            <span class="svg-container">
                                <i class="ri-lock-line"></i>
                            </span>
                            <el-input :key="passwordType" ref="password" v-model="loginForm.password"
                                :type="passwordType" placeholder="Nhập mật khẩu Email Gosu tại đây" name="password"
                                tabindex="2" autocomplete="on" @keyup="checkCapslock" @blur="capsTooltip = false"
                                @keyup.enter="handleLogin" />
                        </el-form-item>
                    </el-tooltip>
                    <div class="more" @click.prevent="handleLogin">
                        <span>Đăng nhập</span>
                    </div>
                    <!-- <el-button :loading="loading" type="primary" style="width: 100%; margin-bottom: 30px"
                        @click.prevent="handleLogin">Login</el-button> -->
                </el-form>
            </div>
        </el-dialog>
        <el-main class="main-login">
            <span class="bg_left"></span>
            <span class="bg_right"></span>
            <span class="bg_bottom"></span>
            <div class="display-flex">
                <div class="info">
                    <div class="logo">
                        <el-image style="width: 347px; height: 347px" :src="Logo12" />
                    </div>
                    <div class="info">
                        <h1 class="title-h1">Đường tơ trăng</h1>
                        <span class="date">18/9/2024</span>
                    </div>
                </div>
                <div class="divider">
                    <el-image :src="Divider" />
                </div>
                <div class="more" @click="showLogin">
                    <span>Đăng nhập</span>
                </div>
            </div>
        </el-main>
        <dialog-about :show-slogan="showSlogan"></dialog-about>
    </div>
    <!--  -->
</template>

<script>
import { validUsername } from "@frontend/utils/validate";
// import SocialSign from './components/SocialSignin'
// import bgLogin from "@/assets/images/bg/authentication-bg.jpg";
import imagesLogo from "@/assets/images/logo/GOSU_full.png";
import Logo12 from "@/assets/images/sinhnhat/logo12.svg";
import Divider from "@/assets/images/sinhnhat/divider.svg";
import bgLogin from "@/assets/images/sinhnhat/bg_login.svg";
import bg_left from "@/assets/images/sinhnhat/img_left.svg";
import bg_right from "@/assets/images/sinhnhat/img_right.svg";
import img_bottom from "@/assets/images/sinhnhat/img_bottom.svg";
import DialogAbout from "@frontend/components/DialogAbout";
import { getAccessToken } from "@frontend/utils/auth";
export default {
    name: "Login",
    components: { DialogAbout },
    data() {
        return {
            Logo12: Logo12,
            Divider: Divider,
            bgLogin: bgLogin,
            bg_left: bg_left,
            bg_right: bg_right,
            img_bottom: img_bottom,
            loginForm: {
                email: "",
                password: "",
            },
            loginRules: {
                email: [
                    {
                        required: true,
                        type: 'email',
                        trigger: "blur",
                        message: "Vui lòng nhập địa chỉ email!",
                    },
                ],
                password: [
                    {
                        required: true,
                        trigger: "blur",
                        message: "Vui lòng nhập mật khẩu!",
                    },
                ],
            },
            passwordType: "password",
            capsTooltip: false,
            loading: false,
            showDialog: false,
            showSlogan: true,
            redirect: undefined,
            redirectUri: undefined,
            oAuthState: undefined,
            otherQuery: {},
            bgLogin: bgLogin,
            logo: imagesLogo,

        };
    },
    watch: {
        $route: {
            handler: function (route) {
                const query = route.query;
                // redirect_uri
                if (query) {
                    this.redirect = query.redirect;
                    this.redirectUri = query.redirect_uri;
                    this.oAuthState = query.state;
                    this.otherQuery = this.getOtherQuery(query);
                }
            },
            immediate: true,
        },
    },
    created() {
    },
    mounted() {

    },
    destroyed() {
    },
    computed: {
        backgroundLogin() {
            return `background-image: url(${this.bgLogin})`;
        },
    },
    methods: {
        showLogin() {
            this.showDialog = !this.showDialog;
        },
        checkCapslock(e) {
            const { key } = e;
            this.capsTooltip =
                key && key.length === 1 && key >= "A" && key <= "Z";
        },
        handleLogin() {
            this.$refs.loginForm.validate((valid) => {
                if (valid) {
                    this.loading = true;
                    this.$store
                        .dispatch("user/login", this.loginForm)
                        .then((response) => {
                            const { data } = response;
                            if (data.success) {
                                this.$message({
                                    message: data.message,
                                    type: 'success'
                                })

                                //console.log("check this.redirectUri",this.redirectUri);
                                if (this.redirectUri) {

                                    //console.log("check this.redirectUri 2",this.redirectUri);
                                    window.location.href = this.redirectUri + '?token=' + getAccessToken() + '&state=' + this.oAuthState;
                                } else {
                                    //console.log("check this.redirect",this.redirect);
                                    window.location.href = "/";
                                }

                            } else {
                                this.$message({
                                    message: data.message,
                                    type: 'error'
                                })
                            }
                            this.loading = false;
                        })
                        .catch(() => {
                            this.loading = false;
                        });
                } else {
                    console.log("error submit!!");
                    return false;
                }
            });
        },
        getOtherQuery(query) {
            return Object.keys(query).reduce((acc, cur) => {
                if (cur !== "redirect") {
                    acc[cur] = query[cur];
                }
                return acc;
            }, {});
        },
    },
};
</script>
<style>
@import "~@style/style.scss";
</style>
<style lang="scss">
$bg: hsl(213, 25%, 21%);
// $bg: #432828;
$light_gray: #616161;
$cursor: #616161;

@supports (-webkit-mask: none) and (not (cater-color: $cursor)) {
    .login-container .el-input input {
        color: $cursor;
    }
}

/* reset element-ui css */
.wrapper-birthday {
    .login-container {
        .el-input {
            display: inline-block;
            height: 47px;
            width: calc(100% - 50px);

            input {
                background: transparent;
                border: 0px;
                -webkit-appearance: none;
                border-radius: 0px;
                padding: 12px 5px 12px 0px;
                color: #616161;
                height: 47px;
                caret-color: #616161;

                &:-webkit-autofill {
                    box-shadow: 0 0 0px 1000px $bg inset !important;
                    -webkit-text-fill-color: '#616161' !important;
                }
            }
        }

    }
}
</style>

<style lang="scss" scoped>
$bg: #2d3a4b;
$bgOverlay : #292626b3;
$dark_gray: #889aa4;
$light_gray: #eee;
$width_main: calc(100%);
$width_siderbar: calc(0%);
$height_logo: 70px;

:deep(.el-dialog) {
    padding: 75px 110px;
    background: #d9d9d9;
    border: 0;
    border-radius: 0;

    .el-dialog__title {
        margin: 0;
        text-align: center;
    }
}

.wrapper-birthday {
    .login-container {
        min-height: 100%;
        width: 100%;
        overflow: hidden;
        display: flex;
        align-items: center;

        .el-form-item {
            border: 1px solid transparent;
            background: #fff;
            border-radius: 0px;
            color: #616161;
            margin-bottom: 30px;
            font-family: 'Inter', sans-serif;

            &.is-error {
                .el-input__wrapper {
                    box-shadow: none;
                }
            }

            .el-input__wrapper {
                width: 100%;
                background: transparent;
                box-shadow: none;
                padding: 0;
                border-radius: 0 5px 5px 0;
                padding-right: 5px;
            }
        }

        .more {
            width: 260px;
            height: 50px;
            font-size: 25px;
            line-height: 50px;
            margin: 0 auto;
        }

        .login-form {
            position: relative;
            width: 100%;
            max-width: 500px;
            padding: 0px 35px;
            margin: 0 auto;
            overflow: hidden;
        }

        .tips {
            font-size: 14px;
            color: #fff;
            margin-bottom: 10px;

            span {
                &:first-of-type {
                    margin-right: 16px;
                }
            }
        }

        .svg-container {
            color: $dark_gray;
            vertical-align: middle;
            width: 50px;
            display: inline-block;
            text-align: center;
        }

        .title-container {
            position: relative;

            .title {
                font-size: 26px;
                color: $light_gray;
                margin: 0px auto 40px auto;
                text-align: center;
                font-weight: bold;
            }
        }

        .show-pwd {
            position: absolute;
            right: 10px;
            top: 7px;
            font-size: 16px;
            color: $dark_gray;
            cursor: pointer;
            user-select: none;
        }

        .thirdparty-button {
            position: absolute;
            right: 0;
            bottom: 6px;
        }

        @media only screen and (max-width: 470px) {
            .thirdparty-button {
                display: none;
            }
        }
    }
}
</style>

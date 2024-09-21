<template>
    <div class="app-wrapper">
        <el-dialog v-model="showDialog" :show-close="false" width="730" align-center>
            <template #header="{ close, titleId }">
                <div class="my-header">
                    <h6 class="button-login-header font_beaufort w700">Đăng nhập</h6>
                    <h4 :id="titleId" :class="`title-form`">Đăng nhập Email Gosu ở đây</h4>
                    <span class="button-close" @click="close"></span>
                </div>
            </template>
            <div class="login-container">
                <el-form ref="loginForm" :model="loginForm" :rules="loginRules" class="login-form" autocomplete="on"
                    label-position="left">
                    <el-form-item prop="email" ref="email_check">
                        <label class="label-input">Email GOSU</label>
                        <el-input ref="email" v-model="loginForm.email" name="email" type="email" tabindex="1"
                            autocomplete="on" />
                    </el-form-item>
                    <el-form-item prop="password" ref="password_check">
                        <label class="label-input">Password</label>
                        <el-input :key="passwordType" ref="password" v-model="loginForm.password" :type="passwordType"
                            name="password" tabindex="2" autocomplete="on" @keyup.enter="handleLogin" />
                    </el-form-item>
                    <div class="more font_beaufort w700" @click.prevent="handleLogin">
                        <span>Đồng ý</span>
                    </div>
                    <!-- <el-button :loading="loading" type="primary" style="width: 100%; margin-bottom: 30px"
                        @click.prevent="handleLogin">Login</el-button> -->
                </el-form>
            </div>
        </el-dialog>
        <el-main class="main-login">
            <!-- <span class="bg_left"></span>
            <span class="bg_right"></span>
            <span class="bg_bottom"></span> -->
            <div class="display-flex" v-if="!showDialog">
                <div class="info">
                    <div class="logo">
                        <el-image :src="LogoLoginPage" />
                    </div>
                </div>
                <div class="divider">
                    <el-image :src="Divider" />
                </div>
<!--                <div class="more font_beaufort w700" @click="showLogin">-->
<!--                    <span>Đăng nhập</span>-->
<!--                </div>-->
                <div class="more font_beaufort w700">
                    <span>Sự kiện đã kết thúc</span>
                </div>
            </div>
        </el-main>
    </div>
    <!--  -->
</template>

<script>
import { validUsername } from "@frontend/utils/validate";
// import SocialSign from './components/SocialSignin'
// import bgLogin from "@/assets/images/bg/authentication-bg.jpg";
import imagesLogo from "@/assets/images/logo/GOSU_full.png";
import Logo12 from "@/assets/images/sinhnhat/logo12.svg";
import LogoLoginPage from "@/assets/images/eventBirthday2024/logo_login_page.svg";
import Divider from "@/assets/images/eventBirthday2024/icon_divider.svg";
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
            bg_left: bg_left,
            bg_right: bg_right,
            img_bottom: img_bottom,
            LogoLoginPage: LogoLoginPage,
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
            showSlogan: false,
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
        this.$router.push(`/bachnhat`);
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
        handleFocusInput() {
            if (this.loginForm.email.length > 0) {
                this.$refs.email_check.$el.classList.add('open');
            } else {
                this.$refs.email_check.$el.classList.remove('open');
            }
            if (this.loginForm.password.length > 0) {
                this.$refs.password_check.$el.classList.add('open')
            } else {
                this.$refs.password_check.$el.classList.remove('open')
            }
        },
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
                                });
                                this.$router.push({name: "Home"});

                                //console.log("check this.redirectUri",this.redirectUri);
                                // if (this.redirectUri) {

                                //     //console.log("check this.redirectUri 2",this.redirectUri);
                                //     window.location.href = this.redirectUri + '?token=' + getAccessToken() + '&state=' + this.oAuthState;
                                // } else {
                                //     //console.log("check this.redirect",this.redirect);
                                //     window.location.href = "/";
                                // }
                                this.showDialog = false;
                                this.emitter.emit("is-login-success");
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
            height: 50px;
            width: 100% !important;

            input {
                background: transparent;
                border: 0px;
                -webkit-appearance: none;
                padding: 12px 10px;
                color: #343D40;
                height: 47px;
                caret-color: #343D40;
                border-radius: 10px;
                border: 1px solid #d9ecf1;

                &:-webkit-autofill {
                    box-shadow: 0 0 0px 1000px #fcfdfe inset !important;
                    -webkit-text-fill-color: #343D40 !important;
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
    padding: 135px 205px 70px 190px;
    background-image: url('../../../assets/images/eventBirthday2024/popup_login.svg');
    border: 0;
    border-radius: 0;
    background-color: transparent;
    box-shadow: none;
    background-size: 100%;
    height: 623px;

    .el-dialog__title {
        margin: 0;
        text-align: center;
    }
}

.wrapper-birthday {
    .login-container {
        min-height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        padding-top: 10px;

        .el-form-item {
            border: 1px solid transparent;
            background: transparent;
            border-radius: 0px;
            color: #343D40;
            margin-bottom: 30px;
            position: relative;

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
            margin: 0 auto;
        }

        .login-form {
            position: relative;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
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

    .button-login-header {
        background-image: url('../../../assets/images/eventBirthday2024/button_login_header.svg');
        width: 220px;
        margin: 30px auto;
        text-transform: uppercase;
        color: #28657D;
        display: flex;
        height: 43px;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .label-input {
        color: #343D40;
        background-color: #fbfcfd;
        padding: 0 5px;
        font-size: 14px;
        line-height: 20px;
        position: absolute;
        left: 5px;
        transition: all .3s ease;
        z-index: 1;
        // top: 50%;
        // transform: translate(0px, -50%);
        top: -10px;
        transform: translate(0px, 0px);
    }

    .open {
        .label-input {
            top: -10px;
            transform: translate(0px, 0px);
        }
    }
}
</style>

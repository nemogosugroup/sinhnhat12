<template>
    <div class="app-wrapper">
        <el-main class="main-login bachnhat">
            <span class="bg_left"></span>
            <span class="bg_right"></span>
            <div class="display-flex bachnhat">
                <div class="info">
                    <div class="logo">
                        <el-image style="width: 300px; height: 300px" :src="Logo12" />
                    </div>
                    <div class="info">
                        <h1 class="title-h1 bachnhat">BÁCH NHẬT GOSU</h1>
                        <span class="date bachnhat">NĂM 2024</span>
                    </div>
                </div>
                <div class="divider bachnhat">
                    <el-image :src="Divider" />
                </div>
                <div class="countdown">
                    <countdown
                        :deadline="countdownDeadline"
                        :labels="countDownLabels"
                        :flipAnimation="false"
                    />
                </div>
            </div>
        </el-main>
    </div>
    <!--  -->
</template>

<script>
import imagesLogo from "@/assets/images/logo/GOSU_full.png";
import Logo12 from "@/assets/images/sinhnhat/logo12.svg";
import Divider from "@/assets/images/sinhnhat/divider.svg";
import bg_left from "@/assets/images/sinhnhat/img_left.svg";
import bg_right from "@/assets/images/sinhnhat/img_right.svg";
import img_bottom from "@/assets/images/sinhnhat/img_bottom.svg";

import {Countdown} from 'vue3-flip-countdown'
export default {
    name: "BachNhat",
    components: {Countdown},
    data() {
        return {
            Logo12: Logo12,
            Divider: Divider,
            bg_left: bg_left,
            bg_right: bg_right,
            img_bottom: img_bottom,
            showSlogan: false,
            redirect: undefined,
            redirectUri: undefined,
            oAuthState: undefined,
            otherQuery: {},
            logo: imagesLogo,
            countdownDeadline: "2024-12-08",
            countDownLabels: {days: 'ngày', hours: 'giờ', minutes: 'phút', seconds: 'giây',}

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
    },
    methods: {
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
                    box-shadow: 0 0 0px 1000px #fff inset !important;
                    -webkit-text-fill-color: #616161 !important;
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
.countdown {
    :deep(.flip-clock__piece) {
        width: 160px;
        height: 160px;
        background: url('../../../assets/images/sinhnhat/bg_time_number.png');
        background-size: 100% 100%;
        background-repeat: no-repeat;
        margin: 0 25px;
        .no-animation__card {
            font-size: 64px;
            background: linear-gradient(to bottom, #ffffff 28%, #ead87f 87%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            top: 25px;
        }
        .flip-clock__slot {
            font-family: Inter, serif;
            font-size: 20px;
            color: #fff;
            position: relative;
            top: 5px;
        }
    }
}
</style>

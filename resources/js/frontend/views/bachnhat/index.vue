<template>
    <div class="app-wrapper">
        <el-main class="main-login bachnhat">
            <div class="display-flex bachnhat">
                <div class="moon">
                    <el-image :src="Moon" />
                </div>
                <div class="info">
                    <div class="logo">
                        <el-image style="width: 450px; height: 375px" :src="BachNhatLogo" />
                    </div>
                </div>
                <div class="countdown">
                    <countdown :deadline="countdownDeadline" :labels="countDownLabels" :flipAnimation="false" />
                </div>
            </div>
        </el-main>
    </div>
</template>

<script>
import imagesLogo from "@/assets/images/logo/GOSU_full.png";
import Divider from "@/assets/images/sinhnhat/divider.svg";
import Moon from "@/assets/images/eventBirthday2024/bachnhat_moon.png";
import BachNhatLogo from "@/assets/images/eventBirthday2024/bachnhat_logo.png";

import { Countdown } from 'vue3-flip-countdown'
export default {
    name: "BachNhat",
    components: { Countdown },
    data() {
        return {
            Moon: Moon,
            BachNhatLogo: BachNhatLogo,
            Divider: Divider,
            showSlogan: false,
            redirect: undefined,
            redirectUri: undefined,
            oAuthState: undefined,
            otherQuery: {},
            logo: imagesLogo,
            countdownDeadline: "2024-12-31",
            countDownLabels: { days: 'ngày', hours: 'giờ', minutes: 'phút', seconds: 'giây', }

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

.info {
    .logo {
        position: relative;
        top: -110px;
    }
}

.countdown {
    background-image: url("../../../assets/images/eventBirthday2024/countdown_frame.png");
    background-size: 100% 100%;
    background-repeat: no-repeat;
    position: relative;
    top: -165px;
    :deep(.flip-clock) {
        width: 500px;
    }
    :deep(.flip-clock__piece) {
        width: 115px;
        height: 80px;
        margin: 0;
        position: relative;

        &:not(:last-child) {
            &::after {
                content: "";
                display: block;
                background-image: url("../../../assets/images/eventBirthday2024/countdown_dot.png");
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center;
                position: absolute;
                right: -12px;
                top: 35px;
                width: 20px;
                height: 30px;
            }
        }

        .no-animation__card {
            font-size: 50px;
            font-family: "LacLongQuan", serif;
            background: #fdf3da;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            top: -5px;
        }

        .flip-clock__slot {
            font-family: Beaufort, serif;
            font-size: 20px;
            color: #73edff;
            text-transform: uppercase;
            position: relative;
            top: -15px;
        }
    }
}

.moon {
    transition: all .3s ease-in-out;
    animation: moon-scale 10s infinite;
}

@keyframes moon-scale {
    0% {
        transform: scale(1);
        filter: brightness(1);
    }
    50% {
        transform: scale(1.05);
        filter: brightness(1.05);
    }
    100% {
        transform: scale(1);
        filter: brightness(1);
    }
}
</style>

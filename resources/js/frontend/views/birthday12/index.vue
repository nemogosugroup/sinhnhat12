<template>
    <div id="sn12Map" :style="`background-image: url(${mapElm.MapBg})`">
        <el-row class="row_1">
            <el-col :span="20">
                <img class="map_title" :src="mapElm.DuongToTrangTextAndDate" alt="">
            </el-col>
            <el-col :span="4" class="alerts">
                <el-row>
                    <el-col :span="24" class="alert_bell" :class="{ active: issetAlert }">
                        <img @click="goToQuestList" :src="mapElm.MapIconBell" alt="">
                    </el-col>
                    <el-col :span="24" class="alert_mochi">
                        <img :src="mapElm.MapIconMochi" alt="">
                        <b class="alert_count mochi">{{ mochiCount }}</b>
                    </el-col>
                    <el-col :span="24" class="alert_silk">
                        <img :src="mapElm.MapIconSilk" alt="">
                        <b class="alert_count silk">{{ silkCount }}</b>
                    </el-col>
                </el-row>
            </el-col>
        </el-row>
        <el-row class="row_2">
            <el-col :span="24" class="ports">
                <el-row>
                    <el-col :span="8" class="port_wrapper cave" style="text-align: right"
                            :class="{ is_first_time: isFirstTime }">
                        <img class="main_img" :src="caveMainImg" alt="">
                        <img
                            @click="goTo('CAVE')"
                            @mouseover="handleHover('CAVE')"
                            @mouseout="handleHoverOut('CAVE')"
                            class="text_img" :src="caveTextImg" alt=""
                        >
                        <div v-if="tooltipType === 'CAVE'" class="bubble_tooltip tooltip_CAVE">
                            <VueTyped :strings="[`<b>Thố Động:</b> Điểm danh và làm nhiệm vụ ngày`]" :typeSpeed="10"
                                      :backSpeed="30" :loop="false">
                            </VueTyped>
                        </div>
                    </el-col>
                    <el-col :span="8" class="port_wrapper gate text-center">
                        <img class="main_img" :src="gateMainImg" alt="">
                        <img
                            @click="goTo('GATE')"
                            @mouseover="handleHover('GATE')"
                            @mouseout="handleHoverOut('GATE')"
                            class="text_img" :src="gateTextImg" alt=""
                        >
                        <div v-if="tooltipType === 'GATE'" class="bubble_tooltip tooltip_GATE">
                            <VueTyped :strings="[`<b>Cổng Moonwalk:</b> Trang hành trình GOSU12`]" :typeSpeed="15"
                                      :backSpeed="30" :loop="false">
                            </VueTyped>
                        </div>
                    </el-col>
                    <el-col :span="8" class="port_wrapper wheel text-left">
                        <img class="main_img" :src="wheelMainImg" alt="">
                        <img
                            @click="goTo('WHEEL')"
                            @mouseover="handleHover('WHEEL')"
                            @mouseout="handleHoverOut('WHEEL')"
                            class="text_img" :src="wheelTextImg" alt=""
                        >
                        <div v-if="tooltipType === 'WHEEL'" class="bubble_tooltip tooltip_WHEEL">
                            <VueTyped :strings="[`<b>Vòng Quay Mặt Trời:</b> Trò chơi thu thập Kim Tơ`]" :typeSpeed="15"
                                      :backSpeed="30" :loop="false">
                            </VueTyped>
                        </div>
                    </el-col>
                </el-row>
            </el-col>
        </el-row>
    </div>

    <map-dialog :dialog-visible="dialogVisible" :dialog-type="dialogType" :cave-type="caveType"
                :first-time="isFirstTime" @hideDialog="handleHideDialog"></map-dialog>

    <dialog-about :show-slogan="showSlogan"></dialog-about>

</template>
<script>
import DefaultAvatar from '@/assets/images/default_avatar.png'
import DownArrow from '@/assets/images/birthday12/map/map_down_arrow.png'

import MapBg from '@/assets/images/eventBirthday2024/bg.svg'
import DuongToTrangTextAndDate from '@/assets/images/eventBirthday2024/duong_to_trang_text_date.svg'
import MapCave from '@/assets/images/eventBirthday2024/img_thodong.svg'
import MapCaveHover from '@/assets/images/eventBirthday2024/img_thodong_hover.svg'
import MapCaveText from '@/assets/images/eventBirthday2024/icon_thodong.svg'
import MapCaveTextHover from '@/assets/images/eventBirthday2024/icon_thodong_hover.svg'
import MapGate from '@/assets/images/eventBirthday2024/img_moonwalk.svg'
import MapGateHover from '@/assets/images/eventBirthday2024/img_moonwalk_hover.svg'
import MapGateText from '@/assets/images/eventBirthday2024/icon_moonwalk.svg'
import MapGateTextHover from '@/assets/images/eventBirthday2024/icon_moonwalk_hover.svg'
import MapWheel from '@/assets/images/eventBirthday2024/img_vongquay.svg'
import MapWheelHover from '@/assets/images/eventBirthday2024/img_vongquay_hover.svg'
import MapWheelText from '@/assets/images/eventBirthday2024/icon_vongquay.svg'
import MapWheelTextHover from '@/assets/images/eventBirthday2024/icon_vongquay_hover.svg'
import MapIconBell from '@/assets/images/eventBirthday2024/icon_notification.svg'
import MapIconSilk from '@/assets/images/eventBirthday2024/icon_kimto.svg'
import MapIconMochi from '@/assets/images/eventBirthday2024/icon_mochi.svg'

import MapDialog from "@frontend/views/birthday12/components/MapDialog.vue";
import {mapGetters} from "vuex";
import {Emitter} from '@frontend/views/birthday12/components/wheel/components/evenEmit.js';
import DialogAbout from "@frontend/components/DialogAbout/index.vue";

export default {
    name: 'Map',
    components: {DialogAbout, MapDialog},
    data() {
        return {
            showSlogan: false,
            tooltipType: null,
            isFirstTime: false,
            dialogVisible: false,
            dialogType: null, // GATE, CAVE, WHEEL
            caveType: "nguyet_nhu", // nguyet_nhu, nguyet_nhiem, nguyet_thach, nguyet_ky
            issetAlert: 0,
            silkCount: 0,
            mochiCount: 0,
            caveMainImg: MapCave,
            caveTextImg: MapCaveText,
            gateMainImg: MapGate,
            gateTextImg: MapGateText,
            wheelMainImg: MapWheel,
            wheelTextImg: MapWheelText,
            mapElm: {
                DefaultAvatar: DefaultAvatar,
                DownArrow: DownArrow,
                MapBg: MapBg,
                DuongToTrangTextAndDate: DuongToTrangTextAndDate,
                MapCave: MapCave,
                MapCaveHover: MapCaveHover,
                MapCaveText: MapCaveText,
                MapCaveTextHover: MapCaveTextHover,
                MapGate: MapGate,
                MapGateHover: MapGateHover,
                MapGateText: MapGateText,
                MapGateTextHover: MapGateTextHover,
                MapWheel: MapWheel,
                MapWheelHover: MapWheelHover,
                MapWheelText: MapWheelText,
                MapWheelTextHover: MapWheelTextHover,
                MapIconBell: MapIconBell,
                MapIconSilk: MapIconSilk,
                MapIconMochi: MapIconMochi,
            }
        }
    },
    computed: {
        ...mapGetters(["user"]),
    },
    mounted() {
    },
    created() {
        this.$store.dispatch("user/getInfo").then(() => {
            this.issetAlert = this.user.alerts > 0;
            this.silkCount = this.user.point_silk;
            this.mochiCount = this.user.point_mochi;
            this.isFirstTime = this.user.first_time;
            this.showSlogan = this.isFirstTime;
        });
    },

    methods: {
        handleHover(pos) {
            this.tooltipType = pos;
            if (pos === "CAVE") {
                this.caveMainImg = this.mapElm.MapCaveHover;
                this.caveTextImg = this.mapElm.MapCaveTextHover;
            } else if (pos === "GATE") {
                this.gateMainImg = this.mapElm.MapGateHover;
                this.gateTextImg = this.mapElm.MapGateTextHover;
            } else if (pos === "WHEEL") {
                this.wheelMainImg = this.mapElm.MapWheelHover;
                this.wheelTextImg = this.mapElm.MapWheelTextHover;
            }
        },
        handleHoverOut(pos) {
            this.tooltipType = null;
            if (pos === "CAVE") {
                this.caveMainImg = this.mapElm.MapCave;
                this.caveTextImg = this.mapElm.MapCaveText;
            } else if (pos === "GATE") {
                this.gateMainImg = this.mapElm.MapGate;
                this.gateTextImg = this.mapElm.MapGateText;
            } else if (pos === "WHEEL") {
                this.wheelMainImg = this.mapElm.MapWheel;
                this.wheelTextImg = this.mapElm.MapWheelText;
            }
        },
        goToQuestList() {
            this.dialogType = "CAVE";
            this.caveType = "nguyet_nhiem";
            this.handleShowDialog();
        },
        goTo(pos) {
            if (pos !== "GATE") {
                this.dialogType = pos;
                this.caveType = "nguyet_nhu";
                this.handleShowDialog();
            } else {
                this.$router.push(`/moonwalk`);
            }
        },
        handleShowDialog() {
            this.dialogVisible = true;
        },
        async handleHideDialog() {
            this.dialogVisible = false;
            Emitter.emit("reset-game", true);
            await this.$store.dispatch("user/getInfo");
            this.issetAlert = this.user.alerts > 0;
            this.silkCount = this.user.point_silk;
            this.mochiCount = this.user.point_mochi;
            this.isFirstTime = this.user.first_time;
        },
        async handleLogout() {
            await this.$store.dispatch("user/logout");
            this.emitter.emit("clicked-logout", true);
            this.$router.push(`/login`);
        }
    },
}
</script>
<style lang="scss" scoped>
@import "~@style/variables.scss";

#sn12Map {
    width: 100%;
    height: 100vh;
    overflow: hidden;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    padding: 100px 20px 0;

    .row_1 {
        .map_title {
            position: relative;
            left: 7%;
        }

        .alerts {
            padding-right: 25px;

            img {
                margin-bottom: 5px;
                float: right;
            }

            .alert_bell {
                transition: all .3s ease-in-out;

                img {
                    cursor: pointer;
                    margin-bottom: 20px;
                }

                &.active {
                    &:before {
                        content: "";
                        width: 15px;
                        height: 15px;
                        display: block;
                        background: #D95117;
                        position: absolute;
                        border-radius: 50%;
                        right: 5px;
                        top: 10px;
                        box-shadow: 0 0 10px #D95117;
                        animation: scale_effect 1s infinite;
                    }
                }
            }

            .alert_mochi {
                position: relative;

                img {
                    position: relative;
                    left: 7px;
                    bottom: 2px;
                }
            }

            .alert_silk {
                position: relative;
            }

            .alert_count {
                position: absolute;
                color: #fff;
                right: 10px;
                transform: translate(50%, -50%);
                font-size: 18px;
                width: 30px;
                text-align: center;
                text-shadow: 0 0 7px #000;
                letter-spacing: 1px;

                &.silk {
                    top: 59px;
                }

                &.mochi {
                    top: 65px;
                }
            }

            .el-col-20 {
                position: relative;

                span {
                    font-family: "Myriad Pro", serif;
                    color: #8D410E;
                    position: absolute;
                    top: 35%;
                    left: 0;
                    transform: translate(10%, -50%);
                    font-size: 24px;
                }
            }
        }
    }

    .row_2 {

        .ports {
            .port_wrapper {
                position: relative;
                height: 500px;

                .main_img {
                    position: relative;
                    transition: all .3s ease-in-out;
                    animation: bounce 7s infinite;
                }

                .text_img {
                    position: absolute;
                    transform: translate(50%, -50%);
                    cursor: pointer;
                    transition: all .3s ease-in-out;
                }

                &.cave {

                    &.is_first_time {
                        &:before {
                            content: "";
                            position: absolute;
                            width: 150px;
                            height: 120px;
                            top: -32%;
                            right: 0;
                            background-image: url("@/assets/images/eventBirthday2024/icon_muiten.svg");
                            background-repeat: no-repeat;
                            background-size: contain;
                            animation: bounce 1s infinite, blink 1s infinite;
                        }
                    }

                    .main_img {
                        bottom: 20%;
                        left: 12%;
                    }

                    .text_img {
                        top: 26%;
                        right: 26%;
                    }
                }

                &.gate {
                    .main_img {
                        bottom: 67%;
                        left: 5%;
                    }

                    .text_img {
                        top: -17%;
                        left: -4%;
                    }
                }

                &.wheel {
                    .main_img {
                        bottom: 43%;
                        left: 9%;
                    }

                    .text_img {
                        top: 10%;
                        left: -27%;
                    }
                }

                .bubble_tooltip {
                    position: absolute;
                    width: 100%;
                    text-align: center;
                    z-index: 2;

                    &.tooltip_CAVE {
                        top: 34%;
                        left: 27%;
                    }

                    &.tooltip_GATE {
                        top: -9%;
                        left: -14%;
                    }

                    &.tooltip_WHEEL {
                        top: 18%;
                        left: -32%;
                    }

                    > div {
                        display: inline;
                        padding: 7px 15px;
                        background: #fff;
                        border-radius: 7px;
                        box-shadow: 0 0 5px #000;
                        font-style: italic;
                        font-family: "Myriad Pro", serif;
                    }
                }
            }
        }
    }

    .img_button {
        max-width: 400px;
    }
}

@keyframes bounce {
    0% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-5px);
    }

    100% {
        transform: translateY(0);
    }
}

@keyframes blink {
    50% {
        opacity: 0;
    }
}

@keyframes scale_effect {
    0% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.1);
    }

    100% {
        transform: scale(1);
    }
}
</style>

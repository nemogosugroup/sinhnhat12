<template>
    <div id="sn12Map" :style="`background-image: url(${mapElm.MapBg})`">
        <el-row class="row_1">
            <el-col :span="24">
                <h1 class="map_title">{{ "ĐƯỜNG TƠ TRĂNG" }}</h1>
            </el-col>
            <el-col :span="24">
                <div class="map_user_board" :style="`background-image: url(${mapElm.MapBgUserBoard})`">
                    <el-row>
                        <el-col :span="4">
                            <el-avatar :size="50" :src="user.avatar">
                                <img
                                    :src="mapElm.DefaultAvatar"
                                    alt=""
                                />
                            </el-avatar>
                        </el-col>
                        <el-col :span="6">
                            <span>{{ "Xin chào" }}</span>
                        </el-col>
                        <el-col :span="10">
                            <b>{{ user.fullname }}</b>
                        </el-col>
                        <el-col :span="4">
                            <a @click="handleLogout">{{ "Thoát" }}</a>
                        </el-col>
                    </el-row>
                </div>
            </el-col>
        </el-row>
        <el-row class="row_2">
            <el-col :span="6" class="alerts">
                <el-row>
                    <el-col :span="24">
                        <el-row>
                            <el-col :span="4">
                                <img @click="goToQuestList" :src="mapElm.MapIconBell" alt="">
                                <b class="alert_count bell">15</b>
                            </el-col>
                            <el-col :span="20">
                                <span>{{ "Thông báo" }}</span>
                            </el-col>
                        </el-row>
                    </el-col>
                    <el-col :span="24">
                        <el-row>
                            <el-col :span="4">
                                <img :src="mapElm.MapIconSilk" alt="">
                                <b class="alert_count silk">15</b>
                            </el-col>
                            <el-col :span="20">
                                <span>{{ "Kim tơ" }}</span>
                            </el-col>
                        </el-row>
                    </el-col>
                    <el-col :span="24">
                        <el-row>
                            <el-col :span="4">
                                <img :src="mapElm.MapIconMochi" alt="">
                                <b class="alert_count mochi">15</b>
                            </el-col>
                            <el-col :span="20">
                                <span>{{ "Mochi" }}</span>
                            </el-col>
                        </el-row>
                    </el-col>
                </el-row>
            </el-col>
            <el-col :span="18" class="ports">
                <el-row>
                    <el-col :span="24" class="port_wrapper text-center">
                        <img class="main_img" :src="mapElm.MapGate" alt="">
                        <img @click="goTo('GATE')" class="text_img" :src="mapElm.MapGateText" alt="">
                    </el-col>
                    <el-col :span="12" class="port_wrapper cave text-center" :class="{is_first_time: isFirstTime}">
                        <img class="main_img" :src="mapElm.MapCave" alt="">
                        <img @click="goTo('CAVE')" class="text_img" :src="mapElm.MapCaveText" alt="">
                    </el-col>
                    <el-col :span="12" class="port_wrapper text-center">
                        <img class="main_img" :src="mapElm.MapWheel" alt="">
                        <img @click="goTo('WHEEL')" class="text_img" :src="mapElm.MapWheelText" alt="">
                    </el-col>
                </el-row>
            </el-col>
        </el-row>
    </div>

    <map-dialog
        :dialog-visible="dialogVisible"
        :dialog-type="dialogType"
        :cave-type="caveType"
        :first-time="isFirstTime"
        @hideDialog="handleHideDialog"
    ></map-dialog>

</template>
<script>
import DefaultAvatar from '../../../assets/images/default_avatar.png'
import DownArrow from '../../../assets/images/birthday12/map/map_down_arrow.png'

import MapBg from '../../../assets/images/birthday12/map/map_bg_moon_to_earth.png'
import MapBgUserBoard from '../../../assets/images/birthday12/map/map_bg_user_board.png'
import MapCave from '../../../assets/images/birthday12/map/map_cave.svg'
import MapCaveText from '../../../assets/images/birthday12/map/map_cave_text.svg'
import MapGate from '../../../assets/images/birthday12/map/map_gate.svg'
import MapGateText from '../../../assets/images/birthday12/map/map_gate_text.svg'
import MapWheel from '../../../assets/images/birthday12/map/map_wheel.svg'
import MapWheelText from '../../../assets/images/birthday12/map/map_wheel_text.svg'
import MapIconBell from '../../../assets/images/birthday12/map/map_icon_bell.png'
import MapIconSilk from '../../../assets/images/birthday12/map/map_icon_silk.png'
import MapIconMochi from '../../../assets/images/birthday12/map/map_icon_mochi.png'

import MapDialog from "@frontend/views/birthday12/components/MapDialog.vue";
import {mapGetters} from "vuex";

export default {
    name: 'Map',
    components: {MapDialog},
    data() {
        return {
            isFirstTime: true,
            dialogVisible: false,
            dialogType: null, // GATE, CAVE, WHEEL
            caveType: "nguyet_nhu", // nguyet_nhu, nguyet_nhiem, nguyet_thach, nguyet_ky
            mapElm: {
                DefaultAvatar: DefaultAvatar,
                DownArrow: DownArrow,
                MapBg: MapBg,
                MapBgUserBoard: MapBgUserBoard,
                MapCave: MapCave,
                MapCaveText: MapCaveText,
                MapGate: MapGate,
                MapGateText: MapGateText,
                MapWheel: MapWheel,
                MapWheelText: MapWheelText,
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
    },

    methods: {
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
                alert("GO TO GATE NOW");
            }
        },
        handleShowDialog() {
            this.dialogVisible = true;
        },
        handleHideDialog() {
            this.dialogVisible = false;
        },
        async handleLogout() {
            await this.$store.dispatch("user/logout");
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
    background-size: contain;
    background-position: 100% 80px;
    padding: 100px 20px 0;

    .row_1 {
        .map_title {
            font-family: "Phudu", serif;
            font-size: 160px;
            background: linear-gradient(to top, #833602 31%, #A8622E 65%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 600;
            filter: drop-shadow(0 0 0.75rem rgba(0, 0, 0, 0.25));
            text-shadow: 0 5px 5px rgb(0 0 0 / 10%);
            -webkit-filter: drop-shadow(0 0 0.75rem rgba(0, 0, 0, 0.25));
            margin: 10px 0;
        }

        .map_user_board {
            height: 90px;
            max-width: 460px;
            padding: 20px 45px;
            margin-bottom: 40px;
            background-repeat: no-repeat;
            text-align: center;

            .el-avatar {
                border: 2px solid #fff;
                box-shadow: 0 4px 7px #00000070;

                img {
                    object-fit: cover;
                }
            }

            .el-col {
                &:not(:first-child) {
                    span, b, a {
                        position: relative;
                        top: 16px;
                        color: #66494E;
                    }
                    span, a {
                        font-family: "LacLongQuan", serif;
                    }
                }

                &:last-child {
                    a {
                        position: relative;

                        &:before {
                            content: "";
                            height: 20px;
                            width: 1px;
                            background: #000;
                            position: absolute;
                            left: -8px;
                            top: 1px;
                        }
                    }
                }
            }
        }
    }

    .row_2 {
        .alerts {
            img {
                margin-bottom: 5px;
                cursor: pointer;
            }

            .alert_count {
                position: absolute;
                color: #fff;
                top: 60px;
                left: 7px;
                transform: translate(50%, -50%);
                font-size: 12px;
                width: 30px;
                text-align: center;

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
                    font-family: "LacLongQuan", serif;
                    color: #8D410E;
                    position: absolute;
                    top: 35%;
                    left: 0;
                    transform: translate(10%, -50%);
                    font-size: 24px;
                }
            }
        }

        .ports {
            .port_wrapper {
                position: relative;
                right: 60px;
                bottom: 100px;

                &.cave {
                    &:after {
                        content: "";
                        position: absolute;
                        top: 90px;
                        right: 100px;
                        width: 100px;
                        height: 100px;
                        background-image: url("../../../assets/images/birthday12/map/map_cave_rabbit.svg");
                        background-repeat: no-repeat;
                    }

                    &.is_first_time {
                        &:before {
                            content: "";
                            position: absolute;
                            width: 120px;
                            height: 150px;
                            top: -30%;
                            left: 42%;
                            background-image: url("../../../assets/images/birthday12/map/map_down_arrow.png");
                            background-repeat: no-repeat;
                            background-size: contain;
                            animation: bounce 1s infinite, blink 1s infinite;
                        }
                    }
                }

                .main_img {
                    position: relative;
                }

                .text_img {
                    position: absolute;
                    top: 50%;
                    right: 50%;
                    transform: translate(50%, -50%);
                    transition: all .3s ease-in-out;
                    cursor: pointer;

                    &:hover {
                        transform: translate(50%, -55%);
                    }
                }

                &:first-child {
                    .text_img {
                        top: 60%;
                    }
                }

                &:nth-child(2) {
                    .text_img {
                        top: 33%;
                    }
                }

                &:last-child {
                    .main_img {
                        bottom: 80px;
                    }

                    .text_img {
                        top: 40%;
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
        transform: translateY(-10px);
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
</style>

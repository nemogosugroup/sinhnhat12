<template>
    <el-dialog
        v-model="isShowDialog" @close="closeDialog"
        class="custom_el_dialog"
        style="width: 100%; height: 100%; background-color: transparent; box-shadow: none; margin: 0 auto"
        :show-close="false"
    >
        <div class="custom_dialog" :class="dialogType" :style="`background-image: url(${dialogElm.DialogBg})`">

            <div class="custom_title" :class="dialogType">
                <img :src="dialogType === 'CAVE' ? dialogElm.DialogCaveTitle : dialogElm.DialogWheelTitle" alt="">
            </div>

            <div class="custom_logo" :class="dialogType">
                <img :src="dialogType === 'CAVE' ? dialogElm.DialogCaveLogo : dialogElm.DialogWheelLogo" alt="">
            </div>

            <div class="custom_close_btn">
                <img @click="closeDialog" :src="dialogElm.DialogCloseBtn" alt="">
            </div>

            <div class="custom_gabi">
                <img :src="dialogElm.DialogGabi" alt="">
            </div>

            <div class="custom_content">
                <cave-content
                    v-if="dialogType === 'CAVE'"
                    :cave-type="caveType"
                />
                <wheel-content
                    v-if="dialogType === 'WHEEL'"
                />
            </div>
        </div>
    </el-dialog>
</template>
<script>
import CaveContent from "../components/cave"
import WheelContent from "../components/wheel"

import DialogBg from "../../../../assets/images/birthday12/map/dialog/dialog_bg.png"
import DialogCloseBtn from "../../../../assets/images/birthday12/map/dialog/dialog_close_btn.png"
import DialogGabi from "../../../../assets/images/birthday12/map/dialog/dialog_gabi.png"
import DialogCaveLogo from "../../../../assets/images/birthday12/map/dialog/dialog_cave.svg"
import DialogCaveTitle from "../../../../assets/images/birthday12/map/dialog/dialog_cave_text.png"
import DialogWheelLogo from "../../../../assets/images/birthday12/map/dialog/dialog_wheel.svg"
import DialogWheelTitle from "../../../../assets/images/birthday12/map/dialog/dialog_wheel_text.png"

export default {
    name: 'MapDialog',
    components: {CaveContent, WheelContent},
    props: {
        dialogVisible: {
            type: Boolean,
            default: false
        },
        dialogType: {
            type: String,
            default: null // CAVE, WHEEL
        },
        caveType: {
            type: String,
            default: null // nguyet_nhu, nguyet_nhiem, nguyet_thach, nguyet_ky
        }
    },
    data() {
        return {
            isShowDialog: this.dialogVisible,
            dialogElm: {
                DialogBg: DialogBg,
                DialogCloseBtn: DialogCloseBtn,
                DialogGabi: DialogGabi,
                DialogCaveLogo: DialogCaveLogo,
                DialogCaveTitle: DialogCaveTitle,
                DialogWheelLogo: DialogWheelLogo,
                DialogWheelTitle: DialogWheelTitle
            }
        }
    },
    filters: {},
    created() {
    },
    watch: {
        dialogVisible(newValue) {
            this.isShowDialog = newValue;
        },
    },
    methods: {
        closeDialog() {
            this.isShowDialog = false
            this.$emit('hideDialog', {});
        }
    }
}

</script>
<style lang="scss" scoped>
.custom_dialog {
    font-family: "LacLongQuan", serif;
    position: relative;
    width: 100%;
    height: 90vh;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    padding: 5% 20% 8.6% 21%;
    .custom_close_btn {
        position: relative;
        float: right;
        right: -25px;
        top: -30px;
        cursor: pointer;
        img {
            transition: all .3s ease-in-out;
        }
        &:hover {
            img {
                transform: scale(1.1);
            }
        }
    }
    .custom_title {
        position: absolute;
        top: 8%;
        left: 9.5%;
        &.CAVE {
            left: 11.5%;
        }
        img {
            transition: all .3s ease-in-out;
        }
        &:hover {
            img {
                transform: scale(1.1);
            }
        }
    }
    .custom_logo {
        position: absolute;
        bottom: -4%;
        left: 11%;
        img {
            transition: all .3s ease-in-out;
        }
        &:hover {
            img {
                transform: scale(1.1);
            }
        }
        &.WHEEL {
            bottom: -6.5%;
            left: 6%;
            img {
                transform: scale(.8);
            }
            &:hover {
                img {
                    transform: scale(.9);
                }
            }
        }
    }
    .custom_close_btn {
        position: relative;
        float: right;
        right: -25px;
        top: -30px;
        cursor: pointer;
        img {
            transition: all .3s ease-in-out;
        }
        &:hover {
            img {
                transform: scale(1.1);
            }
        }
    }
    .custom_gabi {
        position: absolute;
        bottom: 3%;
        right: 9%;
        cursor: pointer;
        img {
            transition: all .3s ease-in-out;
        }
        &:hover {
            img {
                transform: scale(1.1);
            }
        }
    }
}
</style>
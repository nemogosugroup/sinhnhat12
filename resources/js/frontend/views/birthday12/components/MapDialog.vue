<template>
    <el-dialog v-model="isShowDialog" class="custom_el_dialog"
        style="width: 100%; height: 100%; background-color: transparent; box-shadow: none; margin: 0 auto"
        :show-close="false">
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
                <div v-if="isShowBubble" class="bubble_callout"
                    :style="`background-image: url(${dialogElm.BubbleCallout})`">
                    <VueTyped :strings="typedContent" :typeSpeed="50" :backSpeed="30" :loop="false"
                        :onComplete="handleCompleteAll">
                    </VueTyped>
                </div>
                <img :src="dialogElm.DialogGabi" alt="">
            </div>

            <div class="custom_content">
                <cave-content v-if="dialogType === 'CAVE'" :cave-type="tabType" :first-time="isFirstTime" />
                <wheel-content v-if="dialogType === 'WHEEL'" />
            </div>
        </div>
    </el-dialog>
</template>
<script>
import CaveContent from "../components/cave"
import WheelContent from "../components/wheel"

import DialogBg from "@/assets/images/birthday12/map/dialog/dialog_bg.png"
import DialogCloseBtn from "@/assets/images/birthday12/map/dialog/dialog_close_btn.png"
import DialogGabi from "@/assets/images/birthday12/map/dialog/dialog_gabi.png"
import DialogCaveLogo from "@/assets/images/birthday12/map/dialog/dialog_cave.svg"
import DialogCaveTitle from "@/assets/images/birthday12/map/dialog/dialog_cave_text.png"
import DialogWheelLogo from "@/assets/images/birthday12/map/dialog/dialog_wheel.svg"
import DialogWheelTitle from "@/assets/images/birthday12/map/dialog/dialog_wheel_text.png"
import BubbleCallout from "@/assets/images/birthday12/map/bubble_callout.png"

export default {
    name: 'MapDialog',
    components: { CaveContent, WheelContent },
    props: {
        dialogVisible: {
            type: Boolean,
            default: false
        },
        firstTime: {
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
            isFirstTime: this.firstTime,
            isShowBubble: false,
            tabType: this.caveType,
            typedContent: ["Các Thỏ Ngọc hãy hoàn thành các nhiệm vụ ngày tại Nguyệt Nhiệm để nhận Mochi tham gia trò chơi Vòng Quay Mặt Trời nhé!"],
            dialogElm: {
                DialogBg: DialogBg,
                DialogCloseBtn: DialogCloseBtn,
                DialogGabi: DialogGabi,
                DialogCaveLogo: DialogCaveLogo,
                DialogCaveTitle: DialogCaveTitle,
                DialogWheelLogo: DialogWheelLogo,
                DialogWheelTitle: DialogWheelTitle,
                BubbleCallout: BubbleCallout
            }
        }
    },
    filters: {},
    created() {
        this.emitter.off("show-bubble-callout");
        this.emitter.off("hide-bubble-callout");
    },
    mounted() {
        this.emitter.on("show-bubble-callout", () => {
            document.querySelector(".custom_gabi").classList.add("active");
            this.isShowBubble = true;
        });
        this.emitter.on("hide-bubble-callout", () => {
            this.isShowBubble = false;
        });
    },
    watch: {
        dialogVisible(newValue) {
            this.isShowDialog = newValue;
        },
        firstTime(newValue) {
            this.isFirstTime = newValue;
        },
        caveType(newValue) {
            this.tabType = newValue;
        },
    },
    methods: {
        handleCompleteAll() {
            // complete bubble
            console.log("complete bubble")
        },
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
    padding: 5% 20% 9.5% 22.5%;

    .custom_close_btn {
        position: relative;
        float: right;
        right: -25px;
        top: -30px;
        cursor: pointer;
        z-index: 9;

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
        z-index: 9;

        img {
            transition: all .3s ease-in-out;
        }

        &.active,
        &:hover {
            img {
                transform: scale(1.1);
            }
        }

        .bubble_callout {
            background-repeat: no-repeat;
            background-size: contain;
            position: absolute;
            top: -85%;
            width: 350px;
            height: 200px;
            left: 20%;
            padding: 30px 40px 90px 35px;
            font-size: 17px;
            font-weight: bold;
            font-style: italic;
        }
    }
}
</style>

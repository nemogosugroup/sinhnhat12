<template>
    <el-dialog v-model="isShowDialog" class="custom_el_dialog"
               style="width: 100%; height: 100%; background-color: transparent; box-shadow: none; margin: 0 auto"
               :show-close="false" @close="closeDialog">
        <div class="custom_dialog" :class="dialogType"
             :style="`background-image: url(${dialogType === 'CAVE' ? dialogElm.DialogCaveBg :  dialogElm.DialogWheelBg})`">
            <div class="custom_close_btn">
                <img @click="closeDialog" :src="dialogElm.DialogCloseBtn" alt="">
            </div>

            <div class="custom_content">
                <cave-content v-if="dialogType === 'CAVE'" :cave-type="tabType" :first-time="isFirstTime"/>
                <wheel-content v-if="dialogType === 'WHEEL'"/>
            </div>
        </div>
    </el-dialog>
</template>
<script>
import CaveContent from "../components/cave"
import WheelContent from "../components/wheel"

import DialogCaveBg from "@/assets/images/eventBirthday2024/popup_thodong.svg"
import DialogWheelBg from "@/assets/images/eventBirthday2024/popup_vongquay.svg"
import DialogCloseBtn from "@/assets/images/eventBirthday2024/icon_close.svg"

import RepositoryFactory from '@frontend/utils/RepositoryFactory';

const game2048Repository = RepositoryFactory.get('game2048');
export default {
    name: 'MapDialog',
    components: {CaveContent, WheelContent},
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
            tabType: this.caveType,
            typedContent: ["Các Thỏ Ngọc hãy hoàn thành các nhiệm vụ ngày tại Nguyệt Nhiệm để nhận Mochi tham gia trò chơi Vòng Quay Mặt Trời nhé!"],
            dialogElm: {
                DialogCaveBg: DialogCaveBg,
                DialogWheelBg: DialogWheelBg,
                DialogCloseBtn: DialogCloseBtn
            }
        }
    },
    filters: {},
    created() {
        this.emitter.off("hide-bubble-callout");
    },
    mounted() {
        this.emitter.on("end-first-time", () => {
            // call api update users.first_time = false
            this.setFirstTimeToFalse();
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
            this.isShowDialog = false;
            this.$emit('hideDialog', {});
        },
        async setFirstTimeToFalse() {
            const {data} = await game2048Repository.setFirstTimeToFalse();
            if (data.success) {
                console.log('end first-time for user')
            }
        }
    }
}

</script>
<style lang="scss" scoped>
.custom_dialog {
    font-family: "Myriad Pro", serif;
    position: relative;
    width: 100%;
    height: 90vh;
    background-size: 1354px;
    background-repeat: no-repeat;
    background-position: 267px 0;
    padding: 198px 377px 75px 472px;
    min-width: 1888px;
    max-width: 1888px;
    min-height: 827px;
    max-height: 827px;

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

    .custom_close_btn {
        position: relative;
        float: right;
        right: -40px;
        top: -20px;
        cursor: pointer;

        img {
            transition: all .3s ease-in-out;
        }

        &:hover {
            img {
                transform: scale(1.15);
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

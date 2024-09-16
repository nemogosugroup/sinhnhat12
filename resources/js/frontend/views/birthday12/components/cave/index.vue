<template>
    <div class="cave_content">
        <div class="left_nav">
            <el-row>
                <el-col :span="24">
                    <div class="tab_text" :class="{active: type === 'nguyet_nhu'}" @click="changeTab('nguyet_nhu')">
                        {{ "Nguyệt Nhũ" }}
                    </div>
                </el-col>
                <el-col :span="24" class="nguyet_nhiem" :class="{is_first_time: isFirstTime}">
                    <div class="tab_text" :class="{active: type === 'nguyet_nhiem'}" @click="changeTab('nguyet_nhiem')">
                        {{ "Nguyệt Nhiệm" }}
                    </div>
                </el-col>
                <el-col :span="24">
                    <div class="tab_text" :class="{active: type === 'nguyet_thach'}" @click="changeTab('nguyet_thach')">
                        {{ "Nguyệt Thạch" }}
                    </div>
                </el-col>
                <el-col :span="24">
                    <div class="tab_text" :class="{active: type === 'nguyet_ky'}" @click="changeTab('nguyet_ky')">
                        {{ "Nguyệt Ký" }}
                    </div>
                </el-col>
            </el-row>
        </div>
        <div class="right_content">
            <el-row>
                <el-col v-if="type === 'nguyet_nhu'" :span="24">
                    <nguyet-nhu/>
                </el-col>
                <el-col v-if="type === 'nguyet_nhiem'" :span="24">
                    <nguyet-nhiem/>
                </el-col>
                <el-col v-if="type === 'nguyet_thach'" :span="24">
                    <nguyet-thach/>
                </el-col>
                <el-col v-if="type === 'nguyet_ky'" :span="24">
                    <nguyet-ky/>
                </el-col>
            </el-row>
        </div>
    </div>
</template>
<script>

import NguyetNhu from "@frontend/views/birthday12/components/cave/tabs/nguyet_nhu.vue";
import NguyetNhiem from "@frontend/views/birthday12/components/cave/tabs/nguyet_nhiem.vue";
import NguyetThach from "@frontend/views/birthday12/components/cave/tabs/nguyet_thach.vue";
import NguyetKy from "@frontend/views/birthday12/components/cave/tabs/nguyet_ky.vue";

export default {
    name: 'Cave',
    components: {
        NguyetNhu,
        NguyetNhiem,
        NguyetThach,
        NguyetKy
    },
    props: {
        caveType: {
            type: String,
            default: null // nguyet_nhu, nguyet_nhiem, nguyet_thach, nguyet_ky
        },
        firstTime: {
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
            type: this.caveType,
            isFirstTime: false
        }
    },
    filters: {},
    created() {
        this.isFirstTime = this.firstTime;
    },
    watch: {
        caveType(newValue) {
            this.type = newValue;
        },
        firstTime(newValue) {
            this.isFirstTime = newValue;
        }
    },
    methods: {
        changeTab(tabType) {
            if (this.isFirstTime && tabType === "nguyet_nhiem") {
                this.isFirstTime = false;
                this.emitter.emit("end-first-time", true);
            }
            this.type = tabType;
        }
    }
}

</script>
<style lang="scss" scoped>
.cave_content {
    position: relative;

    .left_nav {

        .nguyet_nhiem {
            &.is_first_time {
                &:before {
                    content: "";
                    position: absolute;
                    width: 100px;
                    height: 120px;
                    top: 25%;
                    left: -55%;
                    background-image: url("../../../../../assets/images/eventBirthday2024/icon_muiten_ngang.png");
                    background-repeat: no-repeat;
                    background-size: contain;
                    animation: bounce 1s infinite, blink 1s infinite;
                }
            }
        }

        position: absolute;
        left: -138.5px;
        top: 90px;
        max-width: 145px;
        padding-left: 5px;

        .tab_text {
            cursor: pointer;
            text-align: center;
            color: #fff;
            font-size: 24px;
            line-height: 30px;
            padding: 25px 20px 5px 5px;
            height: 110px;
            width: 122px;
            transition: all .3s ease-in-out;
            background-size: 88% !important;
            background: url('../../../../../assets/images/eventBirthday2024/button_tab.svg') no-repeat 0;
            margin-bottom: 10px;
            font-family: Beaufort, serif;
            font-weight: bold;

            &:hover,
            &.active {
                padding-top: 28px;
                padding-left: 12px;
                color: #513A05;
                position: relative;
                background-size: 100% !important;
                background: url('../../../../../assets/images/eventBirthday2024/button_tab_hover.svg') no-repeat 0 12px;
            }
        }
    }

    .right_content {
        .el-row {
            width: 100%;
            top: -80px;
            height: 100%;
        }
    }
}

@keyframes bounce {
    0% {
        transform: translateX(0);
    }
    50% {
        transform: translateX(-10px);
    }
    100% {
        transform: translateX(0);
    }
}

@keyframes blink {
    50% {
        opacity: 0;
    }
}
</style>
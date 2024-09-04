<template>
    <div class="cave_content">
        <div class="left_nav">
            <el-row>
                <el-col :span="24">
                    <div class="tab_text" :class="{active: type === 'nguyet_nhu'}" @click="changeTab('nguyet_nhu')">
                        {{ "NGUYỆT NHŨ" }}
                    </div>
                    <hr class="custom_hr">
                </el-col>
                <el-col :span="24" class="nguyet_nhiem" :class="{is_first_time: isFirstTime}">
                    <div class="tab_text" :class="{active: type === 'nguyet_nhiem'}" @click="changeTab('nguyet_nhiem')">
                        {{ "NGUYỆT NHIỆM" }}
                    </div>
                    <hr class="custom_hr">
                </el-col>
                <el-col :span="24">
                    <div class="tab_text" :class="{active: type === 'nguyet_thach'}" @click="changeTab('nguyet_thach')">
                        {{ "NGUYỆT THẠCH" }}
                    </div>
                    <hr class="custom_hr">
                </el-col>
                <el-col :span="24">
                    <div class="tab_text" :class="{active: type === 'nguyet_ky'}" @click="changeTab('nguyet_ky')">
                        {{ "NGUYỆT KÝ" }}
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
        setTimeout(() => {
            this.isFirstTime = this.firstTime;
            setTimeout(() => {
                this.emitter.emit("show-bubble-callout", true);
            }, 1000);
        }, 5000);
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
                document.querySelector(".custom_gabi").classList.remove("active");
                this.emitter.emit("hide-bubble-callout", true);
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
                    height: 80px;
                    top: 23%;
                    left: -120%;
                    background-image: url("../../../../../assets/images/birthday12/map/map_right_arrow.png");
                    background-repeat: no-repeat;
                    background-size: contain;
                    animation: bounce 1s infinite, blink 1s infinite;
                }
            }
        }

        position: absolute;
        left: -136px;
        top: 180px;
        max-width: 80px;

        .tab_text {
            cursor: pointer;
            text-align: center;
            color: #fff;
            font-size: 20px;
            line-height: 27px;
            padding: 2px 0 5px;
            transition: all .3s ease-in-out;

            &:before {
                content: "";
                position: absolute;
                top: 2px;
                transition: all .3s ease-in-out;
            }

            &:hover,
            &.active {
                color: #FDD796;
                text-shadow: 0 0 10px #FDD796;
                position: relative;

                &:before {
                    width: 80px;
                    height: 50px;
                    border-radius: 50%;
                    background-color: rgba(253, 215, 150, 0.25);
                    filter: blur(10px);
                }
            }
        }

        .custom_hr {
            background: linear-gradient(90deg, transparent, #fff, transparent);
            border: none;
            height: 1px;
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
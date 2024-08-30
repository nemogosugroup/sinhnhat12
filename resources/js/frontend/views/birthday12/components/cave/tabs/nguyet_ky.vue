<template>
    <div>
        <h1 class="title">{{ "LỊCH SỬ HOẠT ĐỘNG" }}</h1>
        <hr class="custom_hr">
        <div class="content_wrapper">
            <div class="content">
                <el-row v-for="(item, idx) in data" :key="idx">
                    <el-col class="time" :span="6">
                        <div>{{ item.time }}</div>
                    </el-col>
                    <el-col class="content" :span="16">
                        <div>{{ item.content }}</div>
                    </el-col>
                    <el-col class="value" :span="2">
                        <div>
                            <span class="number">{{ item.value.number }}</span>
                            <img v-if="item.value.type === 'SILK'" class="icon" :src="iconSilk" alt="">
                            <img v-else :src="iconMochi" class="icon" alt="">
                        </div>
                    </el-col>
                </el-row>
            </div>
        </div>
    </div>
</template>
<script>
import iconSilk from "../../../../../../assets/images/birthday12/map/dialog/icon_silk.png";
import iconMochi from "../../../../../../assets/images/birthday12/map/dialog/icon_mochi.png";

export default {
    name: 'NguyetKyTab',
    components: {},
    data() {
        return {
            iconSilk: iconSilk,
            iconMochi: iconMochi,
            data: [
                {
                    time: "24-09-18 16:09:20",
                    content: "Nhận nhiệm vụ 1 tại bảng thử thách",
                    value: {number: 5, type: "SILK"}
                },
                {
                    time: "24-09-18 16:09:20",
                    content: "Nhận nhiệm vụ 1 tại bảng thử thách",
                    value: {number: 10, type: "MOCHI"}
                },
                {
                    time: "24-09-18 16:09:20",
                    content: "Nhận nhiệm vụ 1 tại bảng thử thách",
                    value: {number: 15, type: "MOCHI"}
                },
                {
                    time: "24-09-18 16:09:20",
                    content: "Nhận nhiệm vụ 1 tại bảng thử thách",
                    value: {number: 20, type: "SILK"}
                },
                {
                    time: "24-09-18 16:09:20",
                    content: "Nhận nhiệm vụ 1 tại bảng thử thách",
                    value: {number: 5, type: "SILK"}
                },
                {
                    time: "24-09-18 16:09:20",
                    content: "Nhận nhiệm vụ 1 tại bảng thử thách",
                    value: {number: 10, type: "MOCHI"}
                },
                {
                    time: "24-09-18 16:09:20",
                    content: "Nhận nhiệm vụ 1 tại bảng thử thách",
                    value: {number: 15, type: "MOCHI"}
                },
                {
                    time: "24-09-18 16:09:20",
                    content: "Nhận nhiệm vụ 1 tại bảng thử thách",
                    value: {number: 20, type: "SILK"}
                },
                {
                    time: "24-09-18 16:09:20",
                    content: "Nhận nhiệm vụ 1 tại bảng thử thách",
                    value: {number: 5, type: "SILK"}
                },
                {
                    time: "24-09-18 16:09:20",
                    content: "Nhận nhiệm vụ 1 tại bảng thử thách",
                    value: {number: 10, type: "MOCHI"}
                },
                {
                    time: "24-09-18 16:09:20",
                    content: "Nhận nhiệm vụ 1 tại bảng thử thách",
                    value: {number: 15, type: "MOCHI"}
                },
                {
                    time: "24-09-18 16:09:20",
                    content: "Nhận nhiệm vụ 1 tại bảng thử thách",
                    value: {number: 20, type: "SILK"}
                },
            ]
        }
    },
    filters: {},
    created() {
    },
    watch: {},
    methods: {}
}

</script>
<style lang="scss" scoped>
.title {
    font-family: Phudu, serif;
    text-align: center;
    margin: 0 0 15px;
    font-size: 44px;
    color: #516677;
}

.custom_hr {
    background: linear-gradient(90deg, transparent, #516677, transparent);
    border: none;
    height: 1px;
    max-width: 150px;
}

.content_wrapper {
    height: 475px;
    overflow-y: auto;
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
    padding: 5px;
    border-radius: 10px;

    &::-webkit-scrollbar {
        width: 1em;
    }

    &::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
    }

    &::-webkit-scrollbar-thumb {
        background: linear-gradient(0deg, #7A5026, #E09246);
        border-radius: 10px;
    }

    .content {
        font-size: 22px;
        .el-col {
            padding: 5px;
            &.content {
                > div {
                    text-align: left;
                }
            }
            > div {
                text-align: center;
                background-color: #E8EFF5;
                border-radius: 5px;
                height: 50px;
                line-height: 36px;
                padding: 5px 15px;
                .number {
                    position: relative;
                    left: -20px;
                    color: #000;
                }
                .icon {
                    width: 45px;
                    height: 45px;
                    -o-object-fit: contain;
                    object-fit: contain;
                    position: absolute;
                    right: 7px;
                    top: 7px;
                }
            }
        }
    }
}
</style>
<template>
    <div>
        <h1 class="title">{{ "NHIỆM VỤ HÀNG NGÀY" }}</h1>
        <hr class="custom_hr">
        <div class="content_wrapper">
            <div class="content">
                <el-row
                    :class="{is_done: item.is_done === 1}"
                    v-for="(item, idx) in data.quests"
                    :key="idx"
                >
                    <el-col class="mochi" :span="2">
                        <img :src="iconMochi" alt="">
                        <div>x{{ item.mochi }}</div>
                    </el-col>
                    <el-col class="content" :span="17">

                        <!--COPY CODE + ENTER CODE-->
                        <div v-if="item.number === 2 || item.number === 3">
                            <el-row>
                                <el-col :span="12">
                                    <div class="content">{{ item.desc }}</div>
                                    <div class="progress">
                                        ({{ item.progress.current }}/{{ item.progress.max }})
                                    </div>
                                </el-col>
                                <el-col v-if="item.number === 2" :span="12">
                                    <el-row>
                                        <el-col :span="16">
                                            <el-input v-model="item.code" :disabled="true"></el-input>
                                        </el-col>
                                        <el-col :span="8">
                                            <el-button @click="copyCode(item.code)">Copy Code</el-button>
                                        </el-col>
                                    </el-row>
                                </el-col>
                                <el-col v-else :span="12">
                                    <el-row>
                                        <el-col :span="16">
                                            <el-input v-model="inviteCode"
                                                      placeholder="Nhập code thỏ ngọc"></el-input>
                                        </el-col>
                                        <el-col :span="8">
                                            <el-button @click="submitInviteCode" :loading="isLoading">Nhập Code
                                            </el-button>
                                        </el-col>
                                    </el-row>
                                </el-col>
                            </el-row>
                        </div>
                        <!--COPY CODE + ENTER CODE-->
                        <div v-else>
                            <div class="content">{{ item.desc }}</div>
                            <div class="progress">
                                ({{ item.progress.current }}/{{ item.progress.max }})
                            </div>
                        </div>
                    </el-col>
                    <el-col class="buttons" :span="5">
                        <el-button v-if="item.is_done === 1" class="btn_done">Xong nhiệm vụ</el-button>
                        <el-button v-else class="btn_receive"
                                   :type="item.progress.current === item.progress.max ? 'success': 'primary'"
                                   @click="getQuest(item, idx)">Nhận nhiệm vụ
                        </el-button>
                    </el-col>
                </el-row>
            </div>
        </div>
    </div>
</template>
<script>
import iconMochi from "@/assets/images/birthday12/map/dialog/icon_mochi.png";
import {ElMessage} from "element-plus";

export default {
    name: 'NguyetNhiemTab',
    components: {},
    data() {
        return {
            iconMochi: iconMochi,
            inviteCode: null,
            isLoading: false,
            data: {
                date: "18-9",
                quests: [
                    {
                        number: 1,
                        is_done: 1,
                        mochi: 5,
                        progress: {current: 1, max: 1},
                        desc: "Đăng ký đi chơi công viên"
                    },
                    {
                        number: 2,
                        is_done: 0,
                        mochi: 10,
                        progress: {current: 2, max: 10},
                        desc: "Rủ 10 thỏ ngọc khác cùng đi chơi",
                        code: "JAJDAX14" // generate every day = Crypt::encrypt/decrypt(user_id + current day)
                    },
                    {
                        number: 3,
                        is_done: 0,
                        mochi: 10,
                        progress: {current: 4, max: 10},
                        desc: "Được 10 thỏ ngọc khác rủ đi chơi"
                    },
                    {
                        number: 4,
                        is_done: 0,
                        mochi: 20,
                        progress: {current: 5, max: 5},
                        desc: "Tham gia trò chơi Vòng Xoay Mặt Trời 5 lần/ngày"
                    },
                    {
                        number: 5,
                        is_done: 0,
                        mochi: 5,
                        progress: {current: 0, max: 1},
                        desc: "Lần đầu nhận được Kim Tơ trong ngày "
                    },
                    {
                        number: 6,
                        is_done: 0,
                        mochi: 15,
                        progress: {current: 10, max: 15},
                        desc: "Thu thập được 15 Kim Tơ/ngày"
                    },
                    {
                        number: 7,
                        is_done: 0,
                        mochi: 15,
                        progress: {current: 10, max: 50},
                        desc: "Thu thập được 50 Kim Tơ/ngày"
                    },
                    {
                        number: 8,
                        is_done: 0,
                        mochi: 10,
                        progress: {current: 0, max: 1},
                        desc: "Ghi được 1500 điểm trong một lượt chơi tại Vòng Xoay Mặt Trời"
                    },
                    {
                        number: 9,
                        is_done: 0,
                        mochi: 5,
                        progress: {current: 0, max: 1},
                        desc: "Ghé thăm Thố Động mỗi ngày"
                    },
                    {
                        number: 10,
                        is_done: 0,
                        mochi: 15,
                        progress: {current: 0, max: 1},
                        desc: "Hoàn thành các nhiệm vụ trên mỗi ngày"
                    },
                ]
            }
        }
    },
    filters: {},
    created() {
    },
    watch: {},
    methods: {
        getQuest(quest, idx) {
            if (quest.progress.current === quest.progress.max) {
                this.data.quests[idx].is_done = 1;
                ElMessage.success("Hoàn thành nhiệm vụ!");
            } else {
                ElMessage.warning(
                    `(${quest.progress.current}/${quest.progress.max}) Hãy tiếp tục nhiệm vụ!`
                );
            }
        },
        copyCode(code) {
            navigator.clipboard.writeText(code)
                .then(() => {
                    ElMessage.success(`Code ${code} đã được sao chép!`);
                })
                .catch(err => {
                    console.error('Có lỗi xảy ra khi sao chép:', err);
                });
        },
        submitInviteCode() {
            if (!this.inviteCode) {
                ElMessage.warning(`Vui lòng nhập Code!`);
            } else {
                this.isLoading = true;
                // call api invite code

                setTimeout(() => {
                    const result = 1; // 0 = code fail, 1 = success, 2 = max code
                    if (result === 1) {
                        // success
                        ElMessage.success(`Nhập code ${this.inviteCode} thành công!`);
                    } else if (result === 2) {
                        ElMessage.warning(`Bạn đã nhập đủ số lượng, nhiệm vụ hoàn thành!`);
                    } else {
                        ElMessage.error(`Code ${this.inviteCode} không hợp lệ!`);
                    }
                    this.isLoading = false;
                }, 1000);
            }
        }
    }
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
    border-radius: 10px;
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
        font-size: 18px;

        > .el-row {
            height: 80px;
            margin: 15px 5px;
            background-color: #E8EFF5;
            border-radius: 5px;
            overflow: hidden;

            &.is_done {
                filter: grayscale(1);
            }
        }

        .el-col {
            &.mochi {
                text-align: center;
                background-color: #A3CBEE;

                img {
                    width: 80px;
                    height: 80px;
                    object-fit: contain;
                    position: relative;
                    bottom: 10px;
                }

                > div {
                    position: relative;
                    bottom: 30px;
                }
            }

            &.content {
                padding: 20px;
            }

            &.buttons {
                padding: 20px;
                text-align: center;
            }
        }
    }
}

:deep(.el-input),
:deep(.el-button) {
    font-size: 18px;
    height: 40px;
}

:deep(.el-input) {
    .el-input__wrapper {
        padding: 5px 15px;
        border-radius: 7px;
    }
}

:deep(.el-button) {
    border-radius: 7px;
    position: relative;
    right: 10px;
    background-color: #F0D14E;

    &.btn_done {
        cursor: default;
        right: 0;
        width: 100%;
    }

    &.btn_receive {
        background-color: #A3CBEE;
        right: 0;
        width: 100%;
        &.el-button--success {
            background-color: #95d475;
        }
    }
}
</style>
<template>
    <div>
        <h1 class="title">{{ "NHIỆM VỤ" }}</h1>
        <div class="content_wrapper">
            <div class="content">
                <el-row
                    :class="{is_done: item.is_done === 1 && item.is_received === 1}"
                    v-for="(item, idx) in quests"
                    :key="idx"
                >
                    <el-col class="mochi" :span="2">
                        <img :src="iconMochi" alt="">
                        <div>x{{ item.mochi }}</div>
                    </el-col>
                    <el-col class="content" :span="17">

                        <!--COPY CODE + ENTER CODE-->
                        <div v-if="item.id === 2 || item.id === 3">
                            <el-row>
                                <el-col :span="12">
                                    <div class="content" v-html="item.desc"></div>
                                    <div class="progress">
                                        ({{ item.progress.current }}/{{ item.progress.max }})
                                    </div>
                                </el-col>
                                <el-col v-if="item.id === 2" :span="12">
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
                                            <el-input
                                                v-model="inviteCode"
                                                placeholder="Nhập code thỏ ngọc"
                                                :disabled="item.is_done === 1"
                                            ></el-input>
                                        </el-col>
                                        <el-col :span="8">
                                            <el-button
                                                @click="submitInviteCode"
                                                :loading="isLoading"
                                                :disabled="item.is_done === 1"
                                            >Paste Code
                                            </el-button>
                                        </el-col>
                                    </el-row>
                                </el-col>
                            </el-row>
                        </div>
                        <!--COPY CODE + ENTER CODE-->
                        <div v-else>
                            <div class="content" v-html="item.desc"></div>
                            <div class="progress">
                                ({{ item.progress.current }}/{{ item.progress.max }})
                            </div>
                        </div>
                    </el-col>
                    <el-col class="buttons" :span="5">
                        <el-button v-if="item.is_received === 1" class="btn_done">Xong</el-button>
                        <el-button v-else class="btn_receive"
                                   :type="item.progress.current === item.progress.max ? 'success': 'primary'"
                                   @click="getQuest(item, idx)">Nhận
                        </el-button>
                    </el-col>
                </el-row>
            </div>
        </div>
    </div>
</template>
<script>
import iconMochi from "@/assets/images/eventBirthday2024/img_mochi_nguyet_nhiem.svg";
import {ElMessage} from "element-plus";
import {mapGetters} from "vuex";
import RepositoryFactory from '@frontend/utils/RepositoryFactory';
const questsRepository = RepositoryFactory.get('quests');

export default {
    name: 'NguyetNhiemTab',
    components: {},
    data() {
        return {
            iconMochi: iconMochi,
            inviteCode: null,
            isLoading: false,
            quests: []
        }
    },
    filters: {},
    created() {
        this.quests = this.user.quests;
    },
    mounted() {
        this.quests = this.user.quests;
    },
    watch: {},
    computed: {
        ...mapGetters(["user"]),
    },
    methods: {
        async getQuest(quest, idx) {
            if (quest.progress.current === quest.progress.max) {
                const { data } = await questsRepository.receiveReward(quest.id);
                if (data.success) {
                    this.quests[idx].is_received = 1;
                    ElMessage.success("Hoàn thành nhiệm vụ!");
                }
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
        async submitInviteCode() {
            if (!this.inviteCode) {
                ElMessage.warning(`Vui lòng nhập Code!`);
            } else {
                this.isLoading = true;
                const { data } = await questsRepository.handleInviteCode(this.inviteCode);
                if (data.success) {
                    this.inviteCode = null;
                    await this.$store.dispatch("user/getInfo").then(() => {
                        this.quests = this.user.quests;
                    });
                    ElMessage.success(data.message);
                    this.isLoading = false;
                } else {
                    ElMessage.warning(data.message);
                    this.isLoading = false;
                }
            }
        }
    }
}

</script>
<style lang="scss" scoped>
.title {
    font-family: Beaufort, serif;
    text-align: center;
    padding: 10px 0;
    margin: 5px 0 10px;
    font-size: 30px;
    color: #28657D;
    background-image: url('../../../../../../assets/images/eventBirthday2024/bg_title_nguyet_nhiem.svg');
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
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
        background: #60A8AC;
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
                max-width: 80px;

                img {
                    width: 85px;
                    height: 80px;
                    position: relative;
                    object-fit: none;
                }

                > div {
                    position: relative;
                    bottom: 25px;
                    color: #fff;
                    text-align: right;
                    right: 5px;
                    text-shadow: 0 0 5px #000;
                }
            }

            &.content {
                padding: 15px 20px 20px;
                .content,
                .progress {
                    font-weight: bold;
                    font-size: 22px;
                }
            }

            &.buttons {
                padding: 15px 20px 20px;
                text-align: center;
                > button {
                    background-image: url('../../../../../../assets/images/eventBirthday2024/button_done.svg');
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: cover;
                    height: 50px;
                    color: #fff;
                    transition: all .3s ease-in-out;
                    border: none;

                    &:hover {
                        filter: brightness(1.2);
                    }
                    &.el-button--success {
                        filter: brightness(1) hue-rotate(290deg);
                        transition: all .3s ease-in-out;
                        &:hover {
                            filter: brightness(1.2) hue-rotate(290deg);
                        }
                    }
                }
            }
        }
    }
}

:deep(.el-input),
:deep(.el-button) {
    font-size: 18px;
    height: 50px;
}

:deep(.el-input) {
    .el-input__wrapper {
        padding: 5px 15px;
        border-radius: 7px;
        box-shadow: none;
    }
}

:deep(.el-button) {
    border-radius: 7px;
    position: relative;
    right: 10px;
    background-color: #F2D281;
    border: none;
    font-weight: bold;
    width: 100px;

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
<template>
    <div>
        <h1 class="title">{{ "LỊCH SỬ HOẠT ĐỘNG" }}</h1>
        <div class="content_wrapper">
            <div class="content">
                <el-row v-for="(item, idx) in logs" :key="idx">
                    <el-col class="time" :span="6">
                        <div>{{ item.time }}</div>
                    </el-col>
                    <el-col class="content" :span="16">
                        <div :title="item.content.replace(/<[^>]*>/g, '')" v-html="item.content"></div>
                    </el-col>
                    <el-col class="value" :span="2">
                        <div>
                            <span class="number">{{ item.value.number }}</span>
                            <img v-if="item.value.type === 'SILK'" class="icon" :class="item.value.type" :src="iconSilk" alt="">
                            <img v-else :src="iconMochi" class="icon" :class="item.value.type" alt="">
                        </div>
                    </el-col>
                </el-row>
            </div>
        </div>
    </div>
</template>
<script>
import iconSilk from "@/assets/images/eventBirthday2024/icon_kimto_2.svg";
import iconMochi from "@/assets/images/eventBirthday2024/icon_mochi_2.svg";

import RepositoryFactory from '@frontend/utils/RepositoryFactory';
const game2048Repository = RepositoryFactory.get('game2048');
export default {
    name: 'NguyetKyTab',
    components: {},
    data() {
        return {
            iconSilk: iconSilk,
            iconMochi: iconMochi,
            logs: []
        }
    },
    filters: {},
    created() {
        this.fetch();
    },
    watch: {},
    methods: {
        async fetch() {
            const { data } = await game2048Repository.getLogs();
            console.log(data);
            if (data.success) {
                this.logs = data.logs;
            }
        },
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
    background-image: url('../../../../../../assets/images/eventBirthday2024/bg_title_nguyet_ky.svg');
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
    color: #4E4E4E;

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
        font-size: 22px;
        .el-col {
            padding: 5px;
            &.content {
                > div {
                    cursor: pointer;
                    text-align: left;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
            }
            > div {
                text-align: center;
                background-color: #DDEBF0;
                border-radius: 5px;
                height: 50px;
                line-height: 42px;
                padding: 5px 15px;
                .number {
                    position: relative;
                    left: -20px;
                    color: #000;
                }
                .icon {
                    -o-object-fit: contain;
                    object-fit: contain;
                    position: absolute;
                    &.SILK {
                        width: 40px;
                        height: 40px;
                        right: 7px;
                        top: 11px;
                    }
                    &.MOCHI {
                        width: 45px;
                        height: 45px;
                        right: 3px;
                        top: 1px;
                    }
                }
            }
        }
    }
}
</style>
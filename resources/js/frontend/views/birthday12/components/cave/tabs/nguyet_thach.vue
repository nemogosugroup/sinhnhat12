<template>
    <div>
        <h1 class="title">{{ "BẢNG XẾP HẠNG" }}</h1>
        <hr class="custom_hr">
        <div class="content_wrapper">
            <div class="content">
                <div id="myTable">
                    <div class="header">
                        <el-row class="search">
                            <el-col :span="8" :offset="16">
                                <el-input class="search_input" @keyup="searchPlayer" v-model="searchValue"
                                          placeholder="Tìm người chơi"></el-input>
                                <i class="ri-search-line search_icon"></i>
                            </el-col>
                        </el-row>
                        <el-row class="thead">
                            <el-col :span="3">RANK</el-col>
                            <el-col :span="3">AVATAR</el-col>
                            <el-col :span="7">NGƯỜI CHƠI</el-col>
                            <el-col :span="7">ĐIỂM 2048</el-col>
                            <el-col :span="4">KIM TƠ</el-col>
                        </el-row>
                    </div>
                    <div class="tbody_wrapper">
                        <el-row class="table_row rank_wrapper" :class="`rank_${idx+1}`" v-for="(item, idx) in ranks"
                                :key="idx">
                            <el-col class="rank" :span="3">
                                <img v-if="idx === 0" class="top_1" :src="MedalTop1" alt="">
                                <img v-else-if="idx === 1" class="top_2" :src="MedalTop2" alt="">
                                <img v-else-if="idx === 2" class="top_3" :src="MedalTop3" alt="">
                                <div v-else class="top_n">
                                    <img :src="MedalTopN" alt="">
                                    <span>{{ idx + 1 }}</span>
                                </div>
                            </el-col>
                            <el-col class="avatar" :span="3">
                                <span>
                                    <img :src="item.avatar" alt="" width="50" height="50">
                                </span>
                            </el-col>
                            <el-col class="name" :span="7">{{ item.name }}</el-col>
                            <el-col class="point" :span="7">{{ item.points }}</el-col>
                            <el-col class="silk" :span="4">
                                <div>{{ item.silks }}</div>
                                <img :src="iconSilk" alt="" width="50" height="50">
                            </el-col>
                        </el-row>
                    </div>
                    <div v-if="isSearching" class="search_result">
                        <el-row v-if="Object.keys(this.searchData).length > 0" class="table_row rank_wrapper"
                                :class="`rank_${searchData.idx+1}`">
                            <el-col class="rank" :span="3">
                                <img v-if="searchData.idx === 0" class="top_1" :src="MedalTop1" alt="">
                                <img v-else-if="searchData.idx === 1" class="top_2" :src="MedalTop2" alt="">
                                <img v-else-if="searchData.idx === 2" class="top_3" :src="MedalTop3" alt="">
                                <div v-else class="top_n">
                                    <img :src="MedalTopN" alt="">
                                    <span>{{ searchData.idx + 1 }}</span>
                                </div>
                            </el-col>
                            <el-col class="avatar" :span="3">
                                <span>
                                    <img :src="searchData.avatar" alt="" width="50" height="50">
                                </span>
                            </el-col>
                            <el-col class="name" :span="7">{{ searchData.name }}</el-col>
                            <el-col class="point" :span="7">{{ searchData.points }}</el-col>
                            <el-col class="silk" :span="4">
                                <div>{{ searchData.silks }}</div>
                                <img :src="iconSilk" alt="" width="50" height="50">
                            </el-col>
                        </el-row>
                        <div v-else class="not_found text-center">
                            <b><i>... Không tìm thấy kết quả phù hợp ...</i></b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import avatar1 from "@/assets/images/birthday12/map/dialog/ranks/avatar_1.png";
import avatar2 from "@/assets/images/birthday12/map/dialog/ranks/avatar_2.png";
import MedalTop1 from "@/assets/images/birthday12/map/dialog/ranks/medal_top1.png";
import MedalTop2 from "@/assets/images/birthday12/map/dialog/ranks/medal_top2.png";
import MedalTop3 from "@/assets/images/birthday12/map/dialog/ranks/medal_top3.png";
import MedalTopN from "@/assets/images/birthday12/map/dialog/ranks/medal_top_n.png";
import iconSilk from "@/assets/images/birthday12/map/dialog/icon_silk.png";

import RepositoryFactory from '@frontend/utils/RepositoryFactory';
const game2048Repository = RepositoryFactory.get('game2048');

export default {
    name: 'NguyetThachTab',
    components: {},
    data() {
        return {
            avatar1: avatar1,
            avatar2: avatar2,
            iconSilk: iconSilk,
            MedalTop1: MedalTop1,
            MedalTop2: MedalTop2,
            MedalTop3: MedalTop3,
            MedalTopN: MedalTopN,
            searchValue: null,
            isSearching: false,
            searchData: {},
            ranks: []
        }
    },
    filters: {},
    created() {
        this.fetch();
    },
    mounted() {

    },
    watch: {},
    methods: {
        async fetch() {
            const { data } = await game2048Repository.getRanks();
            console.log(data);
            if (data.success) {
                this.ranks = data.ranks;
            }
        },
        searchPlayer() {
            this.searchData = {};
            this.isSearching = this.searchValue;
            if (this.isSearching) {
                this.ranks.forEach((rank, idx) => {
                    if (rank.name.toLowerCase().includes(this.searchValue.toLowerCase())) {
                        this.searchData = rank;
                        this.searchData.idx = idx;
                    }
                });
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
        #myTable {
            width: 100%;
            height: 100%;
            padding: 10px 5px;
            position: relative;

            .header {
                position: sticky;
                width: 100%;
                top: 0;
                z-index: 9;
                background: #fff;
                padding: 1px 0;

                .search {
                    margin: 5px 0 2.5px;

                    .search_input {
                        font-size: 20px;
                        height: 40px;

                        :deep(.el-input__wrapper) {
                            padding: 5px 55px 5px 10px;
                        }
                    }

                    .search_icon {
                        position: absolute;
                        right: 15px;
                        top: 7px;
                        font-size: 24px;

                        &:after {
                            content: "";
                            display: block;
                            width: 1px;
                            height: 24px;
                            background-color: #000;
                            position: absolute;
                            right: 35px;
                            top: 1px;
                        }
                    }
                }

                .thead {
                    margin: 15px 0;
                    padding: 10px;
                    background-color: #ECF5FC;
                    border-radius: 5px;

                    > .el-col {
                        text-align: center;
                        font-size: 20px;
                    }
                }
            }

            .tbody_wrapper,
            .search_result {
                .table_row {
                    &.rank_wrapper {
                        height: 80px;
                        overflow: hidden;
                        padding: 10px;
                        margin: 10px 0;
                        border-radius: 10px;
                        background-color: #ECF5FC;

                        &:first-child {
                            margin-top: 0;
                        }

                        &:last-child {
                            margin-bottom: 0;
                        }

                        .rank {
                            position: relative;
                            top: 3px;
                        }

                        &.rank_1 {
                            background-color: #FFF4DA;
                        }

                        &.rank_2 {
                            background-color: #E2EBEF;
                        }

                        &.rank_3 {
                            background-color: #FFF0DF;
                        }

                        &:not(.rank_1,.rank_2,.rank_3) {
                            .rank {
                                top: -3px;

                                .top_n {
                                    position: relative;

                                    > span {
                                        position: absolute;
                                        top: 50%;
                                        left: 50%;
                                        transform: translate(-45%, -70%);
                                        font-weight: bold;
                                        font-size: 21px;
                                    }
                                }
                            }
                        }

                        .avatar {
                            span {
                                position: relative;
                                display: inline-flex;
                                top: 6px;

                                img {
                                    border-radius: 50%;
                                    position: relative;
                                    z-index: 3;
                                    object-fit: cover;
                                }

                                &:before {
                                    content: "";
                                    width: 56px;
                                    height: 56px;
                                    display: block;
                                    position: absolute;
                                    top: -3px;
                                    left: -3px;
                                    z-index: 2;
                                    border-radius: 50%;
                                    background: linear-gradient(45deg, #7A5026, #E09246);
                                }
                            }
                        }

                        .silk {
                            padding-right: 20px;

                            img {
                                position: absolute;
                                top: 15px;
                                right: 32px;
                            }
                        }
                    }

                    > .el-col {
                        text-align: center;
                        font-size: 20px;
                        line-height: 60px;
                    }
                }
            }

            .search_result {
                position: sticky;
                width: 100%;
                bottom: 0;
                z-index: 9;
                background: #fff;
                padding: 0;
                box-shadow: 0 0 5px #000;
                border-radius: 10px;
                margin-top: 15px;

                .not_found {
                    padding: 20px;
                    font-size: 16px;
                }
            }
        }
    }
}
</style>
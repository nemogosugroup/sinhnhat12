<template>
    <div>
        <h1 class="title">{{ "BẢNG XẾP HẠNG" }}</h1>
        <el-row class="search">
            <el-col :span="24">
                <el-input class="search_input" @keyup="searchPlayer" v-model="searchValue"
                          placeholder="Tìm nhân viên..."></el-input>
                <i class="ri-search-line search_icon"></i>
            </el-col>
        </el-row>
        <div class="content_wrapper">
            <div class="content">
                <div id="myTable">
                    <div class="header">
                        <el-row class="thead">
                            <el-col :span="3">Hạng</el-col>
                            <el-col :span="3">AVATAR</el-col>
                            <el-col :span="7">Người chơi</el-col>
                            <el-col :span="7">Điểm 2048</el-col>
                            <el-col :span="4">Kim tơ</el-col>
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
                </div>
            </div>
        </div>
        <div class="search_result" :class="{searching: isSearching}">
            <el-row v-if="searchData !== null" class="table_row rank_wrapper"
                    :class="`rank_${searchData.idx+1}`">
                <el-col class="rank" :span="3">
                    <img v-if="searchData.idx === 0" class="top_1" :src="MedalTop1" alt="">
                    <img v-else-if="searchData.idx === 1" class="top_2" :src="MedalTop2" alt="">
                    <img v-else-if="searchData.idx === 2" class="top_3" :src="MedalTop3" alt="">
                    <div v-else class="top_n">
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
</template>
<script>
import MedalTop1 from "@/assets/images/eventBirthday2024/icon_top1.svg";
import MedalTop2 from "@/assets/images/eventBirthday2024/icon_top2.svg";
import MedalTop3 from "@/assets/images/eventBirthday2024/icon_top3.svg";
import iconSilk from "@/assets/images/eventBirthday2024/icon_kimto_2.svg";

import RepositoryFactory from '@frontend/utils/RepositoryFactory';
import {mapGetters} from "vuex";

const game2048Repository = RepositoryFactory.get('game2048');

export default {
    name: 'NguyetThachTab',
    components: {},
    data() {
        return {
            iconSilk: iconSilk,
            MedalTop1: MedalTop1,
            MedalTop2: MedalTop2,
            MedalTop3: MedalTop3,
            searchValue: null,
            isSearching: false,
            searchData: null,
            ranks: [],
            selfRank: null
        }
    },
    filters: {},
    created() {
        this.fetch();
    },
    mounted() {

    },
    computed: {
        ...mapGetters(["user"]),
    },
    watch: {},
    methods: {
        async fetch() {
            const {data} = await game2048Repository.getRanks();
            if (data.success) {
                this.ranks = data.ranks;
                this.ranks.forEach((rank, idx) => {
                    if (rank.user_id === this.user.id) {
                        this.selfRank = rank;
                        this.selfRank.idx = idx;
                    }
                });
                this.searchData = this.selfRank;
            }
        },
        searchPlayer() {
            this.searchData = null;
            this.isSearching = this.searchValue;
            if (this.isSearching) {
                this.ranks.forEach((rank, idx) => {
                    if (rank.name.toLowerCase().includes(this.searchValue.toLowerCase())) {
                        this.searchData = rank;
                        this.searchData.idx = idx;
                    }
                });
            } else {
                this.searchData = this.selfRank;
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
    background-image: url('../../../../../../assets/images/eventBirthday2024/bg_title_nguyet_thach.svg');
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
}

.search {
    margin: 5px 0 2.5px;
    position: absolute;
    top: 15px;
    right: 70px;
    width: 250px;

    .search_input {
        font-size: 20px;
        height: 40px;

        :deep(.el-input__wrapper) {
            padding: 5px 25px 5px 0;
            box-shadow: none;
            background: transparent;
            border-bottom: 2px solid #B4CBD4;
            border-radius: 0;

            > input {
                font-style: italic;
            }
        }
    }

    .search_icon {
        position: absolute;
        right: 0;
        top: 7px;
        font-size: 24px;
        font-weight: bold;
        color: #3aabad;
    }
}

.search_result {
    position: relative;
    padding-top: 19px;
    margin-top: 20px;
    border-top: 1px solid #CBCBCB;

    .not_found {
        margin-top: 20px;
        font-size: 20px;
    }

    &.searching {
        &:before {
            content: "Kết quả tìm kiếm";
            width: 125px;
        }
    }

    &:before {
        content: "Hạng của bạn";
        color: #4E4E4E;
        font-size: 18px;
        width: 105px;
        height: 25px;
        display: block;
        position: absolute;
        top: -17px;
        left: 0;
        padding: 5px;
        background: #fff;
        font-weight: bold;
    }

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
                top: -8px;
                left: 8px;
            }

            &.rank_1 {
                background-color: #FFF4DA;
            }

            &:not(.rank_1) {
                .rank {
                    top: -8px;

                    .top_n {
                        position: relative;

                        > span {
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-75%, 10%);
                            font-weight: bold;
                            font-size: 24px;
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
                        background: #fff;
                    }
                }
            }

            .silk {
                padding-right: 20px;

                img {
                    position: absolute;
                    top: 17px;
                    right: 30px;
                    object-fit: none;
                }
            }
        }

        > .el-col {
            text-align: center;
            font-size: 20px;
            line-height: 65px;
        }
    }
}

.content_wrapper {
    height: 360px;
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
        #myTable {
            width: 100%;
            height: 100%;
            padding: 10px 5px;
            position: relative;
            color: #4E4E4E;

            .header {
                position: sticky;
                width: 100%;
                top: 0;
                z-index: 9;
                background: #f3f9fb;
                padding: 1px 0;

                .thead {
                    margin: 7px 0;
                    padding: 10px;
                    background-color: #ECF5FC;
                    border-radius: 5px;

                    > .el-col {
                        text-align: center;
                        font-size: 22px;
                        font-weight: bold;
                    }
                }
            }

            .tbody_wrapper {
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
                            top: -8px;
                            left: 8px;
                        }

                        &.rank_1 {
                            background-color: #FFF4DA;
                        }

                        &:not(.rank_1) {
                            .rank {
                                top: -8px;

                                .top_n {
                                    position: relative;

                                    > span {
                                        position: absolute;
                                        top: 50%;
                                        left: 50%;
                                        width: 50px;
                                        transform: translate(-75%, 10%);
                                        font-weight: bold;
                                        font-size: 24px;
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
                                    background: #fff;
                                }
                            }
                        }

                        .silk {
                            padding-right: 20px;

                            img {
                                position: absolute;
                                top: 17px;
                                right: 30px;
                                object-fit: none;
                            }
                        }
                    }

                    > .el-col {
                        text-align: center;
                        font-size: 20px;
                        line-height: 65px;
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
<template>
    <div :class="`wrap-moonwalk ${isActiveSlider ? 'active' : ''}`">
        <div class="wrap-moonwalk__content">
            <el-row justify="center">
                <el-col :span="24">
                    <swiper :slidesPerView="1" :cssMode="true" :navigation="true" :pagination="true" :mousewheel="true"
                        :keyboard="true" :modules="modules" :spaceBetween="0" class="mySwiper" @swiper="onSwiper"
                        @slideChange="onSlideChange">
                        <swiper-slide>
                            <div class="wrap-timeline">
                                <el-row>
                                    <el-col :span="4">
                                        <div class="images">
                                            <el-image :src="imgElm.moonWalk" />
                                        </div>
                                        <div class="back_button">
                                            <RouterLink to="/" class="back bg_border font_beaufort">Home
                                            </RouterLink>
                                        </div>
                                    </el-col>
                                    <el-col :span="20">
                                        <div class="content_timeline">

                                            <el-row>
                                                <el-col :span="4">
                                                    <span class="year font_beaufort w600 size68">{{
                                                        showDataTimeLine.year }}</span>
                                                    <el-scrollbar ref="scrollbarRef" height="300px" always>
                                                        <div class='content font_myriad_con'>
                                                            <ul>
                                                                <li v-for="item in showDataTimeLine.content"
                                                                    :key="item.date">
                                                                    <span class="font_beaufort w600">{{ item.date + ' :'
                                                                        }}</span>
                                                                    <span class="font_myriad_con">{{ item.content
                                                                        }}</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </el-scrollbar>
                                                </el-col>
                                                <el-col :span="20">
                                                    <div class="list_images" v-if="listImages">
                                                        <lightgallery :key="indexActive"
                                                            :settings="{ speed: 500, plugins: plugins }"
                                                            @lgInit="onInit" @lgBeforeSlide="onBeforeSlide">
                                                            <template v-if="listImages.length < 2">
                                                                <a class="el-image" v-for="(image, index) in listImages"
                                                                    :key="index" :href="image.href"
                                                                    :class="`itemImages ${index > 3 ? 'hide' : ''}`">
                                                                    <img class="el-image__inner" :src="image.url"
                                                                        :alt="image.alt">
                                                                    <div class="countImages"
                                                                        v-if="index == 3 && (countImages - 4) > 0">
                                                                        <span class="font_beaufort w700">{{ '+' +
                                                                            (countImages - 4) }}</span>
                                                                    </div>
                                                                </a>
                                                            </template>
                                                            <template v-else>
                                                                <a class="el-image" v-for="(image, index) in listImages"
                                                                    :key="index" :href="image.href"
                                                                    :class="`itemImages ${index > 3 ? 'hide' : ''}`">
                                                                    <img class="el-image__inner" :src="image.url"
                                                                        :alt="image.alt">
                                                                    <div class="countImages"
                                                                        v-if="index == 3 && (countImages - 4) > 0">
                                                                        <span class="font_beaufort w700">{{ '+' +
                                                                            (countImages - 4) }}</span>
                                                                    </div>
                                                                </a>
                                                            </template>
                                                        </lightgallery>
                                                    </div>
                                                </el-col>
                                            </el-row>
                                        </div>
                                    </el-col>
                                </el-row>
                                <div class="list-timeline">
                                    <div class="bg_border total_silk">
                                        <div class="content_total">
                                            <span class="icon"></span>
                                            <div class="title_total">
                                                <span class="font_myriad_con">Tổng kim tơ</span>
                                                <span>{{ user.total_silk }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="lists">
                                        <li class="item_list" v-for="item in listTimeLine" :key="item.index">
                                            <span :class="`icon_timeline ${indexActive == item.index ? 'active' : ''}`"
                                                @click="handleActiveTimeline(item)"></span>
                                            <div class="item__year">
                                                <span class="year font_myriad_con w700">{{ item.year }}</span>
                                                <p>
                                                    <span>{{ item.mileStoneSilk }}</span>
                                                    <span>{{ nameSilk }}</span>
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </swiper-slide>
                        <swiper-slide>
                            <div class="wrap_tree">
                                <div class="container-true">
                                    <div class="wrap_nguyetdat_search">
                                        <div class="title_nguyetda">
                                            <div class="tree_title"><img :src="imgElm.nguyetDattitle" alt=""></div>

                                            <div class="wrap-search">
                                                <search-employee ref="searchEmployee"></search-employee>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="trunk">
                                        <div class="trunk_tree">
                                            <img :src="imgElm.nguyetDa" alt="">
                                        </div>
                                        <div class="branches">
                                            <div v-for="(item, key) in listDepartMent" :key="key"
                                                :class="`font_myriad_con leaf leaf_${key}`"
                                                @click="handleShowEmployee(item.data)">
                                                <div class="info">
                                                    <span>{{ item.name }}</span>
                                                    <span class="w700">{{ item.data }}</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper>
                </el-col>
            </el-row>
        </div>
        <vue-easy-lightbox :visible="visible" :imgs="listImagesLightBox" :index="index" @hide="visible = false" />
    </div>
</template>

<script>
import treeImg from "@/assets/images/sinhnhat/tree.png";
import moonWalk from "@/assets/images/eventBirthday2024/icon_moonwalk_title.png";
import nguyetDattitle from "@/assets/images/eventBirthday2024/icon_nguyet_da_title.png";
import Arrow from "@/assets/images/eventBirthday2024/icon_muiten.svg";
import moon from "@/assets/images/eventBirthday2024/icon_moon.png";
import bannerTimeline from "@/assets/images/eventBirthday2024/banner-wweb.png";
import nguyetDa from "@/assets/images/eventBirthday2024/nguyet_da.png";
import SearchEmployee from "@frontend/components/SearchEmployee";
import { dataTimeline, dataDepartMent } from './timeline';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import { mapGetters } from "vuex";
import { Navigation } from 'swiper/modules';
import 'swiper/css/navigation';
import Lightgallery from 'lightgallery/vue';
import lgThumbnail from 'lightgallery/plugins/thumbnail';
import lgZoom from 'lightgallery/plugins/zoom';
export default {
    components: { Swiper, SwiperSlide, SearchEmployee, Lightgallery },
    data() {
        return {
            plugins: [lgThumbnail, lgZoom],
            listTimeLine: false,
            listDepartMent: false,
            tree: treeImg,
            treeWidth: 475,
            treeHeight: 410,
            indexSlider: 4,
            nameEmployee: null,
            indexActive: 0,
            isActiveSlider: false,
            nameSilk: 'Kim tơ',
            showDataTimeLine: [],
            listImagesLightBox: [],
            imgElm: {
                moonWalk: moonWalk,
                nguyetDattitle: nguyetDattitle,
                moon: moon,
                arrow: Arrow,
                bannerTimeline: bannerTimeline,
                nguyetDa: nguyetDa,
            },
            visible: false,
            index: 0,
            countImages: 0,
            listImages: []
        }
    },
    setup() {
        return {
            modules: [Navigation],
        };
    },
    computed: {
        ...mapGetters(["user"]),
    },
    created() {
        this.listTimeLine = dataTimeline().map((item, index) => {
            item['index'] = index;
            item['isLast'] = false;
            item['isShow'] = false;
            item['showTimeline'] = this.user.total_silk >= item.mileStoneSilk ? true : false;
            return item;
        });
        this.showDataTimeLine = this.listTimeLine[0];
        this.indexActive = this.showDataTimeLine.index;
        this.countImages = this.showDataTimeLine.listImages.length;
        this.listImages = this.showDataTimeLine.listImages.map((item, index) => {
            item['href'] = item.url;
            item['src'] = item.url;
            return item;
        });
        this.listImagesLightBox = this.showDataTimeLine.listImages.map((item) => item);
        this.listDepartMent = dataDepartMent().map((item, index) => {
            return item;
        });
        this.listDepartMent = this.listDepartMent.slice().sort(() => Math.random() - 0.5);
    },
    mounted() {
    },
    methods: {
        onInit() {
            console.log('lightGallery has been initialized');
        },
        onBeforeSlide() {
            console.log('calling before slide');
        },
        openLightbox(index) {
            this.index = index;
            this.visible = true;
        },
        handleActiveTimeline(item) {
            if (item.showTimeline) {
                this.showDataTimeLine = this.listTimeLine[item.index];
                this.countImages = this.showDataTimeLine.listImages.length;
                this.listImagesLightBox = this.showDataTimeLine.listImages.map((item) => item.url);
                this.listImages = this.showDataTimeLine.listImages.map((item, index) => {
                    item['src'] = item.url;
                    item['href'] = item.url
                    return item;
                });
                this.indexActive = this.showDataTimeLine.index;
                this.onInit();
                this.onBeforeSlide();
            } else {
                this.$message({
                    message: 'Chưa thể mở được mốc năm ' + item.year,
                    type: 'error',
                })
            }
        },
        onSwiper(swiper) {
            if (swiper.activeIndex == 1) {
                this.isActiveSlider = true
            } else {
                this.isActiveSlider = false
            }
        },
        onSlideChange(swiper) {
            if (swiper.activeIndex == 1) {
                this.isActiveSlider = true
            } else {
                this.isActiveSlider = false
            }
        },
        handleCheckShowContent(number) {
            this.listTimeLine = this.listTimeLine.map((item, index) => {
                item['isLast'] = index == number ? true : false;
                item['isShow'] = index == number || index == (number - 1) ? true : false;
                return item;
            });
        },
        handleShowEmployee(dept) {
            this.nameEmployee = dept;
            this.emitter.emit("search-dept", dept);
            this.$refs.searchEmployee.focusSelect();
        },
        updateNameEmployee(newName) {
            this.nameEmployee = newName;
        }
    }
}
</script>
<style lang="scss" scoped>
@import 'lightgallery/css/lightgallery.css';
@import 'lightgallery/css/lg-thumbnail.css';
@import 'lightgallery/css/lg-zoom.css';

.wrap-moonwalk {
    padding: 100px 40px 80px;
    background-image: url('../../../assets/images/eventBirthday2024/bg_moonwalk.jpg');
    background-position: left top;
    background-repeat: no-repeat;
    height: 100vh;

    &.active {
        background-position: right calc(100% + 50px);
    }

    .bg_border {
        background-image: url('../../../assets/images/eventBirthday2024/bg_border.png');
        width: 190px;
        height: 58px;
        display: flex;
        align-items: center;
        font-size: 28px;
        justify-content: center;
    }

    .back {
        background-image: url('../../../assets/images/eventBirthday2024/bg_border.png');
        width: 190px;
        height: 58px;
        display: flex;
        align-items: center;
        font-size: 28px;
        justify-content: center;
        color: #f9e3bb;
        margin-top: 25px;

        &:before {
            content: '';
            background-image: url('../../../assets/images/eventBirthday2024/icon_muiten.svg');
            width: 50px;
            height: 50px;
            display: flex;
            background-size: 100%;
            background-repeat: no-repeat;
            transform: rotate(90deg);
            margin-right: 10px;
            transition: all .3s ease;
            position: relative;
            left: 0;
        }

        &:hover {
            &:before {
                transition: all .3s ease;
                left: -5px;
            }
        }
    }

    .content_timeline {
        .year {
            color: #73b3c6;
            display: flex;
            position: relative;
            flex-direction: column;

            &::after {
                content: '';
                width: 40px;
                height: 1px;
                background-color: #678d81;
                display: block;
                margin: 20px 0;
            }
        }

        .content {
            color: #fff;
            font-size: 18px;
            line-height: 26px;

            ul {
                padding: 0 10px 0 0;
                margin: 0;
                list-style: none;

                li {
                    margin-bottom: 10px;
                    padding-left: 20px;
                    position: relative;

                    &:last-child {
                        margin-bottom: 0;
                    }

                    &::before {
                        content: "";
                        background-image: url('../../../assets/images/eventBirthday2024/icon_timeline_hover.png');
                        display: block;
                        width: 20px;
                        height: 26px;
                        position: absolute;
                        left: 0;
                        background-size: 100%;
                    }

                    span {
                        display: block;
                    }
                }
            }
        }

        .list_images {

            .lightgallery-vue {
                display: flex;
                flex-direction: row;
                flex-wrap: nowrap;
                justify-content: flex-start;
                align-items: stretch;
                align-content: stretch;
                margin: 0;
                padding: 0;
                list-style: none;
            }

            .itemImages {
                flex: 1;
                max-width: 25%;
                margin: 0px 10px;
                cursor: pointer;
                transition: all .3s ease-in-out;
                height: 430px;
                position: relative;
                border-radius: 15px;
                box-shadow: 0px 0px 5px 2px rgba(0, 0, 0, .35);

                &.hide {
                    display: none;
                }

                .countImages {
                    width: calc(100%);
                    height: calc(100%);
                    position: absolute;
                    background: rgba(0, 0, 0, .6);
                    border-radius: 15px;
                    top: 0px;
                    left: 0px;
                    font-size: 50px;
                    color: #fff;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    font-weight: 900;
                }

                &:hover {
                    flex: 2;
                    max-width: 50%;
                    transition: all .3s ease-in-out;
                }

                .el-image__inner {
                    border-radius: 15px;
                    height: 100%;
                    object-fit: cover;
                }
            }
        }
    }

    .list-timeline {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: flex-start;
        align-items: center;
        align-content: stretch;
        margin-top: 25px;

        .content_total {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: flex-start;
            align-items: center;
            align-content: stretch;

            span {
                &:last-child {
                    font-size: 22px;
                    font-weight: 700;
                }

                font-size: 18px;
                color:#fff;
                display: block;
                text-align: center;
            }
        }

        .icon {
            background-image: url('../../../assets/images/eventBirthday2024/icon_kimto_2.svg');
            display: block;
            width: 47px;
            height: 46px;
            background-size: 100%;
            margin-right: 20px;
        }

        .lists {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: flex-start;
            align-items: center;
            align-content: stretch;
            margin: 0;
            list-style: none;
            padding: 0;

            .item_list {
                position: relative;
                padding: 0 30px;

                &::before {
                    width: 100%;
                    content: '';
                    height: 1px;
                    background: #e5d6ac;
                    position: absolute;
                    left: 0;
                    top: 50%;
                    transform: translateY(-50%);
                }

                .icon_timeline {
                    background-image: url('../../../assets/images/eventBirthday2024/icon_timeline.svg');
                    display: block;
                    width: 40px;
                    height: 50px;
                    background-size: 100%;
                    background-repeat: no-repeat;
                    margin: 0 auto;
                    position: relative;
                    z-index: 1;
                    cursor: pointer;
                    transition: all .3s ease;
                    transform: scale(1);

                    &:hover {
                        background-image: url('../../../assets/images/eventBirthday2024/icon_timeline_hover.png');
                        transition: all .3s ease;
                        transform: scale(1.3);
                    }

                    &.active {
                        background-image: url('../../../assets/images/eventBirthday2024/icon_timeline_hover.png');
                        transform: scale(1.3);
                    }
                }

                .item__year {
                    border-radius: 5px;
                    padding: 5px 15px;
                    background: rgb(37, 101, 119);
                    background: linear-gradient(180deg, rgba(37, 101, 119, 1) 0%, rgba(37, 101, 119, 0) 100%);
                    color: #fff;
                    text-align: center;
                    position: absolute;
                    left: 50%;
                    top: 100%;
                    transform: translate(-50%, 5px);
                    width: 50px;

                    .year {
                        color: #f8d79c;
                        border-bottom: 1px solid #73b3c6;
                        padding-bottom: 5px;
                        margin-bottom: 5px;
                        display: block;
                    }

                    p {
                        margin: 0;
                        font-size: 16px;
                        display: flex;
                        flex-direction: column;
                        line-height: 20px;
                    }
                }
            }
        }
    }

    .wrap_nguyetdat_search {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: flex-end;
        align-items: stretch;
        align-content: stretch;
        margin-right: 50px;
        position: absolute;
        z-index: 1;
        right: 0;

        .title_nguyetda {
            .tree_title {
                position: relative;

                &:before {
                    content: '';
                    background-image: url('../../../assets/images/eventBirthday2024/img_star_2.svg');
                    height: 70px;
                    width: 60px;
                    background-size: 100%;
                    background-repeat: no-repeat;
                    position: absolute;
                    right: 115px;
                    background-position: bottom;
                    top: 65px;
                }

                &:after {
                    content: '';
                    background-image: url('../../../assets/images/eventBirthday2024/img_star_1.svg');
                    width: 60px;
                    background-size: 100%;
                    background-repeat: no-repeat;
                    position: absolute;
                    right: 30px;
                    height: 77px;
                    background-position: bottom;
                    top: 105px;
                }
            }
        }

    }

    .swiper-slide {
        height: 100vh;

        .trunk {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translate(-50%, 0px);
            width: auto;

            .trunk_tree {
                img {
                    width: 125.5%;
                    position: relative;
                }

                &:before {
                    content: '';
                    background-image: url('../../../assets/images/eventBirthday2024/icon_moon.png');
                    width: 100px;
                    height: 100px;
                    position: absolute;
                    background-size: 100%;
                    top: 50%;
                    left: 50%;
                    transform: translate(calc(-50% + -50px), calc(-50% + 45px));
                    background-repeat: no-repeat;
                }
            }

            .branches {
                position: absolute;
                width: 85%;
                top: 0;
                height: 50%;
                left: 20%;

                .leaf {
                    width: 80px;
                    height: 100px;
                    background-image: url('../../../assets/images/eventBirthday2024/bt_tt.png');
                    color: #b29b66;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    transition: all .3s ease-in-out;
                    cursor: pointer;
                    position: absolute;
                    background-size: 100%;

                    &:hover {
                        background-image: url('../../../assets/images/eventBirthday2024/bt_tt_hv.png');
                        transition: all .3s ease-in-out;
                    }

                    .info {
                        width: 60px;
                        height: 60px;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        margin-top: 20px;
                        text-align: center;

                        span {
                            font-size: 16px;

                            &.w700 {
                                font-size: 18px;
                            }
                        }
                    }

                    &.leaf_0 {
                        left: 24%;
                        top: 145px;
                    }

                    &.leaf_1 {
                        left: 35%;
                        top: 77px;
                    }

                    &.leaf_2 {
                        left: 50%;
                        top: 95px;
                    }

                    &.leaf_3 {
                        left: 72%;
                        top: 110px;
                    }

                    &.leaf_4 {
                        left: 81%;
                        top: 190px;
                    }

                    &.leaf_5 {
                        left: 81%;
                        bottom: 11px;
                    }

                    &.leaf_6 {
                        left: 67%;
                        bottom: 35px;
                    }

                    &.leaf_7 {
                        left: 61%;
                        bottom: 130px;
                    }

                    &.leaf_8 {
                        left: 47%;
                        bottom: 50px;
                    }

                    &.leaf_9 {
                        left: 37%;
                        bottom: 120px;
                    }

                    &.leaf_10 {
                        left: 24%;
                        bottom: 25px;
                    }

                    &.leaf_11 {
                        left: 9%;
                        bottom: -25px;
                    }
                }
            }
        }
    }

    .wrap-timeline {
        margin-top: 60px;
    }
}
</style>
<style lang="scss">
.swiper-button-prev {
    background-image: url('../../../assets/images/eventBirthday2024/icon_muiten.svg');
    transform: rotate(90deg) translate(calc(-50% - 100px), 20px);
}

.swiper-button-next {
    background-image: url('../../../assets/images/eventBirthday2024/icon_muiten.svg');
    transform: rotate(-90deg) translate(calc(-50% + 140px), 25px);
}

.swiper-button-prev,
.swiper-button-next {
    width: 60px;
    height: 60px;
    background-size: 100%;
    background-repeat: no-repeat;
    top: 50%;
    transition: all .3s ease-in-out;
    margin: 0;
}

.swiper-button-prev:hover {
    transition: all .3s ease-in-out;
}

.swiper-button-next:hover {
    transition: all .3s ease-in-out;
}

.swiper-button-prev.swiper-button-disabled,
.swiper-button-next.swiper-button-disabled {
    display: none;
}

.swiper-button-prev:after,
.swiper-button-next:after {
    display: none;
}
</style>

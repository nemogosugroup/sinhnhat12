<template>
    <div class="wrap-moonwalk">
        <div class="wrap-moonwalk__content">
            <el-row justify="center">
                <el-col :span="24">
                    <swiper :slidesPerView="1" :navigation="true" :modules="modules" :spaceBetween="0" class="mySwiper"
                        @swiper="onSwiper" @slideChange="onSlideChange">
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
                                            <el-scrollbar ref="scrollbarRef" height="465px" always @scroll="scroll">
                                                <el-row>
                                                    <el-col :span="4">
                                                        <span class="year font_beaufort w600 size68">2022</span>
                                                        <div class='content font_myriad_con'>
                                                            Lorem Ipsum is simply dummy text of the printing and
                                                            typesetting
                                                            industry. Lorem Ipsum has been the industry's standard dummy
                                                            text ever since the 1500s, when an unknown printer took a
                                                            galley
                                                            of type and scrambled it to make a type specimen book. It
                                                            has
                                                            survived not only five centuries, but also the leap into
                                                            electronic typesetting, remaining essentially unchanged. It
                                                            was
                                                            popularised in the 1960s with the release of Letraset sheets
                                                            containing Lorem Ipsum passages, and more recently with
                                                            desktop
                                                            publishing software like Aldus PageMaker including versions
                                                            of
                                                            Lorem Ipsum.
                                                            Lorem Ipsum is simply dummy text of the printing and
                                                            typesetting
                                                            industry. Lorem Ipsum has been the industry's standard dummy
                                                            text ever since the 1500s, when an unknown printer took a
                                                            galley
                                                            of type and scrambled it to make a type specimen book. It
                                                            has
                                                            survived not only five centuries, but also the leap into
                                                            electronic typesetting, remaining essentially unchanged. It
                                                            was
                                                            popularised in the 1960s with the release of Letraset sheets
                                                            containing Lorem Ipsum passages, and more recently with
                                                            desktop
                                                            publishing software like Aldus PageMaker including versions
                                                            of
                                                            Lorem Ipsum.
                                                        </div>
                                                    </el-col>
                                                    <el-col :span="20">
                                                        <ul class="list_images">
                                                            <li><el-image :src="imgElm.bannerTimeline" /></li>
                                                            <li><el-image :src="imgElm.bannerTimeline" /></li>
                                                            <li><el-image :src="imgElm.bannerTimeline" /></li>
                                                        </ul>
                                                    </el-col>
                                                </el-row>
                                            </el-scrollbar>
                                        </div>
                                    </el-col>
                                </el-row>
                                <div class="list-timeline">
                                    <div class="bg_border total_silk">
                                        <div class="content_total">
                                            <span class="icon"></span>
                                            <div class="title_total">
                                                <span>Tổng kim tơ</span>
                                                <span>15000</span>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="lists">
                                        <li class="item_list" v-for="(item, key) in listTimeLine" :key="key">
                                            <span class="icon_timeline"></span>
                                            <div class="item__year">
                                                <span class="year">{{ item.year }}</span>
                                                <p>
                                                    <span>10000</span>
                                                    <span>kimto</span>
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
                                    <div class="trunk">
                                        <div class="trunk_tree">
                                            <img :src="imgElm.nguyetDa" alt="">
                                        </div>
                                        <!-- <div class="branches">
                                            <div v-for="(user, key) in listEmployee" :key="key"
                                                :class="`leaf leaf_${key}`" @click="handleShowEmployee(user.hoten)">
                                                <div class="leaf__content">
                                                    <img :src="user.avatar" :alt="user.hoten">
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="wrap_nguyetdat_search">
                                        <div class="title_nguyetda">
                                            <img :src="imgElm.nguyetDattitle" alt="">
                                        </div>
                                        <div class="wrap-search">
                                            <search-employee ref="searchEmployee" :name-employee="nameEmployee"
                                                @update:name-employee="updateNameEmployee"></search-employee>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper>

                    <!-- <swiper :grabCursor="true" :autoHeight=true :slidesPerView="5" :spaceBetween="0" class="mySwiper"
                        @swiper="onSwiper" @slideChange="onSlideChange">
                        <swiper-slide v-for="(item, key) in listTimeLine" :key="key">
                            <div
                                :class="`item ${item.isActive && item.showTimeline ? 'active' : ''} ${item.isShow ? 'leftContent' : ''}`">
                                <div v-if="item.isActive && item.showTimeline" :class="`listImages`">
                                    <div class="item_img" v-for="(url, key) in item.listImages" :key="key">
                                        <el-image class="images" :src="`/static/uploads/sinhnhat/default.png`"
                                            style="width: 200px; height: 150px;" :fit="`cover`" />
                                    </div>
                                </div>
                                <div :class="`item__year ${item.isLast ? 'lastItem' : ''}`"
                                    @click="handleShowData(item.year)">
                                    <span class="icon"></span>
                                    <span class="year">{{ item.year }}</span>
                                </div>
                                <div class="item__content" v-if="item.isActive && item.showTimeline">
                                    <span class="line"></span>
                                    <div class="item__content__title">{{ item.title }}</div>
                                    <div class="item__content__desc">{{ item.content }}</div>
                                    <div class="item__images">
                                        <div class="item_img" v-for="(url, key) in item.listImages" :key="key">
                                            <el-image class="images" :src="`/static/uploads/sinhnhat/default.png`"
                                                style="width: 60px; height: 60px;" :fit="`cover`" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </swiper-slide>
                    </swiper> -->
                    <!-- <div class="wrap-moonwalk__timeline">
                        <swiper :grabCursor="true" :autoHeight=true :slidesPerView="5" :spaceBetween="0"
                            class="mySwiper" @swiper="onSwiper" @slideChange="onSlideChange">
                            <swiper-slide v-for="(item, key) in listTimeLine" :key="key">
                                <div
                                    :class="`item ${item.isActive && item.showTimeline ? 'active' : ''} ${item.isShow ? 'leftContent' : ''}`">
                                    <div v-if="item.isActive && item.showTimeline" :class="`listImages`">
                                        <div class="item_img" v-for="(url, key) in item.listImages" :key="key">
                                            <el-image class="images" :src="`/static/uploads/sinhnhat/default.png`"
                                                style="width: 200px; height: 150px;" :fit="`cover`" />
                                        </div>
                                    </div>
                                    <div :class="`item__year ${item.isLast ? 'lastItem' : ''}`"
                                        @click="handleShowData(item.year)">
                                        <span class="icon"></span>
                                        <span class="year">{{ item.year }}</span>
                                    </div>
                                    <div class="item__content" v-if="item.isActive && item.showTimeline">
                                        <span class="line"></span>
                                        <div class="item__content__title">{{ item.title }}</div>
                                        <div class="item__content__desc">{{ item.content }}</div>
                                        <div class="item__images">
                                            <div class="item_img" v-for="(url, key) in item.listImages" :key="key">
                                                <el-image class="images" :src="`/static/uploads/sinhnhat/default.png`"
                                                    style="width: 60px; height: 60px;" :fit="`cover`" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </swiper-slide>
                        </swiper>
                    </div> -->
                </el-col>
                <!-- <el-col :span="9">
                    <div class="container-true">
                        <div class="trunk">
                            <div class="trunk_tree">
                                <img :src="tree" alt="">
                            </div>
                            <div class="branches">
                                <div v-for="(user, key) in listEmployee" :key="key" :class="`leaf leaf_${key}`"
                                    @click="handleShowEmployee(user.hoten)">
                                    <div class="leaf__content">
                                        <img :src="user.avatar" :alt="user.hoten">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrap-search">
                            <search-employee ref="searchEmployee" :name-employee="nameEmployee"
                                @update:name-employee="updateNameEmployee"></search-employee>
                        </div>
                    </div>
                </el-col> -->
            </el-row>
        </div>
        <RouterLink to="/" class="back"><i class="ri-arrow-left-s-fill"></i> Quay lại công viên</RouterLink>
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
import { dataTimeline } from './timeline';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import { mapGetters } from "vuex";
import { Employee } from '@frontend/components/SearchEmployee/data';
import { Navigation } from 'swiper/modules';
import 'swiper/css/navigation';
export default {
    components: { Swiper, SwiperSlide, SearchEmployee },
    data() {
        return {
            listTimeLine: false,
            listEmployee: false,
            tree: treeImg,
            treeWidth: 475,
            treeHeight: 410,
            indexSlider: 4,
            nameEmployee: null,
            imgElm: {
                moonWalk: moonWalk,
                nguyetDattitle: nguyetDattitle,
                moon: moon,
                arrow: Arrow,
                bannerTimeline: bannerTimeline,
                nguyetDa: nguyetDa,
            }
        }
    },
    setup() {
        return {
            modules: [Navigation],
        };
    },
    computed: {
        ...mapGetters(["silk"]),
    },
    created() {
        this.listTimeLine = dataTimeline().map((item, index) => {
            item['isActive'] = false;
            item['isLast'] = false;
            item['isShow'] = false;
            item['showTimeline'] = this.silk >= item.showDataTimeLine ? true : false;
            return item;
        });

        // Khởi tạo danh sách nhân viên với vị trí hợp lệ
        this.listEmployee = Employee.filter((item) => {
            return item.avatar !== 'https://static.gosucorp.vn/hrm/avatar/none/none_profile.jpg';
        });
        this.listEmployee = this.listEmployee.slice().sort(() => Math.random() - 0.5);
        //this.listEmployee = this.shuffleArray(this.listEmployee);
        // this.listEmployee = (() => {
        //     const tempListEmployee = []; // Mảng tạm để lưu trữ các nhân viên với vị trí hợp lệ
        //     const minDistance = 30; // Khoảng cách tối thiểu giữa các nhân viên
        //     const branchWidth = 550; // Chiều rộng của tán cây
        //     const branchHeight = 400; // Chiều cao của tán cây
        //     const treeWidth = 500; // Chiều rộng cây
        //     const treeHeight = 705; // Chiều cao cây

        //     // Lặp qua từng nhân viên
        //     dataEmployee().forEach((item, index) => {
        //         let isValidPosition = false;
        //         let top, left;

        //         // Lặp cho đến khi tìm được vị trí hợp lệ
        //         while (!isValidPosition) {
        //             // Sinh vị trí ngẫu nhiên
        //             top = Math.random() * branchHeight;
        //             left = Math.random() * branchWidth + (treeWidth - branchWidth) / 2; // Đảm bảo nằm trong vùng tán cây

        //             // Kiểm tra khoảng cách với các nhân viên đã có trước đó
        //             isValidPosition = true; // Giả sử vị trí là hợp lệ
        //             for (const prevItem of tempListEmployee) {
        //                 const distance = Math.sqrt(Math.pow(top - prevItem.top, 2) + Math.pow(left - prevItem.left, 2));
        //                 if (distance < minDistance) {
        //                     isValidPosition = false;
        //                     break;
        //                 }
        //             }
        //         }

        //         // Gán vị trí hợp lệ cho item hiện tại và thêm vào mảng tạm
        //         item.top = top;
        //         item.left = left;
        //         tempListEmployee.push(item);
        //     });

        //     return tempListEmployee; // Trả về mảng tạm đã chứa tất cả nhân viên với vị trí hợp lệ
        // })();
    },
    mounted() {
    },
    methods: {
        handleShowData(year) {
            this.listTimeLine = this.listTimeLine.map((item) => {
                //item.isActive = false;
                if (item.year == year) {
                    item.isActive = !item.isActive
                } else {
                    item.isActive = false;
                }
                return item;
            });
        },
        onSwiper(swiper) {
            let index = swiper.activeIndex + this.indexSlider;
            this.handleCheckShowContent(index)
        },
        onSlideChange(swiper) {
            let index = swiper.activeIndex + this.indexSlider;;
            this.handleCheckShowContent(index)
        },
        handleCheckShowContent(number) {
            this.listTimeLine = this.listTimeLine.map((item, index) => {
                item['isLast'] = index == number ? true : false;
                item['isShow'] = index == number || index == (number - 1) ? true : false;
                return item;
            });
        },
        handleShowEmployee(hoten) {
            this.nameEmployee = hoten;
            this.$refs.searchEmployee.focusSelect();
        },
        updateNameEmployee(newName) {
            this.nameEmployee = newName;
        }
    }
}
</script>
<style lang="scss" scoped>
.wrap-moonwalk {
    padding: 100px 40px 80px;
    background-image: url('../../../assets/images/eventBirthday2024/bg_moonwalk.jpg');
    background-position: left top;
    background-repeat: no-repeat;

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
        }

        .list_images {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: flex-start;
            align-items: stretch;
            align-content: stretch;
            margin: 0;
            padding: 0;
            list-style: none;

            li {
                padding: 10px;

                :deep(.el-image) {
                    border-radius: 15px;
                    box-shadow: 0px 0px 5px 2px rgba(0, 0, 0, .35)
                }

                :deep(.el-image__inner) {
                    border-radius: 15px;
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
        margin-top: 45px;

        .icon {
            background-image: url('../../../assets/images/eventBirthday2024/icon_kimto_2.svg');
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
        }
    }

    .item {
        position: relative;

        .listImages {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: 1fr;
            grid-column-gap: 20px;
            grid-row-gap: 0px;
            position: absolute;
            top: -170px;

            .item_img {
                display: block;
                position: relative;
            }

            :deep(.el-image__inner) {
                border-radius: 20px;
            }
        }

        .item__year {
            position: relative;
            padding-bottom: 25px;
            cursor: pointer;

            &:before {
                position: absolute;
                content: '';
                width: 100%;
                height: 1px;
                background-color: #000;
                bottom: 0px;
                left: 0;
            }

            &.lastItem {
                &:before {
                    background: linear-gradient(90deg, #000 25%, #fff 100%);
                }
            }

            .icon {
                width: 22px;
                height: 22px;
                display: inline-block;
                background: #bbb;
                border-radius: 100%;
                position: absolute;
                z-index: 1;
                bottom: -11px;
                left: 0;
            }

            .year {
                position: relative;
                font-size: 30px;
                color: #bbb;
                font-family: 'Phudu';
                margin-left: 25px;
            }
        }

        .item__content {
            width: 560px;
            padding: 20px;
            position: relative;
            background-color: #ffffff;
            font-size: 20px;
            font-family: 'Inter';
            color: #000;

            .item__content__title {
                font-family: 'Phudu';
                font-weight: 500;
            }

            .line {
                position: absolute;
                height: 100%;
                width: 1px;
                background: linear-gradient(to bottom, #000 25%, #fff 100%);
                left: 0;
                top: 0;
                left: 10px
            }

            .item__images {
                display: flex;

                :deep(.images) {
                    margin-right: 5px;


                }

                :deep(.el-image__inner) {
                    border-radius: 5px;
                }
            }

            .item__content__desc {
                margin: 10px 0;
            }
        }

        &.active {
            .item__year {
                .icon {
                    background-color: #FFC200;
                }
            }
        }

        &.leftContent {
            .listImages {
                left: -270%;
            }

            .item__content {
                left: -250%;

                .line {
                    left: auto;
                    right: 20px;
                }
            }
        }
    }

    .container-true {
        position: relative;
    }

    .trunk {
        width: 680px;
        height: 705px;
        position: relative;

        .branches {
            width: 475px;
            height: 410px;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 0
        }

        .leaf {
            position: absolute;
            z-index: 1;
            width: 30px;
            height: 30px;
            border-radius: 100%;
            overflow: hidden;
            top: 108%;
            left: 43%;
            transform: scale(1);
            transition: all 1.2s ease;
            cursor: pointer;

            img {
                width: 100%;
                height: 100%;
                object-fit: fill;
                object-position: center;
            }

            &:hover {
                transition: all .7s ease;
                transform: scale(2);
                z-index: 2;
            }
        }

        .trunk_tree {
            img {
                width: 100%;
            }
        }
    }
}
</style>

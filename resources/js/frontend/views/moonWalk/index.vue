<template>
    <div class="wrap-moonwalk">
        <div class="wrap-moonwalk__content">
            <el-row justify="center">
                <el-col :span="15">
                    <h1 class="title-h1">Cổng moonwalk</h1>
                    <h2 class="title-h2">CÙNG NHÌN LẠI MỘT HÀNH TRÌNH DÀI</h2>
                    <div class="wrap-moonwalk__timeline">
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
                    </div>
                </el-col>
                <el-col :span="9">
                    <div class="container-true">
                        <div class="trunk">
                            <div class="trunk_tree">
                                <img :src="tree" alt="">
                            </div>
                            <!-- :style="{ top: user.top + 'px', left: user.left + 'px' } -->
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
                </el-col>
            </el-row>
        </div>
        <RouterLink to="/" class="back"><i class="ri-arrow-left-s-fill"></i> Quay lại công viên</RouterLink>
    </div>
</template>

<script>
import treeImg from "@/assets/images/sinhnhat/tree.png";
import SearchEmployee from "@frontend/components/SearchEmployee";
import { dataTimeline } from './timeline';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import { mapGetters } from "vuex";
import { Employee } from '@frontend/components/SearchEmployee/data';
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
        }
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
@import "~@style/style_moonwalk.scss";
// @for $i from 0 through 190 {
//     .leaf_#{$i} {
//         top: #{random(300)}px;
//         left: #{random(300)}px;
//     }
// }

.wrap-moonwalk {
    padding: 100px 40px 80px;

    .title-h1 {
        font-size: 150px;
        background: #ffffff;
        background: linear-gradient(to bottom, #833602 31%, #A8622E 65%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 30px 0 0;
        font-family: 'Phudu';
        // margin: -10px 0 0;
        // font-weight: 600;
        // /* filter: drop-shadow(0 0 0.75rem rgba(234, 216, 127, 0.4)); */
        // text-shadow: -4px -4px 10px rgba(255, 255, 255, 0.5), 1px 1px 10px rgba(234, 216, 127, 0.3);
        // /* -webkit-filter: drop-shadow(0 0 0.75rem rgba(234, 216, 127, 0.4));
    }

    .title-h2 {
        font-family: 'Inter';
        font-size: 32px;
        font-weight: 600;
        margin: 0;
    }

    .back {
        position: absolute;
        bottom: 20px;
        left: 40px;
        font-weight: 500;
        font-size: 26px;

        &:after {
            content: '';
            border-bottom: 2px solid #66494e;
            position: absolute;
            width: 0;
            left: 0;
            bottom: -3px;
            transition: all .3s ease-in-out;
        }

        &:hover {
            color: #66494e;

            &:after {
                transition: all .3s ease-in-out;
                width: 100%;
            }
        }
    }


    .swiper {
        padding-top: 190px;
        padding-bottom: 15px;
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

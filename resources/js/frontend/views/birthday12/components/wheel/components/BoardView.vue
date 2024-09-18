<template>
    <div class="wrap-board">
        <span class="point-reward point-silk"><img :src="iconSilk" /><span class="point">{{
            dataBoard.pointSilk.value
                }}</span></span>
        <span class="point-reward point-mochi"><img :src="iconMochi" /><span class="point">{{ mochi }}</span></span>
        <el-row :gutter="10" style="position: relative; top:-35px">
            <el-col :span="13">
                <div class="board">
                    <div v-for="(r_item, r_i) in board.cells" :key="r_i">
                        <cell v-for="(c_item, c_i) in r_item" :key="c_i"></cell>
                    </div>
                    <tile-view v-for="(tile, i) in tiles" :tile="tile" :key="i"></tile-view>
                    <game-end-overlay :board="board" :onrestart="onRestart" :onsubmit="submitScore"></game-end-overlay>
                    <div v-if="!checkStartGame" class='youWin'></div>
                </div>
            </el-col>
            <el-col :span="11" class="infoGame">
                <el-row class="align-item-center" :gutter="10" justify="space-between">
                    <el-col :span="24">
                        <h1 class="title-2048 font_beaufort w900">{{ mapData.title2048 }}</h1>
                    </el-col>
                </el-row>
                <el-row :gutter="10">
                    <el-col :span="24">
                        <div class="content">
                            <p>Dùng các phím mũi tên trên keyboard để điều hướng các ô số sao cho các ô có giá trị giống
                                nhau kết hợp lại sẽ tạo được ô có giá trị lớn hơn trong 5 phút. Điểm càng cao càng nhận
                                được nhiều Kim Tơ</p>
                            <p><strong class="w900">*Số Kim Tơ quy đổi theo từng mốc điểm in game:</strong></p>
                            <ul>
                                <li><span>Điểm 0000 - 1489: 5 Kim Tơ</span></li>
                                <li><span>Điểm 1500 - 1998: 10 Kim Tơ</span></li>
                                <li><span>Điểm 2000 - 2498: 15 Kim Tơ</span></li>
                                <li><span>Điểm 2500 - 2998: 20 Kim Tơ</span></li>
                                <li><span>Điểm 3000 - 3498: 25 Kim Tơ</span></li>
                            </ul>
                            <p>Cứ thêm 500 điểm in-game sẽ đc cộng thêm 5 Kim Tơ</p>
                        </div>
                    </el-col>
                </el-row>
                <el-row :gutter="10">
                    <el-col :span="12">
                        <div class="countDown">
                            <span>{{ mapData.countdown }}</span>
                            <Countdown :deadline="`${dataBoard.deadline.value}`" :stop="!startGame" :showLabels="false"
                                :showDays="false" :showHours="false" mainFlipBackgroundColor="#DCF0F8"
                                secondFlipBackgroundColor='#DCF0F8' mainColor="#121F24" secondFlipColor="#121F24"
                                :flipAnimation="false" />
                        </div>
                        <div class="play-again">
                            <el-button :loading="loading" class="reset" @click="onRestart">
                                <div class='img'><img :src="iconMochi2" alt=""> <span class="count">{{
                                    use_mochi
                                        }}</span></div>
                                <div>{{
                                    !startGame && score == 0 ?
                                        mapData.play : mapData.play_again
                                }}
                                </div>
                            </el-button>
                        </div>
                    </el-col>
                    <el-col :span="12">
                        <div class="wrap-score">
                            <div class="score">
                                <span>{{ mapData.currentScore }}</span>
                                <span> {{ score }}</span>
                            </div>
                            <div class="score">
                                <span>{{ mapData.bestScore }}</span>
                                <span>{{ bestScore }}</span>
                            </div>
                        </div>

                    </el-col>
                </el-row>
            </el-col>
        </el-row>
    </div>
</template>

<script>
import RepositoryFactory from '@frontend/utils/RepositoryFactory';

const game2048Repository = RepositoryFactory.get('game2048');

import MapIconMochi from '@/assets/images/eventBirthday2024/icon_mochi.svg'
import MapIconSilk from '@/assets/images/eventBirthday2024/icon_kimto.svg'
import MapIconMochi2 from '@/assets/images/eventBirthday2024/icon_mochi_2.svg'
import Cell from "./Cell.vue";
import TileView from "./TileView.vue";
import GameEndOverlay from "./GameEndOverlay.vue";
import { Board } from "../board";
import { onMounted, onBeforeUnmount, ref, computed } from "vue";
import { Countdown } from 'vue3-flip-countdown';
import moment from 'moment';
import { useStore } from "vuex";
import { Emitter, encryptData } from './evenEmit';
import { ElMessage } from 'element-plus'

const levels = [
    { min: 0, max: 1489, levelKey: 'lv1' },
    { min: 1500, max: 1998, levelKey: 'lv2' },
    { min: 2000, max: 2498, levelKey: 'lv3' },
    { min: 2500, max: 2998, levelKey: 'lv4' },
    { min: 3000, max: 3498, levelKey: 'lv5', bonus: true }
];
import CryptoJS from "crypto-js";

export default {
    data() {
        return {
            iconSilk: MapIconSilk,
            iconMochi: MapIconMochi,
            iconMochi2: MapIconMochi2,
            mapData: {
                'currentScore': 'Điểm hiện tại',
                'bestScore': 'Điểm cao nhất',
                'countdown': 'Điếm ngược',
                'play': 'Chơi game',
                'play_again': 'Chơi lại',
                'title2048': 2048
            }
        }
    },
    setup() {
        const board = ref(new Board());
        const startGame = ref(false); // kiểm tra trạng thái game
        const checkStartGame = ref(false); // kiểm tra trạng thái game
        const loading = ref(false); // loading button
        const store = useStore();
        const silk = computed(() => store.getters['silk']);
        const mochi = computed(() => store.getters['mochi']);
        const bestScore = computed(() => store.getters['bestscore']);
        const user = computed(() => store.getters['user']);
        const minutes = user.value.time_duration;
        const use_mochi = user.value.use_mochi;
        const secretKey = 'jqRIMbaBP+XoHUem/M0Y8dIZ2DHuh7DJ';
        const iv = "M0Y8dIZ2DHXoHUem";
        const createDefaultData = () => {
            return {
                startTime: moment().format('YYYY-MM-DD HH:mm:ss'),
                endTime: null, // end time
                deadline: ref(moment().add(minutes, 'minutes').format('YYYY-MM-DD HH:mm:ss')),
                timer: null, // timer interval
                intervalData: null, // reset interval
                countMinutes: Math.round(moment().add(minutes, 'minutes').diff(moment()) / 1000), // count seconds
                pointSilk: ref(0),
                levelSilk: {
                    'lv1': { 'point': 5, 'check': true },
                    'lv2': { 'point': 5, 'check': true },
                    'lv3': { 'point': 5, 'check': true },
                    'lv4': { 'point': 5, 'check': true },
                    'lv5': { 'point': 5, 'check': true }
                },
                checkBonnus: false,
                scoreBonnus: 0, // kiểm tra điểm bonnus nếu score đạt trên 3500 bắt đầu tính toán để cộng dồn silk
                silkBonnus: 5, // set giá trị mặc định của kim tơ
                start: true,
                pointMaxBonnus: 3500,
                pointBonnus: 500,
            };
        };
        let dataBoard = createDefaultData();
        const handleKeyDown = (event) => {
            if (board.value.hasWon()) {
                return;
            }

            if (!startGame.value) return;

            if (event.keyCode >= 37 && event.keyCode <= 40) {
                event.preventDefault();
                var direction = event.keyCode - 37;
                board.value.move(direction);
            }
        };

        const handleTouch = () => {
            let startX, startY;

            document.addEventListener('touchstart', (event) => {
                startX = event.touches[0].clientX;
                startY = event.touches[0].clientY;
            });

            document.addEventListener('touchend',
                (event) => {
                    const endX = event.changedTouches[0].clientX;
                    const endY = event.changedTouches[0].clientY;

                    const deltaX = endX - startX;
                    const deltaY = endY - startY;

                    // Ngưỡng để xác định độ lớn của cử chỉ
                    const threshold = 250;

                    if (Math.abs(deltaX) > threshold) {
                        if (deltaX < 0) {
                            // console.log("Vuốt từ phải sang trái")
                            // Mô phỏng phím mũi tên trái (keyCode 37)
                            const keyboardEvent = new KeyboardEvent('keydown', { keyCode: 37 });
                            board.value.move(37 - 37);
                            document.dispatchEvent(keyboardEvent);
                        } else {
                            // console.log("Vuốt từ trái sang phải")
                            // Mô phỏng phím mũi tên phải (keyCode 39)
                            const keyboardEvent = new KeyboardEvent('keydown', { keyCode: 39 });
                            board.value.move(39 - 37);
                            document.dispatchEvent(keyboardEvent);
                        }
                    } else if (Math.abs(deltaY) > threshold) {
                        if (deltaY < 0) {
                            // console.log("Vuốt từ dưới lên trên")
                            // Mô phỏng phím mũi tên lên (keyCode 38)
                            const keyboardEvent = new KeyboardEvent('keydown', { keyCode: 38 });
                            board.value.move(38 - 37);
                            document.dispatchEvent(keyboardEvent);
                        } else {
                            // console.log("Vuốt từ trên xuống dưới")
                            // Mô phỏng phím mũi tên xuống (keyCode 40)
                            const keyboardEvent = new KeyboardEvent('keydown', { keyCode: 40 });
                            board.value.move(40 - 37);
                            document.dispatchEvent(keyboardEvent);
                        }
                    }
                });
        }

        const startTimer = () => {
            dataBoard.timer = setInterval(() => {
                if (dataBoard.countMinutes > 0) {
                    dataBoard.countMinutes--;
                } else {
                    clearInterval(dataBoard.timer);
                    board.value.isLost = true;
                }
            }, 1000);
        };
        const resetTimer = () => {
            clearInterval(dataBoard.timer);
            dataBoard.countMinutes = Math.round(moment().add(minutes, 'minutes').diff(moment()) / 1000)
            dataBoard.startTime = moment().format('YYYY-MM-DD HH:mm:ss');
            dataBoard.endTime = null; // end time
            dataBoard.deadline.value = moment().add(minutes, 'minutes').format('YYYY-MM-DD HH:mm:ss');
            dataBoard.timer = null; // timer interval
            dataBoard.intervalData = null; // reset interval
            dataBoard.pointSilk.value = 0;
            dataBoard.scoreBonnus = 0;
            dataBoard.checkBonnus = false;
            dataBoard.levelSilk = {
                'lv1': { 'point': 5, 'check': true },
                'lv2': { 'point': 5, 'check': true },
                'lv3': { 'point': 5, 'check': true },
                'lv4': { 'point': 5, 'check': true },
                'lv5': { 'point': 5, 'check': true }
            };
            startGame.value = true;
            checkStartGame.value = true;
            startTimer();
        };

        const intervalScore = () => {
            dataBoard.intervalData = setInterval(async () => {
                //endTime = formatDate();
                try {
                    // let formData = {
                    //     score: board.value.score,
                    //     start: startTime,
                    //     end: endTime
                    // }
                    //const { data } = await game2048Repository.create(formData);
                    //console.log('data')
                } catch (error) {

                }
            }, 5000)
        }

        const resetIntervalScore = () => {
            clearInterval(dataBoard.intervalData);
            intervalScore();
        };

        // run file
        intervalScore();
        startTimer();

        const onRestart = () => {
            // nếu đang chơi chưa hết timer reset game thì lưu dữ liệu lại
            if (mochi.value - use_mochi < 0) {
                openCenter();
                return false;
            }
            // kiểm tra mochi
            const dataCommit = {
                'mochi': mochi.value - use_mochi
            }
            store.dispatch('user/updateDataUser', dataCommit);
            //if (board.value.score > 0 && startGame.value) {
            if (startGame.value) {
                submitScore();
            }
            board.value = new Board();
            resetTimer();
        };

        const submitScore = async () => {
            clearInterval(dataBoard.timer);
            clearInterval(dataBoard.intervalData);
            dataBoard.endTime = moment().format('YYYY-MM-DD HH:mm:ss');
            try {
                let formData = {
                    scores: board.value.score,
                    start: dataBoard.startTime,
                    end: dataBoard.endTime,
                    point_silk: dataBoard.pointSilk.value,
                    user_id: user.value.id
                }
                startGame.value = false;
                loading.value = true;
                const _encryptData = encryptData(formData, secretKey, iv);
                const { data } = await game2048Repository.create({ 'data': _encryptData, iv: iv });
                if (data.success) {
                    const dataCommit = {
                        'silk': dataBoard.pointSilk.value + silk.value
                    }
                    store.dispatch('user/updateDataUser', dataCommit)
                    loading.value = false;
                }
                //loading.value = false;
            } catch (error) {
                console.error('error', error);
            }
        }

        onMounted(() => {
            Emitter.on("reset-game", () => {
                //if (startGame.value && board.value.score > 0) {
                if (startGame.value) {
                    submitScore();
                }
                // else {
                //     const dataCommit = {
                //         'mochi': mochi.value + use_mochi
                //     }
                //     store.dispatch('user/updateDataUser', dataCommit);
                // }

                board.value = new Board();
                startGame.value = false;
                checkStartGame.value = false;
                loading.value = false;
                dataBoard.pointSilk.value = 0
            });

            handleTouch();
            window.addEventListener("keydown", handleKeyDown);
        });

        onBeforeUnmount(() => {

            handleTouch();
            window.removeEventListener("keydown", handleKeyDown);
        });

        const tiles = computed(() => {
            return board.value.tiles.filter((tile) => tile.value != 0);
        });
        const score = computed(() => {
            calculatePoint(board.value.score);
            if (board.value.score > bestScore.value) {
                let data = {
                    bestscore: board.value.score
                }
                store.dispatch("user/updateDataUser", data);
            }
            return board.value.score;
        });

        const calculatePoint = (score) => {
            levels.forEach(level => {
                const currentLevel = dataBoard.levelSilk[level.levelKey];
                if (score > level.min && score <= level.max && currentLevel.check) {
                    dataBoard.pointSilk.value += currentLevel.point;
                    currentLevel.check = false;
                }
            });

            // kiểm tra nếu điểm 3500 trở lên thì bắt đầu kiểm tra + thêm kim tơ
            if (!dataBoard.checkBonnus && score >= dataBoard.pointMaxBonnus) {
                dataBoard.scoreBonnus = dataBoard.pointMaxBonnus;
                dataBoard.checkBonnus = true;
            }

            if ((dataBoard.scoreBonnus >= dataBoard.pointMaxBonnus) && ((score - dataBoard.scoreBonnus) >= dataBoard.pointBonnus)) {
                dataBoard.pointSilk.value += dataBoard.silkBonnus; //cộng thêm 5 kim tơ điểm nếu đặt mốc
                dataBoard.scoreBonnus = dataBoard.scoreBonnus + dataBoard.pointBonnus; //cộng thêm 500 điểm nếu đặt mốc
            }

        };

        const openCenter = () => {
            ElMessage({
                showClose: false,
                message: 'Bạn đã sử dụng hết Mochi!',
                type: 'error',
                center: true,
            });
        }

        return {
            board,
            onRestart,
            tiles,
            score,
            submitScore,
            dataBoard,
            mochi,
            silk,
            bestScore,
            startGame,
            checkStartGame,
            loading,
            use_mochi
        };
    },
    components: {
        Cell,
        TileView,
        GameEndOverlay,
        Countdown
    },
};
</script>
<style lang="scss" scoped>
:deep(.flip-card__bottom),
:deep(.flip-card__back-bottom) {
    border-top: 0 !important;
}

:deep(.flip-card__back-bottom),
:deep(.flip-card__back:after),
:deep(.flip-card__back:before),
:deep(.flip-card__bottom),
:deep(.flip-card__top) {
    width: auto !important;
}

:deep(.flip-clock__piece) {
    font-size: 36px;
}

:deep(.no-animation__card) {
    font-size: 36px;
    font-weight: 600;
    line-height: 40px;
}

:deep(.flip-clock__piece:last-child) {
    position: relative;
}

:deep(.flip-clock__piece:last-child:before) {
    content: ":";
    position: absolute;
    left: -9px;
    font-size: 36px;
    top: 50%;
    transform: translate(0px, -55%);
    color: #121F24;
    font-weight: 600;
}

.wrap-board {
    position: relative;

    :deep(.el-row) {
        width: 100%
    }

    .point-reward {
        display: inline-flex;
        font-size: 18px;
        font-weight: 700;
        position: absolute;
        left: -120px;
        bottom: -30px;
        color: #fff;

        &.point-mochi {
            bottom: 50px;

            .point {
                right: 17px;
            }
        }

        .point {
            position: absolute;
            right: 12px;
            bottom: 4px;
            text-shadow: 1px 1px #000, -1px -1px #000;
        }
    }

    .content {
        position: relative;
        padding-top: 20px;
        width: 100%;
        color: #121f24;
        font-size: 16px;

        &::before {
            content: '';
            background-color: #60A8AC;
            position: absolute;
            left: 0;
            top: 10px;
            width: 100%;
            height: 1px;
        }


        p {
            margin: 0 0 20px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0 0 20px
        }
    }

    .countDown {
        background-color: #DCF0F8;
        padding: 10px 10px 5px;
        text-align: center;
        border-radius: 10px;
        font-weight: 600;

        span {
            display: block;
            color: #25617A;
            font-size: 14px;
        }
    }

    .reset {
        width: 100%;
        margin-top: 5px;
        color: #fff;
        font-size: 18px;
        font-weight: 600;
        background-image: url('../../../../../../assets/images/eventBirthday2024/button.svg');
        border-radius: 10px;
        background-size: 100%;
        height: 60px;
        border: 0;
        background-repeat: no-repeat;
        position: relative;

        .img {
            position: relative;
            left: -15px;
            top: -6px;

            .count {
                position: absolute;
                bottom: 8px;
                left: 40px;
                text-shadow: 1px 1px #000, -1px -1px #000;
            }
        }

    }

    .wrap-score {
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        align-content: stretch;
        border: 1px solid #C2EEFF;
        border-radius: 10px;
        padding: 10px 20px;
    }

    .score {
        font-weight: 600;
        border-radius: 5px;
        font-size: 14px;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        align-content: stretch;

        &:first-child {
            &:after {
                display: block;
                background: #307388;
                height: 1px;
                width: 50px;
                margin: 8px auto;
                content: '';
            }
        }

        span {
            color: #121F24;

            &:last-child {
                font-size: 36px;
                display: block;
                line-height: 32px;
            }
        }

        &:last-child {
            span:last-child {
                color: #3FC2F9;
            }
        }
    }
}

.el-row {
    width: 100% !important
}
</style>

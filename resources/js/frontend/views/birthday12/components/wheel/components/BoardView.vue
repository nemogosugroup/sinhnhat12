<template>
    <div class="wrap-board">
        <el-row :gutter="10">
            <el-col :span="12">
                <div class="board">
                    <div v-for="(r_item, r_i) in board.cells" :key="r_i">
                        <cell v-for="(c_item, c_i) in r_item" :key="c_i"></cell>
                    </div>
                    <tile-view v-for="(tile, i) in tiles" :tile="tile" :key="i"> </tile-view>
                    <game-end-overlay :board="board" :onrestart="onRestart" :onsubmit="submitScore"></game-end-overlay>
                    <div v-if="!checkStartGame" class='youWin'></div>
                </div>
            </el-col>
            <el-col :span="12" class="infoGame">
                <el-row class="align-item-center" :gutter="10" justify="space-between">
                    <el-col :span="14">
                        <h1 class="title-2048">2048</h1>
                    </el-col>
                    <el-col :span="10">
                        <el-row class="align-item-center" :gutter="10" justify="end">
                            <span class="point-reward">{{ dataBoard.pointSilk.value }} <img :src="iconSilk" /></span>
                            <span class="point-reward">{{ mochi }} <img :src="iconMochi" /></span>
                        </el-row>
                    </el-col>
                </el-row>
                <el-row :gutter="10">
                    <el-col :span="24">
                        <div class="content">
                            <p>Điều hướng các ô số guống nhập thành số chắn lớn hơn trong 5 phút. Điểm càng cao nhận
                                càng
                                nhiều Kim Tơ</p>
                            <p><strong>*Số Kim Tơ quy đổi theo từng mốc điểm in game:</strong></p>
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
                            <span>countdown</span>
                            <Countdown :deadline="`${dataBoard.deadline.value}`" :stop="!startGame" :showLabels="false"
                                :showDays="false" :showHours="false" mainFlipBackgroundColor="#E6F5DF"
                                secondFlipBackgroundColor='#E6F5DF' mainColor="#000" secondFlipColor="#000"
                                :flipAnimation="false" />
                        </div>
                        <div class="play-again">
                            <el-button :loading="loading" type="warning" class="reset" @click="onRestart">{{
                                !startGame && score == 0 ?
                                    'Play Game' : 'Play Again' }}</el-button>
                        </div>
                    </el-col>
                    <el-col :span="12">
                        <div class="score">
                            <span>Current score</span>
                            <span> {{ score }}</span>
                        </div>
                        <div class="score">
                            <span>Best score</span>
                            <span>{{ bestScore }}</span>
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

import MapIconMochi from '@/assets/images/birthday12/map/dialog/icon_mochi.png'
import MapIconSilk from '@/assets/images/birthday12/map/dialog/icon_silk.png'
import Cell from "./Cell.vue";
import TileView from "./TileView.vue";
import GameEndOverlay from "./GameEndOverlay.vue";
import { Board } from "../board";
import { onMounted, onBeforeUnmount, ref, computed } from "vue";
import { Countdown } from 'vue3-flip-countdown';
import moment from 'moment';
import { useStore } from "vuex";
import Emitter from './evenEmit';
import { ElMessage } from 'element-plus'
const levels = [
    { min: 0, max: 1489, levelKey: 'lv1' },
    { min: 1500, max: 1998, levelKey: 'lv2' },
    { min: 2000, max: 2498, levelKey: 'lv3' },
    { min: 2500, max: 2998, levelKey: 'lv4' },
    { min: 3000, max: 3498, levelKey: 'lv5', bonus: true }
];

export default {
    data() {
        return {
            iconSilk: MapIconSilk,
            iconMochi: MapIconMochi,
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

            if (dataBoard.countMinutes > 0 && board.value.score > 0 && startGame.value)
                submitScore();

            // kiểm tra mochi
            const dataCommit = {
                'mochi': mochi.value - use_mochi
            }
            store.dispatch('user/updateDataUser', dataCommit);
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
                const { data } = await game2048Repository.create(formData);
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
                if (startGame.value) {
                    submitScore();
                }
                board.value = new Board();
                startGame.value = false;
                checkStartGame.value = false;
                loading.value = false;
                dataBoard.pointSilk.value = 0
            });
            window.addEventListener("keydown", handleKeyDown);
        });

        onBeforeUnmount(() => {
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
            loading
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

:deep(.flip-clock__piece:last-child) {
    position: relative;
}

:deep(.flip-clock__piece:last-child:before) {
    content: ":";
    position: absolute;
    left: -9px;
    font-size: 35px;
    top: 50%;
    transform: translate(0px, -60%);
    color: #000
}

.wrap-board {
    :deep(.el-row) {
        width: 100%
    }

    .point-reward {
        font-family: 'Inter';
        background-color: #ECF5FC;
        display: inline-flex;
        padding: 5px 5px 5px 10px;
        border-radius: 5px;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: center;
        align-items: center;
        align-content: stretch;
        font-size: 18px;
        font-weight: 700;

        &:first-child {
            margin-right: 5px;
        }

        img {
            width: 30px;
        }
    }

    .content {
        position: relative;
        padding-top: 20px;
        width: 100%;
        font-family: 'Inter';

        &::before {
            content: '';
            background-image: linear-gradient(90deg, #000 25%, #fff 100%);
            position: absolute;
            left: 0;
            top: 10px;
            width: 100%;
            height: 2px;
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
        background-color: #E6F5DF;
        padding: 10px;
        text-align: center;
        font-family: 'Inter';
        border-radius: 5px;

        span {
            text-transform: uppercase;
            font-size: 14px;
        }
    }

    .reset {
        width: 100%;
        margin-top: 5px;
        text-transform: uppercase;
        color: #000;
        font-size: 14px;
        font-family: 'Inter';
    }

    .score {
        background-color: #ECF5FC;
        font-family: 'Inter';
        border-radius: 5px;
        font-size: 14px;
        height: calc(50% - 2.5px);
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        align-content: stretch;

        &:first-child {
            margin-bottom: 5px;
        }

        span {
            color: #000;
            text-transform: uppercase;

            &:last-child {
                font-size: 22px;
                display: block;
                font-weight: bold;
            }
        }
    }
}

.el-row {
    width: 100% !important
}
</style>

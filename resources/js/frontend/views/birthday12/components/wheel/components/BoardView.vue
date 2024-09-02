<template>
    <div class="wrap-board">
        <el-row>
            <el-col :span="12">
                <div class="board">
                    <div v-for="(r_item, r_i) in board.cells" :key="r_i">
                        <cell v-for="(c_item, c_i) in r_item" :key="c_i"></cell>
                    </div>
                    <tile-view v-for="(tile, i) in tiles" :tile="tile" :key="i"> </tile-view>
                    <game-end-overlay :board="board" :onrestart="onRestart" :onsubmit="submitScore"></game-end-overlay>
                </div>
            </el-col>
            <el-col :span="12">
                <div class="infoGame">
                    <el-row :gutter="20">
                        <el-col :span="12">
                            <div class="wrap-header">
                                <h1 class="title-2048">2048</h1>
                                <div class="reward">
                                    <span class="point-reward"></span>
                                    <span class="point-reward">{{ dataBoard.pointKimTo.value }}</span>
                                </div>
                            </div>

                        </el-col>
                    </el-row>
                    <el-row :gutter="20">
                        <el-col :span="12">
                            <div>
                                <p>Điều hướng các ô số guống nhập thành số chắn lớn hơn trong 5 phút. Điểm càng cao nhận
                                    càng
                                    nhiều Kim Tơ</p>
                                <p><strong></strong>*Số Kim Tơ quy đổi theo từng mnosc điểm in game:</p>
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
                    <el-row :gutter="20">
                        <el-col :span="12">
                            <div class="countDown">
                                <span>countdown</span>
                                <Countdown :deadline="`${dataBoard.deadline.value}`" :showLabels="false"
                                    :showDays="false" :showHours="false" mainFlipBackgroundColor="#fff"
                                    secondFlipBackgroundColor='#fff' mainColor="#000" secondFlipColor="#000" />
                            </div>
                            <div class="play-again">
                                <el-button type="warning" class="reset" @click="onRestart">Play Again</el-button>
                            </div>
                        </el-col>
                        <el-col :span="12">
                            <div class="score">
                                <span>Current score</span>
                                <span> {{ score }}</span>
                            </div>
                            <div class="score">
                                <span>Best score</span>
                                <span>25008</span>
                            </div>
                        </el-col>
                    </el-row>
                </div>
            </el-col>
        </el-row>
    </div>
</template>

<script>
import Cell from "./Cell.vue";
import TileView from "./TileView.vue";
import GameEndOverlay from "./GameEndOverlay.vue";
import { Board } from "../board";
import { onMounted, onBeforeUnmount, ref, computed } from "vue";
import RepositoryFactory from '@frontend/utils/RepositoryFactory';
const game2048Repository = RepositoryFactory.get('game2048');
import { Countdown } from 'vue3-flip-countdown';
import moment from 'moment';
const levels = [
    { min: 0, max: 1489, levelKey: 'lv1' },
    { min: 1500, max: 1998, levelKey: 'lv2' },
    { min: 2000, max: 2498, levelKey: 'lv3' },
    { min: 2500, max: 2998, levelKey: 'lv4' },
    { min: 3000, max: 3498, levelKey: 'lv5', bonus: true }
];
let minutes = 1; // set minutes coundown
const createDefaultData = () => {
    return {
        startTime: moment().format('YYYY-MM-DD HH:mm:ss'),
        endTime: null, // end time
        deadline: ref(moment().add(minutes, 'minutes').format('YYYY-MM-DD HH:mm:ss')),
        timer: null, // timer interval
        intervalData: null, // reset interval
        countMinutes: Math.round(moment().add(minutes, 'minutes').diff(moment()) / 1000), // count seconds
        pointKimTo: ref(0),
        levelKimTo: {
            'lv1': { 'point': 5, 'check': true },
            'lv2': { 'point': 10, 'check': true },
            'lv3': { 'point': 15, 'check': true },
            'lv4': { 'point': 20, 'check': true },
            'lv5': { 'point': 25, 'check': true }
        },
        scoreBonnus: 0, // kiểm tra điểm bonnus nếu score đạt trên 3500 bắt đầu tính toán để cộng dồn kimto
        kimToBonnus: 5, // set giá trị mặc định của kim tơ
        start: true,
        pointMaxBonnus: 3500,
        pointBonnus: 500
    };
};
export default {
    setup() {
        const board = ref(new Board());
        console.log('board', board);
        const createDefaultData = () => {
            return {
                startTime: moment().format('YYYY-MM-DD HH:mm:ss'),
                endTime: null, // end time
                deadline: ref(moment().add(minutes, 'minutes').format('YYYY-MM-DD HH:mm:ss')),
                timer: null, // timer interval
                intervalData: null, // reset interval
                countMinutes: Math.round(moment().add(minutes, 'minutes').diff(moment()) / 1000), // count seconds
                pointKimTo: ref(0),
                levelKimTo: {
                    'lv1': { 'point': 5, 'check': true },
                    'lv2': { 'point': 10, 'check': true },
                    'lv3': { 'point': 15, 'check': true },
                    'lv4': { 'point': 20, 'check': true },
                    'lv5': { 'point': 25, 'check': true }
                },
                scoreBonnus: 0, // kiểm tra điểm bonnus nếu score đạt trên 3500 bắt đầu tính toán để cộng dồn kimto
                kimToBonnus: 5, // set giá trị mặc định của kim tơ
                start: true,
                pointMaxBonnus: 3500,
                pointBonnus: 500
            };
        };
        let dataBoard = createDefaultData();

        const handleKeyDown = (event) => {
            if (board.value.hasWon()) {
                return;
            }

            if (!dataBoard.start) return;

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
                    console.log('countMinutes', dataBoard.countMinutes);
                    clearInterval(dataBoard.timer);
                    console.log('Hết thờ gian');
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
            dataBoard.pointKimTo.value = 0;
            dataBoard.scoreBonnus = 0;
            dataBoard.start = true;
            dataBoard.levelKimTo = {
                'lv1': { 'point': 5, 'check': true },
                'lv2': { 'point': 10, 'check': true },
                'lv3': { 'point': 15, 'check': true },
                'lv4': { 'point': 20, 'check': true },
                'lv5': { 'point': 25, 'check': true }
            };

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
            board.value = new Board();
            if (dataBoard.countMinutes > 0 && score > 0)
                submitScore();
            resetTimer();
        };

        const submitScore = async () => {
            dataBoard.start = false;
            clearInterval(dataBoard.timer);
            clearInterval(dataBoard.intervalData);
            dataBoard.endTime = moment().format('YYYY-MM-DD HH:mm:ss');
            try {
                let formData = {
                    score: board.value.score,
                    start: dataBoard.startTime,
                    end: dataBoard.endTime
                }
                const { data } = await game2048Repository.create(formData);
                console.log('data', data);
            } catch (error) {
                console.error('error', error);
            }

        }

        onMounted(() => {
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
            return board.value.score;
        });

        const calculatePoint = (score) => {
            levels.forEach(level => {
                const currentLevel = dataBoard.levelKimTo[level.levelKey];
                if (score > level.min && score <= level.max && currentLevel.check) {
                    dataBoard.pointKimTo.value += currentLevel.point;
                    currentLevel.check = false;
                    if (level.bonus) {
                        dataBoard.scoreBonnus = score;
                    }
                }
            });

            if (dataBoard.scoreBonnus > dataBoard.pointMaxBonnus && score - dataBoard.scoreBonnus >= dataBoard.pointBonnus) {
                dataBoard.pointKimTo.value += dataBoard.kimToBonnus;
                dataBoard.scoreBonnus = score;
            }

        };

        return {
            board,
            onRestart,
            tiles,
            score,
            submitScore,
            dataBoard
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
<style scoped>
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
    left: -10px;
    font-size: 3rem;
    top: 50%;
    transform: translate(0px, -50%);
}
</style>

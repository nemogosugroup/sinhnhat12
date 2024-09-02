<template>
    <div class="overlay" v-show="show">
        <div v-html="contents"></div>
        <!-- <p class="message">{{ contents }}</p>
    <button class="tryAgain" @click="restart">Try again</button> -->
    </div>
</template>

<script>
import { toRefs, ref, computed } from "vue";
export default {
    props: {
        board: {
            type: Object,
            required: true,
        },
        onrestart: {
            type: Function,
            required: true,
        },
        onsubmit: {
            type: Function,
            required: true,
        },
    },
    setup(props) {
        const { board } = toRefs(props);
        const show = computed(() => {
            return board.value.hasWon() || board.value.hasLost();
        });
        const contents = computed(() => {
            if (board.value.hasWon()) {
                props.onsubmit && props.onsubmit();
                return "<div class='youWin'></div>";
            } else if (board.value.hasLost()) {
                props.onsubmit && props.onsubmit();
                return "<div class='gameOver'></div>";
            } else {
                return "";
            }
        });
        const restart = () => {
            props.onrestart && props.onrestart();
        }
        return {
            show,
            contents,
            restart,
        }
    },
};
</script>

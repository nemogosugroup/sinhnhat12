<template>
    <el-dialog class="box-slogan" v-model="showSlogan" :show-close="false" width="1070" align-center
        @close="handleClose">
        <template #header="{ close, titleId }">
            <div class="header-dialog">
                <h4 :id="titleId" class="title-form">
                    <VueTyped v-if="isShowTitle" :strings="typedStrings" :typeSpeed="50" :backSpeed="30" :loop="false"
                        :onComplete="handleComplete">
                    </VueTyped>
                </h4>
                <span v-if="isShowClose" class="button-close" @click="close"></span>
            </div>
        </template>
        <div class="content">
            <span v-if="!isShowTitle" class="icon_row" @click="handleShowTitle"></span>
            <VueTyped v-if="isTyped" :strings="typedContent" :typeSpeed="50" :backSpeed="30" :loop="false"
                :onComplete="handleCompleteAll">
            </VueTyped>
        </div>
    </el-dialog>
</template>

<script>
export default {
    //components: { VueTypedJs },
    props: {
        showSlogan: {
            required: true,
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            typedStrings: ['CHÀO MỪNG ĐẾN VỚI <br />CÔNG VIÊN MẶT TRĂNG GOSU!'],
            typedContent: ['Dưới ánh trăng rằm lung linh, hãy dừng chân tại Cổng Moonwalk <br />để khám phá Thể Lệ nhé! Điều này sẽ giúp bạn chuẩn bị tốt hơn <br />trước khi bắt đầu hành trình tham gia những trò chơi đầy hấp <br /> dẫn và bất ngờ đang chờ đợi phía trước. 🌕🎉'],
            isShow: this.showSlogan,
            isShowTitle: false,
            isTyped: false,
            isShowClose: false
        }
    },
    created() {
        this.emitter.off("login-complete");
    },
    computed: {
        showSlogan(newValue) {
            return newValue.showSlogan
        }
    },
    mounted() {
        this.emitter.on("login-complete", data => {
            this.isShow = data
        });
    },
    methods: {
        handleClose() {
            console.log('Dialog closed');
            //this.showSlogan = false;
            window.location.href = "/";
        },
        handleComplete() {
            this.isTyped = true;
        },
        handleCompleteAll() {
            this.isShowClose = true;
        },
        handleShowTitle() {
            this.isShowTitle = true
        }
    }
}
</script>
<style lang="scss" scoped>
.icon_row {
    //position: absolute;
    width: 120px;
    height: 95px;
    background-image: url("../../../assets/images/birthday12/map/right_arrow.png");
    background-repeat: no-repeat;
    background-size: contain;
    display: block;
    transform: rotate(90deg);
    cursor: pointer;
    animation: bounce 1s infinite, blink 1s infinite;
}

@keyframes bounce {
    0% {
        transform: translateX(0);
    }

    50% {
        transform: translateX(10px);
    }

    100% {
        transform: translateX(0);
    }
}
</style>

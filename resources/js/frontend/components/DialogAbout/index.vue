<template>
    <el-dialog class="box-slogan" v-model="isShow" :show-close="false" width="1070" align-center @close="handleClose">
        <template #header="{ close, titleId }">
            <div class="header-dialog">
                <h4 :id="titleId" class="title-form">
                    <VueTyped :strings="typedStrings" :typeSpeed="50" :backSpeed="30" :loop="false"
                        :onComplete="handleComplete">
                    </VueTyped>
                </h4>
                <span v-if="isShowClose" class="button-close" @click="close"></span>
            </div>
        </template>
        <div class="content">
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
            this.isShow = false;
        },
        handleComplete() {
            this.isTyped = true;
        },
        handleCompleteAll() {
            this.isShowClose = true;
        },
    }
}
</script>

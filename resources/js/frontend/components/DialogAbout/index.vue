<template>
    <el-dialog class="box-slogan" v-model="showSlogan" :show-close="false" width="1070" align-center
               @close="handleClose">
        <template #header="{ close, titleId }">
            <div class="header-dialog">
                <h1 class="title">{{ "THÔNG BÁO" }}</h1>
                <span class="button-close" @click="close"></span>
            </div>
        </template>
        <div class="content">
            <h4 class="title-form">
                <VueTyped :strings="typedStrings" :typeSpeed="25" :backSpeed="30" :loop="false"
                          :onComplete="handleComplete">
                </VueTyped>
            </h4>
            <VueTyped v-if="isTyped" :strings="typedContent" :typeSpeed="25" :backSpeed="30" :loop="false"
                      :onComplete="handleCompleteAll">
            </VueTyped>
        </div>
    </el-dialog>
</template>

<script>
export default {
    props: {
        showSlogan: {
            required: true,
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            typedStrings: ['<b style="font-weight: 700;font-size: 22px;width: 100%;display: block;text-align: center;padding-top: 15px;">Chào mừng các Thỏ Ngọc đến Công Viên Mặt Trăng GOSU!</b>'],
            typedContent: ['<span style="font-size: 20px;width: 85%;margin: 0 auto;display: block;text-align: center;position: relative;top: 15px;">Hãy xem Thể Lệ tại <b style="font-weight: 700">Thố Động</b> trước khi tham gia các hoạt động thú vị ở đây nhé!<br>🌕🎉</span>'],
            isShow: this.showSlogan,
            isTyped: false
        }
    },
    created() {
        this.emitter.off("login-complete");
    },
    computed: {
        showSlogan(newValue) {
            return newValue.showSlogan;
        }
    },
    mounted() {
        this.emitter.on("login-complete", data => {
            this.isShow = data
        });
    },
    methods: {
        handleClose() {
            this.emitter.emit("clicked-logout", false);
        },
        handleComplete() {
            this.isTyped = true;
        },
        handleCompleteAll() {
            //this.isShowClose = true;
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
    font-size: 18px;
    color: #28657D;
    background-image: url('../../../assets/images/eventBirthday2024/bg_title_slogan.svg');
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
    position: absolute;
    top: -45px;
    width: 100%;
}

.icon_row {
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

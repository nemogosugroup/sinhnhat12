<template>
    <div>
        <h1 class="title">{{ "NỘI QUY CÔNG VIÊN" }}</h1>
        <div class="content_wrapper">
            <div id="rules" class="content">
                <ol type="I">
                    <li>
                        <strong>Thể lệ:</strong>
                        <ol>
                            <li>
                                <strong>Đối tượng tham gia:</strong>
                                <ol>
                                    <li>Toàn thể nhân sự Công ty GOSU: chính thức + thử việc.</li>
                                </ol>
                            </li>
                            <li>
                                <strong>Thời gian bắt đầu sự kiện:</strong>
                                <ol>
                                    <li>Bắt đầu: 00:00AM, ngày 18/9/2024</li>
                                    <li>Kết thúc: 17h00, ngày 21/9/2024</li>
                                </ol>
                            </li>
                            <li>
                                <strong>Cách thức tham gia:</strong>
                                <ol>
                                    <li>Bước 1: Đăng ký tham gia công viên bằng cách vào trang sự kiện và đăng nhập tài
                                        khoản
                                        GOSU
                                    </li>
                                    <li>Bước 2: Bắt đầu khám phá các khu vui chơi trong công viên và hoàn thành các
                                        Nhiệm vụ
                                        hàng ngày
                                    </li>
                                </ol>
                            </li>
                        </ol>
                    </li>
                    <li>
                        <strong>Công viên ánh trăng GOSU có gì?</strong>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam,  
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    name: 'NguyetNhuTab',
    components: {},
    data() {
        return {}
    },
    filters: {},
    created() {
    },
    watch: {},
    methods: {}
}

</script>
<style lang="scss" scoped>
.title {
    font-family: Beaufort, serif;
    text-align: center;
    padding: 10px 0;
    margin: 5px 0 10px;
    font-size: 30px;
    color: #28657D;
    background-image: url('../../../../../../assets/images/eventBirthday2024/bg_title_nguyet_nhu.svg');
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
}

.content_wrapper {
    height: 475px;
    overflow-y: auto;
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
    padding: 5px;
    border-radius: 10px;

    &::-webkit-scrollbar {
        width: 1em;
    }

    &::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
    }

    &::-webkit-scrollbar-thumb {
        background: #60A8AC;
        border-radius: 10px;
    }

    .content {
    }

    #rules {
        font-size: 22px;
        ol {
            li {
                &::marker,
                > strong {
                    color: #5B4216;
                    margin-bottom: 10px;
                    display: block;
                }
                ol {
                    li {
                        &::marker,
                        strong {
                            font-weight: bold;
                            color: #5B4216;
                        }
                        ol {
                            list-style-type: disc;
                            margin-bottom: 20px;
                        }
                    }
                }
            }
        }
        p { margin: 0; }
    }
}
</style>
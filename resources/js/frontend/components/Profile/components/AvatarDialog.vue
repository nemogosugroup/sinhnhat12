<template>
    <el-dialog v-model="isShowDialog" class="custom_el_dialog"
               style="width: 100%; height: 100%; background-color: transparent; box-shadow: none; margin: 0 auto"
               :show-close="false" @close="closeDialog">
        <div class="custom_dialog"
             :style="`background-image: url(${dialogElm.DialogAvatarBg})`">
            <div class="custom_close_btn">
                <img @click="closeDialog" :src="dialogElm.DialogCloseBtn" alt="">
            </div>

            <div class="custom_content">
                <div id="userAvatar">
                    <div class="user_avatar" :style="`background-image: url(${tmpAvatar})`">
                        <img class="avatar_frame" :src="dialogElm.AvatarFrame" alt="">
                    </div>
                </div>
                    <div class="btn_upload">
                        <el-button type="primary" @click="uploadAndCrop">Thay Đổi</el-button>
                    </div>
                <div class="btn_download">
                    <el-button type="primary" @click="screenshotAndDownloadAvatar">Tải Xuống</el-button>
                </div>
            </div>
        </div>
    </el-dialog>
</template>
<script>

import DialogAvatarBg from "@/assets/images/eventBirthday2024/avatar_popup.png";
import DialogCloseBtn from "@/assets/images/eventBirthday2024/icon_close.svg";
import AvatarFrame from "@/assets/images/eventBirthday2024/avatar_frame.png";
import DefaultAvatar from '@/assets/images/eventBirthday2024/default_avatar.svg';

import RepositoryFactory from '@frontend/utils/RepositoryFactory';
import {mapGetters} from "vuex";
const game2048Repository = RepositoryFactory.get('game2048');
import html2canvas from 'html2canvas';
export default {
    name: 'AvatarDialog',
    components: {},
    props: {
        dialogVisible: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            isShowDialog: this.dialogVisible,
            tmpAvatar: null,
            dialogElm: {
                DialogAvatarBg: DialogAvatarBg,
                DialogCloseBtn: DialogCloseBtn,
                AvatarFrame: AvatarFrame,
                DefaultAvatar: DefaultAvatar
            }
        }
    },
    filters: {},
    created() {
    },
    mounted() {
        //this.tmpAvatar = this.user?.avatar ?? this.dialogElm.DefaultAvatar; TODO: keep this for update login with local avatar file path

        // tmp handle TODO: re-handle after update first-time login
        const parts = this.user.avatar.split("/");
        this.tmpAvatar = `/static/uploads/avatar/${this.user.profile_id}/${parts[parts.length - 1]}`;
    },
    computed: {
        ...mapGetters(["user"]),
    },
    watch: {
        dialogVisible(newValue) {
            this.isShowDialog = newValue;
        }
    },
    methods: {
        uploadAndCrop() {

        },
        screenshotAndDownloadAvatar() {
            html2canvas(document.getElementById("userAvatar"), {
                scale: 1,
                width: 550,
                height: 550
            })
                .then(canvas => {
                    this.imageUrl = canvas.toDataURL('image/jpeg', 1.0);
                    this.tmpAvatar = this.imageUrl;
                });
        },
        closeDialog() {
            this.isShowDialog = false;
            this.$emit('hideDialog', {});
        },
        async setFirstTimeToFalse() {
            const {data} = await game2048Repository.setFirstTimeToFalse();
            if (data.success) {
                console.log('end first-time for user')
            }
        }
    }
}

</script>
<style lang="scss" scoped>
.custom_dialog {
    font-family: "Myriad Pro", serif;
    position: relative;
    width: 100%;
    height: 90vh;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    padding: 200px 600px 85px 580px;

    .custom_close_btn {
        position: relative;
        float: right;
        right: -30px;
        top: -30px;
        cursor: pointer;
        z-index: 9;

        img {
            transition: all .3s ease-in-out;
        }

        &:hover {
            img {
                transform: scale(1.15);
            }
        }
    }

    .custom_content {
        position: relative;
        #userAvatar {
            .user_avatar {
                width: 550px;
                height: 550px;
                background-size: 100%;
                background-repeat: no-repeat;
                background-position: center;
                border-radius: 5px;
                .avatar_frame {
                    height: 550px;
                    width: 550px;
                    border-radius: 5px;
                    background-color: transparent;
                }
            }
        }

        .btn_upload {
            position: absolute;
            top: 40%;
            right: 20px;
        }

        .btn_download {
            position: absolute;
            top: 60%;
            right: 20px;
        }
    }
}
</style>

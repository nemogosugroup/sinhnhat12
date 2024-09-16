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
                    <el-button type="primary" @click="uploadAndCrop">
                        <i class="ri-refresh-line"></i>Thay Đổi
                    </el-button>
                    <input :id="`uploadInput`" type="file" accept="image/*"
                           style="display: none"
                           @change="(event) => handleUpload(event)">
                </div>
                <div class="btn_submit">
                    <el-button
                        v-if="isAfterCropped"
                        type="success"
                        @click="submitChangeAvatar"
                        :loading="isLoadingChangeAvatar"
                    ><i class="ri-check-line"></i>Xác Nhận</el-button>
                </div>
                <div class="btn_download">
                    <el-button
                        type="primary"
                        @click="screenshotAndDownloadAvatar"
                        :loading="isLoadingDownload"
                    >
                        <i class="ri-file-download-line"></i>Tải Xuống
                    </el-button>
                </div>
            </div>
        </div>
    </el-dialog>

    <dialog-crop
        :dialog-crop-visible="dialogCropVisible"
        :data="dataCrop"
        @hidedialog="handleHideCropDialog"
    ></dialog-crop>

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
import DialogCrop from "@frontend/components/Profile/components/DialogCrop.vue";
import {ElMessage} from "element-plus";

export default {
    name: 'AvatarDialog',
    components: {DialogCrop},
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
            isLoadingDownload: false,
            isLoadingChangeAvatar: false,
            dialogElm: {
                DialogAvatarBg: DialogAvatarBg,
                DialogCloseBtn: DialogCloseBtn,
                AvatarFrame: AvatarFrame,
                DefaultAvatar: DefaultAvatar
            },
            dialogCropVisible: false,
            dataCrop: "",
            tmpFile: null,
            isAfterCropped: false
        }
    },
    filters: {},
    created() {
        this.emitter.off('send-cropped-image');
    },
    mounted() {
        this.tmpAvatar = this.user?.avatar ?? this.dialogElm.DefaultAvatar;
        this.emitter.on('send-cropped-image', data => {
            this.tmpAvatar = data.blob;
            this.tmpFile = this.dataURLtoFile(this.tmpAvatar, `avatar_${this.user.profile_id}.jpg`);
            this.isAfterCropped = true;
        });
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
            const input = document.getElementById('uploadInput');
            input.value = null;
            input.click();
        },
        handleUpload(event) {
            this.tmpFile = event.target.files[0] ?? null;
            if (this.tmpFile) {
                const type = this.tmpFile.type;

                if (type.includes("image")) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.handleShowCropDialog(e.target.result);
                    };
                    reader.readAsDataURL(this.tmpFile);

                }
            }
        },
        screenshotAndDownloadAvatar() {
            this.isLoadingDownload = true;
            html2canvas(document.getElementById("userAvatar"), {
                scale: 1,
                width: 550,
                height: 550
            })
                .then(canvas => {
                    this.imageUrl = canvas.toDataURL('image/jpeg', 1.0);
                    this.tmpAvatar = this.imageUrl;

                    const now = new Date();
                    const formattedDate = now.toLocaleDateString('vi-VN');
                    const formattedTime = now.toLocaleTimeString('vi-VN');
                    const name = `${this.user.fullname} - Sinh Nhật GOSU 12 - ${formattedDate} ${formattedTime}.jpg`;

                    const file = this.dataURLtoFile(this.tmpAvatar, name);
                    const url = URL.createObjectURL(file);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = name;
                    link.click();

                    URL.revokeObjectURL(url);
                    this.isLoadingDownload = false;
                });
        },
        dataURLtoFile(dataURL, filename) {
            let arr = dataURL.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[arr.length - 1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);
            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new File([u8arr], filename, {type: mime});
        },
        closeDialog() {
            this.isShowDialog = false;
            this.$emit('hideDialog', {});
        },
        handleHideCropDialog() {
            this.dialogCropVisible = false;
            this.dataCrop = "";
        },
        handleShowCropDialog(dataCrop) {
            this.dataCrop = dataCrop;
            this.dialogCropVisible = true;
        },
        async submitChangeAvatar() {
            this.isLoadingChangeAvatar = true;
            let formData = new FormData();
            formData.append("new_avatar", this.tmpFile);
            const {data} = await game2048Repository.changeAvatar(formData);
            if (data.success) {
                this.tmpAvatar = data.avatar;
                this.user.avatar = data.avatar;
                ElMessage.success(data.message);
                this.isAfterCropped = false;
            } else {
                ElMessage.error('Đã có lỗi xảy ra!');
            }
            this.isLoadingChangeAvatar = false;
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
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                filter: drop-shadow(0px 0px 4px #000);

                .avatar_frame {
                    height: 550px;
                    width: 550px;
                    background-color: transparent;
                }
            }
        }

        .btn_upload {
            position: absolute;
            top: 35%;
            right: 20px;
        }

        .btn_submit {
            position: absolute;
            top: 45%;
            right: 20px;
        }

        .btn_download {
            position: absolute;
            top: 60%;
            right: 20px;
        }

        :deep(.el-button) {
            height: 40px;
            width: 100px;
             i {
                 position: relative;
                 right: 5px;
             }
        }
    }
}
</style>

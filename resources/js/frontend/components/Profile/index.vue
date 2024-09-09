<template>
    <div class="app-wrapper">
        <div class="map_user_board" :style="`background-image: url(${mapElm.MapBgUserBoard})`">
            <el-row>
                <el-col :span="4">
                    <el-avatar :size="50" :src="user.avatar">
                        <img :src="mapElm.DefaultAvatar" alt="" />
                    </el-avatar>
                </el-col>
                <el-col :span="6">
                    <span>{{ "Xin chào" }}</span>
                </el-col>
                <el-col :span="10">
                    <b>{{ user.fullname ? user.fullname : "Gosu 2024" }}</b>
                </el-col>
                <el-col :span="4">
                    <a @click="handleLogout">{{ "Thoát" }}</a>
                </el-col>
            </el-row>
        </div>
    </div>
    <!--  -->
</template>

<script>
import { mapGetters } from "vuex";
import DefaultAvatar from '@/assets/images/eventBirthday2024/default_avatar.svg'
export default {
    name: "Profile",
    components: {},
    data() {
        return {
            mapElm: {
                DefaultAvatar: DefaultAvatar,
            }
        };
    },
    watch: {
    },
    created() {
    },
    mounted() {

    },
    destroyed() {
    },
    computed: {
        ...mapGetters(["user"]),
    },
    methods: {
        async handleLogout() {
            await this.$store.dispatch("user/logout");
            this.emitter.emit("clicked-logout", true);
            this.$router.push(`/login`);
        }
    },
};
</script>

<style lang="scss" scoped>
.map_user_board {
    height: 65px;
    min-width: 360px;
    padding: 5px 5px;
    background-repeat: no-repeat;
    text-align: center;
    border: 1px solid #123e544f;
    border-radius: 45px;
    background-color: #3b647966;

    .el-avatar {
        border: 2px solid #fff;
        box-shadow: 0 4px 7px #00000070;

        img {
            object-fit: cover;
        }
    }

    .el-col {
        &:not(:first-child) {

            span,
            b,
            a {
                position: relative;
                top: 16px;
                color: #fff;
                font-size: 18px;
            }
        }

        &:last-child {
            a {
                position: relative;

                &:before {
                    content: "";
                    height: 20px;
                    width: 1px;
                    background: #fff;
                    position: absolute;
                    left: -8px;
                    top: 1px;
                }
            }
        }
    }
}
</style>

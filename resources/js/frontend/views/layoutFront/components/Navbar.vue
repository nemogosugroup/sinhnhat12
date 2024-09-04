<template>
    <div class="navbar">
        <Logo :isLogin="isLogin" />
        <div class="right-menu">
            <Menu :isLogin="isLogin"></Menu>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import Logo from "@frontend/components/Logo";
import Menu from "@frontend/components/Menu";
import avatarDefault from "@/assets/images/logo/avatar.gif";
export default {
    components: {
        Logo,
        Menu
    },
    data() {
        return {
            isLogin: false
        }
    },
    computed: {
        ...mapGetters(["sidebar", "device", "user"]),
        avatar() {
            let avatar = this.user.avatar;
            return avatar ? avatar : avatarDefault;
        },
        variables() {
            return variables;
        },
    },
    created() {
        this.checkLogin();
        this.emitter.off("clicked-logout");
    },
    mounted() {
        this.emitter.on("clicked-logout", val => {
            this.isLogin = val;
        });
    },
    methods: {
        toggleSideBar() {
            this.$store.dispatch("app/toggleSideBar");
        },
        async logout() {
            await this.$store.dispatch("user/logout");
            //this.$router.push(`/login?redirect=${this.$route.fullPath}`);
            this.$router.push(`/login`);
        },
        checkLogin() {
            if (this.user.id === null || this.user.id === undefined) {
                this.isLogin = true;
            }
        }
    },
};
</script>

<style lang="scss" scoped>
.navbar {
    overflow: hidden;
    position: relative;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;

    .right-menu {
        float: right;
        height: 100%;

        &:focus {
            outline: none;
        }

        .right-menu-item {
            display: inline-block;
            padding: 0 8px;
            height: 100%;
            font-size: 18px;
            color: #5a5e66;
            vertical-align: text-bottom;

            &.hover-effect {
                cursor: pointer;
                transition: background 0.3s;

                &:hover {
                    background: rgba(0, 0, 0, 0.025);
                }
            }
        }

        .avatar-container {
            margin-right: 30px;

            .avatar-wrapper {
                margin-top: 5px;
                position: relative;

                .user-avatar {
                    cursor: pointer;
                    width: 40px;
                    height: 40px;
                    border-radius: 10px;
                }

                .el-icon-caret-bottom {
                    cursor: pointer;
                    position: absolute;
                    right: -20px;
                    top: 25px;
                    font-size: 12px;
                }
            }
        }
    }
}
</style>

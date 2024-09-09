<template>
    <div class="wrap-menu">
        <ul :class="`menu ${color}`">
            <li><a href="https://gosucorp.vn/vi" target="_blank">Gosucorp</a></li>
            <li><a href="https://s20.gosu.vn/news" target="_blank">S20</a></li>
            <li><a href="#" @click="goToBachNhat">Bách Nhật</a></li>
            <li><a href="https://www.facebook.com/groups/gosu.s20" target="_blank">Facebook</a></li>
        </ul>
    </div>
</template>

<script>

import { mapGetters } from "vuex";

export default {
    props: {
        isLogin: {
            required: true,
            type: Boolean,
            default: false
        }
    },
    name: "Menu",
    data() {
        return {
            color: 'white'
        }
    },
    created() {
    },
    mounted() {
    },
    watch: {},
    computed: {
        ...mapGetters(["user"]),
        isWhiteColor() {
            return this.$router.currentRoute.value.name === "BachNhat" || this.isLogin;
        }
    },
    methods: {
        goToBachNhat() {
            this.$router.push(`/bachnhat`);
        }
    }
}
</script>

<style lang="scss" scoped></style>

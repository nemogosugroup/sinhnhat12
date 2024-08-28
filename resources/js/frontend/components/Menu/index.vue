<template>
    <div class="wrap-menu">
        <ul :class="`menu ${isLogin ? color : ''}`">
            <li><a href="https://gosucorp.vn/vi" target="_blank">Gosucorp</a></li>
            <li><a href="https://s20.gosu.vn/news" target="_blank">S20</a></li>
            <li><a href="#" target="_blank">Bách Nhật</a></li>
            <li><a href="https://www.facebook.com/groups/gosu.s20" target="_blank">Facebook</a></li>
        </ul>
    </div>
</template>

<script>

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
}
</script>

<style lang="scss" scoped></style>

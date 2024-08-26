<template>
    <div class="wrap-menu">
        <ul :class="`menu ${color}`">
            <li><a href="https://gosucorp.vn/vi" target="_blank">Gosucorp</a></li>
            <li><a href="https://s20.gosu.vn/news" target="_blank">S20</a></li>
            <li><a href="#" target="_blank">Bách Nhật</a></li>
            <li><a href="https://www.facebook.com/groups/gosu.s20" target="_blank">Facebook</a></li>
        </ul>
    </div>
</template>

<script>

export default {
    name: "Menu",
    data() {
        return {
            color: 'white'
        }
    },
    created() {
        //this.emitter.off("");
    },
    mounted() {
        // this.emitter.on("", data => {
        //     this.color = data;
        // });
    },
}
</script>

<style lang="scss" scoped></style>

<template>
    <div>
        <h1>CAVE CONTENT</h1>
    </div>
</template>
<script>
import NguyetNhu from "@frontend/views/birthday12/components/cave/tabs/nguyet_nhu.vue";
import NguyetNhiem from "@frontend/views/birthday12/components/cave/tabs/nguyet_nhiem.vue";
import NguyetThach from "@frontend/views/birthday12/components/cave/tabs/nguyet_thach.vue";
import NguyetKy from "@frontend/views/birthday12/components/cave/tabs/nguyet_ky.vue";

export default {
    name: 'Cave',
    components: {
        NguyetNhu,
        NguyetNhiem,
        NguyetThach,
        NguyetKy
    },
    props: {
        caveType: {
            type: String,
            default: null // nguyet_nhu, nguyet_nhiem, nguyet_thach, nguyet_ky
        }
    },
    data() {
        return {
        }
    },
    filters: {},
    created() {
        console.log(`From CAVE CONTENT, type = ${this.caveType}`)
    },
    watch: {},
    methods: {}
}

</script>
<style lang="scss" scoped>
</style>
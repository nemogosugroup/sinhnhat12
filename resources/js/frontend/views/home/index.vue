<template>
    <h1>Hello</h1>

</template>
<script>
import { ref } from 'vue'
import Pagination from '@frontend/components/Pagination'
import RepositoryFactory from '@frontend/utils/RepositoryFactory';
import { ElLoading } from 'element-plus';
export default {
    name: 'Home',
    components: {},
    data() {
        return {

            listData: [],
            listAlls: [],
            total: 0,
            zoom: 4,
            mapZoom: 12,
            listQuery: {
                page: 1,
                limit: 10,
                sort: 'desc',
                title: '',
            },
            listQueryAll: {
                sort: 'desc',
                title: '',
            },
            total: 0,
            infoWindowVisible: []
        }
    },
    computed: {
    },
    mounted() {

    },
    created() {
        //this.fetch();
    },

    methods: {
        async fetch() {

        },
    },
}
</script>
<style lang="scss" scoped>
@import "~@style/variables.scss";
</style>

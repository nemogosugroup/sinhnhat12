<template>
    <div class="app-container">
        <search-category :list-query="listQuery.title" @showdialog="handleShowDialog"
            @search="handleSearch"></search-category>
        <table-user @showdialog="handleShowDialog" :list="listData" :isShowCategory="isShowCategory"></table-user>
        <pagination v-show="total > 10" v-bind:total="total" v-model:page="listQuery.page" v-model:limit="listQuery.limit"
            layout="prev, pager, next" @pagination="fetch" />
    </div>
</template>
<script>
import { ref } from 'vue';
import SearchCategory from '@/backend/components/SearchCategory'
import Pagination from '@backend/components/Pagination';
import TableUser from '@/backend/components/DataUsers';
import RepositoryFactory from '@backend/utils/RepositoryFactory';
const userRepository = RepositoryFactory.get('user');
import { ElLoading } from 'element-plus';
export default {
    name: 'Users',
    components: { Pagination, TableUser, SearchCategory },
    data() {
        return {
            total: 0,
            listQuery: {
                page: 1,
                limit: 10,
                sort: 'desc',
                title: '',
            },
            listData:[],
        }
    },
    computed: {
    },
    mounted() {
    },
    created() {
        this.fetch();
    },

    methods: {
        handleChangeZoom() {
            this.zoom = this.$refs.mapRef.map.zoom;
        },
        async fetch() {
            // const loading = ElLoading.service({
            //     lock: true,
            //     background: 'rgba(0, 0, 0, 0.7)'
            // });
            const { data } = await userRepository.list(this.listQuery);
            console.log('data', data);
            // loading.close();
            if (data.success) {
                const results = data.data.data;
                this.listData = results.map(item => {
                    return item
                });
                this.total = data.data.total;
            }
        },
        excerpt(desc, number) {
            if (desc && desc.length > 0) {
                desc = desc.split(' ');
                if (desc.length > number) {
                    desc = desc.slice(0, number).join(' ') + "...";
                } else {
                    desc = desc.join(' ')
                }
            }
            return desc;
        },
        //search
        handleSearch(data) {
            this.listQuery.page = 1;
            this.listQuery.limit = 20;
            this.fetch();
        },
    },
}
</script>
<style>
.marker-position {
    bottom: 35px;
    left: 0;
    position: relative;
}
</style>
<style lang="scss" scoped>
@import "~@style/variables.scss";

.search {
    width: calc(100% - 60px);
    margin: 30px 0 10px 40px;
}
</style>
<template>
    <div class="search">
        <h6 class="title-h6"> Nguyệt đa thần trụ</h6>
        <div>
            <el-select v-model="value" filterable clearable remote reserve-keyword placeholder="Tìm kiếm nhân sự"
                :remote-method="remoteMethod" :loading="loading" @change="handleChange">
                <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value" />
            </el-select>
        </div>
    </div>
</template>
<script>
import { Employee } from './data';
export default {
    name: "SearchEmployee",
    data() {
        return {
            list: [],
            options: [],
            value: null,
            loading: false,
        };
    },
    mounted() {
        this.list = Employee.map((item) => {
            return { value: item, label: item };
        });
    },
    methods: {
        remoteMethod(query) {
            if (query) {
                this.loading = true;
                setTimeout(() => {
                    this.loading = false;
                    this.options = this.list.filter((item) => {
                        return item.label.toLowerCase().includes(query.toLowerCase());
                    });
                }, 200);
            } else {
                this.options = [];
            }
        },
        handleChange() {
            console.log(this.value)
        }
    },
};
</script>
<style lang="scss" scoped>
.search {
    position: absolute;
    bottom: 20%;
    width: 230px;
    left: 0;
    transform: translateX(20%);

    .title-h6 {
        font-size: 18px;
        margin: 0 0 10px;
    }
}

.el-select-dropdown__item {
    color: #000;
    position: relative;
    display: flex;
    align-items: center;

    &:before {
        content: url(../../../assets/images/sinhnhat/icon_employee.png);
        width: 20px;
        height: 20px;
        margin-right: 5px;
    }
}

// el-select-dropdown__item is-hovering
.el-select {
    font-family: 'Inter';
}
</style>

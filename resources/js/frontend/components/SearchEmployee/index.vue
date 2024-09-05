<template>
    <div class="search">
        <h6 class="title-h6"> Nguyệt đa thần trụ</h6>
        <div>
            <el-select ref="employeeSelect" v-model="selectedEmployee" filterable clearable remote reserve-keyword
                placeholder="Tìm kiếm nhân sự" :remote-method="remoteMethod" :loading="loading" @change="handleChange">
                <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                    <span class="wrap-images">
                        <span class="images">
                            <img :src="item.avatar" alt="">
                        </span>
                        <span class="info">
                            <strong>{{ item.label }}</strong>
                            <span class="job">{{ item.job }}</span>
                        </span>
                    </span>
                </el-option>
            </el-select>
        </div>
    </div>
</template>
<script>
import { Employee } from './data';
export default {
    name: "SearchEmployee",
    props: {
        nameEmployee: {
            type: String,
            default: null
        }
    },
    data() {
        return {
            list: [],
            options: [],
            value: null,
            loading: false,
            selectedEmployee: this.nameEmployee
        };
    },
    watch: {
        nameEmployee(newValue) {
            this.selectedEmployee = newValue; // Cập nhật khi có thay đổi từ parent
        },
        selectedEmployee(newValue) {
            this.$emit('update:name-employee', newValue); // Truyền giá trị về parent khi el-select thay đổi
        }
    },
    mounted() {
        this.list = Employee.map((item) => {
            return { value: item.hoten, label: item.hoten, avatar: item.avatar, job: item.trungtam };
        });
    },
    methods: {
        remoteMethod() {
            if (this.selectedEmployee) {
                this.loading = true;
                setTimeout(() => {
                    this.loading = false;
                    this.options = this.list.filter((item) => {
                        return item.label.toLowerCase().includes(this.selectedEmployee.toLowerCase());
                    });
                }, 200);
            } else {
                this.options = [];
            }
        },
        handleChange() {
            console.log(this.value)
        },
        focusSelect() {
            this.$refs.employeeSelect.focus();
            this.$nextTick(() => {
                this.$refs.employeeSelect.toggleMenu(); // Mở menu dropdown
            });
        },
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
    height: 50px;
    line-height: 20px;

    .wrap-images {
        color: #000;
        position: relative;
        display: flex;
        align-items: center;
        font-weight: 700;

        .images {
            width: 30px;
            height: 30px;
            border-radius: 100%;
            display: inline-flex;
            margin-right: 3px;
            overflow: hidden;

            img {
                width: 100%;
                height: 100%;
            }
        }

        strong {
            font-weight: 700;
        }

        .job {
            font-weight: 400;
            display: block;
        }
    }

}

// el-select-dropdown__item is-hovering
.el-select {
    font-family: 'Inter';
}
</style>

<template>
    <div class="search">
        <div class="bg_border">
            <el-input v-model="selectedEmployee" @keyup="handleSearchEmployee" class="search-employee"
                ref="employeeSelect" style="max-width: 600px" placeholder="Search" @change="handleChange"
                :loading="loading">
                <template #append>
                    <i class="ri-search-line"></i>
                </template>
            </el-input>
        </div>
        <el-scrollbar ref="scrollbarRef" v-loading="loading" height="350px">
            <div class="listEmployee">
                <div class="item" v-for="(item) in listEmployee" :key="item.value">
                    <span class="wrap-images">
                        <span class="images">
                            <img :src="item.avatar" alt="">
                        </span>
                        <span class="info">
                            <strong>{{ item.label }}</strong>
                            <span class="job">{{ item.job }}</span>
                        </span>
                    </span>
                </div>
            </div>
        </el-scrollbar>
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
            selectedEmployee: null,
            isSearch: false,
            listEmployee: []
        };
    },
    watch: {
    },
    created() {
        this.emitter.off("search-dept");
    },
    mounted() {
        this.list = Employee.map((item) => {
            return { value: item.dept, label: item.fullname, avatar: item.avatar, job: item.jodid };
        });
        this.emitter.on("search-dept", (data) => {

            if (data == 'HCNS') {
                data = 'Hành chính nhân sự'
            }
            if (data == 'KTHT') {
                data = 'Kỹ thuật hạ tầng'
            }
            if (data == 'TCKT') {
                data = 'Tài chính kế toán'
            }
            this.selectedEmployee = data;

            this.handleSearchEmployee();
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
            //console.log(this.selectedEmployee)
        },
        focusSelect() {
            this.$refs.employeeSelect.focus();
        },
        handleSearchEmployee() {
            if (this.selectedEmployee.length >= 2) {
                let newStr = this.selectedEmployee.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                newStr = this.formatString(newStr);
                this.loading = true;
                console.log('newStr', newStr)
                this.listEmployee = this.list.filter((item) => {
                    return item.value.toLowerCase().includes(newStr.toLowerCase());
                });
                this.loading = false;
            } else {
                this.listEmployee = [];
            }
        },
        formatString(str) {
            str = str.toLowerCase();
            str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
            str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
            str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
            str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
            str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
            str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
            str = str.replace(/đ/g, "d");
            return str;
        }
    },
};
</script>
<style lang="scss" scoped>
.search {
    padding-left: 65px;

    .bg_border {
        background-image: url('../../../assets/images/eventBirthday2024/bg_border.png');
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-size: 100% 100%;
        position: relative;
        margin-bottom: 30px;
        max-width: 260px;
        min-width: 260px;
    }

    .search-employee {
        background-color: transparent;
        font-size: 18px;
        color: #fff;

        :deep(.el-input__wrapper) {
            background-color: transparent;
            border: 0;
            box-shadow: none;
            color: #fff;
            padding-left: 20px;
        }

        :deep(.el-input-group__append) {
            border: 0;
            background-color: transparent;
            box-shadow: none;
            cursor: pointer;
            color: #60a8ac;
            font-size: 24px;
        }

        :deep(.el-input__inner) {
            color: #fff;
        }

        :deep(.el-input__inner)::placeholder {
            opacity: 1;
            color: #fff;
        }
    }
}

:deep(.el-loading-mask) {
    background-color: transparent;
}

.el-select-dropdown__item {
    height: 50px;
    line-height: 20px;
}

.listEmployee {
    position: relative;

    .item {
        width: 100%;
    }

    .wrap-images {
        color: #000;
        position: relative;
        display: flex;
        align-items: center;
        font-weight: 700;
        background: #1a445c69;
        border-radius: 5px;
        padding: 5px 12px;
        margin-bottom: 10px;
        font-size: 18px;
        min-width: 240px;
        max-width: 240px;

        .images {
            min-width: 47px;
            max-width: 47px;
            height: 47px;
            border: 2px solid #fff;
            box-shadow: 0 4px 7px rgba(0, 0, 0, 0.4392156863);
            border-radius: 100%;
            display: inline-flex;
            margin-right: 12px;
            overflow: hidden;

            img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }

        strong {
            font-weight: 700;
            color: #b6ebec;
        }

        .job {
            font-weight: 400;
            display: block;
            color: #fff;
        }
    }
}

// el-select-dropdown__item is-hovering
.el-select {
    font-family: 'Inter';
}
</style>

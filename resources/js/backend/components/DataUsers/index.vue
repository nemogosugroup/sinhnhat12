<template>
    <el-table
        ref="dragTable"
        v-loading="isLoading"        
        row-key="id"
        border
        fit
        highlight-current-row
        style="width: 100%"
        @selection-change="handleSelectionChange"
        v-bind:data="list"
    >
        <!-- icon -->
        <el-table-column min-width="50px" label="Avarta">
            <template v-slot="item">
                <div class="el-image">
                    <img :src="item.row.avatar" :alt="item.row.fullname">
                </div>
            </template>
        </el-table-column>
        <!-- Full Name -->
        <el-table-column min-width="120px" label="Họ Tên">
            <template v-slot="item">
                <span>{{ item.row.fullname }}</span>
            </template>
        </el-table-column>

         <!-- Email -->
         <el-table-column min-width="120px" label="Email">
            <template v-slot="item">
                <span>{{ item.row.email }}</span>
            </template>
        </el-table-column>

        <!-- BirthDay -->
        <el-table-column min-width="120px" label="Ngày Sinh">
            <template v-slot="item">
                <span>{{ item.row.birthday }}</span>
            </template>
        </el-table-column>

        <!-- Giới tính -->
        <el-table-column min-width="120px" label="Giới tính">
            <template v-slot="item">
                <span>{{ item.row.gender }}</span>
            </template>
        </el-table-column>

        <!-- Action -->
        <el-table-column align="center" min-width="80px" label="Sửa">
            <template v-slot="item">
                <!-- Nút sửa -->
                <el-button v-show="item.row.id != 1" type="danger" size="small" @click="showDialog({'status':'delete', 'id':item.row.id, 'title':item.row.title})">Xóa</el-button>
                <el-button type="primary" size="small" @click="showDialog({'status':'edit', 'item':item.row})">Sửa</el-button>
            </template>
        </el-table-column>
    </el-table>
</template>
<script>
    export default {
        name: 'TableUser',
        props: {
            list: {
                type: Array,
                default: ''
            },
            isLoading:{
                type: Boolean,
                default: false
            },
            search:{
                type: String,
                default: ''
            }
        },
        data () {  
            return {
                multipleSelection: [],
            }           
        },

        filters:{
            
        },

        created() {},

        methods: {
            showDialog(data){
                this.$emit('showdialog', data)
            },
            handleSelectionChange(val) {
                // this.multipleSelection = val;
                // this.listIds = [];
                // if (this.multipleSelection.length > 0) {
                //     let _this = this;
                //     this.multipleSelection.filter(item => {
                //         _this.listIds.push(item.id);
                //     });
                //     this.$emit('listIds', this.listIds);
                // }
            }
        }
    }

</script>
<style lang="scss" scoped>
.el-image > img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border: 1px dashed red;
    margin: 10px;
}
</style>
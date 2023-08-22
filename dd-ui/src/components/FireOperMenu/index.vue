<template>
  <el-row class="oper-main" :gutter="10">
    <el-col :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
      <div class="oper-title">
        {{ opTitle }}
      </div>
      <Breadcrumb />
    </el-col>
    <el-col class="oper-right" :xs="24" :sm="12" :md="12" :lg="12" :xl="12">
      <el-button
        v-show="showAdd"
        type="add"
        size="small"
        icon="el-icon-plus"
        @click="handleCreate"
      >添加</el-button>
      <el-button
        v-show="showDelete"
        type="del"
        size="small"
        icon="el-icon-delete"
        @click="handleDeleteAll"
      >删除</el-button>
      <el-button
        v-show="showExcelImport"
        type="import"
        size="small"
        icon="el-icon-s-fold"
        @click="ExcelImport"
      >批量导入</el-button>
      <el-button
        v-show="showExcelExport"
        type="export"
        size="small"
        icon="el-icon-s-unfold"
        @click="ExcelExport"
      >批量导出</el-button>
      <el-button
        v-show="showOperation"
        type="operation"
        size="small"
        icon="el-icon-delete"
        @click="allOperation"
      >批量操作</el-button>
    </el-col>
  </el-row>
</template>

<script>
import Breadcrumb from '@/components/Breadcrumb/index.vue'
export default {
  name: 'Fuxian',
  components: {
    Breadcrumb
  },
  props: {
    showAdd: {
      type: Boolean,
      default: true
    },
    showDelete: {
      type: Boolean,
      default: false
    },
    showExcelImport: {
      type: Boolean,
      default: false
    },
    showExcelExport: {
      type: Boolean,
      default: false
    },
    showOperation: {
      type: Boolean,
      default: false
    },
    items: {
      type: Array,
      default: () => {
        return [
          {
            label: '列表',
            url: 'index',
            active: true
          },
          {
            label: '添加',
            url: 'create',
            active: false
          }
        ]
      }
    },
    activeIndex: {
      type: Number,
      default: 0
    }
  },
  data: function() {
    return {
      opTitle: ''
    }
  },
  created: function() {
    this.opTitle = this.$route.meta.title
    console.log('this.$route', this.$route.meta.title)
  },
  methods: {
    // 创建
    handleCreate() {
      // console.log('add')
      this.$emit('handleCreate')
    },
    // 批量删除
    handleDeleteAll() {
      // console.log('delete')
      this.$emit('handleDeleteAll')
    },
    // 批量操作，用户可扩展
    allOperation() {
      this.$emit('allOperation')
    },
    // 导入
    ExcelImport() {
      this.$emit('ExcelImport')
    },
    // 导出
    ExcelExport() {
      this.$emit('ExcelExport')
    },
    handleSelect(key, keyPath) {
      const that = this
      that.items.forEach((item, k) => {
        if ('menu' + k === key) {
          window.location.href = item.url
        }
      })
    },
    reloadpage() {
      window.location.reload()
    },
    historypage() {
      history.go(-1)
    }
  }
}
</script>

<style lang="scss" scoped>
.oper-main {
  height: 75px;
  display: flex;
  margin-bottom: 29px;
  .oper-title {
    /* width: 126px; */
    padding-left: 10px;
    height: 45px;
    font-size: 28px;
    font-weight: normal;
    color: #0e2c4b;
    line-height: 28px;
  }
  .oper-right {
    justify-content: right;
    display: flex;
  }
  .el-button {
    &--add {
      width: 125px;
      height: 45px;
      background: #00afc7;
      border-radius: 12px 12px 12px 12px;
      font-size: 18px;
      font-family: Alibaba PuHuiTi 2-55 Regular, Alibaba PuHuiTi 20;
      font-weight: normal;
      color: #ffffff;
      line-height: 18px;
    }
    &--del {
      width: 125px;
      height: 45px;
      background: #00afc7;
      border-radius: 12px 12px 12px 12px;
      font-size: 18px;
      font-family: Alibaba PuHuiTi 2-55 Regular, Alibaba PuHuiTi 20;
      font-weight: normal;
      color: #ffffff;
      line-height: 18px;
    }
    &--import {
      width: 125px;
      height: 45px;
      background: #ffffff;
      border-radius: 12px 12px 12px 12px;
      font-size: 18px;
      font-weight: normal;
      color: #0a0a0a;
      line-height: 18px;
    }
    &--export {
      width: 125px;
      height: 45px;
      background: #ffffff;
      border-radius: 12px 12px 12px 12px;
      font-size: 18px;
      font-weight: normal;
      color: #0a0a0a;
      line-height: 18px;
    }
    &--operation {
      width: 125px;
      height: 45px;
      background: #ffffff;
      border-radius: 12px 12px 12px 12px;
      font-size: 18px;
      font-weight: normal;
      color: #0a0a0a;
      line-height: 18px;
    }
  }
}
</style>

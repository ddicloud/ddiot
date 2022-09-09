<template>
  <div class="margin-tb-xs">
    <el-button type="success" size="mini" icon="el-icon-edit" @click="handleCreate">添加</el-button>
    <el-button type="danger" size="mini" icon="el-icon-share" @click="handleDeleteAll">删除</el-button>
    <el-button v-show="showExcelImport" type="warning" size="mini" icon="el-icon-delete" @click="ExcelImport">批量导入</el-button>
    <el-button v-show="showExcelExport" type="warning" size="mini" icon="el-icon-delete" @click="ExcelExport">批量导出</el-button>
    <el-button v-show="showOperation" type="warning" size="mini" icon="el-icon-delete" @click="allOperation">批量操作</el-button>
  </div>
</template>

<script>
export default {
  name: 'FireOperMenu',
  props: {
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
    }
  },
  created: function() {
  },
  methods: {
    // 创建
    handleCreate() {
      console.log('add')
      this.$emit('handleCreate')
    },
    // 批量删除
    handleDeleteAll() {
      console.log('add')
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

<style></style>

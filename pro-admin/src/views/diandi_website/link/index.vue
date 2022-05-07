<template>
  <div class="app-container">
    <!-- 检索 start -->
    <el-filter
      size="medium"
      :data="filterInfo.data"
      :field-list="filterInfo.fieldList"
      :list-type-info="listTypeInfo"
      :show-selection="false"
      @handleFilter="handleFilter"
      @handleReset="handleReset"
      @handleEvent="handleEvent"
    />
    <!-- 检索 end -->

    <!-- 公共操作 star -->
    <fire-oper-menu
      :show-excel-export="true"
      :show-excel-import="true"
      @ExcelExport="handleDownload"
      @handleCreate="handleCreate"
      @handleDeleteAll="handleDeleteAll"
    />
    <!-- 公共操作 end -->

    <!-- 数据列表 start -->
    <fire-table
      ref="table"
      :list="list"
      :total="total"
      :list-loading="listLoading"
      :list-query="filterInfo.data"
      :columns="tableColumns"
      :handle="tableHandle"
      @handleSelectionChange="handleSelectionChange"
    />
    <!-- 数据列表 end -->

    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <ele-form
        ref="form"
        v-model="formData"
        v-bind="formConfig"
        :span="22"
        label-position="top"
        :request-fn="handleRequest"
        @request-success="handleRequestSuccess"
      />
    </el-dialog>
  </div>
</template>

<script>
import {
  fetchList,
  createItem,
  updateItem,
  deleteItem,
  fetchView
} from '@/views/diandi_website/api/link.js'
import {
  fetchAddons
} from 'diandi-admin/lib/api/admin/permission.js'
import {
  parseTime
} from '@/utils'

export default {
  data() {
    return {
      // 表格数据 start
      tableColumns: [{
        label: '公司名称',
        prop: 'name'
      },
      {
        label: '链接地址',
        prop: 'link'
      },
      {
        label: '创建时间',
        prop: 'createtime'
      }
      ],
      tableHandle: [{
        label: '修改',
        type: 'primary',
        isPop: false,
        method: row => {
          this.editItem(row)
        }
      },
      {
        label: '删除',
        type: 'danger',
        isPop: true,
        method: row => {
          this.deleteItem(row)
        }
      }
      ],
      // 表格数据end
      // 检索 start
      filterInfo: {
        data: {
          page: 1,
          limit: 20,
          name: '',
          parent_id: '',
          description: ''
          // sex: 1,
          // date: null,
          // dateTime: null,
          // range: null
        },
        fieldList: [{
          label: '菜单名称',
          type: 'input',
          value: 'Menu[name]'
        },
        {
          label: '菜单地址',
          type: 'input',
          value: 'Menu[route]',
          disabled: true
        },
        {
          label: '模块类型',
          type: 'select',
          value: 'Menu[module_name]',
          list: 'addonsList'
        },
        {
          label: '菜单描述',
          type: 'input',
          value: 'Menu[description]',
          min: 1,
          max: 10
        }
        ]
      },
      listTypeInfo: {
        addonsList: this.initAddonsFitter()
      },
      // 检索 end
      tableKey: 0,
      formInline: {
        user: '',
        region: ''
      },
      // 表单数据 start
      formData: {},
      formConfig: {
        formDesc: {
          name: {
            type: 'input',
            label: '公司名称'
          },
          logo: {
            label: '公司logo',
            type: 'image-uploader'
          },
          wechat_code: {
            label: '公司公众号',
            type: 'image-uploader'
          },
          image: {
            label: '公司环境',
            type: 'image-uploader'
          },
          link: {
            type: 'input',
            label: '链接地址'
          },
          intro: {
            type: 'fire-editor',
            label: '公司简介'
          }
        },
        order: []
      },
      // 表单数据 end
      total: 0,
      list: [],
      demo: {
        title: ''
      },
      temp: {
        id: undefined,
        importance: 1,
        remark: '',
        timestamp: new Date(),
        title: '',
        type: '',
        status: 'published'
      },
      dialogFormVisible: false,
      dialogStatus: '',
      textMap: {
        update: '编辑菜单',
        create: '添加菜单'
      },
      dialogPvVisible: false,
      pvData: [],
      downloadLoading: false
    }
  },
  created() {
    this.getList()
  },
  methods: {
    initAddons() {
      const arr = []
      arr.push({
        text: '选择模块',
        value: ''
      })
      fetchAddons().then(res => {
        const keys = Object.keys(res.data)
        const values = Object.values(res.data)
        values.forEach((item, index) => {
          arr.push({
            text: item,
            value: keys[index]
          })
        })
      })
      return arr
    },
    initAddonsFitter() {
      const arr = []
      arr.push({
        id: '选择模块',
        name: ''
      })
      fetchAddons().then(res => {
        const keys = Object.keys(res.data)
        const values = Object.values(res.data)
        values.forEach((item, index) => {
          arr.push({
            id: keys[index],
            name: item
          })
        })
      })

      return arr
    },
    // 触发请求
    async resetForm() {
      console.log(this.$refs.form)
      await this.$refs.form.resetForm(new MouseEvent('click'))
    },
    handleSelectionChange(val) {
      console.log('传递来的', val)
    },
    // 更新，和创建
    handleRequest(data) {
      console.log(data)
      const that = this

      if (that.dialogStatus === 'create') {
        createItem(data).then(response => {
          console.log(response)
          that.getList()
          that.dialogFormVisible = false
        })
      } else if (that.dialogStatus === 'update') {
        updateItem(data).then(res => {
          console.log('更新', res)
          that.getList()
          that.dialogFormVisible = false
        })
      }

      return Promise.resolve()
    },
    // 单行数据删除
    deleteItem(row) {
      const that = this
      deleteItem(row.id).then(res => {
        console.log('更新', res)
        that.getList()
        that.dialogFormVisible = false
      })
    },
    handleRequestSuccess() {

    },
    getList() {
      const that = this
      that.listLoading = true
      fetchList(that.filterInfo.data).then(response => {
        console.log('response', response)
        that.total = response.data.dataProvider.total
        that.list = response.data.dataProvider.allModels
        console.log('列表数据层级测试', that.list)
        that.listLoading = false
      })
    },
    /** 搜索 */
    handleFilter(row) {
      const that = this
      console.log(row)
      that.$set(that.filterInfo, 'data', row)
      console.log('检索前', that.filterInfo.data)
      that.getList()
    },
    /** 重置 */
    handleReset(row) {
      console.log(row)
    },
    /** 焦点失去事件 */
    handleEvent(row) {
      console.log(row)
    },
    handleModifyStatus(row, status) {
      this.$message({
        message: '操作Success',
        type: 'success'
      })
      row.status = status
    },
    sortChange(data) {
      const {
        prop,
        order
      } = data
      if (prop === 'id') {
        this.sortByID(order)
      }
    },
    sortByID(order) {
      if (order === 'ascending') {
        this.listQuery.sort = '+id'
      } else {
        this.listQuery.sort = '-id'
      }
      this.handleFilter()
    },
    handleCreate() {
      const that = this
      this.resetForm()
      console.log(this.list)
      that.dialogStatus = 'create'
      that.dialogFormVisible = true
    },
    handleDeleteAll() {
      console.log('删除')
    },
    handleUpdate(row) {
      this.temp = Object.assign({}, row) // copy obj
      this.temp.timestamp = new Date(this.temp.timestamp)
      this.dialogStatus = 'update'
      this.dialogFormVisible = true
    },
    updateData() {},
    handleDelete(row, index) {
      this.$notify({
        title: 'Success',
        message: 'Delete Successfully',
        type: 'success',
        duration: 2000
      })
      this.list.splice(index, 1)
    },
    editItem(row) {
      const that = this
      that.formData = {
        ...row
      }
      that.dialogFormVisible = true
      console.log('formData', row, that.formData)
      this.dialogStatus = 'update'

      fetchView(row.id).then(res => {
        console.log('view', res)
      })
    },
    handleDownload() {
      this.downloadLoading = true
      import('@/vendor/Export2Excel').then(excel => {
        const tHeader = ['title', 'create_time']
        const filterVal = [{
          title: '12',
          create_time: '23435345353'
        }]
        const data = this.formatJson(filterVal)
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: 'table-list'
        })
        this.downloadLoading = false
      })
    },
    formatJson(filterVal) {
      return this.list.map(v =>
        filterVal.map(j => {
          if (j === 'timestamp') {
            return parseTime(v[j])
          } else {
            return v[j]
          }
        })
      )
    },
    getSortClass: function(key) {
      const sort = this.listQuery.sort
      return sort === `+${key}` ? 'ascending' : 'descending'
    }
  }
}
</script>

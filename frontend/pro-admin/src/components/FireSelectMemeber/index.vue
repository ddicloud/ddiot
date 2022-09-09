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

    <!-- 编辑 start -->
    <el-dialog :title="textMap" :visible.sync="dialogFormVisible">
      <el-tabs v-model="actives" @tab-click="cutClick">
        <el-tab-pane label="管理" name="first">
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
          <fire-oper-menu
            :show-excel-export="true"
            :show-excel-import="true"
            @ExcelExport="handleDownload"
            @handleCreate="handleCreate"
            @handleDeleteAll="handleDeleteAll"
          />
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
        </el-tab-pane>
        <el-tab-pane label="添加" name="second">
          会员信息
          <el-form
            :label-position="labelPosition"
            label-width="80px"
            :model="accounts"
          >
            <el-form-item label="会员名称">
              <el-input v-model="accounts.appid" />
            </el-form-item>
            <el-form-item label="微信昵称">
              <el-input v-model="accounts.token" />
            </el-form-item>
            <el-form-item label="真实姓名">
              <el-input v-model="accounts.aeskey" />
            </el-form-item>
            <el-form-item label="会员头像">
              <el-input v-model="accounts.secret" />
            </el-form-item>

            <el-form-item label="微信头像">
              <image-uploader
                ref="uploadImage"
                v-model="accounts.url"
                :action="uploudUrl"
                :headers="headers"
                :response-fn="handleResponse"
                :before-remove="beforeRemove"
              />
            </el-form-item>
          </el-form>
        </el-tab-pane>
      </el-tabs>
    </el-dialog>
    <!-- 编辑 end -->
    <!-- 修改密码 start -->
    <el-dialog :title="permissionTitle" :visible.sync="dialogAuthVisible">
      <el-input v-model="password" placeholder="请输入密码" />
      <el-button plain style="margin-top: 60px">取消</el-button>
      <el-button type="primary">确认</el-button>
    </el-dialog>
    <!-- 修改密码 end -->
  </div>
</template>

<script>
import {
  fetchList,
  deletePermission,
  getRules,
  fetchLevels,
  fetchAddons,
  fetchView
} from 'diandi-admin/lib/api/admin/permission.js'
// import waves from '@/directive/waves' // waves directive
import { parseTime } from '@/utils'
export default {
  data() {
    return {
      labelPosition: 'top',
      accounts: {
        appid: '',
        token: '',
        aeskey: '',
        secret: '',
        url: '',
        imag: ''
      },
      uploudUrl: '',
      headers: {},
      password: '',
      actives: 'first',
      // 表格数据 start
      tableColumns: [
        { label: '会员ID', prop: 'ID' },
        { label: '头像', prop: 'head' },
        { label: '用户名', prop: 'name' },
        { label: '手机号', prop: 'mobile' },
        { label: '状态', prop: 'state' },
        { label: '时间', prop: 'time' }
      ],
      tableHandle: [
        {
          label: '编辑',
          type: 'primary',
          isPop: false,
          method: (row) => {
            this.editItem(row)
          }
        },
        {
          label: '删除',
          type: 'danger',
          isPop: true,
          method: (row) => {
            this.deleteItem(row)
          }
        },
        {
          label: '修改密码',
          type: 'warning',
          isPop: false,
          method: (row) => {
            this.authItem(row)
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
        fieldList: [
          { label: '会员ID', type: 'input', value: 'AuthItemSearch[ID]' },
          { label: '会员编码', type: 'input', value: 'AuthItemSearch[num]' },
          { label: 'openid', type: 'input', value: 'AuthItemSearch[openid]' },
          { label: '手机号', type: 'input', value: 'AuthItemSearch[mobile]' },
          { label: '用户名', type: 'input', value: 'AuthItemSearch[name]' },
          { label: '状态', type: 'input', value: 'AuthItemSearch[state]' },
          {
            label: '会员组',
            type: 'select',
            value: 'AuthItemSearch[member_group]'
          }
        ]
      },
      listTypeInfo: {
        addonsList: this.initAddons()
      },
      // 检索 end
      // 表单数据 start
      formData: {},
      formConfig: {
        formDesc: {
          permission_type: {
            type: 'radio',
            label: '权限类型',
            options: [
              { text: '目录', value: 0 },
              { text: '页面', value: 1 },
              { text: '按钮', value: 2 },
              { text: '接口', value: 3 }
            ]
          },
          name: {
            type: 'input',
            label: '名称'
          },
          rule_name: {
            type: 'select',
            label: '规则名称',
            isOptions: true,
            options: getRules().then((res) => {
              return res.data
            })
          },
          parent_id: {
            type: 'tree-select',
            label: '父级权限',
            isOptions: true,
            options: fetchLevels().then((res) => {
              const arr = [{ id: 0, label: '选择父级权限' }]
              return arr.concat(res.data)
            }),
            attrs: {
              showAllLevels: false
            }
          },
          // routes: {
          //   type: 'tree-select',
          //   label: '菜单路由',
          //   isOptions: true,
          //   options: fetchRoute().then(res => {
          //     return res.data;
          //   }),
          //   attrs: {
          //     multiple: true,
          //     clearable: true
          //   }
          // },
          description: {
            type: 'textarea',
            label: '描述',
            attrs: {
              autosizeType: 'switch',
              autosize: false
            }
          },
          data: {
            type: 'textarea',
            label: '数据',
            attrs: {
              autosizeType: 'switch',
              autosize: false
            }
          }
        },
        order: [
          'permission_type',
          'name',
          'rule_name',
          'parent_id',
          'description',
          'data'
        ]
      },
      // 表单数据 end
      total: 0,
      list: [],
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
      textMap: '编辑',
      downloadLoading: false,
      // 权限项管理
      permissionId: 0,
      dialogAuthVisible: false,
      permissionValue: {
        route: [],
        permission: [],
        role: []
      },
      permissionData: {
        route: [],
        permission: [],
        role: []
      },
      permissionTitle: '修改密码'
    }
  },
  created() {
    this.getList()
  },
  methods: {
    cutClick(tab, event) {
      console.log(tab, event)
    },
    initAddons() {
      const arr = []
      arr.push({ id: ' ', name: '选择模块' })
      fetchAddons().then((res) => {
        const keys = Object.keys(res.data)
        const values = Object.values(res.data)
        values.forEach((item, index) => {
          arr.push({ id: keys[index], name: item })
        })
      })

      return arr
    },
    handleSelectionChange(val) {
      console.log('传递来的', val)
    },
    // 单行数据删除
    deleteItem(row) {
      const that = this
      deletePermission(row.id).then((res) => {
        console.log('更新', res)
        that.getList()
        that.dialogFormVisible = false
      })
    },
    authItem(row) {
      const that = this
      that.dialogAuthVisible = true
      that.permissionId = row.id

      fetchView(row.id).then((res) => {
        console.log('assigneds', res.data.assignedKey)
        that.permissionData = res.data.availables
        that.permissionValue = res.data.assignedKey
      })
    },
    getList() {
      const that = this
      that.listLoading = true
      fetchList(that.filterInfo.data).then((response) => {
        console.log('response', response)
        that.total = response.data.dataProvider.total
        that.list = response.data.list
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
    handleCreate() {
      const that = this
      that.dialogFormVisible = true
    },
    handleDeleteAll() {
      console.log('删除')
    },
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
      that.formData = { ...row }
      that.dialogFormVisible = true
    },
    handleDownload() {
      this.downloadLoading = true
      import('@/vendor/Export2Excel').then((excel) => {
        const tHeader = ['title', 'create_time']
        const filterVal = [{ title: '12', create_time: '23435345353' }]
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
      return this.list.map((v) =>
        filterVal.map((j) => {
          if (j === 'timestamp') {
            return parseTime(v[j])
          } else {
            return v[j]
          }
        })
      )
    },
    handleResponse(response, file, fileList) {
      console.log('response', response)
      // 根据响应结果, 设置 URL
      this.accounts.url = response.attachment
      this.accounts.imag = response.url
      return response.url
    },
    upLoad() {
      // 触发上传图片按钮
      console.log('点击上传按钮')
      this.$refs['uploadImage'].$refs['upload'].$refs[
        'upload-inner'
      ].handleClick()
    },
    beforeRemove(index) {
      console.log(index, this.$refs.uploadImage)
      this.accounts.url = ''
    }
  }
}
</script>
<style>
.el-transfer-panel {
  width: 300px;
}
</style>

<template>
  <div class="app-container">
    <ele-form
      ref="form"
      v-model="formData"
      v-bind="formConfig"
      :span="22"
      label-position="top"
      :request-fn="handleRequest"
      @request-success="handleRequestSuccess"
    />
  </div>
</template>

<script>
import {
  createItem,
  updateItem,
  deleteItem,
  fetchView,
  fetchCate
} from '@/views/diandi_website/api/article.js'
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
        label: '类型',
        prop: 'cate',
        width: 80,
        align: 'center',
        render: (h, {
          row
        }) => {
          return h('el-tag', {}, row.cate ? row.cate.title : '系统')
        }
      },
      {
        label: '标题',
        prop: 'title'
      },
      {
        label: '简介',
        prop: 'description'
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
          pageSize: 20,
          name: '',
          parent_id: '',
          description: ''
          // sex: 1,
          // date: null,
          // dateTime: null,
          // range: null
        },
        fieldList: [{
          label: '文章名称',
          type: 'input',
          value: 'WebsiteArticle[title]'
        },
        {
          label: '文章类型',
          type: 'select',
          value: 'WebsiteArticle[pcate]',
          list: 'articleCate'
        }
        ]
      },
      listTypeInfo: {
        articleCate: this.initCate()
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
          title: {
            type: 'input',
            label: '标题'
          },
          pcate: {
            label: '一级分类',
            // 只需要在这里指定为 tree-select 即可
            type: 'tree-select',
            // 属性参考: https://vue-treeselect.js.org/
            attrs: {
              multiple: false,
              clearable: true
            },
            options: async data => {
              console.log('编 号', data.name)

              const obj = {
                pcate: 0
              }
              const res = await fetchCate(obj)
              console.log('编 号', res.data)
              const arr = [{
                id: 0,
                label: '一级菜单'
              }]
              console.log('父级菜单', res.data)
              return arr.concat(res.data)
            }
          },
          ccate: {
            label: '二级分类',
            // 只需要在这里指定为 tree-select 即可
            type: 'tree-select',
            // 属性参考: https://vue-treeselect.js.org/
            attrs: {
              multiple: false,
              clearable: true
            },
            vif: data => data.pcate,
            // 这里必须制定 optionsLinkageFields 做为关联字段，当次字段值发生变化时，会重新出发请求
            optionsLinkageFields: ['pcate'],
            options: async data => {
              console.log('编 号', data.name)
              if (data.pcate) {
                const obj = {
                  pcate: data.pcate
                }
                const res = await fetchCate(obj)
                console.log('编 号', res.data)
                const arr = [{
                  id: 0,
                  label: '一级菜单'
                }]
                console.log('父级菜单', res.data)
                return arr.concat(res.data)
              }
            }
          },
          ishot: {
            type: 'radio',
            label: '是否热门',
            isOptions: true,
            options: [{
              text: '热门',
              value: 1
            },
            {
              text: '非热门',
              value: 0
            }
            ]
          },
          thumb: {
            label: '文章主图',
            type: 'image-uploader'
          },
          displayorder: {
            type: 'input',
            label: '分类排序'
          },
          template: {
            type: 'input',
            label: '模板'
          },
          author: {
            type: 'input',
            label: '作者'
          },
          source: {
            type: 'input',
            label: '文章来源'
          },
          linkurl: {
            type: 'input',
            label: '来源地址'
          },
          description: {
            type: 'textarea',
            label: '简介'
          },
          content: {
            type: 'fire-editor',
            label: '文章内容',
            attrs: {
              responseFn(response, file, fileList) {
                return response.url
              }
            }
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
  },
  methods: {
    closePage() {
      this.$store.dispatch('app/closePage', {
        vm: this,
        fromName: this.$route.name,
        toName: 'diandi-website-article-index',
        params: {}
      })
    },
    initCate() {
      const arr = [{
        name: '选择分类',
        id: 0
      }]

      fetchCate({
        pcate: 0
      }).then(res => {
        console.log('检索分类', res.data)

        res.data.forEach((item, index) => {
          arr.push({
            name: item.label,
            id: item.id
          })
        })
        console.log('父级菜单', arr)
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
      createItem(data).then(response => {
        console.log(response)
        if (response.code === 200) {
          that.closePage()
        }
      })

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

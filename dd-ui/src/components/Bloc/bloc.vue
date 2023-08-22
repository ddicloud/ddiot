<template>
  <div>
    <ele-form
      v-model="formData"
      v-bind="formConfig"
      :request-fn="handleSubmit"
      @request-success="handleRequestSuccess"
    />
  </div>

</template>

<script>
import {
  fetchList,
  createItem,
  updateItem,
  deleteItem,
  fetchView,
  getParentbloc,
  getReglevel,
  getBlocstatus,
  getLevels
} from 'diandi-admin/lib/api/addons/bloc.js'
import {
  getCitylist
} from 'diandi-admin/lib/api/system/system.js'
export default {
  name: 'Bloc',
  props: {
    extra: {
      type: Object,
      default() {
        return {}
      }
    },
    formData: {
      type: Object,
      default() {
        return {}
      }
    },
    order: {
      type: Array,
      default() {
        return {}
      }
    }
  },
  data() {
    return {
      formConfig: {
        order: [
        ],
        formDesc: {
          business_name: {
            type: 'input',
            label: '商家名称'
          },
          logo: {
            label: '商户LOGO',
            type: 'image-uploader' // 只需要在这里指定为 image-uploader 即可
          },
          pid: {
            label: '父级公司',
            // 只需要在这里指定为 tree-select 即可
            type: 'tree-select',
            // 属性参考: https://vue-treeselect.js.org/
            attrs: {
              multiple: false,
              clearable: true
            },
            options: getParentbloc().then((res) => {
              console.log('父级公司', res.data)
              const arr = [{
                id: 0,
                label: '请选择父级公司'
              }]
              console.log('父级公司', arr.concat(res.data))
              return arr.concat(res.data)
            })
          },
          provinceCityDistrict: {
            type: 'cascader',
            label: '所在地区',
            isOptions: true,
            options: getCitylist().then((res) => {
              console.log('城市列表', res.data)
              return res.data
            })
          },
          open_time: {
            type: 'date',
            label: '启用时间',
            attrs: {
              valueFormat: 'yyyy-MM-dd'
            }
          },
          end_time: {
            type: 'date',
            label: '有效期',
            attrs: {
              valueFormat: 'yyyy-MM-dd'
            }
          },
          address: {
            type: 'bmap',
            label: '具体地址',
            valueFormatter(val) {
              console.log(val)
              // 最终提交时
              return val && val.address ? val.address : null
            },
            displayFormatter: (address) => {
              console.log('address', address, typeof address)
              // 设置显示的值
              if (typeof address !== 'undefined') {
                this.formData.latitude = address.lat
                this.formData.longitude = address.lng
                return address
              }
            },
            props: {
              showAddressBar: true,
              autoLocation: true,
              attrs: {
                center: '上海市'
              }
            }

          },
          longitude: {
            type: 'input',
            label: '经度',
            attrs: {
              disabled: true
            }
          },
          latitude: {
            type: 'input',
            label: '维度',
            attrs: {
              disabled: true
            }
          },
          avg_price: {
            type: 'input',
            label: '平均消费'
          },
          recommend: {
            type: 'textarea',
            label: '简介'
          },
          introduction: {
            type: 'textarea',
            label: '详细介绍'
          },
          special: {
            type: 'input',
            label: '特色'
          },
          telephone: {
            type: 'input',
            label: '联系电话'
          },
          license_no: {
            type: 'input',
            label: '营业执照注册号'
          },
          license_name: {
            type: 'input',
            label: '营业执照公司名称'
          },
          // register_level: {
          //   type: 'radio',
          //   label: '注册级别',
          //   isOptions: true,
          //   options: getReglevel().then((res) => {
          //     return res.data
          //   }),
          //   default: 1
          // },
          level_num: {
            type: 'select',
            label: '公司等级',
            isOptions: true,
            options: getLevels().then((res) => {
              console.log('用户等级', res.data)
              return res.data
            })
          },
          is_group: {
            type: 'radio',
            label: '是否是集团',
            vif: data => data.pid,
            // 这里必须制定 optionsLinkageFields 做为关联字段，当次字段值发生变化时，会重新出发请求
            optionsLinkageFields: ['pid'],
            options: async data => {
              console.log('编 号', data.pid)
              if (data.pid) {
                return [{
                  text: '否',
                  value: 0
                },
                {
                  text: '是',
                  value: 1
                }
                ]
              }
            },
            default: 0
          },
          status: {
            type: 'radio',
            label: '审核状态',
            isOptions: true,
            options: getBlocstatus().then((res) => {
              return res.data
            }),
            default: 1
          }
        }
      }
    }
  },
  watch: {
    formData(newVal, oldVal) {
      console.log('formData', newVal, oldVal)
      this.formData = newVal
      // this.blocGroups[0].form.formData = newVal
      // this.blocGroups[1].form.formData = newVal
    }
  },
  created() {
    const that = this
    that.formConfig.formDesc = Object.assign(that.formConfig.formDesc, that.extra)
    console.log('表达数据初始化', Object.keys(that.formConfig.formDesc))

    that.formConfig.order = Object.assign(that.formConfig.order, that.order)
  },
  methods: {
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
    handleRequestSuccess() {
      this.$message.success('发送成功')
    },
    handleSubmit(data) {
      console.log('handleSubmit', data)
      this.$emit('request', data)
    }
  }
}
</script>

<style>

</style>

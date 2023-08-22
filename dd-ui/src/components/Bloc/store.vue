<template>
  <div>
    <ele-form
      v-model="formData"
      v-bind="formConfig"
      :request-fn="handleSubmit"
      @request-success="handleRequestSuccess"
    />
    <!-- <ele-form-group
      ref="ele-form-group"
      v-model="formData"
      :form-btns="formBtns"
      :groups="blocGroups"
      :tab-attrs="tabAttrs"
      :is-show-back-btn="false"
      active-group-id="extra"
      submit-btn-text="确定"
      @request="handleSubmit"
    >
      <template v-slot:extra="{ formData }">
        <slot name="extra" />
      </template>
    </ele-form-group> -->
  </div>

</template>

<script>
import {
  createItem,
  updateItem,
  getBloc,
  getStorestatus,
  getStoreLabel,
  getCategory
} from 'diandi-admin/lib/api/addons/store.js'
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
          bloc_id: {
            label: '所属商家',
            // 只需要在这里指定为 tree-select 即可
            type: 'tree-select',
            // 属性参考: https://vue-treeselect.js.org/
            attrs: {
              multiple: false,
              clearable: true
            },
            options: getBloc().then((res) => {
              console.log('所属公司', res.data)
              const arr = [{ id: '', label: '请选择父级商户' }]
              console.log('父级商户', arr.concat(res.data))
              return arr.concat(res.data)
            })
          },
          name: {
            type: 'input',
            label: '门店名称'
          },
          provinceCityDistrict: {
            type: 'cascader',
            label: '所在地区',
            isOptions: true,
            options: getCitylist().then((res) => {
              console.log('城市列表', res)
              return res.data
            })
          },
          category: {
            type: 'cascader',
            label: '商户分类',
            isOptions: true,
            options: getCategory().then((res) => {
              console.log('商户分类', res.data)
              return res.data
            })
          },
          address: {
            type: 'bmap',
            label: '具体地址',
            valueFormatter(val) {
              console.log(val)
              // 最终提交时
              return val && val.address ? val.address : null
            },
            vif: (data) => data.provinceCityDistrict,
            // 这里必须制定 optionsLinkageFields 做为关联字段，当字段值发生变化时，会重新出发请求
            optionsLinkageFields: ['provinceCityDistrict'],
            attrs: (data) => {
              // 动态设置地图中心
              if (data.provinceCityDistrict && !data.address) {
                return {
                  zoom: 19,
                  center:
                    this.$refs[
                      'form'
                    ].$refs.provinceCityDistrict[0].$refs.cascader.getCheckedNodes()[0]
                      .label
                }
              } else {
                return {
                  zoom: 19
                }
              }
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
              autoLocation: true
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
          mobile: {
            type: 'input',
            label: '联系电话'
          },
          status: {
            type: 'radio',
            label: '审核状态',
            isOptions: true,
            options: getStorestatus().then((res) => {
              console.log('审核状态', res)
              return res.data
            }),
            default: 1
          },
          logo: {
            label: '商户LOGO',
            type: 'image-uploader' // 只需要在这里指定为 image-uploader 即可
          },
          label_link: {
            type: 'checkbox',
            label: '商户标签',
            isOptions: true,
            options: getStoreLabel().then((res) => {
              return res.data
            })
          }
        }
      }
    }
  },
  watch: {
    formData(newVal, oldVal) {
      console.log('formData', newVal, oldVal)
      this.blocGroups[0].form.formData = newVal
      this.blocGroups[1].form.formData = newVal
    }
  },
  created() {
    const that = this
    that.formConfig.formDesc = Object.assign(that.formConfig.formDesc, that.extra)
    console.log('表达数据初始化', Object.keys(that.formConfig.formDesc).join(','))
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

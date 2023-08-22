<template>
  <div>
    <el-select
      v-model="blocsStores.bloc_id"
      placeholder="请选择"
      clearable
      style="margin-right: 20px"
      @change="changeFn1"
      @clear="clearFn1"
    >
      <el-option
        v-for="item in blocs"
        :key="item.value"
        :label="item.label"
        :value="item.value"
      />
    </el-select>
    <el-select
      v-if="stores.length"
      v-model="blocsStores.store_id"
      placeholder="请选择"
      clearable
      @change="changeFn2"
      @clear="clearFn2"
    >
      <el-option
        v-for="item in stores"
        :key="item.value"
        :label="item.label"
        :value="item.value"
      />
    </el-select>
  </div>
</template>

<script>
import { enumsStoresbloc } from 'diandi-admin/lib/api/addons/Enums.js'
import formMixin from 'diandi-ele-form/lib/mixins/formMixin'
export default {
  mixins: [formMixin],
  data() {
    return {
      blocs: [],
      stores: [],
      blocsStores: {
        bloc_id: '',
        store_id: ''
      },
      dataArr: []
    }
  },
  watch: {
    value: {
      handler(val) {
        if (val[0]) {
          this.$set(this.blocsStores, 'bloc_id', val[0])
        }
        setTimeout(() => {
          if (val[0] && val[1]) {
            const obj = this.blocs.find((item) => item.value === val[0])
            if (obj?.children) {
              this.stores = obj.children
            }
            this.$set(this.blocsStores, 'store_id', val[1])
          }
        }, 200)
      },
      deep: true
    }
  },
  created() {
    this.initSelect()
  },
  methods: {
    initSelect() {
      this.getDate()
    },
    getDate() {
      enumsStoresbloc().then((res) => {
        this.blocs = res.data
        setTimeout(() => {
          const obj = res.data.find(
            (item) => item.value === this.blocsStores.bloc_id
          )
          if (obj?.children) {
            this.stores = obj.children
          }
        }, 200)
      })
    },
    changeFn1(e) {
      const item = this.blocs.find((item) => item.value === e)
      if (item?.children) {
        this.stores = item.children
      }
      this.$set(this.dataArr, '0', e)
      if (this.dataArr.length === 1) {
        this.$emit('input', this.dataArr)
      }
    },
    clearFn1() {
      this.stores = []
      this.$set(this.blocsStores, 'store_id', '')
    },
    changeFn2(e) {
      this.$set(this.dataArr, '1', e)
      if (!this.dataArr[0]) {
        this.$set(this.dataArr, '0', this.blocsStores.bloc_id)
      }
      if (this.dataArr.length === 2) {
        this.$emit('input', this.dataArr)
      }
    },
    clearFn2() {}
  }
}
</script>

<style></style>

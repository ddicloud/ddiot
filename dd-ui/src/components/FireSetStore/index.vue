<template>
  <div :class="{'show':show}" class="header-search">
    <el-tooltip content="点击选择集团与商户" placement="bottom" effect="light">
      <svg-icon class-name="store-icon" icon-class="store" @click.stop="clickStore" />
    </el-tooltip>

    <div class="header-search-select">
      <el-input v-model="filterText" autocomplete="off" :autofocus="true" placeholder="商户检索" @click.stop="ceshi" />
    </div>
    <el-card v-if="show" class="box-card">
      <el-tree
        ref="tree"
        class="filter-tree"
        :data="storeList"
        :props="defaultProps"
        default-expand-all
        :filter-node-method="filterNode"
        @node-click="change"
      />
    </el-card>
  </div>
</template>

<script>
import {
  getStoreGroup
} from 'diandi-admin/lib/api/addons/bloc.js'
import {
  fetchList
} from 'diandi-admin/lib/api/store.js'
export default {
  name: 'FireSetStore',
  props: {
    isshow: ''
  },
  data() {
    return {
      search: '',
      options: [],
      searchPool: [],
      show: false,
      fuse: undefined,
      storeList: [],
      filterText: '',
      defaultProps: {
        children: 'children',
        label: 'label'
      }
    }
  },
  computed: {
    routes() {
      return this.$store.getters.permission_routes
    }
  },
  watch: {
    searchPool(list) {
      this.initFuse(list)
    },
    filterText(val) {
      this.$refs.tree.filter(val)
    },
    show(value) {
      console.log('clickvalue', value)
    },
    isshow(value) {
      this.show = value
      console.log('isshow', value)
    }
  },
  created() {
    getStoreGroup().then(res => {
      if (res.code === 200) {
        this.storeList = res.data.list
      }
      console.log('获取store组', res, res.code === 200, res.code)
    })
  },
  methods: {
    ceshi() {
      console.log('23345643')
    },
    clickStore() {
      this.show = !this.show
      this.$emit('topshow', { type: 'store', show: this.show })
      if (this.show) {
        this.$refs.tree && this.$refs.tree.focus()
      }
    },
    closeStore() {
      this.show = false
      this.$refs.tree && this.$refs.tree.blur()
    },
    filterNode(value, data) {
      if (!value) return true
      return data.label.indexOf(value) !== -1
    },
    change(val) {
      console.log(val)
      this.getStoreList(val)
      this.$nextTick(() => {
        this.show = false
      })
    },
    getStoreList: function(data) {
      const that = this
      fetchList(data).then(res => {
        console.log('切换商户成功', data.store_id)
        that.$store.dispatch('app/setBlocs', data)
        this.$nextTick(() => {
          this.$router.replace({
            path: '/redirect' + this.$route.fullPath
          })
        })
      })
    }
  }
}
</script>

<style lang="scss" scoped>
  .header-search {
    font-size: 0 !important;

    .store-icon {
      color: #FFFFFF;
      cursor: pointer;
      font-size: 18px;
      vertical-align: middle;
    }

    .header-search-select {
      font-size: 18px;
      transition: width 0.2s;
      width: 0;
      overflow: hidden;
      background: transparent;
      border-radius: 0;
      display: inline-block;
      vertical-align: middle;

      ::v-deep .el-input__inner {
        border-radius: 0;
        border: 4px;
        padding-left: 5px;
        padding-right: 0;
        box-shadow: none !important;
        border-bottom: 1px solid #d9d9d9;
        vertical-align: middle;
      }
    }

    .setstore-main {
      background-color: #FFFFFF;
      width: 260px;
      padding: 0 15px;
      // border: 1px solid #20222a;
      border-top: none;
      border-radius: 0px 0px 4px 4px;
      height: initial;
      padding-bottom: 20px;
    }

    &.show {
      .header-search-select {
        width: 210px;
        margin-left: 10px;
      }
    }
  }
</style>

<template>
  <div class="el-row--flex">
    <div class="header-search">
      <div :class="{'show':showSearch,'header-search-text-top':Layout == 'top','header-search-text':Layout != 'top'}" class="right-menu-item">
        <el-tooltip content="点击搜索菜单" placement="bottom" effect="light">
          <svg-icon class-name="search-icon" icon-class="search" @click.stop="click" />
        </el-tooltip>
        <el-select
          v-if="showSearch"
          ref="headerSearchSelect"
          v-model="search"
          :remote-method="querySearch"
          filterable
          default-first-option
          remote
          placeholder="Search"
          class="header-search-select"
          @change="change"
        >
          <el-option v-for="item in options" :key="item.path" :value="item" :label="item.title.join(' > ')" />
        </el-select>
      </div>
    </div>
    <!-- <div v-if="isshowBloc === 'units'" class="header-store">
      <div :class="{'show':showStore,'header-search-text-top':Layout == 'top','header-search-text':Layout != 'top'}" class="right-menu-item">
        <el-tooltip content="点击选择集团与商户" placement="bottom" effect="light">
          <svg-icon class-name="store-icon" icon-class="store" @click.stop="clickStore" />
        </el-tooltip>

        <div v-if="showStore" class="header-search-select">
          <el-input v-model="filterText" autocomplete="off" :autofocus="true" placeholder="商户检索" />
        </div>
        <el-card v-if="showStore" class="box-card">
          <el-tree
            ref="tree"
            class="filter-tree"
            :data="storeList"
            :props="defaultProps"
            :filter-node-method="filterNode"
            @node-click="storeChange"
          />
        </el-card>
      </div>
    </div> -->

  </div>
</template>

<script>
// fuse is a lightweight fuzzy-search module
// make search results more in line with expectations
import {
  mapGetters
} from 'vuex'
import Fuse from 'fuse.js'
import path from 'path'
import {
  getStoreGroup
} from 'diandi-admin/lib/api/addons/bloc.js'
import {
  getView
} from 'diandi-admin/lib/api/addons/store.js'

import { config } from '@/utils/publicUtil'

export default {
  name: 'HeaderSearch',
  props: {
    isshow: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      search: '',
      options: [],
      searchPool: [],
      showSearch: false,
      showStore: false,
      fuse: undefined,
      storeList: [],
      filterText: '',
      defaultProps: {
        children: 'children',
        label: 'label'
      },
      isshowBloc: ''
    }
  },
  computed: {
    routes() {
      return this.$store.getters.permission_routes
    },
    ...mapGetters(['Layout'])
  },
  watch: {
    routes() {
      this.searchPool = this.generateRoutes(this.routes)
    },
    searchPool(list) {
      this.initFuse(list)
    },
    filterText(val) {
      this.$refs.tree.filter(val)
    },
    showSearch(value) {
      if (value) {
        this.showStore = false
        document.body.addEventListener('click', this.close)
      } else {
        document.body.removeEventListener('click', this.close)
      }
    },
    showStore(value) {
      if (value) {
        this.showSearch = false
        document.body.addEventListener('click', this.close)
      } else {
        document.body.removeEventListener('click', this.close)
      }
    }
  },
  created() {
    getStoreGroup().then(res => {
      if (res.code === 200) {
        this.storeList = res.data.list
      }
    })
    this.isshowBloc = config.modeType
  },
  mounted() {
    this.searchPool = this.generateRoutes(this.routes)
  },
  methods: {
    click() {
      console.log('来源')
      this.showSearch = !this.showSearch
      if (this.showSearch) {
        this.$refs.headerSearchSelect && this.$refs.headerSearchSelect.focus()
      }
    },
    close() {
      this.$refs.headerSearchSelect && this.$refs.headerSearchSelect.blur()
      this.options = []
      this.showSearch = false
    },
    change(val) {
      this.$router.push(val.path)
      this.search = ''
      this.options = []
      this.$nextTick(() => {
        this.showSearch = false
      })
    },
    initFuse(list) {
      this.fuse = new Fuse(list, {
        shouldSort: true,
        threshold: 0.4,
        location: 0,
        distance: 100,
        maxPatternLength: 32,
        minMatchCharLength: 1,
        keys: [{
          name: 'title',
          weight: 0.7
        }, {
          name: 'path',
          weight: 0.3
        }]
      })
    },
    // Filter out the routes that can be displayed in the sidebar
    // And generate the internationalized title
    generateRoutes(routes, basePath = '/', prefixTitle = []) {
      let res = []

      for (const router of routes) {
        // skip hidden router
        if (router.hidden) { continue }

        const data = {
          path: path.resolve(basePath, router.path),
          title: [...prefixTitle]
        }

        if (router.meta && router.meta.title) {
          data.title = [...data.title, router.meta.title]

          if (router.redirect !== 'noRedirect') {
            // only push the routes with title
            // special case: need to exclude parent router without redirect
            res.push(data)
          }
        }

        // recursive child routes
        if (router.children) {
          const tempRoutes = this.generateRoutes(router.children, data.path, data.title)
          if (tempRoutes.length >= 1) {
            res = [...res, ...tempRoutes]
          }
        }
      }
      return res
    },
    querySearch(query) {
      if (query !== '') {
        this.options = this.fuse.search(query)
      } else {
        this.options = []
      }
    },
    clickStore() {
      this.showStore = !this.showStore
      if (this.showStore) {
        this.$refs.tree && this.$refs.tree.focus()
      }
    },
    closeStore() {
      this.showStore = false
      this.$refs.tree && this.$refs.tree.blur()
    },
    filterNode(value, data) {
      if (!value) return true
      return data.label.indexOf(value) !== -1
    },
    storeChange(val) {
      this.getStoreList(val)
    },
    getStoreList: function(data) {
      const that = this
      if (!data.business_name) {
        getView(data.store_id).then(res => {
          console.log('商户数据',res);
          that.$store.dispatch('elForm/changeHEaders', {
            key: 'store-id',
            value: res.data.store_id
          })
          that.$store.dispatch('elForm/changeHEaders', {
            key: 'bloc-id',
            value: res.data.bloc_id
          })
          that.$store.dispatch('elForm/changeSetting', {
            key: 'attachmentUrl',
            value: res.data.config.attachmentUrl
          })
          that.$store.dispatch('app/setBlocs', res.data)
          this.$nextTick(() => {
            this.$router.replace({
              path: '/redirect' + this.$route.fullPath
            })
            this.showStore = false
          })
        })
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.header-search {
  font-size: 0 !important;

  .search-icon {
    cursor: pointer;
    font-size: 18px;
    vertical-align: middle;
  }
  .header-search-text{
    color: #5a5e66;
  }
  .header-search-text-top{
    color: #ffffff;
  }
  .right-menu-item{
      display: inline-block;
      padding: 0 8px;
      height: 100%;
      font-size: 18px;
      vertical-align: text-bottom;
  }
  .header-search-select {
    font-size: 18px;
    transition: width 0.2s;
    width: calc( 100% - 50px);
    margin-left:15px;
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

  &.show {
    .header-search-select {
      width: 210px;
      margin-left: 10px;
    }
  }
}

 .header-store {
    font-size: 0 !important;
    .box-card{
      position: fixed;
      z-index: 2000;
    }
    .store-icon {
      // color: #FFFFFF;
      cursor: pointer;
      font-size: 18px;
      vertical-align: middle;
    }

    .header-search-text{
    color: #5a5e66;
    }
    .header-search-text-top{
      color: #ffffff;
    }
    .header-search-select {
      font-size: 18px;
      transition: width 0.2s;
      overflow: hidden;
      background: transparent;
      border-radius: 0;
      display: inline-block;
      vertical-align: middle;
      width: calc( 100% - 50px);
      margin-left:15px;
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

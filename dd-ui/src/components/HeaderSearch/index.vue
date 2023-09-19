<template>
  <div class="el-row--flex header-search-main">
    <div class="header-search">
      <div
        :class="{
          show: showSearch,
          'header-search-text-top': Layout == 'top',
          'header-search-text': Layout != 'top',
        }"
        class="right-menu-item"
      >
        <i class="el-icon-search margin-left-xs" />
        <el-select
          ref="headerSearchSelect"
          v-model="search"
          :remote-method="querySearch"
          filterable
          default-first-option
          remote
          placeholder="搜索功能与帮助"
          class="header-search-select"
          @change="change"
        >
          <el-option
            v-for="item in options"
            :key="item.path"
            :value="item"
            :label="item.title.join(' > ')"
          />
        </el-select>
      </div>
    </div>
  </div>
</template>

<script>
// fuse is a lightweight fuzzy-search module
// make search results more in line with expectations
import { mapGetters } from 'vuex'
import Fuse from 'fuse.js'
import path from 'path'
import { getStoreGroup } from 'diandi-admin/lib/api/addons/bloc.js'
import { getView } from 'diandi-admin/lib/api/addons/store.js'

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
      showSearch: true,
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
    getStoreGroup().then((res) => {
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
      this.showSearch = true
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
        keys: [
          {
            name: 'title',
            weight: 0.7
          },
          {
            name: 'path',
            weight: 0.3
          }
        ]
      })
    },
    // Filter out the routes that can be displayed in the sidebar
    // And generate the internationalized title
    generateRoutes(routes, basePath = '/', prefixTitle = []) {
      let res = []

      for (const router of routes) {
        // skip hidden router
        if (router.hidden) {
          continue
        }

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
          const tempRoutes = this.generateRoutes(
            router.children,
            data.path,
            data.title
          )
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
        getView(data.store_id).then((res) => {
          console.log('商户数据', res)
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
          that.$store.dispatch('App/setBlocs', res.data)
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
.header-search-main {
  display: flex;
  align-items: center;
  justify-items: center;
  width: 320px;
  .header-search {
    font-size: 0 !important;
    width: 100%;
    border-radius: 7px;
    background: #fafbfc;
    // border: 1px solid rgb(187, 187, 187, 0.5);
    height: 44px;
    line-height: 44px;
    i {
      color:  #D1D1D1;
    }
    .search-icon {
      cursor: pointer;
      font-size: 18px;
      vertical-align: middle;
    }
    .header-search-text {
      color: #5a5e66;
    }
    .header-search-text-top {
      color: #ffffff;
    }
    .right-menu-item {
      display: inline-flex;
      align-items: center;
      padding: 0 8px;
      height: 100%;
      font-size: 18px;
      vertical-align: text-bottom;
    }
    .header-search-select {
      font-size: 18px;
      transition: width 0.2s;
      width: calc(100% - 50px);
      margin-left: 15px;
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
        font-weight: 400;
        color: #D1D1D1;
        font-size: 16px;
        box-shadow: none !important;
        background: #fafbfc;
        // border-bottom: 1px solid #d9d9d9;
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
    .box-card {
      position: fixed;
      z-index: 2000;
    }
    .store-icon {
      // color: #FFFFFF;
      cursor: pointer;
      font-size: 18px;
      vertical-align: middle;
    }

    .header-search-text {
      color: #5a5e66;
    }
    .header-search-text-top {
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
      width: calc(100% - 50px);
      margin-left: 15px;
      ::v-deep .el-input__inner {
        border-radius: 0;
        border: 4px;
        height: 30px;
        padding-left: 5px;
        padding-right: 0;
        box-shadow: none !important;
        border-bottom: 1px solid #d9d9d9;
        vertical-align: middle;
      }
    }

    .setstore-main {
      background-color: #ffffff;
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
}
</style>

<template>
  <div class="navbar" :class="{'el-row--flex':Layout === 'top'}" type="flex" justify="end">
    <div v-if="Layout != 'top'" class="el-col-18">
      <hamburger
        id="hamburger-container"
        :is-active="sidebar.opened"
        class="hamburger-container"
        @toggleClick="toggleSideBar"
      />

      <breadcrumb id="breadcrumb-container" class="breadcrumb-container" />
    </div>

    <div v-if="Layout === 'top'" class="el-col-18">
      <top-sidebar class="sidebar-container-top subfield-container-top" />
    </div>
    <div class="el-col-6">
      <div class="right-menu" :class="{'right-menu-top':Layout === 'top'}">
        <template v-if="device!=='mobile'">

          <search id="header-search" />

          <error-log class="errLog-container right-menu-item hover-effect" />

          <screenfull id="screenfull" class="right-menu-item hover-effect" />

          <el-tooltip content="Global Size" effect="dark" placement="bottom">
            <size-select id="size-select" class="right-menu-item hover-effect" />
          </el-tooltip>

        </template>

        <el-dropdown class="avatar-container right-menu-item hover-effect" trigger="hover">
          <div class="avatar-wrapper">
            <div class="user-avatar">
              {{ username }}
            </div>
            <i class="el-icon-caret-bottom" />
          </div>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item v-if="checkPermission(['总管理员'])" @click.native="backSys">返回系统</el-dropdown-item>
            <router-link to="/profile/index.vue">
              <el-dropdown-item>个人资料</el-dropdown-item>
            </router-link>
            <a target="_blank" href="http://doc.hopesfire.com/admin/">
              <el-dropdown-item>开发手册</el-dropdown-item>
            </a>
            <el-dropdown-item v-if="checkPermission(['总管理员'])" @click.native="clearCache">清除缓存</el-dropdown-item>
            <el-dropdown-item divided @click.native="logout"><span style="display:block;">退出登陆</span></el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </div>
    </div>

  </div>
</template>

<script>
import {
  mapGetters
} from 'vuex'
import Breadcrumb from '@/components/Breadcrumb'
import Hamburger from '@/components/Hamburger'
import ErrorLog from '@/components/ErrorLog'
import Screenfull from '@/components/Screenfull'
import SizeSelect from '@/components/SizeSelect'
import Search from '@/components/HeaderSearch'

import TopSidebar from './TopSidebar/index.vue'
// import FireMediaBox from '@/components/FireMediaBox'
import {
  fetchList
} from 'diandi-admin/lib/api/addons/store.js'
import {
  setBlocCache,
  clearCache
} from 'diandi-admin/lib/api/system/system.js'
import checkPermission from '@/utils/permission' // 权限判断函数
export default {
  components: {
    Hamburger,
    TopSidebar,
    // FireMediaBox,
    Breadcrumb,
    ErrorLog,
    Screenfull,
    SizeSelect,
    Search
  },
  data() {
    return {
      isStoreShow: false,
      isSearchShow: false,
      storeList: [],
      tabPosition: 'top',
      dialogFormVisible: false,
      workTitle: '系统',
      activeIndex: '1',
      activeIndex2: '1'
    }
  },
  computed: {
    ...mapGetters(['sidebar', 'avatar', 'username', 'device', 'menutop', 'menuType', 'LeftMenu', 'storeName',
      'baseUrl', 'fixedHeader', 'Layout', 'roles'
    ])
  },
  methods: {
    checkPermission,
    toggleSideBar() {
      this.$store.dispatch('app/toggleSideBar')
    },
    async logout() {
      await this.$store.dispatch('user/logout')
      this.$router.push(`/login?redirect=${this.$route.fullPath}`)
    },
    /** 搜索 */
    handleFilter(row) {
      const that = this
      that.$set(that.filterInfo, 'data', row)
      that.getStoreList(that.filterInfo.data)
    },
    /** 重置 */
    handleReset(row) {
      console.log(row)
    },
    /** 焦点失去事件 */
    handleEvent(row) {
      console.log(row)
    },
    handleSelect: function(e) {
      const that = this
      that.menutop.forEach((item) => {
        if (e === item.identifie) {
          that.workTitle = item.name
        }
      })
      that.$store.dispatch('permission/setMenuType', e)
      // 初始化左侧菜单状态
      const menus = []
      that.LeftMenu.forEach((item, index) => {
        if (item.type === that.menuType) {
          menus.push(item)
          return false
        }
      })
      const id = menus[0].id
      that.isActive = id
      this.$store.commit('permission/SET_LEFTACTIVE', id)
    },
    backSys() {
      this.$store.dispatch('settings/setMenuType', 'system')
    },
    setStore: function(data) {
      console.log('avatar', this.avatar)
      this.getStoreList(data)
    },
    getStoreList: function(data) {
      const that = this
      fetchList(data).then(res => {
        that.storeList = res.data
        that.dialogFormVisible = true
      })
    },
    clearCache: function() {
      const that = this
      clearCache({
        cache: true,
        template: true
      }).then(res => {
        const { code } = res
        if (code === 200) {
          that.$message.success('清理成功')
        }
      })
    },
    setBloc: function(e) {
      const that = this
      const data = {
        store_name: e.name,
        bloc_id: e.bloc_id,
        store_id: e.store_id
      }

      setBlocCache({
        bloc: data
      }).then(res => {
        if (res.code === 200) {
          this.$store.dispatch('app/setBlocs', res.data)
          that.dialogFormVisible = false
        }
        // that.storeList = res.data
      })
    }
  }
}
</script>

<style lang="scss" scoped>
  .menu-child {
    display: inline-flex;

  }

  .store-search {
    border-bottom: 1px solid #C0CCDA;
  }

  .navbar {
    height: 60px;
    overflow: hidden;
    position: relative;
    background: #fff;
    box-shadow: 0 1px 4px rgba(0, 21, 41, 0.08);

    .hamburger-container {
      line-height: 60px;
      height: 60px;
      float: left;
      cursor: pointer;
      transition: background 0.3s;
      -webkit-tap-highlight-color: transparent;

      &:hover {
        background: rgba(0, 0, 0, 0.025);
      }
    }

    .breadcrumb-container {
      float: left;
    }

    .errLog-container {
      display: inline-block;
      vertical-align: top;
    }

    .right-menu {
      height: 60px;
      line-height: 60px;
      display: flex;
      justify-content: flex-end;

      &:focus {
        outline: none;
      }

      .stores-top {
        display: inline-block;
        vertical-align: top;
        height: 100%;
        color: #5a5e66;
        cursor: pointer;
        transition: background 0.3s;
      }

      .right-menu-item {
        display: inline-block;
        padding: 0 8px;
        height: 100%;
        font-size: 18px;
        color: #5a5e66;
        vertical-align: text-bottom;

        &.hover-effect {
          cursor: pointer;
          transition: background 0.3s;

          &:hover {
            background: rgba(0, 0, 0, 0.025);
          }
        }
      }

      .avatar-container {
        margin-right: 30px;

        .avatar-wrapper {
          margin-top: 5px;
          position: relative;

          .user-avatar {
            cursor: pointer;
            width: 50px;
            height: 40px;
            overflow: hidden;
            border-radius: 10px;
          }

          .el-icon-caret-bottom {
            cursor: pointer;
            position: absolute;
            right: -20px;
            top: 20px;
            font-size: 12px;
          }
        }
      }
    }

    .right-menu-top {
      height: 60px;
      line-height: 49px;
      display: flex;
      justify-content: flex-end;
      background-color: #20222a;
      position: fixed;
      right: 0px;
      top: 0px;
      width: inherit;
      z-index: 1001;

      &:focus {
        outline: none;
      }

      .stores-top {
        display: inline-block;
        vertical-align: top;
        height: 100%;
        color: #ffffff;
        cursor: pointer;
        transition: background 0.3s;
      }

      .right-menu-item {
        display: inline-block;
        padding: 0 8px;
        height: 100%;
        font-size: 18px;
        color: #ffffff;
        vertical-align: text-bottom;

        &.hover-effect {
          cursor: pointer;
          transition: background 0.3s;

          &:hover {
            background: rgba(0, 0, 0, 0.025);
          }
        }
      }

      .avatar-container {
        margin-right: 30px;

        .avatar-wrapper {
          margin-top: 5px;
          position: relative;

          .user-avatar {
            cursor: pointer;
            width: max-content;
            height: 40px;
            overflow: hidden;
            border-radius: 10px;
          }

          .el-icon-caret-bottom {
            cursor: pointer;
            position: absolute;
            right: -20px;
            top: 20px;
            font-size: 12px;
          }
        }
      }
    }
  }

  .navbar-flex {
    display: flex;
  }
</style>

<template>
  <!-- 左侧分两栏 start -->
  <div class="el-row--flex" :class="{ 'has-logo': showLogo }">
    <logo v-if="showLogo" :collapse="isCollapse" />
    <el-scrollbar
      wrap-class="scrollbar-wrapper"
      class="default-sidebar-container"
    >
      <el-menu
        :default-active="activeMenu"
        :collapse="false"
        :background-color="variables.menuBg"
        :text-color="variables.menuText"
        :unique-opened="true"
        :active-text-color="variables.menuActiveText"
        :collapse-transition="false"
        mode="horizontal"
      >
        <sidebar-item
          v-for="route in permission_routes"
          :key="route.id"
          :item="route"
          :base-path="route.path"
        />
      </el-menu>
    </el-scrollbar>
  </div>
  <!-- 左侧分两栏 end -->
</template>

<script>
import {
  mapGetters
} from 'vuex'
import Logo from './Logo'
import SidebarItem from './SidebarItem'
import variables from '@/styles/variables.scss'
import {
  isExternal
} from '@/utils/validate'
import path from 'path'
import { config } from '@/utils/publicUtil'
export default {
  name: 'TopSidebar',
  components: {
    SidebarItem,
    Logo
  },
  data() {
    return {
      isCollapse: false,
      isActive: 0,
      leftSubMenu: [],
      siteName: config.siteName
    }
  },
  computed: {
    ...mapGetters(['permission_routes', 'sidebar', 'Layout', 'LeftMenu', 'menuType', 'webSite', 'subLeftIsActive']),
    subLeftIsActive() {
      const that = this
      let id = 0
      if (this.$store.state.permission.subLeftIsActive) {
        id = this.$store.state.permission.subLeftIsActive
        that.initLeftSubMenu(id)
      }

      return id
    },
    activeMenu() {
      const route = this.$route
      if (route.path === '/' || route.path === '/dashboard') {
        this.$store.dispatch('settings/setMenuType', 'system')
      }
      const {
        meta,
        path
      } = route
      // if set path, the sidebar will highlight the path you set
      if (meta.activeMenu) {
        return meta.activeMenu
      }
      return path
    },
    showLogo() {
      return this.$store.state.settings.sidebarLogo
    },
    variables() {
      return variables
    },
    resolvePath(routePath) {
      if (isExternal(routePath)) {
        return routePath
      }
      if (isExternal(this.basePath)) {
        return this.basePath
      }
      return path.resolve(this.basePath, routePath)
    }
  },
  watch: {
    menuType(val) {
      const that = this
      const menus = that.LeftMenu.find(item => item.type === that.menuType)
      console.log('监听变化', that.LeftMenu, menus)
      const id = menus.id
      that.isActive = id
      that.initLeftSubMenu(id)
    }
  },
  created() {
    const that = this
    const menus = that.LeftMenu.find(item => item.type === that.menuType)
    const id = menus.id
    that.isActive = id
    that.initLeftSubMenu(id)
  },
  methods: {
    initLeftSubMenu(id) {
      const that = this
      const leftSubMenu = that.permission_routes.find(item => item.id === id)
      that.leftSubMenu = leftSubMenu.children
    },
    async targetMenu(id) {
      const that = this
      that.isActive = id
      that.initLeftSubMenu(id)
      this.$store.commit('permission/SET_LEFTACTIVE', id)
    }
  }
}
</script>

<style lang="scss" scoped>
// 侧边栏动画
.sidebar-enter-active {
  transition: all 0.3s;
}
.el-row--flex {
  height: 60px;
}
.main-enter {
  opacity: 0;
  margin-left: -20px;
}

.main-leave-to {
  opacity: 0;
  margin-left: 20px;
}

.sidebar-enter,
.sidebar-leave-active {
  opacity: 0;
  transform: translateY(20px);
}
::v-deep .el-submenu__title > .el-submenu__icon-arrow {
  display: none;
}

::v-deep .el-submenu {
  width: 110px;
  text-align: center;
  .is-active .el-submenu__title {
    border-bottom-color: #1890ff;
    color: #fff !important;
    background-color: #42b983 !important;
  }
}

.sidebar-leave-active {
  position: absolute;
}

.s-navs {
  width: 100%;
  padding: 0;

  .s-navs-item {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100%;
    padding: 10px 0;
    cursor: pointer;

    &.active {
      color: #fff;
      background-color: #334067;
    }

    &.active:after {
      position: absolute;
      left: 84px;
      width: 0;
      height: 0;
      overflow: hidden;
      content: "";
      border-color: transparent #fff transparent transparent;
      border-style: solid dashed dashed;
      border-width: 8px;
    }

    &:hover {
      color: #fff;
      background-color: #334067;
      transition: 0.3s;
    }

    &:not(:hover) {
      transition: 0.3s;
    }

    .icon {
      width: 20px;
      height: 20px;
      font-size: 20px;
      margin: 0 !important;
    }

    h2 {
      font-size: 14px;
      margin: 0;
      margin-top: 4px;
      font-weight: 400;
    }
  }
}
</style>

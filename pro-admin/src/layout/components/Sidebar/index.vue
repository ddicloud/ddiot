<template>
  <div>
    <!-- 左侧分一栏 start -->
    <div v-if="Layout == 'default'" :class="{ 'has-logo 1': showLogo }">
      <logo v-if="showLogo" :collapse="isCollapse" />
      <el-scrollbar wrap-class="scrollbar-wrapper" class="default-sidebar-container">
        <el-menu
          :default-active="activeMenu"
          :collapse="isCollapse"
          :default-openeds="openedsIndexs"
          :background-color="variables.menuBg"
          :text-color="variables.menuText"
          :unique-opened="true"
          :active-text-color="variables.menuActiveText"
          :collapse-transition="false"
          mode="vertical"
        >
          <sidebar-item v-for="route in permission_routes" :key="route.id" :item="route" :base-path="route.path" />
        </el-menu>
      </el-scrollbar>
    </div>
    <!-- 左侧分一栏 end -->

    <!-- 左侧两栏 start -->
    <div v-if="Layout == 'subfield'" class="sidebar-main">
      <div class="main-sidebar-container">
        <div class="sidebar-logo">
          <logo v-if="showLogo" :collapse="!isCollapse" />
        </div>
        <ul class="s-navs">
          <li
            v-for="(item, index) in LeftMenu"
            v-show="item.type == menuType"
            :key="index"
            class="s-navs-item"
            :class="{ active: subLeftIsActive == item.id }"
            @click="targetMenu(item.id)"
          >
            <i class="icon sub-el-icon" :class="item.meta ? item.meta.icon : 'bug'" />
            <h2>{{ item.meta ? item.meta.title : '' }}</h2>
          </li>
        </ul>
      </div>

      <el-scrollbar class="subfield-sidebar-container" wrap-class="scrollbar-wrapper">
        <div class="left-title">
          <h1 class="sub-title">{{ storeName?storeName:siteName }}</h1>
          <!-- <div v-if="storeName" class="sub-store">当前商户:{{ storeName }}</div> -->
        </div>
        <el-menu
          :default-active="activeMenu"
          :collapse="isCollapse"
          :default-openeds="openedsIndexs"
          :background-color="variables.leftmenuBg"
          :text-color="variables.leftmenuText"
          :unique-opened="true"
          :active-text-color="variables.leftmenuActiveText"
          :collapse-transition="false"
          mode="vertical"
        >
          <!-- 正常菜单 start -->
          <sidebar-item v-for="(route,index) in leftSubMenu" :key="route.path+isActive+index" :item="route" :base-path="route.path" />
          <!-- 正常菜单 end -->

          <!-- 子插件菜单start -->
          <sidebar-item v-for="(route,index) in pluginsMenu" :key="route.path+isActive+index" :item="route" :base-path="route.path" :is-plugins="true" />
          <!-- 子插件菜单end -->
        </el-menu>
      </el-scrollbar>

    </div>
    <!-- 左侧两栏 end -->

  </div>
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
  components: {
    SidebarItem,
    Logo
  },
  data() {
    return {
      isActive: 0,
      leftSubMenu: [],
      openedsIndexs: [],
      siteName: config.siteName
    }
  },
  computed: {
    ...mapGetters(['permission_routes', 'pluginsMenu', 'sidebar', 'Layout', 'LeftMenu', 'menuType', 'webSite', 'subLeftIsActive', 'storeName']),
    subLeftIsActive() {
      const that = this
      let id = 0
      if (this.$store.state.permission.subLeftIsActive) {
        id = this.$store.state.permission.subLeftIsActive
        console.log('initLeftSubMenu', this.pluginsMenu)
        that.initLeftSubMenu(id)
      }
      return id
    },
    activeMenu() {
      const route = this.$route
      const id = route.matched[0].meta.parent_menu_id || route.matched[0].meta.parent
      console.log('activeMenu', id, route.matched[0].meta)
      if (route.path === '/' || route.path === '/dashboard') {
        this.$store.dispatch('settings/setMenuType', 'system')
      }
      this.initLeftSubMenu(id)
      this.$store.commit('permission/SET_LEFTACTIVE', id)
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
    isCollapse() {
      return !this.sidebar.opened
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
    pluginsMenu(newval) {
      console.log('newval', newval, this.leftSubMenu)
    }
  },
  created() {
    const that = this
    const menus = that.LeftMenu.find(item => item.type === that.menuType)
    const id = menus.id
    that.isActive = id
    that.initLeftSubMenu(id)
    console.log('pluginsMenu', this.pluginsMenu)
  },
  methods: {
    initLeftSubMenu(id) {
      const that = this
      const leftSubMenu = that.permission_routes.find(item => item.id === id)
      that.leftSubMenu = leftSubMenu.children
      console.log('leftSubMenu', leftSubMenu.children)
    },
    async targetMenu(id) {
      const that = this
      that.isActive = id
      that.initLeftSubMenu(id)
      that.activeFirst(that.leftSubMenu)
      this.$store.commit('permission/SET_LEFTACTIVE', id)
    },
    activeFirst(menus) {
      let name = ''
      if (menus[0].children.length > 0) {
        name = menus[0].children[0].name
      } else {
        name = menus[0].name
      }
      this.$router.push({ name: name })
    }
  }
}
</script>

<style lang="scss" scoped>
  // 侧边栏动画
  .sidebar-enter-active {
    transition: all 0.3s;
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
      padding: 15px 0;
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
        font-size: 18px;
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

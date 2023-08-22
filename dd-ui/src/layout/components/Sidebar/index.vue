<template>
  <div>
    <!-- 左侧两栏 start -->
    <div :class="{'sidebar-main':sidebar.opened,'sidebar-main-left':!sidebar.opened}">
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
            @mouseover="hoverTargetMenu($event,item.id)"
            @click="targetMenu(item.id)"
          >
            <h2 class="padding-top-xs">
              <!-- <i
                class="icon sub-el-icon"
                :class="item.meta ? item.meta.icon : 'bug'"
              /> -->
              <svg-icon class="icon sub-el-icon" :icon-class="(item.meta && item.meta.icon) ? item.meta.icon : 'bug'" :size="22" />
              <div class="sub-el-title padding-top-xs">{{ item.meta ? item.meta.title : "" }}</div>
            </h2>
          </li>
        </ul>
      </div>
      <!-- 浮动开始 -->
      <el-scrollbar v-if="!sidebar.opened && isHover && device != 'mobile'" ref="menuContainer" class="subfield-sidebar-pop" @mouseleave.native="mouseleaveLeft">
        <div
          v-for="(route, index) in leftSubMenu"
          :key="route.path + isActive + index"
          :item="route"
          :base-path="route.path"
          :class="hoverMainClass(route)"
        >

          <template v-if="!route.hidden && route.level_type !== 6 && route.level_type !== 1 && route.level_type !== 2 ">
            <router-link v-if="route.level_type === 4" class="el-menu-item" :to="route.path">
              <span class="el-menu-item-child-list-item-icon" :style="hoverSpanColor(index)">
                <svg-icon class="icon-pop sub-el-icon" :icon-class="(route.meta && route.meta.icon) ? route.meta.icon : 'bug'" :size="22" />
              </span>
              <i>{{ route.meta.title }}</i>
            </router-link>
            <div v-if="route.level_type === 3" class="el-menu-item-child-list">
              <div class="el-menu-item-child-list-title">
                <span class="el-menu-item-child-list-item-icon">
                  <svg-icon class="icon-pop-level sub-el-icon" :icon-class="(route.meta && route.meta.icon) ? route.meta.icon : 'bug'" :size="22" />
                </span>
                <i>{{ route.meta.title }}</i>

              </div>
              <div
                v-for="(croute, cindex) in route.children"
                :key="croute.path + isActive + cindex"
                :item="croute"
                :base-path="croute.path"
                :class="{'el-menu-item-child-list-item':!croute.hidden,'el-menu-hidden':croute.hidden}"
              >
                <router-link v-if="!croute.hidden" class="el-menu-item" :to="croute.path">
                  <span class="el-menu-item-child-list-item-icon" :style="hoverSpanColor(cindex+index)">
                    <svg-icon class="icon-pop sub-el-icon" :icon-class="(croute.meta && croute.meta.icon) ? croute.meta.icon : 'bug'" :size="22" />
                  </span>
                  <i>{{ croute.meta.title }}</i>
                </router-link>

              </div>
            </div>
          </template>
        </div>
      </el-scrollbar>
      <!-- 浮动结束 -->

      <!-- 正常开始 -->

      <el-scrollbar
        v-else
        class="text-center"
        :class="{'subfield-sidebar-container':sidebar.opened,'subfield-sidebar-hide':!sidebar.opened && !isHover}"
        wrap-class="scrollbar-wrapper"
        @mouseleave.native="isHover=false"
      >
        <div class="left-title">
          <h1 class="sub-title">{{ webSite.name }}</h1>
          <!-- <div v-if="storeName" class="sub-store">{{ storeName }}</div> -->
        </div>
        <el-menu
          ref="menu"
          :default-active="activeMenu"
          :collapse="isCollapse"
          :background-color="variables.leftmenuBg"
          :text-color="variables.leftmenuText"
          :unique-opened="true"
          :active-text-color="variables.leftmenuActiveText"
          :collapse-transition="false"
          mode="vertical"
          @open="handleOpen"
          @close="handleClose"
        >
          <!-- 正常菜单 start -->
          <sidebar-item
            v-for="(route, index) in leftSubMenu"
            :key="route.path + isActive + index"
            :item="route"
            :base-path="route.path"
          />
          <!-- 正常菜单 end -->
        </el-menu>
      </el-scrollbar>
      <!-- 正常结束 -->

    </div>
    <!-- 左侧两栏 end -->
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Logo from './Logo'
import SidebarItem from './SidebarItem'
import variables from '@/styles/variables.scss'
import { isExternal } from '@/utils/validate'
import path from 'path'
import { config } from '@/utils/publicUtil'
export default {
  components: {
    SidebarItem,
    Logo
  },
  data() {
    return {
      hideTimer: null,
      isActive: 0,
      isCollapse: false,
      menuEnums: 0,
      isHover: false,
      // 分栏数据
      leftSubMenu: [],
      siteName: config.siteName
    }
  },
  computed: {
    ...mapGetters([
      'permission_routes',
      'device',
      'sidebar',
      'LeftMenu',
      'menuType',
      'webSite',
      'subLeftIsActive',
      'storeName'
    ]),
    // subLeftIsActive() {
    //   const that = this
    //   let id = 0
    //   if (this.$store.state.permission.subLeftIsActive) {
    //     id = this.$store.state.permission.subLeftIsActive
    //     that.initLeftSubMenu(id)
    //   }
    //   return id
    // },
    activeMenu() {
      const route = this.$route
      let id = 0
      console.log('activeMenu1', route, route.path)
      if (route.path === '/main/index.vue' || this.menuEnums === 2) {
        return ''
      }

      // 支持插件单独使用也支持组合使用
      if (route.path.indexOf(this.menuType) !== -1) {
        // 模块本身
        console.log('activeMenu4')
        id = route.matched[0].meta.parent
      } else {
        //  插件进入
        console.log('activeMenu5')
        id = route.matched[0].meta.parent_menu_id || route.matched[0].meta.parent
      }
      // const id = route.matched[0].meta.parent
      console.log('activeMenu', route, id, route.matched[0].meta)
      if (route.path === '/' || route.path === '/dashboard') {
        this.$store.dispatch('settings/setMenuType', 'system')
      }
      this.initLeftSubMenu(id)
      this.$store.commit('permission/SET_LEFTACTIVE', id)
      const { meta, path } = route
      // if set path, the sidebar will highlight the path you set
      if (meta.activeMenu) {
        return meta.activeMenu
      }
      console.log('activeMenu3', path)
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
    menuEnums(newval) {
      console.log('menuEnums', newval, this.menuEnums)
    }
  },
  mounted() {
    this.$refs['menuContainer'].addEventListener('mouseout', this.mouseleaveLeft)
  },
  beforeDestroy() {
    this.$refs['menuContainer'].removeEventListener('mouseout', this.mouseleaveLeft)
  },
  created() {
    const that = this
    const menus = that.LeftMenu.find((item) => item.type === that.menuType)
    const id = menus.id
    that.isActive = id
    // 初始化分栏数据
    that.initLeftSubMenu(id)
  },
  methods: {
    mouseleaveLeft() {
      const that = this
      console.log('离开1')
      that.isHover = false
    },
    hoverMainClass(route) {
      // <!--
      //       {
      //         text: "二级菜单",
      //         value: 3,
      //       },
      //       {
      //         text: "二级菜单(无三级菜单)",
      //         value: 4,
      //       },
      //       {
      //         text: "三级菜单",
      //         value: 5,
      //       },
      //       {
      //         text: "非菜单页面",
      //         value: 6,
      //       }, -->
      let cl = 'el-menu'
      switch (route.level_type) {
        case 3:
          // 二级菜单
          // cl = 'el-menu'
          cl = 'el-menu-item-child'

          break
        case 4:
          // 二级菜单(无三级菜单)
          cl = 'el-menu'
          break
        case 5:
          // 三级菜单
          cl = 'el-menu'

          break

        default:
          cl = 'el-menu'

          break
      }
      return cl
      // if (route.level_type === 0) {
      //   return 'el-menu'
      // } else if (route.children.length > 0) {
      //   const l = route.children.filter(item => item.level_type === 5)
      //   if (l.length === 1) {
      //     return 'el-menu el-menu-hidden'
      //   } else {
      //     return 'el-menu-item-child'
      //   }
      // console.log('有子集区别处理',route.children.filter(item=>item.level_type === 5))
    },
    handleOpen() {
      console.log('2')
    },
    handleClose() {
      console.log('3')
    },
    initLeftSubMenu(id) {
      const that = this
      const leftSubMenu = that.permission_routes.find((item) => item.id === id)
      console.log('initLeftSubMenu', leftSubMenu.children, that.permission_routes, id)
      if (leftSubMenu) {
        that.leftSubMenu = leftSubMenu.children
      }
    },
    hoverSpanColor(index) {
      const clor = ['#9694FF', '#57CAEB', '#FFA754', '#FF7976', '#5DDAB4']
      console.log('颜色')
      const i = index % 5
      return { 'background': clor[i] }
    },
    async hoverTargetMenu(event, id) {
      const that = this
      that.isActive = id
      this.menuEnums = 0
      that.initLeftSubMenu(id)

      if (that.leftSubMenu.length > 1) {
        that.isHover = true
      } else {
        that.isHover = false
      }
      this.$store.commit('permission/SET_LEFTACTIVE', id)
    },
    async targetMenu(id) {
      const that = this
      that.isActive = id
      this.menuEnums = 0
      that.initLeftSubMenu(id)
      that.activeFirst(that.leftSubMenu)
      this.$store.commit('permission/SET_LEFTACTIVE', id)
    },
    activeFirst(menus) {
      console.log('menus', menus)
      // let name = ''
      // if (menus[0].children.length > 0) {
      //   name = menus[0].children[0].name
      // } else {
      //   name = menus[0].name
      // }
      this.$router.push({ name: menus[0].name })
    }
  }
}
</script>

<style lang="scss" scoped>
// 侧边栏动画
.sidebar-enter-active {
  transition: all 0.3s;
}
.icon-pop {
      color: #fff;
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

.s-navs-service {
  position: absolute;
}
.el-menu-hidden {
  display: none;
}
.s-navs {
  width: 100%;
  padding: 0;

  .s-navs-item {
    display: flex;
    flex-direction: column;
    justify-content: left;
    cursor: pointer;
    margin: 20px auto;
    height: 82px;
    width: 82px;
    // padding-left: 5px;
    padding: 4px 12px;
    color: #ccc;
    &.active {
      width: 82px;
      height: 82px;
      text-align: left;
      background-color: #12A9A4;
      // box-shadow: 0px 0px 2px 1px rgba(14, 5, 10, 0.75);
      border-radius: 3px 3px 3px 3px;
      color: #fff;
      .icon {
        color: #fff;
      }
    }

    &.active:after {
      position: absolute;
      left: 85px;
      width: 0;
      height: 0;
      overflow: hidden;
      content: "";
      border-color: transparent #fff transparent transparent;
      border-style: solid dashed dashed;
      border-width: 8px;
    }

    &:hover {
      // margin: auto;
      // width: 80px;
      //  height: 15px;
      // background-color: #4f5970;
      transition: 0.3s;
    }

    &:not(:hover) {
      transition: 0.3s;
    }

    .icon {
      width: 20px;
      height: 20px;
      font-size: 18px;
      margin-right: 5px;
      color: #cccccc;
    }

    h2 {
      font-size: 10px;
      text-align: center;
    }
  }
}
::v-deep .el-menu-item {
  margin: 10px !important;
  font-size: 14px !important;
}
</style>

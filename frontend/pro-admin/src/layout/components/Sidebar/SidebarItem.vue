<template>
  <div>
    <div v-if="item.type == menuType || (item.path == '/dashboard' && Layout == 'default')">
      <template
        v-if="
          hasOneShowingChild(item.children, item) &&
            (!onlyOneChild.children.length || onlyOneChild.noShowingChildren) &&
            !item.alwaysShow
        "
      >
        <app-link v-if="onlyOneChild.meta" :to="resolvePath(onlyOneChild.path)">
          <el-menu-item
            v-show="!item.hidden"
            :index="resolvePath(onlyOneChild.path)+item.id"
            :class="{ 'submenu-title-noDropdown': !isNest }"
          >
            <item
              :icon="onlyOneChild.meta.icon || (item.meta && item.meta.icon)"
              :title="onlyOneChild.meta.title"
            />
          </el-menu-item>
        </app-link>
      </template>
      <el-submenu v-else ref="subMenu" :index="resolvePath(item.path)+item.id" popper-append-to-body>
        <template slot="title">
          <item
            v-if="item.meta"
            :icon="item.meta && item.meta.icon"
            :title="item.meta.title"
          />
        </template>
        <sidebar-item
          v-for="child in item.children"
          v-show="!child.hidden"
          :key="child.path"
          :is-nest="true"
          :item="child"
          :base-path="resolvePath(child.path)"
          class="nest-menu"
        />
      </el-submenu>
    </div>
    <!-- 子模块 start -->
    <div v-if="hasChild(item) && isPlugins">
      <!-- 子插件菜单集合 -->
      <template
        v-if="
          hasOneShowingChild(item.children, item) &&
            (!onlyOneChild.children.length || onlyOneChild.noShowingChildren) &&
            !item.alwaysShow
        "
      >
        <app-link v-if="onlyOneChild.meta" :to="resolvePath(onlyOneChild.path)">
          <el-menu-item
            v-show="!item.hidden"
            :index="resolvePath(onlyOneChild.path)"
            :class="{ 'submenu-title-noDropdown': !isNest }"
          >
            <item
              :icon="onlyOneChild.meta.icon || (item.meta && item.meta.icon)"
              :title="onlyOneChild.meta.title"
            />
          </el-menu-item>
        </app-link>
      </template>
      <el-submenu v-else ref="subMenu" :index="resolvePath(item.path)+item.id" popper-append-to-body>
        <template slot="title">
          <item
            v-if="item.meta"
            :icon="item.meta && item.meta.icon"
            :title="item.meta.title"
          />
        </template>
        <sidebar-item
          v-for="child in item.children"
          v-show="!child.hidden"
          :key="child.path+child.id"
          :is-nest="true"
          :item="child"
          :is-plugins="true"
          :base-path="resolvePath(child.path)"
          class="nest-menu"
        />
      </el-submenu>
    </div>
    <!-- 子模块 end -->

  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import path from 'path'
import { isExternal } from '@/utils/validate'
import Item from './Item'
import AppLink from './Link'
import FixiOSBug from './FixiOSBug'
export default {
  name: 'SidebarItem',
  components: {
    Item,
    AppLink
  },
  mixins: [FixiOSBug],
  props: {
    // route object
    item: {
      type: Object,
      required: {},
      default() {
        return {}
      }
    },
    isNest: {
      type: Boolean,
      default: false
    },
    isPlugins: {
      type: Boolean,
      default: false
    },
    basePath: {
      type: String,
      default: ''
    }
  },
  data() {
    // To fix https://github.com/PanJiaChen/vue-admin-template/issues/237
    // TODO: refactor with render function
    this.onlyOneChild = null
    return {
      // menuType: 'system'
    }
  },
  computed: {
    ...mapGetters(['menuType', 'plugins', 'LeftMenu', 'Layout', 'subLeftIsActive'])
  },

  methods: {
    hasOneShowingChild(children = [], parent) {
      const showingChildren = children.filter((item) => {
        if (item.hidden) {
          return false
        } else {
          // Temp set(will be used if only has one showing child)
          this.onlyOneChild = item
          return true
        }
      })
      // When there is only one child router, the child router is displayed by default
      if (showingChildren.length === 1) {
        return true
      }

      // Show parent if there are no child router to display
      if (showingChildren.length === 0) {
        this.onlyOneChild = {
          ...parent,
          path: '',
          noShowingChildren: true
        }
        return true
      }
      return false
    },
    hasChild(item) {
      const activeMenu = this.LeftMenu.find((item) => item.id === this.subLeftIsActive)
      if (activeMenu.path.includes('plugins/default/index.vue')) {
        return true
      } else {
        return false
      }
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
  }
}
</script>

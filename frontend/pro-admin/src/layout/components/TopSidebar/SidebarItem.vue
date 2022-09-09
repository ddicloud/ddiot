<template>
  <div v-if="item.type == menuType">
    <template
      v-if="
        hasOneShowingChild(item.children, item) &&
          (!onlyOneChild.children.length || onlyOneChild.noShowingChildren) &&
          !item.alwaysShow
      "
    >
      <app-link v-if="onlyOneChild.meta" :to="resolvePath(onlyOneChild)">
        <el-menu-item
          :index="resolvePath(onlyOneChild)"
          :class="{ 'submenu-title-noDropdown-top': !isNest }"
        >
          <item
            class="a"
            :icon="onlyOneChild.meta.icon || (item.meta && item.meta.icon)"
            :title="onlyOneChild.meta.title"
          />
        </el-menu-item>
      </app-link>
    </template>
    <el-submenu
      v-else
      ref="subMenu"
      :index="resolvePath(item)"
      popper-append-to-body
    >
      <template slot="title">
        <item
          v-if="item.meta"
          class="b"
          :icon="item.meta && item.meta.icon"
          :title="item.meta.title"
        />
      </template>
      <sidebar-item
        v-for="child in item.children"
        v-show="!child.hidden"
        :key="child.id"
        :is-nest="true"
        :item="child"
        :base-path="resolvePath(child)"
        class="nest-menu"
      />
    </el-submenu>
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
      required: true
    },
    isNest: {
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
    ...mapGetters(['menuType'])
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
    resolvePath(menu) {
      let routePath = menu.path
      if (isExternal(routePath)) {
        return routePath
      }
      if (isExternal(this.basePath)) {
        return this.basePath
      }

      if (routePath === '/main/index.vue') {
        routePath = routePath + '/' + menu.id
        // console.log('菜单唯一识别办法', menu, routePath, this.basePath, isExternal(routePath), isExternal(this.basePath))
      }
      return path.resolve(this.basePath, routePath)
    }
  }
}
</script>

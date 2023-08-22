<template>
  <div class="tab-menu">
    <el-menu
      v-show="items.length > 0"
      v-cloak
      id="_tab"
      :default-active="activeIndex"
      class="el-menu-demo topnavmenu"
      mode="horizontal"
      @select="handleSelect"
    >
      <el-menu-item v-for="(menu, index) in items" :key="index" :index="'menu' + index" :class="menu.active ? 'is-active' : ''">
        <a v-if="menu.label" :href="menu.url">{{ menu.label }}</a>
      </el-menu-item>
      <el-menu-item class="pull-right">
        <el-link icon="glyphicon glyphicon-refresh" @click="reloadpage">刷新</el-link>
        <el-link @click="historypage">
          <i class="fa fa-mail-reply" />
          返回
        </el-link>
      </el-menu-item>
    </el-menu>
  </div>
</template>
<script>
export default {
  name: 'TableMenu',
  props: {
    items: {
      type: Array,
      default() {
        return [
          {
            label: '列表',
            url: 'index',
            active: true
          },
          {
            label: '添加',
            url: 'create',
            active: false
          }
        ]
      }
    },
    activeIndex: {
      type: Number,
      default: 0
    }
  },
  data: function() {
    return {
    }
  },
  created: function() {

  },
  methods: {
    handleSelect(key, keyPath) {
      const that = this
      that.items.forEach((item, k) => {
        if ('menu' + k === key) {
          window.location.href = item.url
        }
      })
    },
    reloadpage() {
      window.location.reload()
    },
    historypage() {
      history.go(-1)
    }
  }
}
</script>

<style lang="scss">
  .topnavmenu{
        border-radius: 4px 4px 0 0;
    }
    .tab-menu{
      margin-bottom: 15px;
    }
</style>

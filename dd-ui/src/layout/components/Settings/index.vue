<template>
  <div class="drawer-container">
    <div>
      <h3 class="drawer-title">页面风格配置</h3>
      <div class="drawer-item">
        <span>布局</span>
        <el-radio-group v-model="layoutVal" size="small" class="drawer-switch" @change="setLayout">
          <el-radio-button v-for="item in options" :key="item.value" :label="item.label" :value="item.value" />
        </el-radio-group>
      </div>

      <div class="drawer-item">
        <span>主题色</span>
        <theme-picker style="float: right;height: 26px;margin: -3px 8px 0 0;" @change="themeChange" />
      </div>

      <div class="drawer-item">
        <span>Open Tags-View</span>
        <el-switch v-model="tagsView" class="drawer-switch" />
      </div>

      <div class="drawer-item">
        <span>Fixed Header</span>
        <el-switch v-model="fixedHeader" class="drawer-switch" />
      </div>

      <div class="drawer-item">
        <span>Sidebar Logo</span>
        <el-switch v-model="sidebarLogo" class="drawer-switch" />
      </div>
    </div>
  </div>
</template>

<script>
import ThemePicker from '@/components/ThemePicker'

export default {
  components: { ThemePicker },
  data() {
    return {
      options: [
        {
          value: 'subfield',
          label: '分栏'
        },
        {
          value: 'default',
          label: '常规'
        }
      ],
      value1: true,
      layoutVal: '分栏'
    }
  },
  computed: {
    fixedHeader: {
      get() {
        return this.$store.state.settings.fixedHeader
      },
      set(val) {
        this.$store.dispatch('settings/changeSetting', {
          key: 'fixedHeader',
          value: val
        })
      }
    },
    tagsView: {
      get() {
        return this.$store.state.settings.tagsView
      },
      set(val) {
        this.$store.dispatch('settings/changeSetting', {
          key: 'tagsView',
          value: val
        })
      }
    },
    sidebarLogo: {
      get() {
        return this.$store.state.settings.sidebarLogo
      },
      set(val) {
        this.$store.dispatch('settings/changeSetting', {
          key: 'sidebarLogo',
          value: val
        })
      }
    }
  },
  methods: {
    themeChange(val) {
      this.$store.dispatch('settings/changeSetting', {
        key: 'theme',
        value: val
      })
    },
    setLayout(val) {
      console.log(val)
      this.layoutVal = val
      this.options.forEach(item => {
        if (item.label === val) {
          this.$store.dispatch('settings/setLayout', item.value)
        }
      })
    }
  }
}
</script>

<style lang="scss" scoped>
.drawer-container {
	padding: 24px;
	font-size: 14px;
	line-height: 1.5;
	word-wrap: break-word;

	.drawer-title {
		margin-bottom: 12px;
		color: rgba(0, 0, 0, 0.85);
		font-size: 14px;
		line-height: 22px;
	}

	.drawer-item {
		color: rgba(0, 0, 0, 0.65);
		font-size: 14px;
		padding: 12px 0;
	}
	.drawer-switch {
		float: right;
	}
}
</style>

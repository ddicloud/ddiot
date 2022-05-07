<template>
  <div ref="rightPanel" :class="{ show: show }" class="rightPanel-container">
    <!-- <div class="rightPanel-background" /> -->
    <div class="rightPanel">
      <div class="rightPanel-setting-list">
        <div
          class="handle-button"
          :style="{ top: buttonTop + 'px', 'background-color': '#ebf5ff',color :'#1890ff' }"
          @click="tabRight(0)"
        >
          <i :class="show ? 'el-icon-close' : 'el-icon-setting'" />
          <p>模板</p>
        </div>
        <div
          class="handle-button"
          :style="{ top: buttonTop + 'px', 'background-color': '#f7f2fd' ,color :'rgb(131 73 201)'}"
          @click="tabRight(1)"
        >
          <i :class="show ? 'el-icon-close' : 'el-icon-setting'" />
          <p>商户</p>
        </div>
        <div
          class="handle-button"
          :style="{ top: buttonTop + 'px', 'background-color':'#fbe3e3',color: '#b37feb' }"
          @click="tabRight(2)"
        >
          <i :class="show ? 'el-icon-close' : 'el-icon-setting'" />
          <p>应用</p>
        </div>
        <div
          class="handle-button"
          :style="{ top: buttonTop + 'px', background: '#fdedef', color: '#ef4c5d' }"
          @click="tabRight(3)"
        >
          <i :class="show ? 'el-icon-close' : 'el-icon-setting'" />
          <p>控制台</p>
        </div>
      </div>

      <div class="rightPanel-items">
        <slot v-if="showIdx === 0" name="settings" />
        <slot v-if="showIdx === 1" name="store" />
        <slot v-if="showIdx === 2" name="addons" />
        <slot v-if="showIdx === 3" name="sys" />
        <!-- <slot /> -->
      </div>
    </div>
  </div>
</template>

<script>
import { addClass, removeClass } from '@/utils'

export default {
  name: 'RightPanel',
  props: {
    clickNotClose: {
      default: false,
      type: Boolean
    },
    buttonTop: {
      default: 250,
      type: Number
    }
  },
  data() {
    return {
      settingsShow: false,
      storeShow: false,
      showIdx: 0,
      show: false
    }
  },
  computed: {
    theme() {
      return this.$store.state.settings.theme
    }
  },
  watch: {
    show(value) {
      if (value && !this.clickNotClose) {
        this.addEventClick()
      }
      if (value) {
        addClass(document.body, 'showRightPanel')
      } else {
        removeClass(document.body, 'showRightPanel')
      }
    }
  },
  mounted() {
    this.insertToBody()
  },
  beforeDestroy() {
    const elx = this.$refs.rightPanel
    elx.remove()
  },
  methods: {
    tabRight(index) {
      this.show = true
      this.showIdx = index
    },
    addEventClick() {
      window.addEventListener('click', this.closeSidebar)
    },
    closeSidebar(evt) {
      const parent = evt.target.closest('.rightPanel')
      if (!parent) {
        this.show = false
        window.removeEventListener('click', this.closeSidebar)
      }
    },
    insertToBody() {
      const elx = this.$refs.rightPanel
      const body = document.querySelector('body')
      body.insertBefore(elx, body.firstChild)
    }
  }
}
</script>

<style>
.showRightPanel {
  overflow: hidden;
  position: relative;
  width: calc(100% - 15px);
}
</style>

<style lang="scss" scoped>
.rightPanel-background {
  position: fixed;
  top: 0;
  left: 0;
  opacity: 0;
  transition: opacity 0.3s cubic-bezier(0.7, 0.3, 0.1, 1);
  background: rgba(0, 0, 0, 0.2);
  z-index: -1;
}

.rightPanel {
  width: 100%;
  max-width: 260px;
  height: 100vh;
  position: fixed;
  top: 0;
  right: 0;
  box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.05);
  transition: all 0.25s cubic-bezier(0.7, 0.3, 0.1, 1);
  transform: translate(100%);
  background: #fff;
  z-index: 20000;
  .rightPanel-setting-list {
    position: absolute;
    left: -50px;
    top: 50%;
    z-index: 2000;
    padding: 5px;
    margin: 0;
    text-align: center;
    cursor: pointer;
    background: #fff;
    border-left: 1px solid #dcdfe6;
    border-bottom: 1px solid #dcdfe6;
    border-top: 1px solid #dcdfe6;
    border-top-left-radius: 5.5px;
    border-bottom-left-radius: 5.5px;
    box-shadow: 0 0 50px 0 rgb(82 63 105 / 15%);
    transform: translateY(-50%);
    .handle-button {
      width: 40px;
      height: 40px;
      padding: 5px;
      display: grid;
      margin-bottom: 10px;
      text-align: center;
      font-size: 24px;
      border-radius: 6px !important;
      z-index: 0;
      pointer-events: auto;
      cursor: pointer;
      color: #fff;
      line-height: 48px;
      &:hover {
        color: #fff;
        background: #3698fd;
      }
      i {
        display: inline-block;
        font-size: 12px;
        text-align: center;
        vertical-align: -3.5px;
      }
      svg {
        display: inline-block;
        text-align: center;
        vertical-align: -3.5px;
      }
      p {
        padding: 0;
        margin: 0;
        font-size: 12px;
        line-height: 25px;
        text-overflow: ellipsis;
        white-space: nowrap;
      }
    }
  }
}

.show {
  transition: all 0.3s cubic-bezier(0.7, 0.3, 0.1, 1);

  .rightPanel-background {
    z-index: 20000;
    opacity: 1;
    width: 100%;
    height: 100%;
  }

  .rightPanel {
    transform: translate(0);
  }
}
</style>

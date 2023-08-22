<template>
  <div>
    <el-input
      v-model="iconName"
      v-bind="attrs"
      placeholder="图标名称"
      v-on="desc.on"
    >
      <el-button slot="append" @click="slectIcon">
        选择图标
      </el-button>
    </el-input>

    <el-drawer
      title="图标选择"
      :visible.sync="dialogVisible"
      :direction="direction"
      :before-close="handleClose"
      append-to-body
    >
      <div class="icons-container">
        <div style="margin-top: 15px;margin-bottom: 15px;">
          <el-input v-model="iconSearch" placeholder="请输入图标名称" class="input-with-select">
            <el-button slot="append" icon="el-icon-search" @click="searchIcon" />
          </el-input>
        </div>
        <div class="grid icon-content">
          <div v-for="(icon,idx) of iconList" :key="idx" @click="handleClipboard(icon,$event)">
            <el-tooltip placement="top">
              <div slot="content">
                {{ generateElementIconCode(icon) }}
              </div>
              <div class="icon-item">
                <svg-icon class="icon sub-el-icon" :icon-class="icon" color="#e5e5e5" filter="inherit" :size="30" />
                <span>{{ icon }}</span>
              </div>
            </el-tooltip>
          </div>
        </div>
      </div>
    </el-drawer>

    <!--  <el-dialog title="图标选择" :visible.sync="dialogVisible" width="30%" :before-close="handleClose" append-to-body>

      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">取 消</el-button>
        <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
      </span>
    </el-dialog> -->
  </div>
</template>

<script>
const req = require.context('@/icons/svg', false, /\.svg$/)
const requireAll = requireContext => requireContext.keys().map(requireContext)
import formMixin from 'diandi-ele-form/lib/mixins/formMixin'
export default {
  name: 'FireIcon',
  mixins: [formMixin],
  props: {
    // desc是此组件的描述, 结构为
    // { style: {}, class: {}, on: {}, attrs: {} }
    // value 是传递过来的值
    value: {
      type: String,
      default: ''
    },
    desc: {
      type: Object,
      default() {
        return {}
      }
    }
  }, // 必须引入mixin
  data() {
    return {
      direction: 'rtl',
      dialogVisible: false,
      iconSearch: '',
      iconName: '',
      iconList: {}
    }
  },
  computed: {
    errorLogs() {
      return this.$store.getters.errorLogs
    }
  },
  watch: {
    iconSearch: {
      handler(newVal) {
        if (newVal) {
          console.log('newVal', newVal)
        }
      },
      immediate: true,
      deep: true
    },
    value: {
      handler(newVal) {
        if (newVal) {
          this.iconName = newVal
        }
      },
      immediate: true,
      deep: true
    }
  },
  created() {
    const that = this
    const iconList = []
    requireAll(req).forEach((element, index) => {
      iconList.push(element.default.id.replace('icon-', ''))
    })
    that.iconList = iconList
  },
  methods: {
    slectIcon() {
      this.dialogVisible = true
    },
    searchIcon() {
      const that = this
      const iconList = []
      requireAll(req).forEach((element, index) => {
        iconList.push(element.default.id.replace('icon-', ''))
      })
      that.iconList = iconList
      if (that.iconSearch) {
        that.iconList = that.iconList.filter(item => item.indexOf(that.iconSearch) !== -1)
      }
    },
    handleClose(done) {
      this.$confirm('确认关闭？')
        .then(_ => {
          done()
        })
        .catch(_ => {})
    },
    generateIconCode(symbol) {
      return `<svg-icon icon-class="${symbol}" />`
    },
    generateElementIconCode(symbol) {
      return `<i class="${symbol}" />`
    },
    handleClipboard(text, event) {
      const that = this
      that.iconName = text
      that.$emit('input', that.iconName)
      this.dialogVisible = false
      console.log(text, event)
    }
  }
}
</script>

<style lang="scss" scoped>
  .icons-container {
    margin: 10px 20px 0;
    height: 100vh;
    overflow: hidden;

    .icon-content {
      height: 90vh;
      overflow: overlay;
    }

    .sub-el-icon{
      font-size: 30px;
    }

    .grid {
      position: relative;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    }

    .icon-item {
      margin: 20px;
      height: 85px;
      text-align: center;
      width: 100px;
      float: left;
      font-size: 30px;
      color: #24292e;
      cursor: pointer;
    }

    span {
      display: block;
      font-size: 16px;
      margin-top: 10px;
    }

    .disabled {
      pointer-events: none;
    }
  }
</style>

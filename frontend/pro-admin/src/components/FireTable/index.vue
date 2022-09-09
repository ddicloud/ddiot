<template>
  <div class="complex-table_container">
    <el-table
      :key="tableKey"
      v-loading="listLoading"
      :data="list"
      :row-key="rowKey"
      :data-total="total"
      :tree-props="{children: 'children', hasChildren: 'hasChildren'}"
      size="small"
      style="width: 100%;"
      @selection-change="handleSelectionChange"
    >

      <el-table-column v-if="showSelection" type="selection" width="55" align="center" />

      <el-table-column v-if="showIndex" type="index" width="50" label="序列" align="center" />
      <!-- 基础列 start -->
      <template v-for="(col,index) in columns" v-bind="index">
        <!-- 定义插槽 start -->
        <el-table-column v-if="col.slot" :key="index" :width="col.width" :label="col.label">
          <template slot-scope="{row}">
            <slot :name="col.slot" :row="row" :index="index" />
          </template>
        </el-table-column>
        <!-- 定义插槽 end -->
        <!-- 正常数据 start -->
        <el-table-column v-else :key="index" :label="col.label" :width="col.width">
          <template slot-scope="{row}">
            <template v-if="'render' in col">
              <Render :row="row" :render="col.render" />
            </template>
            <span v-else>{{ row[col.prop] }}</span>
          </template>
        </el-table-column>
        <!-- 正常数据 end -->
      </template>
      <!-- 基础列 end -->

      <el-table-column v-if="handle.length" v-bind="handleColumn" :width="(handle.length * 80)+'px'">
        <template slot-scope="scope">
          <template v-for="(btn, index) in handle">
            <el-button
              v-if="!btn.isPop"
              :key="index"
              style="margin: 5px;"
              size="mini"
              :type="btn.type"
              @click.native.prevent="btn.method(scope.row,scope)"
            >{{ btn.label }}</el-button>
            <el-popconfirm
              v-if="btn.isPop"
              :key="index"
              placement="right"
              confirm-button-text="确定"
              cancel-button-text="取消"
              icon="el-icon-info"
              icon-color="red"
              :title="btn.title?btn.title:'确定删除吗？'"
              @confirm="$message.success('操作成功');getList();btn.method(scope.row, scope)"
            >
              <el-button slot="reference" style="margin: 5px;" size="mini" :type="btn.type">{{ btn.label }}</el-button>
            </el-popconfirm>
          </template>
        </template>
      </el-table-column>
    </el-table>
    <pagination
      v-show="total>listQuery.pageSize"
      style="padding: 8px 16px; margin-top: 10px;"
      :total="total"
      :page.sync="listQuery.page"
      :limit.sync="listQuery.pageSize"
      @pagination="getList"
    />
  </div>
</template>
<script>
import Pagination from '@/components/Pagination'
import Render from '@/directive/columnRender'
export default {
  name: 'FireTable',
  components: {
    Pagination,
    Render
  },
  props: {
    showSelection: {
      type: Boolean,
      default: false
    },
    showIndex: {
      type: Boolean,
      default: false
    },
    listQuery: {
      type: Object,
      default: () => ({
        page: 1,
        pageSize: 20
      })
    },
    list: {
      type: Array,
      default: () => []
    },
    total: {
      type: Number,
      default: 0
    },
    columns: {
      type: Array,
      default: () => []
    },
    operates: {
      type: Array,
      default: () => []
    },
    handle: {
      type: Array,
      default: () => []
    },
    crud: {
      type: String,
      default: 'crud'
    },
    rowKey: {
      type: [String, Function],
      default: () => {
        return 'id'
      }
    },
    actionsColumn: {
      type: Object,
      default: () => ({
        label: '操作',
        align: 'center'
      })
    },
    listLoading: {
      type: Boolean,
      default: true
    },
    handleColumn: {
      type: Object,
      default: () => ({
        label: '操作',
        align: 'center'
      })
    }
  },
  data() {
    return {
      filterForm: {},
      tableKey: 0,
      multipleSelection: []
    }
  },
  computed: {
    tableHeight() {
      console.log(
        'tableHeight',
        this.total,
        this.listQuery.size,
        window.document.body.clientHeight
      )
      if (this.total > this.listQuery.size) {
        return window.document.body.clientHeight - 242
      } else {
        return window.document.body.clientHeight - 180
      }
    }
  },
  watch: {
    columns(val) {
      console.log('列数据', val)
    }
  },
  created() {},
  methods: {
    getRowKeys(row) {
      return row[this.rowKey] // 每条数据的唯一识别值
    },
    getList(val) {
      console.log(val)
      this.$emit('getList', val)
    },
    handleSelectionChange(val) {
      console.log(val)
      this.multipleSelection = val
      this.$emit('handleSelectionChange', val)
    }
  }
}
</script>
<style lang="scss">
.complex-table_container {
  margin-top: 15px;

  .el-loading-mask {
    z-index: 500;
  }

  .el-table__body-wrapper {
    &::-webkit-scrollbar {
      /*滚动条整体样式*/
      width: 6px !important;
      /*高宽分别对应横竖滚动条的尺寸*/
      height: 6px !important;
      background: #ffffff !important;
      cursor: pointer !important;
    }

    &::-webkit-scrollbar-thumb {
      /*滚动条里面小方块*/
      border-radius: 5px !important;
      box-shadow: inset 0 0 5px rgba(240, 240, 240, 0.5) !important;
      background: rgba(63, 98, 131, 0.8) !important;
      cursor: pointer !important;
    }

    &::-webkit-scrollbar-track {
      /*滚动条里面轨道*/
      box-shadow: inset 0 0 5px rgba(240, 240, 240, 0.5) !important;
      border-radius: 0 !important;
      background: rgba(240, 240, 240, 0.5) !important;
      cursor: pointer !important;
    }
  }
}
</style>

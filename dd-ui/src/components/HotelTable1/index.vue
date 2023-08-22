<template>
  <div class="complex-table_container">
    <el-table
      :data="tableData"
      :span-method="objectSpanMethod"
      @header-click="headerClick"
      border
      style="width: 100%; margin-top: 20px"
    >
      <template v-for="(col, i) in columnData">
        <!-- 定义插槽 start -->
        <el-table-column
          v-if="col.slot"
          :key="i"
          :width="col.width"
          :label="col.label"
          :fixed="col.fixed || false"
          align="center"
        >
          <template slot-scope="{ row, column }">
            <el-row type="flex" justify="center">
              <slot :name="col.slot" :row="[row, column]" />
            </el-row>
          </template>
        </el-table-column>
        <!-- 定义插槽 end -->
        <!-- 正常数据 start -->
        <el-table-column
          v-else
          :key="i"
          :label="col.label"
          :width="col.width"
          :fixed="col.fixed || false"
          align="center"
        >
          <template slot-scope="{ row }">
            <template v-if="'render' in col">
              <Render :row="row" :render="col.render" />
            </template>
            <span v-else>{{ row[col.prop] }}</span>
          </template>
        </el-table-column>
        <!-- 正常数据 end -->
      </template>
    </el-table>
  </div>
</template>

<script>
export default {
  props: {
    listLoading: {
      type: Boolean,
      default: true // true
    },
    tableData: {
      type: Array,
      default: []
    },
    columnData: {
      type: Array,
      default: []
    }
  },
  data() {
    return {}
  },
  methods: {
    headerClick(column, event) {
      this.$emit('headerClick', column, event)
    },
    // 行列合并
    objectSpanMethod({ row, column, rowIndex, columnIndex }) {
      if (columnIndex === 0) {
        if (rowIndex % 2 === 0) {
          return {
            rowspan: 2,
            colspan: 1
          }
        } else {
          return {
            rowspan: 0,
            colspan: 0
          }
        }
      }
    }
  }
}
</script>

<style lang="scss">
.complex-table_container {
  margin-top: 20px;
  padding: 27px 11px 20px;
  background: #ffffff;
  border-radius: 8px;
}
</style>

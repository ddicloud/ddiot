<template>
  <el-table
    :data="tableData"
    :span-method="objectSpanMethod"
    border
    style="width: 100%; margin-top: 20px"
  >

    <el-table-column v-for="(item,index) in ColumnVal" :key="index+'ColumnVal'" v-bind="attrs" :prop="item.field" :label="item.label" />

    <el-table-column v-for="(item,index) in ColumnInput" :key="index+'ColumnInput'" :prop="item.prop" :label="item.label">
      <template slot-scope="scope">
        <el-input
          v-model="chageColumnValue[scope.$index+'_'+index]"
          :data-row="scope.$index"
          class="margin-top-xs"
          :placeholder="item.placeholder"
          @input="chageColumnInput($event,scope.row,scope.$index,index)"
        />
      </template>
    </el-table-column>

    <el-table-column v-for="(comb,index) in Combination" :key="index+'Combination'" :prop="comb.prop" :label="comb.label">
      <template slot-scope="scope">
        <el-input
          v-for="(item,idx) in comb"
          :key="idx+'comb'"
          v-model="chageDisCombinationValue[scope.$index+'_'+idx+'_'+index]"
          :data-row="scope.$index"
          class="margin-top-xs"
          :placeholder="item.placeholder"
          @input="chageDisCombination($event,scope.row,scope.$index,idx,index)"
        />

      </template>

    </el-table-column>

  </el-table>
</template>
<script>
import formMixin from 'diandi-ele-form/lib/mixins/formMixin'
export default {
  name: 'FireDataTable', // name 属性必须填写, 在使用时, 需要和这里定义的 name 一致
  mixins: [formMixin], // 必须引入mixin
  props: {
    // desc是此组件的描述, 结构为
    // { style: {}, class: {}, on: {}, attrs: {} }
    // value 是传递过来的值
    desc: {
      type: Object,
      default() {
        return {}
      }
    }
  },
  data() {
    return {
      chageColumnValue: [],
      listData: [],
      chageDisCombinationValue: [],
      newData: [],
      spanArr: [],
      pos: [],
      ColumnVal: [],
      ColumnInput: [],
      ColumnHiddenInput: [],
      listSku: {
        '颜色': ['红黑色', '绿色', '紫色', '白色'],
        '尺寸': ['xl', 'xxl', 'mm', 'sm'],
        '形状': ['正方形', '长方形', '矩形', '菱形']
      },
      Combination: [
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
      ],
      tableData: []
    }
  },
  watch: {
    attrs: function(val) {
      const that = this
      console.log('ColumnVal 监听attrs', val)
      const { ColumnVal, ColumnInput, Combination, ColumnHiddenInput, chageColumnValue } = val
      that.ColumnVal = ColumnVal || []
      that.ColumnInput = ColumnInput || []
      that.Combination = Combination || []
      that.ColumnHiddenInput = ColumnHiddenInput || []
      // 初始化赋值
      that.chageColumnValue = chageColumnValue || {}
    },
    options: function(val) {
      const that = this
      that.listSku = val
      const list = []
      that.listSku.forEach((item, index) => {
        const i = Object.values(item)
        console.log('options11', i)
        list.push(i[0])
      })
      const k = []
      console.log('options', val)
      console.log('optionslist', list)
      const listd = that.descartes(list)
      // 获取字段，需注意顺序
      that.ColumnVal.forEach((item, index) => {
        k.push(item.field)
      })
      const tableData = []
      // 排列组合计算结果赋值给表格
      listd.forEach((item, index) => {
        const data = []
        item.forEach((i, x) => {
          that.$set(data, k[x], i)
        })
        tableData.push(data)
      })
      that.tableData = tableData
      console.log('tableData listd', listd)
      console.log('tableData tableData', tableData)
      that.getSpanArr(that.tableData)
    }
  },
  methods: {
    // 笛卡尔积计算
    descartes: function(array) {
      console.log('descartes', array)
      if (array.length < 2) return array[0] || []
      return [].reduce.call(array, function(col, set) {
        var res = []
        col.forEach(function(c) {
          set.forEach(function(s) {
            var t = [].concat(Array.isArray(c) ? c : [c])
            t.push(s)
            res.push(t)
          })
        })
        return res
      })
    },
    chageColumnInput(event, row, index, col) {
      const that = this

      console.log('row 01', event, index, col)
      console.log('row 02', row)

      Object.keys(this.ColumnHiddenInput).forEach((item, idx) => {
        console.log('ColumnHiddenInput 02', this.ColumnHiddenInput[item], index)
        that.$set(row, item, this.ColumnHiddenInput[item][index])
      })

      that.$set(row, that.ColumnInput[col].prop, event)
      that.$set(that.chageColumnValue, index + '_' + col, event)
      that.$set(that.listData, index, row)
      that.$emit('input', that.listData)
    },
    chageDisCombination(event, row, index, col) {
      const that = this
      that.$set(that.chageDisCombinationValue, row + '_' + index + '_' + col, event)
      that.$emit('input', that.chageDisCombinationValue)
    },
    retName(index) {
      console.log(index)
    },
    // 计算位置的方法
    getSpanArr(data) {
      const that = this
      that.spanArr = []
      that.pos = []
      // 多个字段组合计算合并
      that.ColumnVal.forEach(item => {
        const field = item.field
        const basespan = []
        let basepos = ''
        // 判断当前元素与上一个元素是否相同
        for (var i = 0; i < data.length; i++) {
          if (i === 0) {
            basespan.push(1)
            basepos = 0
          } else {
            if (data[i][field] === data[i - 1][field]) {
              basespan[basepos] += 1
              basespan.push(0)
            } else {
              basespan.push(1)
              basepos = i
            }
          }
        }
        that.$set(that.spanArr, field, basespan)
        that.$set(that.pos, field, basepos)
      })
    },
    // 合并行数
    objectSpanMethod({ row, column, rowIndex, columnIndex }) {
      const that = this
      // columnIndex === 0 找到第一列，实现合并随机出现的行数
      const columns = Object.keys(row)

      const ll = {
        'rowspan': 1,
        'colspan': 1
      }

      columns.forEach((item, index) => {
        if (columnIndex === index && this.spanArr[item]) {
          const _row = this.spanArr[item][rowIndex]
          const _col = _row > 0 ? 1 : 0
          that.$set(ll, 'rowspan', _row)
          that.$set(ll, 'colspan', _col)
        }
      })

      return ll
    }
  }
}
</script>

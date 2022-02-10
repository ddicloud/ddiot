<template>
  <div class="config-list">
    <el-radio-group v-model="type" style="font-size: 12px">
      <div class="item">
        <el-radio label="TYPE_EVERY" class="choice" :disabled="disabled" size="mini" :border="true">Every Year
        </el-radio>
      </div>
      <div class="item">
        <el-radio label="TYPE_RANGE" class="choice" :disabled="disabled" size="mini" :border="true">Range</el-radio>
        From
        <el-input-number :disabled="type!==TYPE_RANGE || disabled" :min="0" :precision="0"
                         v-model="valueRange.start" style="width: 120px" size="mini"/>
        year(y)
        To
        <el-input-number :disabled="type!==TYPE_RANGE || disabled" :min="1" :precision="0"
                         v-model="valueRange.end" style="width: 120px" size="mini"/>
        year(y)
      </div>
      <div class="item">
        <el-radio label="TYPE_LOOP" class="choice" :disabled="disabled" size="mini" :border="true">Cycle</el-radio>
        From
        <el-input-number :disabled="type!==TYPE_LOOP || disabled" :min="0" :precision="0"
                         v-model="valueLoop.start" style="width: 120px" size="mini"/>
        year To
        <el-input-number :disabled="type!==TYPE_LOOP || disabled" :min="0" :precision="0"
                         v-model="valueLoop.end" style="width: 120px" size="mini"/>
        year, Interval
        <el-input-number :disabled="type!==TYPE_LOOP || disabled" :min="1" :precision="0"
                         v-model="valueLoop.interval" style="width: 120px" size="mini"/>
        year
      </div>
    </el-radio-group>
  </div>
</template>

<script>
  import mixin from './mixin'

  export default {
    name: 'year',
    mixins: [mixin],
    data() {
      return {}
    },
    watch: {
      value_c(newVal, oldVal) {
        // console.info('change:' + newVal)
        this.$emit('change', newVal)
      }
    },
    created() {
      const nowYear = (new Date()).getFullYear()
      this.DEFAULT_VALUE = '*'
      this.minValue = 0
      this.maxValue = 0
      this.valueRange.start = nowYear
      this.valueRange.end = nowYear + 100
      this.valueLoop.start = nowYear
      this.valueLoop.end = nowYear + 100
      this.valueLoop.interval = 1
      // console.info('created')
      this.parseProp(this.prop)
    }
  }
</script>

<style scoped>

  .config-list {
    text-align: left;
    margin: 0 10px 10px 10px;
  }

  .item {
    margin-top: 5px;
  }

  .choice {
    border: 1px solid transparent;
    padding: 5px 8px;
  }

  .choice:hover {
    border: 1px solid #2d8cf0;
  }


</style>

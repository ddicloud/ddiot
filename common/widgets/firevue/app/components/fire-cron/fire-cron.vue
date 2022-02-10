<template>
    <div>
       <div class="form-group">
        <label for="name">定时时间</label>
        <el-row>
            <input-cron v-model="value" @change="changeCron" :hide-year="true"></input-cron>
        </el-row>
    </div>
    </div>
</template>

<script>
    import InputCron from './common/input-cron'
    export default {
        name: "fire-cron",
        model: {
            prop: 'value',
            event: 'update'
        },
        props: {
          value: {
              type: String,
              default: '* * * * * *'
          },
          i18n: {
            type: String,
              default: 'cn'
          }
        },
        components: {
            InputCron
        },
        data() {
            return {
                cronPopover: false,
            };
        },
        methods: {
            changeCron(newVal, oldVal){
                this.value = newVal
                this.$emit('change', newVal)
            }
        },
        created() {
            
        }
    }
</script>

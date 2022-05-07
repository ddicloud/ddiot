<template>
  <div :class="className">
    <el-card class="box-card info-box" shadow="hover" :body-style="{ padding: padding }">
      <div slot="header" class="clearfix">
        <span> {{ name }}</span>
        <el-button style="float: right; padding: 3px 5px" size="mini" type="primary" @click="btnBox">
          <span class="padding-right-xs">{{ btnText }}</span><i class="fa fa-arrow-circle-right" />
        </el-button>
      </div>
      <div class="text item el-row--flex">
        <div class="">
          <el-image
            style="width: 80px; height: 80px"
            :src="img"
            fit="contain"
          />
        </div>
        <div class="padding-sm media-desc">
          {{ desc }}
        </div>
      </div>
      <div class="bottom clearfix">
        <slot name="foot" />
      </div>
    </el-card>
  </div>
</template>

<script>
export default {
  name: 'FireMediaBox',
  props: {
    /* eslint-disable */
    img: String,
    padding:{
        type: String,
        default:'5px'
    },
    name: String,
    desc: String,
    btnText:String,
    className: String
  },
  data() {
    return {

    }
  },
  created() {
    console.log(this.name,this.img,this.desc)
  },
  methods:{
    btnBox(e){
      this.$emit('clickBox',e)
    }
  },
  computed: {
  },
  }
</script>

<style lang="scss" scoped>
  .info-box {
      display: block;
      min-height: 90px;
      background: #fff;
      // box-shadow: 0 1px 1px rgb(0 0 0 / 10%);
      // border-radius: 2px;
      // padding: 10px;
      margin: 10px;
  }
  .bottom {
    margin-top: 13px;
    line-height: 12px;
    text-align: right;
  }
  .clearfix:before,
  .clearfix:after {
      display: table;
      content: "";
  }
  .clearfix:after {
      clear: both
  }
  .media-desc{
    text-overflow: -o-ellipsis-lastline;
     overflow: hidden;
     text-overflow: ellipsis;
     display: -webkit-box;
     -webkit-line-clamp: 2;
     line-clamp: 2;
     -webkit-box-orient: vertical;
  }
</style>

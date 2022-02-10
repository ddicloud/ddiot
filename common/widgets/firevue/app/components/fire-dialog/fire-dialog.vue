<style scoped>
  .sy-dialog-content {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: calc(100vh - 50px);
    border-radius: 12px;
    box-shadow: #000c17;
    z-index:2000;
    padding-top: 2vh;
    padding-left: 10vw;
  }
  .sy-dialog-card {
    width: 80vw;
    min-height: 90vh;
    height: calc(100vh - 50px);
    overflow-y: overlay;
  }
  .sy-dialog-opt {
    float: right;
    padding: 3px 0;
    margin-left: 12px;
  }
</style>
<template>
  <div v-show="visible" class="sy-dialog-content" ref="elementdialog">
      <el-card    class="sy-dialog-card" :body-style="{ padding: '0px' }"  v-loading="loading"  element-loading-text="加载中" element-loading-spinner="el-icon-loading">
        <div slot="header" class="clearfix">
          <span>{{title}}</span>
          <el-button class="sy-dialog-opt" type="text" @click="close()">关闭</el-button>
          <el-button v-for="(btn,index) in btns"  :key='index' class="sy-dialog-opt" type="text" @click="handleClick(btn.clickEventName)">{{btn.name}}</el-button>
        </div> 
        <iframe  :src="url"    @load="getLoding()" frameborder="0" width="100%" :height="iframeH" v-show="isIframe==true"></iframe>
        <slot name="body"  v-show="isIframe==false && body">{{ body }}</slot>
     </el-card>
  </div>
</template>

<script>
    import ElCard from 'element-ui/packages/card/src/main';
    import ElButton from 'element-ui/packages/button/src/button';
    // import ElRow from 'element-ui/packages/row/src/row';
    export default {
    components: {
        ElCard,
        ElButton,
        // ElRow
    },
    props: [
        'title',
        'url',
        'btns',
        'param',
        'isIframe',
        'visible',
      ],
      name: "fire-dialog",
      data: function () {
        return {
          body:'',
          params: {},
          btns:[],
          iframeH:'',
          loading:true
        }
      },
      watch: {
        visible(val){
          console.log('监听dialog',val)
          this.visible = val
        },
        deep: true
      },
      mounted () {
        let _this=this;
        _this.$nextTick(function () {
          this.init()
        })
      },
      created () {
        let _this=this;

        if(_this.isIframe==undefined){
          _this.isIframe = true
        }

      },
      methods: {
        init () {
           setTimeout(() => {
              this.loading = false
           },800);
        },
        handleClick(eventName) {
          for (let btn of this.btns) {
            if (btn.clickEventName == eventName) {
              btn.func(this.$refs['cp'][0])
            }
          }
        },
        close(index){
          this.visible = false
          this.$emit("close", {
            index: index
          })
        },
        getLoding(){
             let height= this.$refs.elementdialog.offsetHeight;
            this.iframeH = (height-50)+'px'
            // console.log('屏幕高度',height,this.$refs.elementdialog,this.$refs.elementdialog.offsetWidth,this.$el.offsetHeight)    
            // console.log('加载事件',this.loading)
        },
      }
    }
</script>


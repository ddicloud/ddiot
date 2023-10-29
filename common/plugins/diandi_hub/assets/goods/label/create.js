/*
* @Author: Wang chunsheng  email:2192138785@qq.com
* @Date:   2020-06-06 15:06:48
* @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
* @Last Modified time: 2020-11-07 19:38:52
*/
// import VueResource from '../node_modules/vue-resource/dist/vue-resource.js'

// import {im} from 'common/importJs.js'
// 以form data 方式进行post请求

new Vue({
  el: '#goods-label-create',
      data: function () {
          return {
              color: '#409EFF'
          }
      },
      created: function (options) {
          let that = this;
          console.log(options,that.global.getUrlParam('id'))

          that.init();
      },
      methods: {
      init(){
          let that = this;
        
          
      },
  
  }
})
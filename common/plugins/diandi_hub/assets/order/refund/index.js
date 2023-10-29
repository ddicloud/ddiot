/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-11 14:30:43
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-11 14:31:12
 */
new Vue({
  el: '#hub-refund-order-index',//当前页面id
  data: function () {
      return {
        
      }
  },
  created: function () {
      let that = this;
  },
  methods: {
    dialog(title,url){
      let that = this;
      that.Popup({
          url:url,
          title:title,
          
          openbefore: () => {
            // 点击按钮事件
            console.log('打开前前')
          }
        })

    }
   
   
}
})
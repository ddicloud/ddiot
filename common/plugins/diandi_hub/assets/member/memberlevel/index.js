/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-13 03:25:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-03 03:28:58
 */
new Vue({
  el: '#hub-member-level-index',//当前页面id
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
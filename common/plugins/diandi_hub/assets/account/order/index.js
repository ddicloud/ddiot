/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-29 15:49:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-29 15:53:28
 */
new Vue({
  el: '#hub-account-order-index',//当前页面id
  data: function () {
      return {
        pickerOptions: {
          shortcuts: [{
            text: '最近一周',
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
              picker.$emit('pick', [start, end]);
            }
          }, {
            text: '最近一个月',
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
              picker.$emit('pick', [start, end]);
            }
          }, {
            text: '最近三个月',
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
              picker.$emit('pick', [start, end]);
            }
          }]
        },
        value1:['',''],
        value2: ''
      }
  },
  created: function () {
    
  },
  methods: {
    getEXcel:function(){
        let that = this;
  
          that.$http.post('exportdatalist', {
              pay_status:that.pay_status,
              pay_type:that.pay_type,
              order_status:that.order_status,
              between_time:that.value1
          }).then((response) => {
              console.log(response.data)
              //响应成功回调
              if (response.data.code == 200) {
                  // list = JSON.parse(JSON.stringify(response.data.data.cate))
                  console.log(response.data.data.url)
                  window.open(response.data.data.url)

              }else{
                  this.$message.error(response.data.message);
              }
              
          return false;
      }, (response) => {
          //响应错误回调
          console.log(response)
      });
  
  },
   
}
})
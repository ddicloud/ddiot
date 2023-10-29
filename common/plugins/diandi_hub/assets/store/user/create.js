/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-12 10:19:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-01 15:25:57
 */
new Vue({
  el: '#hub-store-user-form',//当前页面id
  data: function () {
      return {
            member_id:'',
            store_id:'',
            bloc_id:'',
            storelist:[],
            memberlist:[],
            is_store:0,
            storenames:[],
            member_store_id:'',
            height:'',
            visible:false,
            membervisible:false,
            imgShow: true,
            storename:'',
            downloadLoading: false,
            list: [],//列表数据
            imageList: [],
            listLoading: true,
            keywords:'',
            elementLoadingText: '正在加载...'
          }
  },
  created: function () {
      let that = this;
      console.log('全局设置是否可以',window.sysinfo,window.innerHeight)
  
  },
  methods: {
    // 初始化页面数据
    init(){
      let that = this;
      that.searchList();
    },
    // 获取列表数据
    searchList(queryForm){
          let that = this;
          that.listLoading = true
          
          let data = {
            keywords:that.keywords
          }
      
          that.$http.post('storelist', data).then((response) => {
              console.log(response) 
            //响应成功回调
              if (response.data.code == 200) {
                that.storelist = response.data.data
                console.log('storelist',that.storelist) 

                that.visible = true

              }
              setTimeout(() => {
                this.listLoading = false
              }, 500)
              return false;
          }, (response) => {
              //响应错误回调
              console.log(response)
          });

    },
    searchMember(){
      
      let that = this;
      that.listLoading = true
      
      let data = {
        keywords:that.keywords
      }
  
      that.$http.post('memberlist', data).then((response) => {
          console.log(response) 
        //响应成功回调
          if (response.data.code == 200) {
            that.memberlist = response.data.data
            console.log('storelist',that.storelist) 

            that.membervisible = true

          }
          setTimeout(() => {
            this.listLoading = false
          }, 500)
          return false;
      }, (response) => {
          //响应错误回调
          console.log(response)
      });
      

    },
    setStore(e){
      let that = this
      that.is_store = e
      if(e==0){
        that.member_store_id = ''
        that.storenames = [];

        console.log(e,that.member_store_id)
      }
      console.log(e,that.is_store)
    },
    setSelectRows(val) {
      this.selectRows = val
    },
    handleEdit(index,row) {
      let that = this
      console.log(index,row)
      that.store_id = row.store_id
      that.bloc_id = row.bloc_id
      that.visible = false

    },
    handleMember(index,row) {
      let that = this
      console.log(index,row)
      that.member_id = row.member_id
      that.membervisible = false
    },
}
})
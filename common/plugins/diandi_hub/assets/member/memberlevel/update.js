/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-12 10:19:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-12 20:34:38
 */
        new Vue({
            el: '#hub-member-level-form',//当前页面id
            data: function () {
                return {
                      listKey:'member_id',//列表数据主键
                      storelist:[],
                      is_store:0,
                      storenames:[],
                      member_store_id:'',
                      height:'',
                      visible:false,
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
                that.$http.post('view',{
                  id:that.global.getUrlParam('id')
                }).then((response) => {
                  console.log(response) 
                //响应成功回调
                  if (response.data.code == 200) {
                    let list  = response.data.data.model
                    console.log('is_store',list.is_store)  
                    console.log('list',list,response.data.data)  
                    that.member_store_id = list.member_store_id
                    that.storenames       = response.data.data.storelists
                    that.is_store = list.is_store
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
                that.member_store_id = row.store_id
                that.storename = row.name
                
                that.visible = false

              },
              handleEdit(val) {
                console.log(val)
                if(val.length>0){
                  let store_ids=[] 
                  val.forEach((item,index)=>{
                    store_ids.push(item.store_id)
                  })
                  this.storenames = val;
                 
                  this.member_store_id = store_ids.join(',');
                
                }
               
              },
          }
        })
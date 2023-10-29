/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-07 10:11:28
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-08 12:18:34
 */
        new Vue({
            el: '#hub-express-template-view',//当前页面id
            data: function () {
                return {
                  tableData:[],
                  filterText: '',
                  view:[],//列表数据
                  citys:[],
                  value: [],
                  defaultProps: {
                    children: 'children',
                    label: 'name'
                  },
                  title:'',
                  express_id:0,
                  template_id:0,
                  loading:true,
                }
            },
            created: function () {
                let that = this;
              
                that.init();
            },
            watch: {
              filterText(val) {
                console.log(val)
                this.$refs.tree.filter(val);
              }
            },
            methods: {
              tableRowClassName({row, rowIndex}) {
                if (rowIndex === 1) {
                  return 'warning-row';
                } else if (rowIndex === 3) {
                  return 'success-row';
                }
                return '';
              },
              filterNode(value, citys) {
                console.log(value, citys)
                if (!value) return true;
                return citys.name.indexOf(value) !== -1;
              },
              // 初始化页面数据
              init(){
                let that = this;
                that.getView();
                
              },
              // 获取列表数据
              getView(queryForm){
                let that = this;
                let data = {
                  id:that.global.getUrlParam('id')
                }
              
                that.$http.post('view', data).then((response) => {
                        //响应成功回调
                        console.log('view',response.data)
                        if (response.data.code == 200) {
                          that.view = response.data.data.list
                          that.title = response.data.data.title
                          that.express_id = response.data.data.express_id
                          that.template_id = response.data.data.template_id
                           that.getCitys();
                           that.loading = false
              
                        }
                    
                });
                
              },
              getCitys(){
                let that = this
                
                that.$http.post("citylist",{}).then((res)=>{
                  console.log('citys',res.data)
                  if (res.data.code == 200) {
                    let citys =  [{
                              id:0,
                              level: 0,
                              name: "全国",
                              pid: 0,
                              value: 0,
                              children:res.data.data
                            }]
                    
                      
                      that.citys = citys
                      console.log(res.data);
                      that.getArea();

                  } 
                }).catch((res)=>{
                  console.log('错误',res)
                })
              },
              // 树形结构
              getCheckedNodes() {
                console.log(this.$refs.tree.getCheckedNodes());
              },
              getCheckedKeys() {
                let that = this
                
                const loading = this.$loading({
                  lock: true,
                  text: '请稍后，努力加载中',
                  spinner: 'el-icon-loading',
                  background: 'rgba(0, 0, 0, 0.7)'
                });
              
                
                
                that.$http.post("templatearea",{
                  'title':that.title,
                  'express_id':that.express_id,
                  'template_id':that.template_id,
                  'region_ids':this.$refs.tree.getCheckedKeys()
                }).then((res)=>{
                  console.log('citys',res.data)
                  if (res.data.code == 200) {
                    this.$message({
                      message: res.data.message,
                      type: 'success'
                    });
                    
                    
                  }else{
                    
                    this.$message.error(res.data.message);
                    
                  } 

                  loading.close();

                }).catch((res)=>{
                  console.log('错误',res)
                })
              },
              getArea(){
                let that = this
                that.$http.post("getarea",{
                  'express_id':that.express_id,
                  'template_id':that.template_id,
                }).then((res)=>{
                  console.log('citys',res.data)
                  if (res.data.code == 200) {
                    let region = res.data.data
                    console.log('region',res.data.data)
                    this.$refs.tree.setCheckedKeys(region);
                  } 
                }).catch((res)=>{
                  console.log('错误',res)
                })
              },
              setCheckedKeys() {
                this.$refs.tree.setCheckedKeys([3]);
              },
              resetChecked() {
                this.$refs.tree.setCheckedKeys([]);
              },
              specialArea(){
                let that = this
                that.Popup({
                  url:'../../express/area/index?template_id='+that.template_id,
                  title:'特殊地区设置',
                  
                  openbefore: () => {
                    // 点击按钮事件
                    console.log('打开前前')
                  }
                })
              }
              
          }
    })
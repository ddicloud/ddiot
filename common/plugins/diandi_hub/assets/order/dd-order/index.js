/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-20 19:29:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-07 00:58:35
 */


import {loadCLodop,getLodop} from '/backend/resource/js/LodopFuncs.js'

new Vue({
    el: '#dd-order-index',
    data: {
        title: "打印标题",
        admin:'打印人',
        order:{},
        store:{},
        date: '',
        pay_status:'',
        pay_type:'',
        order_status:'all',
        dialogVisible:false,
        ids:[],
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
    },
    created:function(){
        let that = this
        console.log('创建开始')
        that.init();
    },
    methods: {
        init(){
            
            let that = this
            let pay_status = that.global.getUrlParam('HubOrderSearch[pay_status]') || '';
            let pay_type = that.global.getUrlParam('HubOrderSearch[pay_type]') || '';
            let between_time = that.global.getUrlParam('HubOrderSearch[between_time]') || '';
            
            let order_status = that.global.getUrlParam('HubOrderSearch[order_status]');
            
            that.order_status  = order_status !='all'?order_status:''; 
            that.pay_status  = pay_status
            that.pay_type  = pay_type
            
            if(between_time!=''){
                
                that.value1  = between_time.split(',') 
                
            }
            
            console.log('pay_status',pay_status);
            
            that.$http.post('printsip', {
               
            },{
                headers:{
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
                    'X-CSRF-Token':window.sysinfo.csrfToken // _csrf验证
                }
            }).then((response) => {
                console.log(response.data)
                 //响应成功回调
                    if (response.data.code == 200) {
                        // list = JSON.parse(JSON.stringify(response.data.data.cate))
                        loadCLodop(response.data.data.Lodop_ip)
                    }
                    
                return false;
            }, (response) => {
                //响应错误回调
                console.log(response)
            });
        },
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
        details: function() {
            return  this.site + " - 学的不仅是技术，更是梦想！";
        },
        prints:function(){
            let that = this;

            that.dialogVisible = true 
            console.log(that.global.getUrlParam('id'),that.ids)

            var ids_v = $("#ordergrid").yiiGridView("getSelectedRows");
            console.log(ids_v)
            
            that.$http.post('prints', {ids:ids_v}).then((response) => {
                   console.log(response.data)
                    //响应成功回调
                    if (response.data.code == 200) {
                        // list = JSON.parse(JSON.stringify(response.data.data.cate))
                        
                        that.title = response.data.data.store.wxappName;
                        that.store = response.data.data.store;
                        that.order = response.data.data.order;
                        that.date  = response.data.data.time;
                        that.admin  = response.data.data.admin;
                        that.Lodop_ip = response.data.data.Lodop_ip;
                          
                        console.log(that.color)
                    }
                    
                return false;
            }, (response) => {
                //响应错误回调
                console.log(response)
            });
            
        },
        print_cloud:function(){
            let that = this;

            that.dialogVisible = true 
            console.log(that.global.getUrlParam('id'),that.ids)

            var ids_v = $("#ordergrid").yiiGridView("getSelectedRows");
            let storeSeleted = localStorage.getItem("bloc");
            let bloc = JSON.parse(storeSeleted);
            let ps = '?bloc_id='+bloc.bloc_id+'&store_id='+bloc.store_id
            that.$http.post('printcloud'+ps, {ids:ids_v}).then((response) => {
                console.log(response.data)
                 //响应成功回调
                 if (response.data.code == 200) {
                  
                 }
                 
             return false;
         }, (response) => {
             //响应错误回调
             console.log(response)
         });
        },
        print_preview:function(){
            console.log(this.$ref)
            this.$print(".printer")
        },
        prn1_preview:function(){
            this.CreateOneFormPage();
            LODOP.PREVIEW();
        },
        prn1_print:function(){
            this.CreateOneFormPage();
            LODOP.PRINT();
        },
        prn1_printA:function(){
            this.CreateOneFormPage();
            LODOP.PRINTA();
        },
        CreateOneFormPage:function(){
            LODOP = getLodop();
            LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_表单一");
            LODOP.SET_PRINT_STYLE("FontSize", 18);
            LODOP.SET_PRINT_STYLE("Bold", 1);
            LODOP.ADD_PRINT_HTM(5, 10, 350, 700, document.getElementById("prints-content").innerHTML);
        }
    }
});   
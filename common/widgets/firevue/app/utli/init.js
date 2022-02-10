/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-02-25 14:01:07
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-26 08:46:28
 */

// 全局vue
import Global from './global.js'
import  validate  from './validate.js'
window.sysInit = new Vue({
    el: '#fire-main',
    data: function () {
        return {
            isSubmit:false,
            widheight:0,
            skinClass:'',
            widwidth:`${document.documentElement.clientWidth}`,
            is_addons:false,
            isCollapse: false,
            isLeftAll:0,
            openMypannel:true,//手机端兼容使用
            leftMenu:[],
            topMenu:[],
            activeIndex: '1',
            moduleAll:[],
            asideWidth:'200px',
            Website:{},
            menuCate:'sysai',
            menuBgColor:'',
            menuTextColor:'',
            menuActiveColor:'',
            my_skins_class:[
                'skin-blue',
                'skin-black',
                'skin-purple',
                'skin-green',
                'skin-red',
                'skin-yellow',
                'skin-blue-light',
                'skin-black-light',
                'skin-purple-light',
                'skin-green-light',
                'skin-red-light',
                'skin-yellow-light'
            ],
            my_skins: [
                {
                    skinClass:'skin-blue',
                    bgColor:'#3c8dbc',
                    bgClass:'bg-green',
                    text:'#fff',
                    active:'#fff',
                    title:'蓝色', 
                },
                {
                    skinClass:'skin-black',
                    bgColor:'#333',
                    bgClass:'bg-black',
                    text:'#fff',
                    active:'#409EFF',
                    title:'黑色', 
                },
                {
                    skinClass:'skin-purple',
                    bgColor:'#605ca8',
                    bgClass:'bg-purple',
                    text:'#fff',
                    active:'#fff',
                    title:'紫色', 
                },
                {
                    skinClass:'skin-green',
                    bgColor:'#00a65a',
                    bgClass:'bg-green',
                    text:'#fff',
                    active:'#fff',
                    title:'绿色', 
                },
                {
                    skinClass:'skin-red',
                    bgColor:'#dd4b39',
                    bgClass:'bg-red',
                    text:'#fff',
                    active:'#fff',
                    title:'红色', 
                },
                {
                    skinClass:'skin-yellow',
                    bgColor:'#f39c12',
                    bgClass:'bg-yellow',
                    text:'#fff',
                    active:'#fff',
                    title:'黄色', 
                },
                {
                    skinClass:'skin-blue-light',
                    bgColor:'#3c8dbc',
                    bgClass:'bg-light-blue',
                    text:'#fff',
                    active:'#fff',
                    title:'蓝色高亮', 
                },
                {
                    skinClass:'skin-black-light',
                    bgColor:'#fff',
                    bgClass:'bg-light-black',
                    text:'#303133',
                    active:'#303133',
                    title:'白色高亮', 
                },
                {
                    skinClass:'skin-purple-light',
                    bgColor:'#605ca8',
                    bgClass:'bg-purple',
                    text:'#fff',
                    active:'#fff',
                    title:'紫色高亮', 
                },
                {
                    skinClass:'skin-green-light',
                    bgColor:'#00a65a',
                    bgClass:'bg-green',
                    text:'#fff',
                    active:'#fff',
                    title:'绿色高亮', 
                },
                {
                    skinClass:'skin-red-light',
                    bgColor:'#dd4b39',
                    bgClass:'bg-red',
                    text:'#fff',
                    active:'#fff',
                    title:'红色高亮', 
                },
                {
                    skinClass:'skin-yellow-light',
                    bgColor:'#f39c12',
                    bgClass:'bg-yellow',
                    text:'#fff',
                    active:'#fff',
                    title:'黄色高亮', 
                }
            ]
        }
    },
    created: function () {
        let that = this;
        that.init();
    },
    methods: {
        init(){
            let that = this;
            let  addons = Global.getUrlParam('addons')

            let str = ''
            if(addons){
                str = '?addons='+addons;
            }
            
            that.$http.post('/backend/system/index/info'+str, {
                addons:addons
            }).then((response) => {
                //响应成功回调
                if (response.data.code == 200) {
                    that.leftMenu  = response.data.data.AllNav.left
                    that.topMenu   = response.data.data.AllNav.top

                    that.menuCate   = that.topMenu.length>0?response.data.data.AllNav.top[0].mark:''
                    console.log('menu_type',response.data.data.Website.menu_type)
                    // that.isLeftAll = response.data.data.Website.menu_type

                    that.is_addons = response.data.data.is_addons
                    that.moduleAll = response.data.data.moduleAll
                    that.Website   = response.data.data.Website
                    that.sysInfo(that.Website)
                    
                }
                
            }, (response) => {
                //响应错误回调
                console.log(response)
            });
    
        },
        addTabs(item){
            console.log(item) 
            addTabs({
                id:item.id,
                title: item.text,
                close: true,
                url: item.url,
                urlType: 'relative'
            })
        },
        menuCateSet(event){
            let that = this
            console.log(event.currentTarget.dataset)
            let cate = event.currentTarget.dataset.cate
            that.menuCate        = cate
        },
        sysInfo(Website){
            let that = this;
            this.$nextTick(function () {
                let themcolor = Website.themcolor
                var tmp = that.getStore('skin');
                
                // if ($.inArray(tmp, that.my_skins_class) !=-1){
                //     // 存在
                   
                //     that.my_skins.forEach((item,index)=>{
                //         $("body").removeClass(item.skinClass);
                //         if(item.skinClass == tmp){
                //             that.menuBgColor        =    item.bgColor
                //             that.menuTextColor      = item.text
                //             that.menuActiveColor    = item.active
                //         }
                //     })
                //     $("body").addClass(tmp);
                // }else{

                //     if($.inArray(themcolor, that.my_skins_class) !=-1){
                //         tmp = themcolor
                //     }

                //     that.my_skins.forEach((item,index)=>{
                //         $("body").removeClass(item.skinClass);
                //         if(item.skinClass == tmp){
                //             that.menuBgColor        =    item.bgColor
                //             that.menuTextColor      = item.text
                //             that.menuActiveColor    = item.active
                //         }
                //     })
                //     $("body").addClass(tmp);
                // }

            
                if($.inArray(themcolor, that.my_skins_class) !=-1){
                    tmp = themcolor
                }

                that.my_skins.forEach((item,index)=>{
                    $("body").removeClass(item.skinClass);
                    if(item.skinClass == tmp){
                        that.menuBgColor        =    item.bgColor
                        that.menuTextColor      = item.text
                        that.menuActiveColor    = item.active
                    }
                })
                $("body").addClass(tmp);

                
                that.widheight=  `${document.documentElement.clientHeight}`;
                that.widwidth = `${document.documentElement.clientWidth}`
                if(that.widwidth<768){
                      //xs  
                      that.asideWidth = 0;
                      that.isCollapse = true
                      that.isLeftAll = 1
                }else if(that.widwidth>=768 && that.widwidth<992 ){
                    // sm
                }else if(that.widwidth>=992 && that.widwidth<1200){
                    // md
                }else if(that.widwidth>=1200 && that.widwidth<1920){
                    // lg
                }else if(that.widwidth>=1920){
                    // xl
                }
                

            })

        },  
        handleOpen(key, keyPath) {
         console.log(key, keyPath);
        },
        handleClose(key, keyPath) {
            console.log(key, keyPath);
        },
        handleSelect(key, keyPath) {
            console.log(key, keyPath);

        },
        menuTopSelect(key, keyPath) {
            let that = this
            if(validate.isNumber(key)){
                that.menuCate = that.topMenu[key].mark
            }else{
                window.location.href = 'module?addons='+key

            }

        },
        addonsSelect(event){
            let that = this
            let addons = event.currentTarget.dataset.addons
            

        },
        CollapseSet(){

            let that = this;

            that.isCollapse =  !that.isCollapse
            console.log(that.widwidth,that.isCollapse)
            if(that.widwidth<768){
                //xs  
                if(this.isCollapse){
                    this.asideWidth = '0px' 
                    this.openMypannel = true 

                }else{
                    this.asideWidth = '200px' 
                    this.openMypannel = false 
                    
                }
            }else{
                this.openMypannel = true 
                // xl
                if(this.isCollapse){
                    this.asideWidth = '65px' 
                }else{
                    this.asideWidth = '200px' 
                }
            }
          
        },
        setThemcolor(themcolor){
            let that = this;
            if(!that.isSubmit){
            
                that.$http.post('/backend/system/settings/them', {
                    themcolor:themcolor
                }).then((response) => {
                    //响应成功回调
                    if (response.data.code == 200) {
                        this.$message(response.data.message);
                        console.log(response.data.data)
                        that.isSubmit = true
                        location.reload();
                    }
                    
                }, (response) => {
                    //响应错误回调
                    console.log(response)
                });
            
            }else{
                that.$message.error('操作太频繁，请等待');
            } 
          
        },
        selectStore(row) {
            let that = this
            that.Popup({
                url:'system/settings/store',
                title:'选择商户',
                param: {
                auto: true,
                num: 100
                },
                closeCallBack () {
                    console.log('关闭回调')
                    
                    that.$http.post('system/settings/set-cache',{
                        'bloc':localStorage.getItem("bloc")
                    }).then((response) => {
                        //响应成功回调
                        if (response.data.code == 200) {
                            closeOtherTabs();
                            var pageId = getActivePageId();
                            refreshTabById(pageId)
                            let storeSeleted = localStorage.getItem("bloc"); 
        
                            $('#bloc-left-name').text(JSON.parse(storeSeleted).store_name);        
                            
                        }else{
                            that.$message.error(response.data.message);
                        }
                        
                    }, (response) => {
                        //响应错误回调
                        console.log(response)
                    })
                }
            })
        },
        loginOut(){
            let that = this

            this.$confirm('确认要退出登录吗?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
              }).then(() => {
                that.$http.post('site/logout',{}).then((response) => {
                    //响应成功回调
                    if (response.data.code == 200) {
                        this.$message({
                            type: 'success',
                            message: '已退出'
                          });
                          window.location.href = response.data.data.url
                    }else{
                        that.$message.error(response.data.message);
                    }
                    
                }, (response) => {
                    //响应错误回调
                    console.log(response)
                })

               
              }).catch(() => {
                this.$message({
                  type: 'info',
                  message: '已取消退出'
                });          
              });

           
        },
        change_skin(event){
            let that = this
            let skin= event.currentTarget.dataset.skin
            let my_skins = this.my_skins
            console.log(event.currentTarget.dataset);

            that.menuBgColor        = event.currentTarget.dataset.bgcolor
            that.menuTextColor      = event.currentTarget.dataset.text
            that.menuActiveColor    = event.currentTarget.dataset.active
            

            my_skins.forEach((item,index)=>{
                $("body").removeClass(item.skinClass);
            })
            $("body").addClass(skin);
            this.store('skin', skin);
            that.setThemcolor(skin);
        },
        change_layout(cls) {
            $("body").toggleClass(cls);
            AdminLTE.layout.fixSidebar();
            //Fix the problem with right sidebar and layout boxed
            if (cls == "layout-boxed")
              AdminLTE.controlSidebar._fix($(".control-sidebar-bg"));
            if ($('body').hasClass('fixed') && cls == 'fixed') {
              AdminLTE.pushMenu.expandOnHover();
              AdminLTE.layout.activate();
            }
            AdminLTE.controlSidebar._fix($(".control-sidebar-bg"));
            AdminLTE.controlSidebar._fix($(".control-sidebar"));
        },
        store(name, val) {
            if (typeof (Storage) !== "undefined") {
              localStorage.setItem(name, val);
            } else {
              window.alert('Please use a modern browser to properly view this template!');
            }
        },
        getStore(name) {
            if (typeof (Storage) !== "undefined") {
              return localStorage.getItem(name);
            } else {
              window.alert('Please use a modern browser to properly view this template!');
            }
        }
        

    }

})
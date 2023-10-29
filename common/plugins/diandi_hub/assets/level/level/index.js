        new Vue({
            el: '#hub-level-index',//当前页面id
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
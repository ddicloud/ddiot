
        new Vue({
            el: '#operator-bloc-update',
            data: function () {
                return {
                    account:'',
                }
            },
            created: function () {
                let that = this;
                console.log('全局设置是否可以',window.sysinfo)
                console.log('a is: ' + this.DistributionGoods)
            },
            methods: {
              init(){
                let that = this;
                that.$http.post('attribute', {a:1}).then((response) => {
                    //响应成功回调
                    if (response.data.code == 200) {
                      that.attribute =  that.global.objToar(response.data.data.attribute)
                      that.prices = Object.values(response.data.data.prices)
                    }
                    return false;
                }, (response) => {
                    //响应错误回调
                    console.log(response)
                });
        
              },
              selectBlocs() {
                    let that = this
                    console.log(that)
                    //Lambda写法
                    that.$http.get('blocs', {}).then((response) => {
                       console.log('response',response)
                      // return false;
                        //响应成功回调
                        if (response.data.code == 200) {  
                          that.blocslist = response.data.data
                          that.visible = true
        
                        }
                    }, (response) => {
                        //响应错误回调
                        console.log('错误了',response)
                    });
            },
            setbloc(index,row){
                let that = this
                console.log(index,row)
                that.account = row.bloc_id
                that.name = row.business_name
                
                that.visible = false
        
            }
        
          }
        })
        
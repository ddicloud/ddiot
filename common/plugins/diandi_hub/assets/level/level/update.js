/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-06 15:06:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-07-03 00:02:44
 */
// import VueResource from '../node_modules/vue-resource/dist/vue-resource.js'

// import {im} from 'common/importJs.js'
    // 以form data 方式进行post请求
  
    new Vue({
        el: '#hub-level-update',
        data: function () {
            return {
                id:'',
                checked1: true,
                checked2: false,
                checked3: false,
                checked4: true,
                checkboxGroup1: [],
                checkboxGroup2: [],
                levelname:'',
                levelnum:'',
                condition:'',
                total_num:0,
                total_sale:0,
                total_numVal:0,
                total_saleVal:0,
                 water_ratio:0,
                level2_num:0,
                level1_num:0,
                level1_sale:0,
                level2_sale:0,
            }
        },
        created: function () {
            let that = this;
            console.log('全局设置是否可以',window.sysinfo)
            that.init();
        },
        methods: {
          init(){
            let that = this;
            console.log(that.global)
            let  id = that.global.getUrlParam('id');
            that.id = id
            console.log(id)
            that.$http.post('detail', {
                id:id,
            }).then((response) => {
                console.log(response)
                //响应成功回调
                if (response.data.code == 200) {
                    let data = response.data.data
                    that.levelname = data.levelname
                    that.levelnum = data.levelnum
                    
                    that.total_numVal = data.total_num
                    that.total_saleVal = data.total_sale
                    that.condition = data.condition

                    that.water_ratio = data.water_ratio
                    that.level2_num = data.level2_num
                    that.level1_num = data.level1_num
                    that.level1_sale = data.level1_sale
                    that.level2_sale = data.level2_sale
                    that.self_sale = data.self_sale
                    that.total_num = data.total_num
                    that.total_sale = data.total_sale

                    

                        
                        
                }

                return false;
            }, (response) => {
                //响应错误回调
                console.log(response)
            });
            
           
            
            
          },
          setItem(val){
            var elInput = document.getElementById('condition-input'); //根据id选择器选中对象
            var startPos = elInput.selectionStart;// input 第0个字符到选中的字符
            var endPos = elInput.selectionEnd;// 选中的字符到最后的字符
            if (startPos === undefined || endPos === undefined) return
            var txt = elInput.value;
            // 将表情添加到选中的光标位置
            var result = txt.substring(0, startPos) + val + txt.substring(endPos)
            elInput.value = result;// 赋值给input的value
            // 重新定义光标位置
            elInput.focus();
            elInput.selectionStart = startPos + val.length;
            elInput.selectionEnd = startPos + val.length;
             
            console.log(event)
            this.condition = result
          },
          submitForm(){
            let that = this;
            that.$http.post('update', {
                id:that.id,
                levelname:that.levelname,
                levelnum:that.levelnum,
                levelnum:that.levelnum,
                total_num:that.total_num,
                total_sale:that.total_sale,
                condition:that.condition,
                water_ratio:that.water_ratio,
                level2_num:that.level2_num,
                level1_num:that.level1_num,
                level1_sale:that.level1_sale,
                level2_sale:that.level2_sale,
                self_sale:that.self_sale
            }).then((response) => {
                console.log(response)
                //响应成功回调
                if (response.data.code == 200) {
                    that.$message({
                        message: response.data.message,
                        type: 'success'
                    });
                }
                return false;
            }, (response) => {
                //响应错误回调
                console.log(response)
            });
          }
    }
})
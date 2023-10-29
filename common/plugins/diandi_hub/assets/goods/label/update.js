/*
* @Author: Wang chunsheng  email:2192138785@qq.com
* @Date:   2020-06-06 15:06:48
* @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
* @Last Modified time: 2020-06-12 12:35:46
*/
// import VueResource from '../node_modules/vue-resource/dist/vue-resource.js'

// import {im} from 'common/importJs.js'
// 以form data 方式进行post请求

new Vue({
    el: '#goods-label-update',
    data: function () {
        return {
            color: '#409EFF'
        }
    },
    created: function () {
        let that = this;
        that.init();
    },
    methods: {
    init(){
        let that = this;
        console.log(that.global.getUrlParam('id'))
        that.$http.post('getlist', {id:that.global.getUrlParam('id')}).then((response) => {
               console.log(response)
                //响应成功回调
                if (response.data.code == 200) {
                    // list = JSON.parse(JSON.stringify(response.data.data.cate))
                    
                    that.color =response.data.data.color
                      
                    console.log(that.color)
                }
                
            return false;
        }, (response) => {
            //响应错误回调
            console.log(response)
        });
        
    },

}
})
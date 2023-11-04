import Vue from 'vue'
import store from './store'
import App from './App'
import cuCustom from './components/cu-custom.vue'
import iconfont from './components/iconfont/iconfont.vue'
import iGlobal from './common/global.js'	//引入 global.js
import tabBar from './components/tabbar.vue' 
import painter from './components/painter/index.vue' 
import fui from './common/fui-index.js'
import diandi from './config.js'
// import router from './router'
// import { RouterMount } from 'uni-simple-router'
console.log('diandi',diandi);
import {router,RouterMount} from './router.js'  //路径换成自己的
Vue.use(router)

// 导入并挂载全局的分享方法
import share from './common/libs/share.js'
Vue.mixin(share)
// import UniSocket from "common/libs/socket/uni.socket.js"

// const socket = new UniSocket({
// 		url: "ws://188.131.237.192:9502"
// 	});
// #ifdef H5
window.QQmap = null;
// #endif
// #ifndef MP-TOUTIAO
//网络监听
setTimeout(() => {
	uni.onNetworkStatusChange(function(res) {
		//console.log(res.networkType);
		store.commit("networkChange", {
			isConnected: res.isConnected
		})
	});
}, 100)
// #endif
Vue.prototype.fui = fui
Vue.use(fui,{
	// 请求相关的配置
	    http: {
	        // 请求头字段配置（baseURL无效），设置请求地址请在下面的apiConfig里面进行配置
	        header: {
	            'bloc-id': diandi.bloc_id,
	            'store-id': diandi.store_id,
	            // 'access-token':uni.getStorageSync('access_token')
	        },
	        successCode: 200,
	        apiConfig: {
	            // 代理名称
	            proxyName: '',
	            tokenApi: '/wechat/basics/signup',
				refreshApi:'/user/refresh',
	            // 备用域名配置,至少配置一个,这边会自动设置baseUrl，至少传入一个域名，H5本地调试会自己代理到proxyName
	            domain: diandi.baseUrl
	        },
	        responseSuccessCallBack: (res, catchObj, query) => {
				console.log('请求触发1',res, catchObj, query);
				if(res.code === 403){
					console.log('请求触发1--403');
					uni.removeStorageSync('access_token');
					fui.toLogin(403)
				}
			}
		}	
})
Vue.prototype.resourceUrl = "https://dev.hopesfire.com/attachment/diandi_dangjian/images/"
// Vue.prototype.UniSocket = socket
Vue.prototype.$eventHub = Vue.prototype.$eventHub || new Vue()
Vue.prototype.$store = store
Vue.component('painter', painter)
Vue.component('tab-bar', tabBar)
Vue.component('cu-custom',cuCustom) //全局导航组件
Vue.component('iconfont',iconfont) //全局图标组件
Vue.prototype.iGlobal=iGlobal	//将global.js挂载至Vue.prototype 实现全局调用
Vue.prototype.$store = store
Vue.config.productionTip = false

App.mpType = 'app'


const app = new Vue({
	store,
    ...App
})

//v1.3.5起 H5端 你应该去除原有的app.$mount();使用路由自带的渲染方式
// #ifdef H5
	RouterMount(app,router,'#app')
// #endif

// #ifndef H5
	app.$mount(); //为了兼容小程序及app端必须这样写才有效果
// #endif
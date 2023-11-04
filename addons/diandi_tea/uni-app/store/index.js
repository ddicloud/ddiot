import Vue from 'vue'
import Vuex from 'vuex'
import fetch from '../common/fui-index'

Vue.use(Vuex)

const store = new Vuex.Store({
	state: {
		// 集团公司与商户参数，可切换更改数据,默认填写自营店
		bloc_id:uni.getStorageSync("bloc_id") || fetch.bloc_id,
		store_id:uni.getStorageSync("store_id") || fetch.store_id,
		// 集团公司参数
		global_bloc_id:fetch.bloc_id,
		global_store_id:fetch.store_id,
		currentindex:0,//全局tabar
		//用户登录手机号
		mobile: uni.getStorageSync("mobile") || "echo.",
		//是否登录 项目中改为真实登录信息判断，如token
		isLogin:fetch.isLogin(),
		loginModalShow:false,
		//登录后跳转的页面路径 + 页面参数
		returnUrl:uni.getStorageSync('redirect_uri'),
		//app版本
		version: "1.5.1",
		//当前是否有网络连接
		networkConnected: true,
		isOnline: false,
		inviteCode:0,
	},
	mutations: {
		login(state, payload) {
			if (payload) {
				state.mobile = payload.mobile
			}
			state.isLogin = true
		},
		logout(state) {
			state.mobile = ""
			state.isLogin = false
			state.returnUrl = ""
		},
		changeStore(state,payload){
			console.log(state,payload)
			if (payload) {
				uni.setStorageSync("bloc_id",payload.bloc_id)
				uni.setStorageSync("store_id",payload.store_id)
				state.bloc_id  = payload.bloc_id
				state.store_id  = payload.store_id
			}
		},
		setReturnUrl(state, returnUrl) {
			state.returnUrl = returnUrl
		},
		networkChange(state, payload) {
			state.networkConnected = payload.isConnected
		},
		setOnline(state, payload) {
			state.isOnline = state.isOnline
		},
		setInviteCode(state,payload) {
			state.inviteCode = payload.inviteCode
		},
	},
	actions: {
		getOnlineStatus: async function({
			commit,
			state
		}) {
			return await new Promise((resolve, reject) => {
				// #ifndef MP-WEIXIN
				resolve(true)
				// #endif
				// #ifdef MP-WEIXIN
				if (state.isOnline) {
					resolve(state.isOnline)
				} else {
					fetch.request("/Home/GetStatus", "GET", {}, false, true, true).then((res) => {
						if (res.code == 100 && res.data == 1) {
							commit('setOnline', {
								isOnline: true
							})
							resolve(true)
						} else {
							commit('setOnline', {
								isOnline: false
							})
							resolve(false)
						}
					}).catch((res) => {
						reject(false)
					})
				}
				// #endif
			})
		},
		InviteCode:function(context,obj){
			context.commit('setInviteCode',obj)
		}
	}
})

export default store

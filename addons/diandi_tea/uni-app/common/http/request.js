/*
 * @Descripttion:
 * @version: 1.0
 * @Author: sanhui
 * @Date: 2021-06-21 15:52:38
 */
import Request from 'luch-request' // 下载的插件

import requestBefore from './index'

import Refresh from './refreshToken'
import fui from '@/common/fui-index.js'
const curApiCatchKey = 'CURRENT_API'
// 传入的api配置
let crabRequestConfig = {
    apiCatchTime: 3660 * 24 * 1000, // 域名缓存时间
    tokenApi: '', // 获取token的api
    refreshApi: '', // 刷新的api
    domainList: [], // 备用域名列表
    header: {} // 请求头
}
const refreshToken = Refresh.initRefreshToken()

/**
 * 修改全局配置示例
 **/
const http = new Request({
    header: {
        'Content-Type': 'application/json; charset=utf-8'
    },
    validateStatus: (statusCode) => { // statusCode 必存在。此处示例为全局默认配置
        return statusCode >= 200 && statusCode < 300
    }
})
/* 请求之前拦截器。可以使用async await 做异步操作 */
http.interceptors.request.use(async (config) => {
    config.data = {
        ...config.data
    }
	console.log('准备请求',config);
	
	// 无法避免多次请求
	if (crabRequestConfig.tokenApi && config.url !== crabRequestConfig.tokenApi) {
	    const access_token = fui.getToken()
	    access_token && (config.header['access-token'] = `${access_token}`)
	}
   
    const crabRequestConfigHeader = {}
    Object.keys(crabRequestConfig.header).forEach(key => {
        const item = crabRequestConfig.header[key]
        const itemType = typeof item
        crabRequestConfigHeader[key] = itemType === 'function' ? item() : item
    })
    config.header = {
        ...config.header,
        ...crabRequestConfigHeader
    }
    return config
}, (err) => {
    return err
})

/**
 * 1.正在刷新跳过
 * 20200 token无效
 */
http.interceptors.response.use(async (response) => {
    // token过期
    if (((refreshToken.isRefresh && response.data.code !== 200) || response.data.code === 402) && response.config.url !== crabRequestConfig.refreshApi) {
		// 刷新token状态中
		if (!refreshToken.isRefresh) {
			const refresh_token = fui.getRefToken()
			refreshToken.setRefreshType(true)
			 // 刷新token
			 return resendRefreshRequest(refresh_token).then((res) => {
				 
				 // #ifdef MP-WEIXIN
				 uni.setStorageSync('fans', res.data.wxappFans);				 
				 // #endif
				 
				 // #ifndef MP-WEIXIN
				 uni.setStorageSync('fans', res.data.wechatFans);				 
				 // #endif
				 uni.setStorageSync('nickname', res.data.member.nickname);
				 uni.setStorageSync('access_token', res.data.access_token);
				 uni.setStorageSync('refresh_token', res.data.refresh_token);
				 uni.setStorageSync('expiration_time', res.data.expiration_time);
				 uni.setStorageSync('member', res.data.member);
			     refreshToken.notifyTaskReload()
			     refreshToken.setRefreshType(false)
			     return http.request(response.config)
			 }).catch((v) => {
				 console.log('刷新触发刷新错误',v);
			     refreshToken.clearTask()
			     refreshToken.setRefreshType(false)
			     return response.data
			 })
        }
        return new Promise((r, s) => {
            // 将需要重新请求的接口添加到队列中
            refreshToken.addTask((isError) => {
                if (isError) {
                    return r(response)
                }
                http.request(response.config).then(r).catch(s)
            })
        })
    } else {
        return response.data
    }
}, response => {
    return response
})

export function setHttpConfig({ apiConfig, header = {} }) {	
    const newConfig = {
        ...apiConfig,
        header
    }
    crabRequestConfig = Object.assign({}, crabRequestConfig, newConfig)
    if (!apiConfig.domain) {
        console.error('-----------请设置请求域名---------')
        return
    }
    saveAPIConfig()
}

/**
 * 切换域名
 * force {boolean} 暴力切换
*/
function saveAPIConfig() {
    let domain = crabRequestConfig.domain
    // #ifdef H5
    domain = process.env.NODE_ENV === 'production' ? crabRequestConfig.domain : crabRequestConfig.proxyName
    // #endif
    http && http.setConfig(_config => {
        return { ..._config, baseURL: domain }
    })
    // 这边要对代理的地址做下处理
    const saveAPI = {
        url: domain,
        // #ifdef H5
        url: crabRequestConfig.domain
        // #endif
    }
    // try {
    //     getVuex().commit('zzspui/SET_CUR_DOMAIN', saveAPI)
    // } catch (error) {
    //     console.log('这边没有注入保存当前请求域名的store')
    // }
}



function  resendRefreshRequest(refresh_token) {
	return requestBefore(crabRequestConfig.refreshApi, 'POST',{
		refresh_token: refresh_token
	},false, {
	        catchName: 'wechatSignup',
			abort: false
	})
}


export default http

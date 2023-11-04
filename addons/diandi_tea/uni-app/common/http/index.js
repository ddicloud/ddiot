import http from './request.js'
import globalFunc,{
    deepClone,
    getVarType
} from '@/common/global.js'
import { showToast, showLoading, hideLoading, showModal } from "../utils/message.js"
import fui from '@/common/fui-index.js'

let curPage = {}
const needCatchList = {}
const currentPath = ''
let successCode = 0
let responseSuccessCallBack = null


export function setStatusCode(code) {
    successCode = code
}

export function setResponseSuccessCallBack(callback) {
    responseSuccessCallBack = callback
}

/**
 * @description 判断对象是否存在键值
 * @param {Object} obj 要查找的对象
 * @param {String} key 对象键值
 * @return {Boolean} 返回一个布尔值
 */
function isExitValue(obj, key) {
    if (obj.hasOwnProperty(key) === false || obj[key] === undefined || obj[key] === null || obj[key] === '') return false
    return true
}

// 设置请求列表
export function setRequestList(reqList) {
    for (var key in reqList) {
        var item = reqList[key]
        item.persistence = isExitValue(item, 'persistence') ? item.persistence : true
        item.catchBefore = isExitValue(item, 'catchBefore') ? item.catchBefore : false
        item.showErr = isExitValue(item, 'showErr') ? item.showErr : true
        item.showModal = isExitValue(item, 'showModal') ? item.showModal : false
        item.modalBack = isExitValue(item, 'modalBack') ? item.modalBack : true
        item.source = isExitValue(item, 'source') ? item.source : 'any'
        item.abort = isExitValue(item, 'abort') ? item.abort : true
        item.type = isExitValue(item, 'type') ? item.type : 'post'
        needCatchList[key] = item
    }
}
/**
 * @description 请求前统一拦截
 * @param {String} name 请求地址值key，具体看配置文件@/api/config.js
 * @param {Object} query 请求参数列表
 * @param {String} modifyObj 修改请求配置
 * @param {String} type 请求类型：get | post | upload,默认post
 * @param {Boolean} reLoad 是否是重发请求类型：get | post,默认post
 * @return {Promise} 返回是一个promise
 */
export default function requestBefore(name,type, query = {},isToken = false,modifyObj = {}) {
	const pages = getCurrentPages()
    const tempCurPage = pages.length ? pages[pages.length - 1] : {}
    if (currentPath !== tempCurPage.route) {
        if (tempCurPage.route) {
            // #ifdef H5
            curPage = tempCurPage
            // #endif
            // #ifndef H5
            curPage = tempCurPage.$vm
            // #endif
        }
    }
    return new Promise((resolve, reject) => {
		// 首先处理需要登录的接口判断登录
		let accessToken = ''
		// if (isToken) {
		//     accessToken = fui.getToken();
		//     if (!accessToken){
		//         console.log('去登录的接口', name,'accessToken:'+accessToken,'getRefToken:'+fui.getRefToken())
		//         fui.toLogin(402)
		//         return false
		//     }
		//     console.log('accessToken', accessToken)
		// }
		
        const catchObj = getRequestconfig(name)
		console.log('catchObj',catchObj);
        if (modifyObj) {
            for (var i in modifyObj) {
                if (typeof modifyObj[i] === 'object' && typeof catchObj[i] === 'object') {
                    Object.assign(catchObj[i], modifyObj[i])
                } else {
                    catchObj[i] = modifyObj[i]
                }
            }
        }
        if (!catchObj.url) { // 请求地址不能为空
            // #ifdef H5
            console.error('[fatal error] 请求地址错误，『' + name + '』不存在请求配置文件中')
            // #endif
            // #ifndef H5
            console.log('[fatal error] 请求地址错误，『' + name + '』不存在请求配置文件中')
            // #endif
            return reject({
                status: 20000,
                msg: '请求地址不能为空'
            })
        }
		console.log('catchObj',catchObj);
        if (catchObj.catchName && !catchObj.update && catchObj.abort) { // 说明需要存缓存，先去去缓存，强制更新他人的  必须请求
            var storage = uni.getStorageSync
            var catchName = getCatchName(catchObj.catchName, query)
            var catchStorage = storage(catchName)
            if (catchStorage) {
                return resolve({
                    status: 0,
                    msg: '读取缓存成功',
                    data: catchStorage
                })
            }
            if (catchObj.source === 'catch') { // 如果缓存没有则返回空，一般是object类型
                return resolve({
                    status: 0,
                    msg: '缓存中没有相应数据',
                    data: {}
                })
            }
        }
        type = (type || catchObj.type || 'POST').toLocaleLowerCase()
        catchObj.url += (globalFunc.getVarType(query) === 'String' ? ('/' + query) : '')
        let taskFn = null
        if (globalFunc.getVarType(query) === 'Object') {
            taskFn = query.getTask
            delete query.getTask
        }

        catchObj.loading && showLoading(String(catchObj.loading) === 'true' ? '' : catchObj.loading)
        http[type](
            catchObj.url,
            !['get', 'download'].includes(type) ? {
                ...query,
                getTask: (task) => {
                    task.onProgressUpdate((res) => {
                        taskFn ? taskFn(res) : ''
                    })
                }
            } : {
                params: query
            }
        ).then(async res => {
			console.log('系统',res);
            catchObj.loading && hideLoading()
            responseSuccessCallBack && responseSuccessCallBack(res, catchObj, query)
            if (res.code === successCode) {
                res.data = catchObj.catchBefore ? await catchObj.catchBefore(res.data) : res.data
                await responseSuccess(res, catchObj, query)
                resolve(res)
            } else {
                await responseSuccess(res, catchObj, query)
                reject(res)
            }
        }).catch(err => {
            catchObj.loading && hideLoading()
            responseFail(err, catchObj)
            reject(err)
        })
    })
}

// 判断请求地址是否在配置好的地址表中,如果没有直接转换成跟地址表一样的格式
function getRequestconfig(name) {
    const hasFullAddress = String(name).indexOf('/') !== -1
    const requestName = Object.keys(needCatchList).find(o => needCatchList[o].url === name)
    return globalFunc.deepClone((hasFullAddress ? requestName ? needCatchList[requestName] : false : needCatchList[name]) || (hasFullAddress ? { url: name } : {}))
}

function responseFail(res, catchObj = {}) {
    if (catchObj.toast && res.code) {
        uni.getNetworkType({
            success: (res) => {
                if (res.networkType === 'none' || res.networkType === 'unknown') {
                    showToast(res.msg || '您的网络不佳')
                } else {
                    showToast(res.msg || '系统繁忙')
                }
            }
        })
    }
}

async function responseSuccess(res, catchObj, query) {
    if (res.code === successCode) {
        if (catchObj.catchName || catchObj.update) { // 表示要进行缓存或者强制更新
            catchHandle(catchObj, res, query)
        }
        if (catchObj.removeName) {
            var removeObj = needCatchList[catchObj.removeName]
            var removeName = getCatchName(removeObj.name)
            uni.removeStorageSync(removeName)
        }
    }
    catchObj.toast && showToast(globalFunc.getVarType(catchObj.toast) === 'Boolean' ? res.message : catchObj.toast, res.code === successCode ? 1 : 0)
}

/**
 * @description 缓存统一设置或删除管理
 * @param {Object} catchObj 缓存对象
 * @param {type} queryObj 请求参数
 */

function catchHandle(catchObj = {}, resObj = {}, queryObj = {}) {
    const catchName = getCatchName(catchObj.catchName, queryObj)
    if (catchName === 'jscode2session' && resObj.result) {
        const prevToken = uni.getStorageSync(catchName)
        if (prevToken.token) {
            setStorageSync('prveToken', {}, prevToken.token)
        }
    }
    catchObj.catchName && setStorageSync(catchName, catchObj, resObj.data)
}

/**
 * @description 获取缓存名称
 * @param {Object} catchObj 缓存项
 * @return {String}
 */
const getCatchName = (nameObj, queryObj = {}) => {
    let catchName = ''
    if (globalFunc.getVarType(nameObj) === 'Object') {
        catchName = nameObj.value
        if (nameObj.position) {
            let extraName = ''
            if (globalFunc.getVarType(nameObj.storage) === 'Function') {
                (async () => {
                    nameObj.storage = await nameObj.storage()
                })()
            }
            const nameStorage = nameObj.storage ? nameObj.storage : false
            if (nameStorage) {
                extraName = nameStorage[extraName] || ''
            } else if (globalFunc.getVarType(queryObj) === 'Object') {
                const _key = nameObj.key || ''
                extraName = _key && queryObj.hasOwnProperty(_key) ? queryObj[_key] : _key
            } else {
                extraName = queryObj
            }
            catchName = nameObj.position === 'after' ? (catchName + extraName) : (extraName + catchName)
        }
    } else {
        catchName = nameObj
    }
    return catchName
}
// 设置缓存
function setStorageSync(name, catchObj, data) {
    if (globalFunc.getVarType(data) === 'Object' && JSON.stringify(data) === '{}') return
    if (globalFunc.getVarType(data) === 'Array' && data.length === 0) return
	uni.setStorageSync(name, data)
}
/**
 * @param {Array} list 需要清空缓存的数组
 * @param {String} list 键值
 * @return {Void} 无返回值
 */
function removeStorageSync(list) {
    list.forEach(o => {
        if (o) {
            var catchName
            var storage = {
                get: uni.getStorageSync,
                remove: uni.removeStorageSync
            }
            const catchNameType = globalFunc.getVarType(o.catchName) === 'Object'
            if (catchNameType) {
                catchName = o.catchName.value
            } else {
                catchName = o.catchName
            }
            var _position = catchNameType ? o.catchName.position : false
            if (_position) { // 这种情况都是做持久化的，获取名字匹配的直接删除
                var allCatch = uni.getStorageInfoSync().keys || []
                allCatch.forEach(o1 => {
                    if (_position === 'before') { // 加载前缀
                        var item = o1.split('').reverse().join('')
                        if (item.indexOf(catchName.split('').reverse().join('')) === 0) {
                            console.warn('模糊删除前缀为：' + catchName + '的缓存')
                            storage.remove(o1)
                        }
                    } else {
                        if (o1.indexOf(catchName) === 0) {
                            console.warn('模糊删除后缀为：' + catchName + '的缓存')
                            storage.remove(o1)
                        }
                    }
                })
            } else {
                console.warn('删除缓存：' + catchName)
                storage.remove(catchName)
            }
        }
    })
}

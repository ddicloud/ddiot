import globalStore from '../store/index.js'
import globalConfig from '../config.js'
import {
	router,
	RouterMount
} from '../router.js' //路径换成自己的
import globalFunc from './global.js' //路径换成自己的
import sendHttp, {
	setRequestList,
	setStatusCode,
	setResponseSuccessCallBack
} from "./http/index.js"
import {
	setHttpConfig
} from './http/request'
const fui = {
	uploadUrl: globalConfig.baseUrl + '/upload/images',
	apiBsaeUrl: globalConfig.baseUrl + '/',
	imgBaseUrl: globalConfig.baseUrl + '/attachment/',
	siteUrl: globalConfig.siteUrl + '/#/',
	bloc_id: globalConfig.bloc_id,
	store_id: globalConfig.store_id,
	WECHAT_LOGIN: true,
	// 授权之后返回原有地址
	WECHAT_AUTH_BACK_URL: 'WECHAT_AUTH_BACK_URL',
	// #ifdef H5
	jweixin: require('jweixin-module'), //微信h5开发使用
	// #endif
	toast: function(text, duration, success) {
		uni.showToast({
			title: text || "出错啦~",
			icon: success ? 'success' : 'none',
			duration: duration || 2000
		})
	},
	modal: function(title, content, showCancel, callback, confirmColor, confirmText) {
		uni.showModal({
			title: title || '提示',
			content: content,
			showCancel: showCancel,
			cancelColor: "#555",
			confirmColor: confirmColor || "#5677fc",
			confirmText: confirmText || "确定",
			success: function(res) {
				if (res.confirm) {
					callback && callback(true)
				} else {
					callback && callback(false)
				}
			},
			complete: function(res) {
				console.log(res)
			}
		})
	},
	isAndroid: function() {
		const res = uni.getSystemInfoSync();
		return res.platform.toLocaleLowerCase() == "android"
	},
	isPhoneX: function() {
		const res = uni.getSystemInfoSync();
		let iphonex = false;
		let models = ['iphonex', 'iphonexr', 'iphonexsmax', 'iphone11', 'iphone11pro', 'iphone11promax']
		const model = res.model.replace(/\s/g, "").toLowerCase()
		if (models.includes(model)) {
			iphonex = true;
		}
		return iphonex;
	},
	constNum: function() {
		let time = 0;
		// #ifdef APP-PLUS
		time = this.isAndroid() ? 300 : 0;
		// #endif
		return time
	},
	delayed: null,
	//判断是否登录
	isLogin: function() {
		return uni.getStorageSync('access_token') != '' && uni.getStorageSync('access_token') != 'undefined' &&
			!this.checkCacheTime('access_token');
	},
	//获取token
	getToken() {
		let accessToken = uni.getStorageSync('access_token');
		console.log('unii', uni.getStorageSync('access_token'));
		return accessToken;
	},
	getRefToken() {
		let refresh_token = uni.getStorageSync('refresh_token');
		return refresh_token;
	},
	request: sendHttp,
	toLogin: function(code) {
		let that = this
		let pages = getCurrentPages();
		let route = pages[pages.length - 1].route;
		let options = pages[pages.length - 1].options
		console.log('登录前参数', fui.isLogin(),route,pages[pages.length - 1].options)
		if (code == 402 || code == 403) {
			globalStore.state.loginModalShow = true
			// #ifdef APP-PLUS
			console.log('app')
			router.push({
				name: "login"
			})
			uni.navigateTo({
				url: '/public/login/login',
				complete(res) {
					console.log(res)
				}
			})
			// #endif

			// #ifdef MP-WEIXIN
			console.log('小程序去登录');
			// 小程序
			
			let urlOptions = ''
			if(options.scene){
				urlOptions = '?scene='+options.scene
			}
			uni.navigateTo({
				url: '/public/login/wechatlogin'+urlOptions,
				complete(res) {
					console.log('小程序去登录0', res)
				}
			})
			
			// fui.modal('登录提示','去登录',true,function(e){
			// 	console.log('登录弹窗',e,e.confirm)
			// 	if(e === true){
			// 		uni.navigateTo({
			// 			url: '/public/login/wechatlogin',
			// 			complete(res) {
			// 				console.log('小程序去登录0', res)
			// 			}
			// 		})
			// 	}else{
			// 		uni.navigateBack(1)
			// 	}
			
			// },'#218569')
		
			console.log('小程序去登录 跳转后');
			// #endif


			// #ifdef H5
			let userAgent = navigator.userAgent;
			let _isWeixin = globalFunc.isWeixin()
			let WECHAT_LOGIN = fui.WECHAT_LOGIN
			console.log('_isWeixin', _isWeixin);
			if (_isWeixin && WECHAT_LOGIN) { // 公众号
				fui.wechatlogin()
			} else { //h5
				console.log('当前为H5环境')
				fui.href('/login')
			}

			// #endif
		}
	},
	/**
	 * 上传文件
	 * @param string url 请求地址
	 * @param string src 文件路径
	 */
	uploadFile: function(src) {
		let that = this
		uni.showLoading({
			title: '请稍候...'
		})
		return new Promise((resolve, reject) => {
			uni.showLoading()
			const uploadTask = uni.uploadFile({
				url: fui.uploadUrl + '?access-token=' + fui.getToken(),
				filePath: src,
				name: 'file',
				header: {
					'access-token': fui.getToken()
				},
				formData: {
					'user': 'test'
				},
				success: function(res) {
					console.log(res)
					let img = JSON.parse(res.data)

					uni.hideLoading()
					console.log('图片上传img', img)
					console.log('图片上传res', res.statusCode, res)
					if (res.statusCode == 200) {
						//返回图片地址
						// let fileObj = img.attachment;
						resolve(img)
					} else {
						that.toast(res.msg);
					}
					// resolve(img)
				},
				fail: function(res) {
					console.log('错误', res)
					reject(res)
					that.toast(res.msg);
				}
			})
		})
	},
	fuiJsonp: function(url, callback, callbackname) {
		// #ifdef H5
		window[callbackname] = callback;
		let fuiScript = document.createElement("script");
		fuiScript.src = url;
		fuiScript.type = "text/javascript";
		document.head.appendChild(fuiScript);
		document.head.removeChild(fuiScript);
		// #endif
	},
	store: function() {
		let _this = this
		return new Promise((resolve, reject) => {
			fui.request("/store/info", "GET", {
				store_id: globalStore.state.store_id
			}, false).then((res) => {
				console.log(res)
				if (res.code == 200) {
					getApp().globalData.storeInfo = res.data
				}
				resolve(res.data)
			}).catch((res) => {})
		})

	},
	/**
	 * 授权登录
	 */
	getUserInfo: function(callback) {
		let _this = this
		uni.showLoading({
			title: "正在登录",
			mask: true
		});
		// 执行微信登录
		// 微信登录
		uni.login({
			// provider: 'weixin',
			success: function(loginRes) {
				console.log(loginRes, loginRes.authResult);
				// 获取用户信息
				uni.getUserInfo({
					provider: 'weixin',
					success: function(infoRes) {
						uni.showLoading();
						console.log('用户昵称为：' + infoRes.userInfo.nickName, infoRes
							.userInfo);
						_this.wechatsignup(infoRes, loginRes.code, callback)

					},
					fail(e) {
						console.log(e)
					}
				});
			},
			fail(e) {
				console.log(e)
			}
		});

	},
	// 微信登录
	wechatsignup: function(infoRes, code, callback) {
		console.log(infoRes)
		// 获取用户token
		this.request("/wechat/basics/signup", "POST", {
			code: code,
			avatarUrl: infoRes.userInfo.avatarUrl,
			nickname: infoRes.userInfo.nickName,
			gender: infoRes.userInfo.gender,
			country: infoRes.userInfo.country,
			city: infoRes.userInfo.city,
			province: infoRes.userInfo.province,
			openid: infoRes.userInfo.openId ? infoRes.userInfo.openId : '',
			unionid: infoRes.userInfo.unionId ? infoRes.userInfo.unionId : '',
		}, false).then((res) => {
			console.log(res.data)
			if (res.code == 200) {
				uni.hideLoading();
				console.log('okok1', res.code, res.data.fans.nickname)
				if (res.code == 200) {
					uni.setStorageSync('nickname', res.data.fans.nickname);
					uni.setStorageSync('access_token', res.data.access_token);
					uni.setStorageSync('refresh_token', res.data.refresh_token);
					uni.setStorageSync('expiration_time', res.data.expiration_time);
					uni.setStorageSync('fans', res.data.fans);
					uni.setStorageSync('member', res.data.member);
					console.log(res);
					callback && callback();
				}

			} else {
				this.toast(res.message);
			}
		}).catch((res) => {})


	},
	// 公众号登录
	wechatlogin: function(callback) {
		let that = this

		// 微信公众号授权
		if (that.isLogin()) {
			console.log('微信公众号已授权')
			return false;
		}
		console.log(fui.siteUrl)
		console.log(fui.siteUrl, fui.siteUrl)
		let redirect_uri = encodeURIComponent(fui.siteUrl)
		uni.setStorageSync('redirect_uri', {
			name: router.$route.history.current.name,
			params: router.$route.history.current.query
		})
		this.request("/officialaccount/basics/auth", "POST", {
			redirect_uri: redirect_uri,
		}, false).then((res) => {
			console.log(res.data)
			if (res.code == 200) {
				uni.hideLoading();
				console.log('okok1', res.code, res.data.headers.location[0])
				if (res.code == 200) {
					console.log('当前为公众号环境', decodeURI(res.data.headers.location[0]))
					location.href = decodeURI(res.data.headers.location[0])
					console.log(res);
					callback && callback();
				}

			} else {
				this.toast(res.message);
			}
		}).catch((res) => {})


	},
	// 手机号登录
	mobileLogin: function(username, password, callback) {
		let that = this
		this.request("/user/login", "POST", {
			username: username,
			password: password
		}, false).then((res) => {
			console.log('登录成功', res.data)
			if (res.code == 200) {
				uni.setStorageSync('refresh_token', res.data.refresh_token);
				uni.setStorageSync('access_token', res.data.access_token);
				uni.setStorageSync('expiration_time', res.data.expiration_time);
				uni.setStorageSync('fans', res.data.fans);
				uni.setStorageSync('member', res.data.member);
				console.log(res);
				callback && callback();
			} else {
				this.toast(res.message);
			}
		}).catch((res) => {})
	},
	// h5初始化配置微信sdk
	initJssdk: function(callback) {
		let that = this
		this.request("/officialaccount/jssdk/config", "POST", {
			'url': globalConfig.siteUrl + '/' //fui.siteUrl
		}, false).then((res) => {
			console.log('配置参数获取', res.data)
			if (res.code == 200) {
				that.jweixin.config(res.data)
				setTimeout(() => {
					callback && callback();
				}, 500);
			} else {
				this.toast(res.message);
			}
		}).catch((res) => {
			console.log('initJssdk', res)
		})
	},
	getuserinfoBycode: function(code, callback) {
		let that = this
		let redirect_uri = encodeURIComponent(fui.siteUrl)
		this.request("/officialaccount/basics/userinfo", "POST", {
			code: code
		}, false).then((res) => {
			console.log(res.data)
			if (res.code == 200) {
				uni.setStorageSync('refresh_token', res.data.refresh_token);
				uni.setStorageSync('access_token', res.data.access_token);
				uni.setStorageSync('expiration_time', res.data.expiration_time);
				uni.setStorageSync('fans', res.data.fans);
				uni.setStorageSync('member', res.data.member);
				console.log(res);
				callback && callback(res);
			} else {
				this.toast(res.message);
			}
		}).catch((res) => {})
	},
	wechatpay: function(body, order_no, pay_price, order_id, callback) {
		let _this = this;
		let fans = uni.getStorageSync('fans');
		console.log('订单支付信息组合', {
			openid: fans.openid,
			trade_type: 'JSAPI',
			body: body,
			out_trade_no: order_no,
			total_fee: pay_price,
		})
		uni.showLoading()
		// 获取支付参数
		// #ifdef H5
		console.log('H5')
		let userAgent = navigator.userAgent;
		let WECHAT_LOGIN = this.WECHAT_LOGIN
		if (globalFunc.isWeixin() && WECHAT_LOGIN) { // 公众号
			_this.request('/officialaccount/basics/payparameters', "POST", {
				openid: fans.openid,
				trade_type: 'JSAPI',
				body: body,
				out_trade_no: order_no,
				total_fee: pay_price,
			}).then((parameters) => {
				console.log('支付参数', parameters.code)
				if (parameters.code == 200) {
					uni.hideLoading()
					// 获取支付参数
					console.log('sdkkokready')
					console.log('sdkk', _this.jweixin)
					_this.initJssdk(function() {
						console.log('微信配置参数初始化完成')
						_this.jweixin.ready(function() {
							console.log('微信环境初始化完成', _this.jweixin)
							console.log('支付参数使用', parameters.data, parameters.data
								.timestamp)
							// TODO
							_this.jweixin.chooseWXPay({
								timestamp: parameters.data.timestamp,
								nonceStr: parameters.data.nonceStr,
								package: parameters.data.package,
								signType: parameters.data.signType,
								paySign: parameters.data.paySign,
								success: function(res) {
									// 支付成功后的回调函数
									console.log('支付成功', res)
									callback && callback(JSON.stringify(
										res));
								},
								fail: function(res) {
									_this.toast(JSON.stringify(res));
									console.log('支付失败', res)
								}
							});
						});
					});
				} else {
					_this.toast(parameters.message, 3000, 'error')
				}
			}).catch((err) => {
				console.log("错误", err);
			});
		}
		// #endif

		// #ifdef MP-WEIXIN
		console.log('小程序支付')
		_this.request('/wechat/basics/payparameters', "POST", {
			openid: fans.openid,
			trade_type: 'JSAPI',
			body: body,
			out_trade_no: order_no,
			total_fee: pay_price,
		}).then((parameters) => {
			console.log('支付参数', parameters.code)
			if (parameters.code == 200) {
				uni.hideLoading()

				uni.requestPayment({
					provider: 'wxpay',
					timeStamp: parameters.data.timestamp,
					nonceStr: parameters.data.nonceStr,
					package: parameters.data.package,
					signType: parameters.data.signType,
					paySign: parameters.data.paySign,
					success: function(res) {
						console.log('success:' + JSON.stringify(res));
						console.log(parameters)
						callback && callback(JSON.stringify(res));
					},
					fail: function(err) {
						console.log('fail:' + JSON.stringify(err));
						let msg = err.errMsg == 'requestPayment:fail cancel' ? '取消支付' : err
							.errMsg
						_this.toast(msg)
						uni.redirectTo({
							url: "order"
						})
					}
				});
			}
		}).catch((err) => {
			console.log("错误", err);
		});

		// #endif

		// #ifdef APP-PLUS
		_this.request('/officialaccount/basics/payappparameters', "POST", {
			trade_type: 'APP',
			body: body,
			out_trade_no: order_no,
			total_fee: pay_price,
		}).then((parameters) => {
			console.log('支付参数', parameters.code)
			if (parameters.code == 200) {
				uni.hideLoading()
				// 获取支付参数
				console.log('sdkkokready')
				console.log('sdkk', _this.jweixin, parameters.data)
				console.log('唤起支付', {
					"appid": parameters.data
					.appid, // 微信开放平台 - 应用 - AppId，注意和微信小程序、公众号 AppId 可能不一致
					"noncestr": parameters.data.noncestr, // 随机字符串
					"package": parameters.data.package, // 固定值
					"partnerid": parameters.data.partnerid, // 微信支付商户号
					"prepayid": parameters.data.prepayid, // 统一下单订单号 
					"timestamp": parameters.data.timestamp, // 时间戳（单位：秒）
					"sign": parameters.data.sign // 签名，这里用的 MD5 签名
				})
				uni.requestPayment({
					"provider": 'wxpay',
					"orderInfo": {
						"appid": parameters.data
						.appid, // 微信开放平台 - 应用 - AppId，注意和微信小程序、公众号 AppId 可能不一致
						"noncestr": parameters.data.noncestr, // 随机字符串
						"package": parameters.data.package, // 固定值
						"partnerid": parameters.data.partnerid, // 微信支付商户号
						"prepayid": parameters.data.prepayid, // 统一下单订单号 
						"timestamp": parameters.data.timestamp, // 时间戳（单位：秒）
						"sign": parameters.data.sign // 签名，这里用的 MD5 签名
					},
					success: function(res) {
						console.log('success:' + JSON.stringify(res));
						console.log(parameters)
						callback && callback(JSON.stringify(res));
					},
					fail: function(err) {
						console.log('fail:' + JSON.stringify(err));
						let msg = err.errMsg == 'requestPayment:fail cancel' ? '取消支付' : err
							.errMsg
						_this.toast(msg)
						uni.redirectTo({
							url: "order"
						})
					}
				});
			} else {
				_this.toast(parameters.message, 3000, 'error')
			}
		}).catch((err) => {
			console.log("错误", err);
		});
		// #endif
		return false;

	},
	// 校验有效期
	checkCacheTime: function(keys) {

		let that = this

		var timestamp = Date.parse(new Date());
		if (uni.getStorageSync(keys) == '') {
			return true;
		}
		let cacheVal = uni.getStorageSync(keys).split('_');
		let cacheValTime = cacheVal[cacheVal.length - 1];
		let expiration_time = uni.getStorageSync('expiration_time');
		let timesTotal = parseInt(cacheValTime) + parseInt(expiration_time)
		console.log('缓存过期校验', uni.getStorageSync(keys), timesTotal, timestamp / 1000)
		if (timesTotal <= timestamp / 1000) {
			if (keys == 'access_token') {
				// 缓存过期了
				uni.setStorageSync('access_token', '');
				uni.setStorageSync('fans', {});
				uni.setStorageSync('expiration_time', 0);
				uni.setStorageSync('member', {});
			} else {
				uni.setStorageSync('keys', '');
			}
			return true;
		} else {
			return false;
		}
	},
	loginOut: function(callback) {
		uni.setStorageSync('access_token', '');
		uni.setStorageSync('fans', {});
		uni.setStorageSync('expiration_time', 0);
		uni.setStorageSync('member', {});
		callback && callback()
	},
	//设置用户信息
	setUserInfo: function(mobile, token) {
		uni.setStorageSync("access_token", token)
		uni.setStorageSync("thorui_mobile", mobile)
	},
	getCitylist: function(callback) {
		return new Promise((resolve, reject) => {
			this.request("map/citylist", "GET", {}).then((res) => {
				if (res.code == 200) {
					uni.setStorageSync('Citylist', res.data);
					callback && callback(res.data)
				} else {
					this.toast(res.message);
				}
				resolve(res.data)
			}).catch((res) => {
				reject(res)
			})
		})
	},
	//跳转页面，校验登录状态
	href(url, isVerify) {
		let that = this
		if (isVerify && !fui.isLogin()) {
			uni.navigateTo({
				url: '/login',
				complete(res) {
					console.log(res)
				}
			})
		} else {
			console.log(1, url)
			uni.navigateTo({
				url: url,
				complete(res) {
					console.log(res)
				}
			});
		}
	},
	// 扫一扫
	linkScan(callback) {
		const _this = this;
		return new Promise((resolve, reject) => {
			/*  #ifndef H5  */
			uni.scanCode({
				success: function(res) {
					console.log(res, _this)
					if (res.result.indexOf('http') !== -1) {
						if (res.result.indexOf(_this.$mConfig.hostUrl) !== -1) {

							callback && callback(res)
						} else {
							fui.toast("不能识别该二维码")
						}
					}
					resolve(res)
				},
				fail(res) {
					// 支付成功后的回调函数
					fui.toast('扫描失败：' + res.errMsg)
					reject(res)
				}
			});
			/*  #endif  */
			/*  #ifdef H5  */

			if (globalFunc.isWeixin()) {
				_this.initJssdk(function() {
					console.log('微信配置参数初始化完成')
					_this.jweixin.ready(function() {
						_this.jweixin.scanQRCode({
							needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
							success(res) {
								if (res.result.indexOf('http') !== -1) {
									if (res.result.indexOf(_this.$mConfig
										.hostUrl) !== -1) {
										callback && callback(res)
										resolve(res)
									} else {
										fui.toast('不能识别该二维码')
									}
								}
							},
							fail(res) {
								// 支付成功后的回调函数
								fui.toast('扫描失败：' + res.errMsg)
								reject(res)
							}
						});
					})
				})

			} else {
				fui.toast('请在微信H5进行相关操作')
			}
			/*  #endif  */
		})
	},
	getLocation(callback) {
		let that = this;
		return new Promise((resolve, reject) => {
			// #ifdef H5
			let userAgent = navigator.userAgent;
			let WECHAT_LOGIN = this.WECHAT_LOGIN
			console.log('定位', 'h5', WECHAT_LOGIN)
			if (globalFunc.isWeixin() && WECHAT_LOGIN) { // 公众号
				console.log('定位', '公众号')
				that.initJssdk(function() {
					that.jweixin.ready(function() {
						that.jweixin.getLocation({
							type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
							success: function(res) {
								var latitude = res
								.latitude; // 纬度，浮点数，范围为90 ~ -90
								var longitude = res
								.longitude; // 经度，浮点数，范围为180 ~ -180。
								var speed = res.speed; // 速度，以米/每秒计
								var accuracy = res.accuracy; // 位置精度
								// 请求了
								resolve(res.data)
								// 成功了 200
								callback && callback(res)

							},
							fail: function(res) {
								console.log('公众号定位失败', res)
								// 错误了
								reject(res)
							}
						});
					});
				});

			}
			// #endif
			// #ifdef APP-PLUS || MP-WEIXIN
			console.log('开始定位')
			uni.getLocation({
				// type: 'wgs84',
				type: 'gcj02',
				success: function(res) {
					// 请求了
					resolve(res.data)

					// 成功了 200
					callback && callback(res)

				},
				fail: function(res) {
					// 错误了
					reject(res)
				}
			});

			// #endif
		})
	},
	getQueryString(name) {
		const reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
		const search = window.location.search.split('?')[1] || '';
		const r = search.match(reg) || [];
		return r[2];
	},
	install(vue, extra = {}) {
		const {
			http = {},
				config = {},
		} = extra
		console.log('全局配置数据', http)
		setHttpConfig(http)
		setRequestList(http.apiList || [])
		if (http.successCode) {
			setStatusCode(http.successCode)
		}
		if (http.responseSuccessCallBack) {
			setResponseSuccessCallBack(http.responseSuccessCallBack)
		}
	}
}

export default fui

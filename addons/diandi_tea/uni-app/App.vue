<script>
import Vue from 'vue';
import { mapMutations } from 'vuex';
export default {
	globalData: {
		text: 'text',
		storeInfo: {}
	},
	onLaunch: function(options) {
		let that = this;
		console.log('每一次', options);
		uni.getSystemInfo({
			success: function(e) {
				console.log('终端类型', e);

				Vue.prototype.windowHeight = e.windowHeight;
				// #ifndef MP
				Vue.prototype.StatusBar = e.statusBarHeight;
				if (e.platform == 'android') {
					Vue.prototype.CustomBar = e.statusBarHeight + 50;
				} else {
					Vue.prototype.CustomBar = e.statusBarHeight + 45;
				}
				// #endif

				// #ifdef MP-WEIXIN || MP-QQ
				Vue.prototype.StatusBar = e.statusBarHeight;
				let capsule = wx.getMenuButtonBoundingClientRect();
				if (capsule) {
					Vue.prototype.Custom = capsule;
					// Vue.prototype.capsuleSafe = uni.upx2px(750) - capsule.left + uni.upx2px(750) - capsule.right;
					console.log('高度兼容', capsule.bottom, capsule.top, e.statusBarHeight);
					Vue.prototype.CustomBar = capsule.bottom + capsule.top - e.statusBarHeight;
				} else {
					Vue.prototype.CustomBar = e.statusBarHeight + 50;
				}
				// #endif

				// #ifdef MP-ALIPAY
				Vue.prototype.StatusBar = e.statusBarHeight;
				Vue.prototype.CustomBar = e.statusBarHeight + e.titleBarHeight;
				// #endif
			}
		});

		// #ifdef APP-PLUS
		/* 5+环境锁定屏幕方向 */
		plus.screen.lockOrientation('portrait-primary'); //锁定
		plus.navigator.setFullscreen(true);
		/* 5+环境升级提示 */
		//app检测更新
		let platform = plus.os.name.toLocaleLowerCase();
		plus.runtime.getProperty(plus.runtime.appid, widgetInfo => {
			return false;
			that.fui
				.request(
					'/config/getNewestVersion',
					{
						platform: platform,
						version: widgetInfo.version //资源版本号
					},
					'POST',
					false,
					true
				)
				.then(res => {
					if (res.code === 200 && res.data && (res.data.updateUrl || res.data.partUpdateUrl)) {
						let data = res.data;
						that.fui.modal('检测到新版本', data.updateLog ? data.updateLog : '请您先更新再进行操作，若不及时更新可能导致部分功能无法正常使用。', false, res => {
							if (data.hasPartUpdate === 0) {
								//应用市场更新
								plus.runtime.openURL(data.updateUrl);
								plus.runtime.restart();
							} else if (data.hasPartUpdate === 1) {
								//资源更新（服务器端更新）
								that.fui.href(`/pages/common/update/update?url=${data.partUpdateUrl}`);
							}
						});
					}
				})
				.catch(e => {});
		});

		// #endif

		// #ifdef MP-WEIXIN
		if (wx.canIUse('getUpdateManager')) {
			const updateManager = wx.getUpdateManager();
			updateManager.onCheckForUpdate(function(res) {
				// 请求完新版本信息的回调
				console.log('更新0', res);
				if (res.hasUpdate) {
					console.log('更新1', res);
					updateManager.onUpdateReady(function(res) {
						console.log('更新2', res);
						uni.showModal({
							title: '更新提示',
							content: '新版本已经准备好，是否重启应用？',
							success(res) {
								if (res.confirm) {
									// 新的版本已经下载好，调用 applyUpdate 应用新版本并重启
									updateManager.applyUpdate();
								}
							}
						});
		
					});
					updateManager.onUpdateFailed(function() {
						// 新的版本下载失败
						uni.showModal({
							title: '更新失败',
							content: '新版本更新失败，为了获得更好的体验，请您删除当前小程序，重新搜索打开',
							success(res) {
								if (res.confirm) {
									// 新的版本已经下载好，调用 applyUpdate 应用新版本并重启
									updateManager.applyUpdate();
								}
							}
						});
					});
				}
			});
		}
		console.log('响应式修改大小')
		//YSHaoShenTi.ttf为ui指定字体文件
		uni.loadFontFace({
		  family: 'webfont',
		  source: 'url("https://cnd.dzwztea.cn/fonts/YSHaoShenTi.ttf")',
		  success: function (res) {
			  console.log('字体加载',res.status) //  loaded
		  },
		  fail: function (res) {
			  console.log(res.status) //  error 
		  },
		  complete: function (res) {
			  console.log('字体加载',res.status);
		  }
		});
		// #endif
	},
	methods: {
		...mapMutations(['login'])
	},
	onLoad: function(option) {
		//option为object类型，会序列化上个页面传递的参数
		console.log(option.id); //打印出上个页面传递的参数。
		console.log(option.name); //打印出上个页面传递的参数。
		
		
		
	},
	onShow: function(options) {
		let code = options.query.code;
		let state = options.query.state;
	},
	onHide: function() {
		uni.removeStorageSync('bloc_id');
		uni.removeStorageSync('store_id');
		console.log('App Hide');
	},
	onError: function(err) {
		//全局错误监听
		// #ifdef APP-PLUS
		plus.runtime.getProperty(plus.runtime.appid, widgetInfo => {
			const res = uni.getSystemInfoSync();
			let errMsg = `手机品牌：${res.brand}；手机型号：${res.model}；操作系统版本：${res.system}；客户端平台：${res.platform}；错误描述：${err}`;
			console.log('发生错误：' + errMsg);
		});
		// #endif
	}
};
</script>
<style lang="scss">
/*每个页面公共css uParse为优化版本*/
@import './static/css/base.css';
@import './static/css/app.css';
@import './static/css/fireui.css';
@import './static/css/cs.css';
@import './static/fonts/iconfont.css';
/* #ifndef APP-NVUE */
@import './components/uni/uParse/src/wxParse.css';
/* #endif */
/* #ifdef H5 */
uni-page-head .uni-page-head {
	display: none;
}
/* #endif */
page{
  font-family: 'webfont';
  font-size:40rpx;
  font-style:normal;
  -webkit-font-smoothing: antialiased;
  // -webkit-text-stroke-width: 0.2px;
  -moz-osx-font-smoothing: grayscale;
}
.fui-header {
	width: 100%;
	height: 90rpx;
	padding: 0 30rpx 0 20rpx;
	box-sizing: border-box;
	display: flex;
	align-items: center;
	justify-content: space-between;
	position: fixed;
	left: 0;
	top: 0;
	/* #ifdef H5 */
	top: 0;
	/* #endif */
	z-index: 999;
}
.fui-tabs-view {
	z-index: 1;
}

.wxParse .p {
	padding-bottom: 0rpx;
	clear: both;
}

.fui-item-box {
	width: 100%;
	display: flex;
	align-items: center;
}

.fui-list-cell_name {
	padding-left: 20rpx;
	display: flex;
	align-items: center;
	justify-content: center;
}

.fui-ml-auto {
	margin-left: auto;
}

.fui-logo {
	height: 52rpx;
	width: 52rpx;
	flex-shrink: 0;
}

.fui-flex {
	display: flex;
	align-items: center;
}

.fui-msg-box {
	display: flex;
	align-items: center;
}

.fui-msg-pic {
	width: 100rpx;
	height: 100rpx;
	border-radius: 50%;
	display: block;
	margin-right: 24rpx;
	flex-shrink: 0;
}

.fui-msg-item {
	max-width: 500rpx;
	min-height: 80rpx;
	overflow: hidden;
	display: flex;
	flex-direction: column;
	justify-content: space-between;
}

.fui-msg-name {
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
	font-size: 34rpx;
	line-height: 1;
	color: #262b3a;
}

.fui-msg-content {
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
	font-size: 26rpx;
	line-height: 1;
	color: #9397a4;
}

.fui-msg-right {
	max-width: 120rpx;
	height: 79rpx;
	margin-left: auto;
	text-align: right;
	display: flex;
	flex-direction: column;
	justify-content: space-between;
	align-items: flex-end;
}

.fui-right-dot {
	height: 76rpx !important;
	padding-bottom: 10rpx !important;
}

.fui-msg-time {
	width: 100%;
	font-size: 24rpx;
	line-height: 24rpx;
	color: #9397a4;
}

/* radio 选中后的样式 */
uni-radio .uni-radio-input {
	border-radius: 8.33rpx;
}
.wx-progress-inner-bar {
	border-radius: 14px;
}
</style>

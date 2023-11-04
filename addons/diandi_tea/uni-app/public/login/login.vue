<template>
	<view class="container">
		<image class="bg-contain"  :src="getImgUrl_('bg_dl.png')" mode=""></image>
		<view class="login_title">
			<view>您好！</view>
			<view class="margin-top-xs">欢迎您的到来。</view>
		</view>

		<view class="fui-form">
			<view class="fui-view-input">
				<fui-list-cell :hover="false" :lineLeft="false"  :radius="true" :padding="padd">
					<view class="fui-cell-input fui-my-input">
						<iconfont className="icon-aui-icon-mobile padding" style="margin-right:97.91rpx;" color="#6d7a87" :size="24"></iconfont>
						<input
							:adjust-position="false"
							:value="mobile"
							placeholder="请输入手机号码"
							placeholder-class="fui-phcolor"
							type="number"
							maxlength="11"
							@input="inputMobile"
						/>
						<view class="fui-icon-close1" v-show="mobile" @tap="clearInput(1)"><iconfont className="icon-cuowu1" :size="16" color="#bfbfbf"></iconfont></view>
					</view>
				</fui-list-cell>
				<fui-list-cell :hover="false" :lineLeft="false" :padding="padd" :radius="true" >
					<view class="fui-cell-input fui-my-input">
						<iconfont className="icon-mima padding" style="margin-right:97.91rpx;" color="#6d7a87" :size="24"></iconfont>
						<input
							:adjust-position="false"
							:value="password"
							placeholder="请输入账号密码"
							:password="true"
							placeholder-class="fui-phcolor"
							type="text"
							maxlength="36"
							@input="inputPwd"
						/>
						<view class="fui-icon-close1" v-show="password" @tap="clearInput(2)"><iconfont className="icon-cuowu1" :size="16" color="#bfbfbf"></iconfont></view>
					</view>
				</fui-list-cell>
			</view>
			<view class="fui-btn-box text-center" @tap="login">登录</view>
			<view class="fui-cell-text">
				<view hover-class="fui-opcity" :hover-stay-time="150" @tap="href(2)">注册</view>
				<view class="fui-color-black" hover-class="fui-opcity" :hover-stay-time="150" @tap="href(1)">修改密码</view>
			</view>
		</view>
	</view>
</template>

<script>
import { mapMutations } from 'vuex';
export default {
	// computed: {
	// 	disabled: function() {
	// 		let bool = true;
	// 		if (this.mobile && this.password) {
	// 			bool = false;
	// 		}
	// 		return bool;
	// 	}
	// },
	data() {
		return {
			padd:"9px 28px",
			mobile: '',
			password: '',
			popupShow: false,
			backUrl: '',
			top:0
		};
	},
	computed: {
		getImgUrl_() {
			return url => this.resourceUrl + url;
		}
	},
	onLoad(options) {
		let that = this;
		setTimeout(() => {
			that.logout();
		}, 0);

		that.backUrl = options.backUrl || '/';
		
		wx.getSystemInfo({
		  success (res) {
			  that.top=res.statusBarHeight
		    console.log(res,res.statusBarHeight)
		  }
		})
	},
	methods: {
		...mapMutations(['login', 'logout']),
		back() {
			uni.navigateBack();
		},
		login() {
			let that = this;
			let backUrl = that.backUrl;
			that.fui.mobileLogin(that.mobile, that.password, function(res) {
				that.$Router.back(1);
			});
			that.$Router.push({ name: 'index' });
		},
		inputMobile: function(e) {
			this.mobile = e.detail.value;
		},
		inputPwd: function(e) {
			this.password = e.detail.value;
		},
		clearInput(type) {
			if (type == 1) {
				this.mobile = '';
			} else {
				this.password = '';
			}
		},
		href(type) {
			let that = this;
			let url = '';
			if (type == 1) {
				url = 'forgetPwd';
			} else if (type == 2) {
				url = 'register';
			}
			that.$Router.push({ name: url });
		},
		showOtherLogin() {
			//打开后 不再关闭
			this.popupShow = true;
		}
	}
};
</script>

<style lang="scss">
.container {
	// background: url('~@https://cnd.dzwztea.cn/tea/images/images/bg_dl.png') no-repeat center;
	height: 100vh;
	width: 100%;
	.bg-contain{
		background-size: cover;
		position: relative;
		height: 100%;
		width: 100%;
	}
	.login_title {
		position: absolute;
		margin-left: 79.16rpx;
		width: 535.41rpx;
		height: 175rpx;
		font-size: 72.91rpx;
		font-weight: bold;
		line-height: 35px;
		color: #FFFFFF;
		margin-top: 54.16rpx;
	}

	.fui-my-input {
		// padding: 10px 0px !important;
		background-color: #fff;
	}

	.fui-form {
		position: absolute;
		margin: 208.33rpx 0;
	
		.fui-view-input {
			width: 100%;
			box-sizing: border-box;
			padding: 0 77.08rpx;
			.fui-cell-input {
				width: 100%;
				display: flex;
				align-items: center;
	
				input {
					flex: 1;
					padding-left: $uni-spacing-row-base;
				}
	
				.fui-icon-close1 {
					margin-left: auto;
					padding-right: 12.5rpx;
				}
			}
		}

		.fui-cell-text {
			width: 100%;
			padding: 41.66rpx 79.16rpx;
			color: #FFFFFF;
			box-sizing: border-box;
			font-size: 33.33rpx;
			line-height: 45.83rpx;
			display: flex;
			align-items: center;
			justify-content: space-between;
		}

		.fui-btn-box {
			width: 100%;
			box-sizing: border-box;
			width: 383.33rpx;
			height: 83.33rpx;
			margin: 0 auto;
			background-color: #fe897c;
			color: #ffffff;
			font-size: 35.41rpx;
			line-height: 83.33rpx;
			margin-top: 41.66rpx;
		}
	}

	.fui-login-way {
		width: 100%;
		font-size: 26rpx;
		display: flex;
		justify-content: center;
		position: fixed;
		left: 0;
		bottom: 80rpx;

		view {
			padding: 12rpx 0;
		}
	}

	.fui-auth-login {
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: center;
		padding-bottom: 80rpx;
		padding-top: 20rpx;

		.fui-icon-platform {
			width: 90rpx;
			height: 90rpx;
			display: flex;
			align-items: center;
			justify-content: center;
			position: relative;
			margin-left: 40rpx;

			&::after {
				content: '';
				position: absolute;
				width: 200%;
				height: 200%;
				transform-origin: 0 0;
				transform: scale(0.5, 0.5) translateZ(0);
				box-sizing: border-box;
				left: 0;
				top: 0;
				border-radius: 180rpx;
				border: 1rpx solid $uni-text-color-placeholder;
			}
		}

		.fui-login-logo {
			width: 60rpx;
			height: 60rpx;
		}
	}
}
.fui-list-cell {
	position: relative;
	width: 100%;
	padding: 26rpx 30rpx;
	background-color: #fff;
	box-sizing: border-box;
	margin-top:35rpx;
}
</style>

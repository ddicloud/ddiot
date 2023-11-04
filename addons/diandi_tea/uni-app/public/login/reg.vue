<template>
	<view class="container">
		<image class="bg-contain" :src="getImgUrl_('bg_dl.png')" mode="widthFix"></image>
		<view class="login_title">
			<view>您好！</view>
			<view class="margin-top-xs">欢迎您的到来。</view>
		</view>
		<view class="fui-form">
			<view class="fui-view-input">
				<!-- <fui-list-cell :hover="false" :lineLeft="false" backgroundColor="transparent">
					<view class="fui-cell-input fui-my-input">
						<input placeholder="用户名" placeholder-class="fui-phcolor" type="text" maxlength="11" v-model="username" />
						<view class="fui-icon-close1" v-show="mobile" @tap="clearInput(1)"><iconfont className="icon-cuowu1" :size="16" color="#bfbfbf"></iconfont></view>
					</view>
				</fui-list-cell> -->

				<fui-list-cell :hover="false" :lineLeft="false" :padding="padd" :radius="true" >
					<view class="fui-cell-input fui-my-input">
						<iconfont className="icon-aui-icon-mobile padding" style="margin-right:97.91rpx;" color="#6d7a87" :size="24"></iconfont>
						<input :value="mobile" placeholder="请输入手机号码" placeholder-class="fui-phcolor" type="number" maxlength="11" @input="inputMobile" />
						<view class="fui-icon-close1" v-show="mobile" @tap="clearInput(1)"><iconfont className="icon-cuowu1" :size="16" color="#bfbfbf"></iconfont></view>
					</view>
				</fui-list-cell>

				<fui-list-cell :hover="false" :lineLeft="false" v-if="usecode" :radius="true"  :padding="padd">
					<view class="fui-cell-input fui-my-input">
						<iconfont className="icon-mima padding" color="#6d7a87" style="margin-right:97.91rpx;" :size="24"></iconfont>
						<input placeholder="请输入验证码" placeholder-class="fui-phcolor" type="text" maxlength="6" @input="inputCode" />
						<view class="fui-btn-send" :class="{ 'fui-gray': isSend }" :hover-class="isSend ? '' : 'fui-opcity'" :hover-stay-time="150" @tap="sendCode">
							{{ btnSendText }}
						</view>
					</view>
				</fui-list-cell>
				<fui-list-cell :hover="false" :lineLeft="false" :radius="true" :padding="padd">
					<view class="fui-cell-input fui-my-input">
						<iconfont className="icon-mima padding" color="#6d7a87" style="margin-right:97.91rpx;" :size="24"></iconfont>
						<input :value="password" placeholder="请输入密码" :password="true" placeholder-class="fui-phcolor" type="text" maxlength="40" @input="inputPwd" />
						<view class="fui-icon-close1" v-show="password" @tap="clearInput(2)"><iconfont className="icon-cuowu1" :size="16" color="#bfbfbf"></iconfont></view>
					</view>
				</fui-list-cell>
				<fui-list-cell :hover="false" :lineLeft="false" :radius="true"  :padding="padd">
					<view class="fui-cell-input fui-my-input">
						<iconfont className="icon-mima padding " color="#6d7a87" style="margin-right:97.91rpx;" :size="24"></iconfont>
						<input :value="password" placeholder="请确认密码" :password="true" placeholder-class="fui-phcolor" type="text" maxlength="40" @input="inputPwd" />
						<view class="fui-icon-close1" v-show="password" @tap="clearInput(2)"><iconfont className="icon-cuowu1" :size="16" color="#bfbfbf"></iconfont></view>
					</view>
				</fui-list-cell>
			</view>
			<view class="fui-btn-box text-center" @tap="register">登录</view>
			<view class="fui-cell-text">
				<!-- <view class="fui-col-8"><view class="fui-color-black" hover-class="fui-opcity" :hover-stay-time="150" @tap="protocol">用户注册协议</view></view> -->
				<view class="fui-color-black" hover-class="fui-opcity" :hover-stay-time="150" @tap="toLogin">登录</view>
			</view>
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			padd:"9px 15px",
			mobile: '',
			logo: '',
			password: '',
			username: '',
			code: '',
			usecode: true,
			isSend: false,
			btnSendText: '获取' //倒计时格式：(60秒)
		};
	},
	computed: {
		getImgUrl_() {
			return url => this.resourceUrl + url;
		}
	},
	onLoad() {
		let that = this;
		console.log('邀请码全局存储', that.$store.state.inviteCode);
		that.fui
			.store()
			.then(res => {
				that.logo = res.logo;
				console.log('AAAAAAAAAA', res);
				console.log('关键词热搜', res.logo);
			})
			.catch(res => {
				console.log('shibai', res);
			});
	},
	methods: {
		register() {
			let that = this;
			that.fui
				.request(
					'/user/signup',
					'POST',
					{
						username: that.username,
						mobile: that.mobile,
						password: that.password
					},
					false
				)
				.then(res => {
					console.log(res.fans.nickname);
					if (res.code == 200) {
						console.log(res.fans.nickname);
						this.fui.toast(res.message);
						that.fui.href('/login');
					} else {
						this.fui.toast(res.message);
					}
				})
				.catch(res => {});
		},
		toLogin: function() {
			let that = this;
			that.$Router.push({ name: 'login' });
		},
		back() {
			uni.navigateBack();
		},
		inputCode(e) {
			this.code = e.detail.value;
		},
		sendCode: function() {
			let that = this;
			if (!that.iGlobal.isMobile(that.mobile)) {
				this.fui.toast('请输入正确的手机号');
				return false;
			}
			that.fui
				.request(
					'/user/sendcode',
					'POST',
					{
						mobile: that.mobile,
						type: 'register'
					},
					false
				)
				.then(res => {
					console.log(res);
					if (res.code == 200) {
						console.log(res);
						this.fui.toast(res.message);
					} else {
						this.fui.toast(res.message);
					}
				})
				.catch(res => {});
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
		protocol() {
			this.fui.href('/protocol');
		}
	}
};
</script>

<style lang="scss" scoped>
.container {
	height: 100vh;
	width: 100%;
	.bg-contain{
		background-size: cover;
		position: relative;
		height: 100%;
		width: 100%;
	}
	.login_title {
		margin-left: 79.16rpx;
		width: 535.41rpx;
		height: 175rpx;
		font-size: 72.91rpx;
		font-weight: bold;
		line-height: 35px;
		color: #ffffff;
		margin-top: 54.16rpx;
		position: absolute;
	}
	.fui-page-title {
		width: 100%;
		font-size: 48rpx;
		font-weight: bold;
		color: $uni-text-color;
		line-height: 42rpx;
		padding: 110rpx 40rpx 40rpx 40rpx;
		box-sizing: border-box;
	}
	.fui-my-input {
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
				}
				.fui-icon-close {
					margin-left: auto;
				}
				.fui-btn-send {
					width: 75rpx;
					text-align: right;
					flex-shrink: 0;
					font-size: 22.91rpx;
					color: #ffffff;
					border-radius: 25rpx;
					background-color: #e50012;
					text-align: center;
					padding: 8.33rpx;
					margin: 0 20.83rpx;
				}
				.fui-gray {
					color: $uni-text-color-placeholder;
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
}
.fui-list-cell {
	position: relative;
	width: 100%;
	padding: 26rpx 30rpx;
	background-color: #fff;
	box-sizing: border-box;
	margin-top:35rpx !important;
}
</style>

<template>
	<view class="container">
		<image class="bg-contain" :src="getImgUrl_('bg_dl.png')" mode="widthFix"></image>
		<view class="login_title">
			<view>您好！</view>
			<view class="margin-top-xs">欢迎您的到来。</view>
		</view>
		<view class="fui-form">
			<view class="fui-view-input">
				<fui-list-cell :hover="false" :lineLeft="false" :radius="true" :padding="padd">
					<view class="fui-cell-input  fui-my-input">
						<iconfont className="icon-aui-icon-mobile padding" style="margin-right:97.91rpx;" color="#6d7a87" :size="24"></iconfont>
						<input :value="mobile" placeholder="请输入手机号" placeholder-class="fui-phcolor" type="number" maxlength="11" @input="inputMobile" />
						<view class="fui-icon-close1" v-show="password" @tap="clearInput(2)">
							<iconfont className="icon-cuowu1 padding" :size="16" color="#bfbfbf"></iconfont>
						</view>
					</view>
				</fui-list-cell>
				<fui-list-cell :hover="false" :lineLeft="false" :radius="true" :padding="padd" style="margin-top: 25rpx;">
					<view class="fui-cell-input  fui-my-input">
						<iconfont className="icon-mima padding" color="#6d7a87" style="margin-right:97.91rpx;" :size="24"></iconfont>
						<input placeholder="请输入验证码" placeholder-class="fui-phcolor" type="text" maxlength="6" @input="inputCode" />
						<view class="fui-btn-send" :class="{ 'fui-gray': isSend }" :hover-class="isSend ? '' : 'fui-opcity'" :hover-stay-time="150" @tap="sendCode">{{ btnSendText }}</view>
					</view>
				</fui-list-cell>
				<fui-list-cell :hover="false" :lineLeft="false" :radius="true" :padding="padd" style="margin-top: 25rpx;">
					<view class="fui-cell-input  fui-my-input">
						<iconfont className="icon-mima padding" color="#6d7a87" style="margin-right:97.91rpx;" :size="24"></iconfont>
						<input :value="password" placeholder="请输入新密码" :password="true" placeholder-class="fui-phcolor" type="text" maxlength="40" @input="inputPwd" />
						<view class="fui-icon-close1" v-show="password" @tap="clearInput(2)">
							<iconfont className="icon-cuowu1" :size="16" color="#bfbfbf"></iconfont>
						</view>
					</view>
				</fui-list-cell>
				<fui-list-cell :hover="false" :lineLeft="false" :radius="true" :padding="padd" style="margin-top: 25rpx;">
					<view class="fui-cell-input  fui-my-input">
						<iconfont className="icon-mima padding" color="#6d7a87" style="margin-right:97.91rpx;" :size="24"></iconfont>
						<input :value="password" placeholder="请确认新密码" :password="true" placeholder-class="fui-phcolor" type="text" maxlength="40" @input="inputPwd" />
						<view class="fui-icon-close1" v-show="password" @tap="clearInput(2)">
							<iconfont className="icon-cuowu1" :size="16" color="#bfbfbf"></iconfont>
						</view>
					</view>
				</fui-list-cell>
			</view>
			<view class="fui-btn-box text-center" @tap="forgetPwd">确认</view>
				<view class="fui-cell-text">
					<view class="fui-color-black" hover-class="fui-opcity" :hover-stay-time="150" @tap="href(1)">登录</view>
					<!-- <view hover-class="fui-opcity" :hover-stay-time="150">
						没有账号？
						<text class="fui-color-primary" @tap="href(2)">注册</text>
					</view> -->
				</view>
		</view>
	</view>
</template>

<script>
export default {
	computed: {
		disabled: function() {
			let bool = true;
			if (this.mobile && this.code && this.password) {
				bool = false;
			}
			return bool;
		}
	},
	data() {
		return {
			padd:"9px 15px",
			logo:'',
			mobile: '',
			password: '',
			code: '',
			usecode:true,
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
		let that = this
		that.fui.store().then((res)=>{
			that.logo = res.logo
			console.log('AAAAAAAAAA',res)
			console.log('关键词热搜',res.logo)
		}).catch((res)=>{
			console.log('shibai',res)
		});
	},
	methods: {
		forgetPwd(){
			let that = this
			that.fui.request("/user/forgetpass","POST",{
				code:that.code,
				mobile:that.mobile,
				password:that.password
			}).then((res)=>{
				console.log(res)
				if (res.code == 200) {
					console.log(res)
					this.fui.toast(res.message);
					that.fui.href('/login')
				} else {
					this.fui.toast(res.message);
				}
			}).catch((res)=>{})
		},
		href(type) {
			let that = this
			let url = '';
			if(type==1){
				url =	'login'
			}else if(type==2){
				url =	'register'
			}
			that.$Router.push({name:url})
		},
		inputCode(e) {
			this.code = e.detail.value;
		},
		sendCode:function(){
			let that = this
			if(!that.iGlobal.isMobile(that.mobile)){
				this.fui.toast('请输入正确的手机号');
				return false;
			}
			that.fui.request("/user/sendcode","POST",{
				mobile:that.mobile,
				type:'forgetpass'
			}).then((res)=>{
				console.log(res)
				if (res.code == 200) {
					console.log(res)
					this.fui.toast(res.message);
				} else {
					this.fui.toast(res.message);
				}
			}).catch((res)=>{})
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
		}
	}
};
</script>

<style lang="scss">
.container {
	height: 100vh;
	width: 100%;
	.fui-list-cell {
		position: relative;
		width: 100%;
		padding: 26rpx 30rpx;
		background-color: #fff;
		box-sizing: border-box;
		margin-top:35rpx;
	}
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

	.fui-header {
		width: 100%;
		padding: 40rpx;
		display: flex;
		align-items: center;
		justify-content: space-between;
		box-sizing: border-box;
	}

	.fui-page-title {
		width: 100%;
		font-size: 48rpx;
		font-weight: bold;
		color: $uni-text-color;
		line-height: 42rpx;
		padding: 40rpx;
		box-sizing: border-box;
	}
	
	.logo {
		width: 60%;
		height: 100px;
		border-radius: 10rpx;
		padding-top:20rpx;
	}
	
	.fui-my-input{
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
		.fui-btn-send {
				width: 75rpx;
				text-align: right;
				flex-shrink: 0;
				font-size: 22.91rpx;
				color: #FFFFFF;
				border-radius: 25rpx;
				background-color: #E50012 ;
				text-align: center;
				padding: 8.33rpx;
				margin: 0 20.83rpx;
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
		color: $uni-color-primary;
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
</style>

<template>
	<view class="container">
		<view class="fui-form">
			<view class="fui-view-input">
				<fui-list-cell :hover="false" :lineLeft="false"  backgroundColor="transparent">
					<view class="fui-cell-input fui-my-input">
						<iconfont className="icon-aui-icon-mobile padding" color="#6d7a87" :size="20"></iconfont>
						<input :value="mobile" placeholder="请输入手机号" placeholder-class="fui-phcolor" type="number" maxlength="11" @input="inputMobile" />
						<view class="fui-icon-close1" v-show="mobile" @tap="clearInput(1)">
							<iconfont className="icon-cuowu1" :size="16" color="#bfbfbf"></iconfont>
						</view>
					</view>
				</fui-list-cell>
				
				
				<fui-list-cell :hover="false" :lineLeft="false" backgroundColor="transparent" v-if="usecode">
					<view class="fui-cell-input fui-my-input">
						<iconfont className="icon-mima padding" color="#6d7a87" :size="20"></iconfont>
						<input placeholder="请输入验证码" placeholder-class="fui-phcolor" type="text" maxlength="6" @input="inputCode" />
						<view class="fui-btn-send" :class="{ 'fui-gray': isSend }" :hover-class="isSend ? '' : 'fui-opcity'" :hover-stay-time="150" @tap="sendCode">{{ btnSendText }}</view>
					</view>
				</fui-list-cell>
			</view>
			<view class="padding-lr">
				<view class="fui-btn-box" @tap="bindMobile">
					<fui-button :disabledGray="true" type="danger"  :shadow="true" shape="circle">绑定手机号</fui-button>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			member_id:'',
			mobile: '',
			username:'',
			code: '',
			usecode:true,
			isSend: false,
			btnSendText: '获取验证码' //倒计时格式：(60秒)
		};
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
		
		if(!that.iGlobal.isUndefined(that.$Route.query)){
			that.member_id = that.$Route.query.member_id || ''
			if(that.member_id){
				that.link(that.member_id)
			}
		}
	},
	methods: {
		bindMobile:function(){
			let that = this
			that.fui.request("/user/bindmobile","POST",{
				mobile:that.mobile,
				code:that.code
			}).then((res)=>{
				console.log(res)
				if (res.code == 200) {
					console.log(res)
					this.fui.toast(res.message);
					history.pushState({name: 'index'}, '', '/');
					that.$Router.replaceAll(that.$store.state.returnUrl)
					// that.$Router.replace({ name: 'index',params:{member_id:inviteCode}})
				} else {
					this.fui.toast(res.message);
				}
			}).catch((res)=>{})
		},
		link:function(member_id){
			let that = this
			that.fui.request("/diandi_distribution/level/link","POST",{
				member_id:member_id
			}).then((res)=>{
				console.log(res)
				if (res.code == 200) {
					uni.removeStorageSync('inviteCode')
					console.log(res)
				} else {
					this.fui.toast(res.message);
				}
			}).catch((res)=>{})
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
				type:'bindMobile'
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

<style lang="scss" scoped>
.container {
	.logo {
		width: 60%;
		height: 100px;
		border-radius: 10rpx;
		padding-top:20rpx;
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
	.fui-my-input{
		border: 1px solid rgb(109, 122, 135);
		border-radius: 50px;
		padding: 10px 0px!important;;
	}
	.fui-form {
		padding-top: 50rpx;
		.fui-view-input {
			width: 100%;
			box-sizing: border-box;
			padding: 0 40rpx;
			.fui-cell-input {
				width: 100%;
				display: flex;
				align-items: center;
				padding-top: 18.75rpx;
				padding-bottom: 18.75rpx;
				input {
					flex: 1;
					padding-left: $uni-spacing-row-base;
				}
				.fui-icon-close {
					margin-left: auto;
				}
				.fui-btn-send {
					width: 156rpx;
					text-align: right;
					flex-shrink: 0;
					font-size: $uni-font-size-base;
					color: $uni-color-primary;
					padding-right: 5px;
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
			padding: 40rpx $uni-spacing-row-lg;
			box-sizing: border-box;
			font-size: $uni-font-size-sm;
			color: $uni-text-color-grey;
			display: flex;
			align-items: center;
			.fui-color-primary {
				color: $uni-color-primary;
				padding-left: $uni-spacing-row-sm;
			}
		}
		.fui-btn-box {
			width: 100%;
			padding: 0 $uni-spacing-row-lg;
			box-sizing: border-box;
			margin-top: 80rpx;
		}
	}
}
</style>

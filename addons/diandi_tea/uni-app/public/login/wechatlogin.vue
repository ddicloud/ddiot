<template>
	<view>
		<view class="content">
			<!-- <view> -->
			<view class="container">
			  <view class="wechatapp">
			    <!-- <image class="header" src="/images/wechatapp.png"></image> -->
			    <view class="header">
			      <open-data class="" type="userAvatarUrl"></open-data>
			    </view>
			  </view>
			  <view class="auth-title">申请获取以下权限</view>
			  <view class="auth-subtitle">获得你的公开信息（昵称、头像等）</view>
			  <view class="login-btn">
			    <button class="btn-normal" open-type="getUserInfo" @getuserinfo="wechatLogin" lang="zh_CN">授权登录</button>
			  </view>
			  <view class="no-login-btn">
			    <button class="btn-normal" @click="onNotLogin">暂不登录</button>
			  </view>
			</view>
			<!-- </view> -->
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			backurl:''
		};
	},
	onShow(){
		
	},
	onLoad(e) {
		let _this = this
		_this.backurl = e.back
		console.log('触发',e,e.back)
	},
	methods: {
		wechatLogin(e){
			let _this = this
			//#ifdef MP-WEIXIN
			// 登录态过期
			this.fui.getUserInfo(function(res){
				console.log(res);
				console.log('登录以后',_this.backurl)
				uni.navigateBack({
				})
			})
			//#endif
		},
		onNotLogin(e){
			this.$Router.push({name:'index'})
		}
	}
};
</script>

<style>
	
	.container {
	  padding: 0 60rpx;
	}
	
	.wechatapp {
	  padding: 80rpx 0 48rpx;
	  border-bottom: 1rpx solid #e3e3e3;
	  margin-bottom: 72rpx;
	  text-align: center;
	}
	
	.wechatapp .header {
	  width: 190rpx;
	  height: 190rpx;
	  border: 2px solid #fff;
	  margin: 0rpx auto 0;
	  border-radius: 50%;
	  overflow: hidden;
	  box-shadow: 1px 0px 5px rgba(50, 50, 50, 0.3);
	}
	
	.auth-title {
	  color: #585858;
	  font-size: 34rpx;
	  margin-bottom: 40rpx;
	}
	
	.auth-subtitle {
	  color: #888;
	  margin-bottom: 88rpx;
	  font-size: 28rpx;
	}
	
	.login-btn {
	  padding: 0 20rpx;
	}
	
	.login-btn button {
	  height: 88rpx;
	  line-height: 88rpx;
	  background:  #218569;
	  color: #fff;
	  font-size: 30rpx;
	  border-radius: 999rpx;
	  text-align: center;
	}
	
	.no-login-btn {
	  margin-top: 20rpx;
	  padding: 0 20rpx;
	}
	
	.no-login-btn button {
	  height: 88rpx;
	  line-height: 88rpx;
	  background: #dfdfdf;
	  color: #fff;
	  font-size: 30rpx;
	  border-radius: 999rpx;
	  text-align: center;
	}
</style>

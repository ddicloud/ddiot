<!-- 用来处理微信公众号授权之后地址等操作 -->
<template>
	<view>
		<!--  #ifdef H5 -->
		<!-- <view>仅H5在公众号授权之后过渡显示</view> -->
		<!--  #endif -->
	</view>
</template>
<script>
export default {
	data() {
		return {};
	},
	methods: {},
	onLoad(options) {
		let that = this 
		// #ifdef H5
		if (that.iGlobal.isWeixin()) {
			let code  = that.$Route.query.code
			let state = that.$Route.query.state
			let inviteCode = that.$Route.query.inviteCode
			
			if(code && !that.fui.isLogin()){
				that.fui.getuserinfoBycode(code,function(res){
					console.log('授权登录后校验手机号',res.data.member.mobile,that.iGlobal.isMobile(res.data.member.mobile))
					// return false;
					if(!that.iGlobal.isMobile(res.data.member.mobile)){
						history.pushState({name: 'mobile'}, '', '/');
						that.$Router.replace({ name: 'mobile',params:{member_id:inviteCode}})	
					}else{
						history.pushState({name: 'index'}, '', '/');
						console.log('returnUrl',that.$store.state.returnUrl)
						that.$Router.replaceAll(that.$store.state.returnUrl)
						// that.$Router.replace({ name: 'index',params:{member_id:inviteCode}})
					}
				});	
			}else{
				history.pushState({name: 'index'}, '', '/');
				that.$Router.replace({ name: 'index'})
			}
		} else {
			history.pushState({name: 'index'}, '', '/');
			that.$Router.replace({ name: 'index'})
		}
		// #endif
	},
	mounted() {}
};
</script>

<style></style>

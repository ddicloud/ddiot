<template>
	<view class="container">
		<image class="tea-bag" src="https://cnd.dzwztea.cn/tea/images/bianjin1.png" mode="aspectFill"></image>
		<view class="tea-member">
			<view class="tea-member-level fui-font-size_24 fui-color-white">{{ memberInfo.level === 2 ? '尊享VIP会员' : '普通用户' }}</view>
			<view class="tea-member-info fui-flex">
				<image class="tea-member-thumb" :src="memberInfo.avatarUrl" mode=""></image>
				<view class="fui-color-white margin-left-sm">
					<view class="tea-member-name">{{ memberInfo.username || '' }}</view>
					<view class="tea-member-save">已为您节省{{ memberInfo.saveMoney || 0 }}元</view>
				</view>
			</view>
		</view>
		<view class="tea-member-btn">
			<view class="fui-flex">
				<view class="fui-flex tea-member-kq" @click="href(1)">
					<image class="tea-member-thumb" src="https://cnd.dzwztea.cn/tea/images/hykq.png" mode="widthFix"></image>
					<view class="margin-left-sm">会员卡券</view>
				</view>
				<view class="fui-flex tea-member-kq margin-left-sm" @click="href(2)" style="border:1px solid #F8EDD5 ;">
					<image class="tea-member-thumb" src="https://cnd.dzwztea.cn/tea/images/jfhd.png" mode="widthFix"></image>
					<view class="margin-left-sm">积分活动</view>
				</view>
			</view>
			<view class="fui-flex margin-top-sm">
				<view class="fui-flex tea-member-kq" @click="recharge" style="border:1px solid #EAE9FB ;">
					<image class="tea-member-thumb" src="https://cnd.dzwztea.cn/tea/images/czhd.png" mode="widthFix"></image>
					<view class="margin-left-sm">充值活动</view>
				</view>
				<view class="fui-flex tea-member-kq margin-left-sm" @click="integral" style="border:1px solid #FCDFE7 ;">
					<image class="tea-member-thumb" src="https://cnd.dzwztea.cn/tea/images/jfsc.png" mode="widthFix"></image>
					<view class="margin-left-sm">积分商城</view>
				</view>
			</view>
		</view>
		<fui-modal :show="modal" @cancel="hide" :custom="true" fadeIn>
			<view class="text-df fui-center">
				您还不是会员，请点击充值成为会员
			</view>
			<view class="fui-flex fui-font-size_26 font-weight-600 margin-top-lg">
				<view class="reser-btn fui-center color border2 border-radius-20" @click="recharge">去充值</view>
				<view class="reser-btn fui-center margin-left-32 color border2 border-radius-20" @click="modal=false">取消</view>
			</view>
		</fui-modal>
		<tab-bar :currentindex="currentTabIndex"></tab-bar>
	</view>
</template>

<script>
export default {
	data() {
		return {
			modal:false,
			currentTabIndex: 1,
			memberInfo: {},
			levels: 0
		};
	},
	onShow() {
		this.$nextTick(function(){
			this.getMember();
		})
	},
	methods: {
		getMember() {
			let that = this;
			that.fui
				.request('diandi_tea/member/info', 'GET', {}, true)
				.then(res => {
					if (res.code === 200) {
						that.memberInfo = res.data;
						that.levels = res.data.level;
					} else {
						uni.showToast({
							title: res.message,
							icon: 'none'
						});
					}
				})
				.catch(res => {
					console.log('shibai', res);
				});
		},
		recharge() {
			let that = this;
			that.$Router.push({
				name: 'recharge'
			});
		},
		hide() {
			let that=this
			this.modal = false;
		},
		integral() {
			let that = this;
			that.$Router.push({
				name: 'integral'
			});
		},
		href(index) {
			let that = this;
			let pathUrl = '';
			if (that.levels === 2) {
				if (index == 1) {
					pathUrl = 'coupon';
				} else if (index == 2) {
					pathUrl = 'integrals';
				}
				that.$Router.push({
					name: pathUrl
				});
			} else if (that.levels === 1) {
				that.modal=true
			}
		}
	}
};
</script>

<style>
.tea-bag {
	width: 100%;
	height: 233rpx;
	/* z-index: -1; */
	position: relative;
}
.tea-member {
	z-index: 1;
	position: absolute;
	width: 642.85rpx;
	height: 196rpx;
	background: linear-gradient(180deg, #89E09B 0%, #218569 100%);
	border-top-left-radius: 30rpx;
	left: 0;
	right: 0;
	margin: 30rpx auto 0 auto;
	border-top-right-radius: 30rpx;
}
.tea-member-level {
	font-size: 15px;
	float: right;
	margin-top: 18rpx;
	margin-right: 24rpx;
}
.tea-member-info {
	margin: auto 24rpx;
	height: 100%;
}
.tea-member-thumb {
	width: 102rpx;
	height: 102rpx;
	border-radius: 50%;
}
.tea-member-name {
	font-weight: 600;
	font-size: 32rpx;
	line-height: 45rpx;
}
.tea-member-save {
	font-size: 24rpx;
	opacity: 0.6;
}
.tea-member-btn {
	margin: 60rpx auto;
	border-top-left-radius: 15px;
	border-top-right-radius: 15px;
}
.tea-member-kq {
	font-weight: 600;
	font-size: 32rpx;
	border: 3rpx solid #e5efdc;
	border-radius: 20rpx;
	padding: 34rpx 36rpx;
}
.qd_btn {
	width: 100%;
	height: 60.4rpx;
}
.reser-btn {
	height: 60rpx;
	width: 100%;
}
</style>

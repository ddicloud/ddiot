<template>
	<view class="container">
		<view class="fui-mybg-box bag-color">
			<view class="fui-header-center">
				<image :src="memberInfo.avatarUrl" class="my-top-thumb"></image>
				<view class="fui-info">
					<view class="fui-flex">
						<view class="fui-nickname fui-color-white" @tap="personal(1)">{{ memberInfo.username || '' }}</view>
						<!-- <view class="margin-left-xs color enjoy-member" v-if="memberInfo.level">{{ memberInfo.level === 2 ? '尊享VIP会员' : '普通用户' }}</view> -->
						<image @click="modified" class="margin-right-lg my-top-xg" src="https://cnd.dzwztea.cn/tea/images/bianji@2x.png" mode="widthFix"></image>
					</view>
					<view class="fui-explain fui-color-white">{{ memberInfo.mobile }}</view>
				</view>
			</view>
		</view>
		<view class="fui-mybg-btn">
			<view class="fui-box fui-flex fui-center">
				<view class="fui-order-item" @click="myherf(1)">
					<view class="padding-xs"><image class="fui-mybg-btmg" src="https://cnd.dzwztea.cn/tea/images/dd.png" mode="widthFix"></image></view>
					<view class="fui-assets-text color">订单</view>
				</view>
				<view class="fui-order-item" @click="myherf(2)">
					<view class="padding-xs"><image class="fui-mybg-btmg" src="https://cnd.dzwztea.cn/tea/images/ye.png" mode="widthFix"></image></view>
					<view class="fui-assets-text color">余额</view>
				</view>
				<view class="fui-order-item" @click="myherf(3)">
					<view class="padding-xs"><image style="height: 15px;width: 25px;" src="https://cnd.dzwztea.cn/tea/images/kq.png" mode="widthFix"></image></view>
					<view class="fui-assets-text color">卡券</view>
				</view>
				<view class="fui-order-item" @click="myherf(4)">
					<view class="padding-xs"><image class="fui-mybg-btmg" src="https://cnd.dzwztea.cn/tea/images/jf.png" mode="widthFix"></image></view>
					<view class="fui-assets-text color">积分</view>
				</view>
				<view class="fui-order-item" @click="goPhone">
					<view class="padding-xs"><image class="fui-mybg-btmg" src="../../static/images/phone.png" mode="widthFix"></image></view>
					<view class="fui-assets-text color">客服</view>
				</view>
			</view>
		</view>
		<view class="fui-mybg-cz">
			<view class="fui-flex" @click="myherf(5)">
				<image class="fui-mybg-info fui-col-1" src="https://cnd.dzwztea.cn/tea/images/chongzhi.png" mode="widthFix"></image>
				<view class="margin-left-lg font-sizes fui-col-10">充值</view>
				<iconfont class="fui-col-1" className="icon-right-1-copy" :size="20" color="#979E91"></iconfont>
			</view>
			<view class="fui-flex margin-tops" @click="myherf(6)">
				<image class="fui-mybg-info fui-col-1" src="https://cnd.dzwztea.cn/tea/images/jifenduihuan.png" mode="widthFix"></image>
				<view class="margin-left-lg font-sizes fui-col-10">积分兑换</view>
				<iconfont class="fui-col-1" className="icon-right-1-copy" :size="20" color="#979E91"></iconfont>
			</view>
			<view class="fui-flex margin-tops" @click="myherf(8)">
				<image class="fui-col-1 fui-mybg-info"  src="../../static/images/kaipiao.png" mode="widthFix"></image>
				<view class="margin-left-lg font-sizes fui-col-10">开票记录</view>
				<iconfont class="fui-col-1" className="icon-right-1-copy" :size="20" color="#979E91"></iconfont>
			</view>
			<view class="fui-flex margin-tops" @click="myherf(7)" v-if="show_coupon">
				<image class="fui-mybg-info fui-col-1" src="https://cnd.dzwztea.cn/tea/images/bangzhu.png" mode="widthFix"></image>
				<view class="margin-left-lg font-sizes fui-col-10">赠送卡券</view>
				<iconfont class="fui-col-1" className="icon-right-1-copy" :size="20" color="#979E91"></iconfont>
			</view>
			<view class="fui-flex margin-tops" @click="myherf(9)" v-if="show_coupon">
				<image class="fui-mybg-info fui-col-1" src="https://cnd.dzwztea.cn/tea/images/bangzhu.png" mode="widthFix"></image>
				<view class="margin-left-lg font-sizes fui-col-10">订单汇总</view>
				<iconfont class="fui-col-1" className="icon-right-1-copy" :size="20" color="#979E91"></iconfont>
			</view>
		</view>
		<tab-bar :currentindex="currentTabIndex"></tab-bar>
	</view>
</template>

<script>
export default {
	data() {
		return {
			currentTabIndex: 3,
			memberInfo: {},
			mobile:'',
			show_coupon:false
		};
	},
	onShow() {
		this.$nextTick(function(){
			this.getMember();
			this.getinfomation();
			this.getShowCoupon();
		})
	},
	methods: {
		modified() {
			let that = this;
			that.$Router.push({
				name: 'modified'
			});
		},
		//是否显示赠送卡券
		getShowCoupon() {
			let that = this;
			that.fui
				.request('diandi_tea/meituan/showcoupon', 'POST', {}, true)
				.then(res => {
					if (res.code === 200) {
						that.show_coupon=res.data.show_coupon
					} else {
						uni.showToast({
							title: res.message,
							icon: 'none'
						});
					}
				})
				.catch(res => {
					uni.showToast({
						title: res.message,
						icon: 'none'
					});
				});
		},
		//获取电话
		getinfomation() {
			let that = this;
			that.fui
				.request('diandi_tea/index/top', 'GET', {}, false)
				.then(res => {
					if (res.code === 200) {
						that.mobile = res.data.list.mobile;
						console.log(res);
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
		getMember() {
			let that = this;
			that.fui
				.request('diandi_tea/member/info', 'GET', {}, true)
				.then(res => {
					if (res.code === 200) {
						that.memberInfo = res.data;
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
		myherf(index) {
			let that = this;
			let pathUrl = '';
			if (index != 2) {
				if (index == 1) {
					pathUrl = 'order';
				} else if (index == 3) {
					pathUrl = 'mycoupon';
				} else if (index == 4) {
					pathUrl = 'integrals';
				} else if (index == 5) {
					pathUrl = 'recharge';
				} else if (index == 6) {
					pathUrl = 'integral';
				} else if (index == 7) {
					pathUrl = 'givecoupon';
				}else if (index == 8) {
					pathUrl = 'invoiceDetail';
				}else if (index == 9) {
					pathUrl = 'orderinfo';
				}
				that.$Router.push({
					name: pathUrl
				});
			}
			if (index == 2){
				that.$Router.push({
					name: 'balance',
					params: {
						user_money: that.memberInfo.user_money
					}
				});
			}
		},
		goPhone() {
			let that = this;
			wx.makePhoneCall({
				phoneNumber: that.mobile
			});
		},
		
	}
};
</script>

<style>
.my-top-thumb {
	height: 109rpx;
	width: 109rpx;
	border-radius: 50%;
}
.my-top-xg {
	height: 32rpx;
	width: 32rpx;
	right: 40rpx;
	position: fixed;
}
.fui-mybg-box {
	height: 335rpx;
	width: 100%;
	position: relative;
	border-radius: 0 0 20% 20%;
}

.fui-header-center {
	position: absolute;
	width: 100%;
	padding-left: 85.71rpx;
	margin: auto 0;
	box-sizing: border-box;
	display: flex;
	align-items: center;
	top: 85.71rpx;
}
.fui-item-box {
	width: 100%;
	height: 60rpx;
	display: flex;
	align-items: center;
}
.fui-info {
	padding-left: 30rpx;
}
.fui-list-cell_name {
	padding-left: 34rpx;
	display: flex;
	align-items: center;
	justify-content: center;
}
.fui-nickname {
	font-size: 32.65rpx;
	align-items: center;
}

.fui-explain {
	font-size: 28rpx;
	padding-top: 8rpx;
	opacity: 0.6;
	font-size: 24rpx;
}

.enjoy-member {
	font-size: 10px;
	padding: 2px 7px;
	border-radius: 35rpx;
	background-color: #ffffff;
}
.fui-mybg-btn {
	box-shadow: 0px 7px 20px 0px rgba(229, 234, 224, 1);
	background-color: rgba(255, 255, 255, 1);
	border-radius: 12px;
	z-index: 43;
	height: 156rpx;
	position: absolute;
	left: 40rpx;
	right: 40rpx;
	margin: 217rpx auto;
}
.fui-order-item {
	flex: 1;
	display: flex;
	flex-direction: column;
	align-items: center;
}
.fui-mybg-btmg {
	width: 41rpx;
	height: 45rpx;
}
.fui-assets-text {
	font-size: 20rpx;
}
.fui-box {
	height: 156rpx;
}
.fui-mybg-cz {
	position: absolute;
	left: 52rpx;
	right: 52rpx;
	margin: 435rpx auto;
}
.fui-mybg-info {
	width: 32rpx;
	height: 32rpx;
}
.fui-mybg-infos{
	width: 40rpx;
	height: 40rpx;
}
.margin-tops {
	margin-top: 50rpx;
}
.font-sizes {
	font-size: 28rpx;
}
</style>

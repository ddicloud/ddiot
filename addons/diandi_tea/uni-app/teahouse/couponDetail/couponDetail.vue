<template>
	<view class="container">
		<!--banner-->
		<view class="fui-banner-swiper"><image :src="goodsdetail.coupon_img" class="fui-slide-image" /></view>
		<!--banner-->

		<view class="fui-pro-detail">
			<view class="fui-product-title fui-border-radius">
				<view class="fui-pro-pricebox padding-lr-xs">
					<view class="fui-pro-price">
						<iconfont className="icon-jifen" size="28">
							<text class="padding-left-xs">{{ goodsdetail.name || '' }}</text>
						</iconfont>
					</view>
				</view>
			</view>
			<view class="fui-original-price">
				价值
				<text class="">￥{{ goodsdetail.price || '' }}</text>
			</view>
			<view class="fui-nomore-box"><fui-nomore text="卡券详情" backgroundColor="#f7f7f7"></fui-nomore></view>
			<view class="margin-top_976 tycard-detail ">
				<view class="fui-flex margin-left-sm">
					<view class="color3 justify">有效期</view>
					<view class="margin-left-sm color4 fui-font-size_26">{{ goodsdetail.enable_start || '' }}-{{ goodsdetail.enable_end || '' }}</view>
				</view>
				<view class="fui-flex  margin-left-sm margin-top12">
					<view class="color3 justify">使用时间</view>
					<view class="margin-left-sm color4 fui-font-size_26">{{ goodsdetail.use_start || '' }}-{{ goodsdetail.use_end || '' }}</view>
				</view>
<!-- 				<view class="fui-flex  margin-left-sm margin-top12">
					<view class="color3 justify">使用时长</view>
					<view class="margin-left-sm color4 fui-font-size_26">{{ goodsdetail.max_time || '' }}小时</view>
				</view> -->
				<view class="fui-flex  margin-left-sm margin-top12" v-if="goodsdetail.type===2 || goodsdetail.type===3 || goodsdetail.type===5">
					<view class="color3 justify">使用时长</view>
					<view class="margin-left-sm color4 fui-font-size_26">{{ goodsdetail.max_time || '' }}小时</view>
				</view>
				<view class="fui-flex  margin-left-sm margin-top12" v-if="goodsdetail.type===1">
					<view class="color3 justify">代金券</view>
					<view class="margin-left-sm color4 fui-font-size_26">{{ goodsdetail.cash || '' }}元</view>
				</view>
				<view class="fui-flex  margin-left-sm margin-top12" v-if="goodsdetail.type===4">
					<view class="color3 justify">折扣</view>
					<view class="margin-left-sm color4 fui-font-size_26">{{ goodsdetail.discount  || '' }}折</view>
				</view>
				<view class="fui-flex  margin-left-sm margin-top12">
					<view class="color3 justify">使用限制</view>
					<view class="margin-left-sm color4 fui-font-size_26">{{ goodsdetail.max_num || 0 }}次</view>
				</view>
			</view>
		</view>
		<view class="fui-operation">
			<view class="fui-operation-right fui-right-flex fui-col-8 fui-btnbox-4">
				<view class="fui-flex-1"><fui-button height="72rpx" :size="28" type="bluegreen" shape="circle" @click="showPopup">立即购买</fui-button></view>
			</view>
		</view>

		<!--底部选择层-->
		<fui-bottom-popup :show="showDetail" @close="hidePopup">
			<view class="fui-popup-box">
				<view class="fui-product-box fui-padding">
					<image :src="goodsdetail.coupon_img" class="fui-popup-img"></image>
					<view class="fui-popup-price">
						<view class="fui-amount fui-bold">￥{{ goodsdetail.price || '' }}</view>
					</view>
				</view>
				<view class="fui-flex" style="margin: 51.02rpx 40.81rpx;">
					<view class="reser-btn fui-center color border2 border-radius-20 fui-font-size_32 " @click="wechatpay">微信支付</view>
					<view
						v-if="Number(goodsdetail.price) <= Number(goodsdetail.balance)"
						class="fui-center reser-btn margin-left-32 color border2 border-radius-20 fui-font-size_32 "
						@click="balancePay"
					>
						余额支付
					</view>
					<view
						v-if="Number(goodsdetail.price) > Number(goodsdetail.balance)"
						class=" fui-center reser-btn margin-left-32 fui-color-white bag-color border-radius-20 fui-font-size_32 "
						@click="recharge"
					>
						去充值
					</view>
				</view>
			</view>
		</fui-bottom-popup>
	</view>
</template>

<script>
import uParse from '@/components/u-parse/u-parse.vue';
export default {
	components: {
		uParse
	},
	data() {
		return {
			showDetail: false,
			id: 0,
			goodsdetail: {},
			orderDetail: {}
		};
	},
	onLoad(options) {
		let that = this;
		that.id = that.$Route.query.id;
	},
	onShow() {
		let that = this;
		that.getdetail();
		var pages = getCurrentPages(); // 获取栈实例
		console.log('pagessssssssssssss', pages); // 打印如下
		var page = pages[pages.length - 1]; // 获取当前页面的数据，包含页面路由
	},
	methods: {
		// 获取详情
		getdetail() {
			let that = this;
			that.fui
				.request(
					'diandi_tea/marketing/coupondetail',
					'GET',
					{
						coupon_id: that.id
					},
					true
				)
				.then(res => {
					console.log('商品详情获取成功', res.code == 200, res.code, res.data);
					if (res.code == 200) {
						that.goodsdetail = res.data;
					} else {
					}
				})
				.catch(res => {
					console.log('商品详情获取错误', res);
				});
		},
		// 创建订单
		creartOrder() {
			let that = this;
			that.fui
				.request(
					'diandi_tea/order/createbuycouponorder',
					'POST',
					{
						coupon_type: that.goodsdetail.type,
						coupon_name: that.goodsdetail.name,
						price: that.goodsdetail.price,
						coupon_id: that.goodsdetail.id
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						that.showDetail = true;
						that.orderDetail = res.data;
					} else {
						uni.showToast({
							title: res.message,
							icon: 'none'
						});
					}
				})
				.catch(res => {
					that.showDetail = false;
					uni.showToast({
						title: res.message,
						icon: 'none'
					});
				});
		},
		async wechatpay() {
			let that = this;
			let fans = uni.getStorageSync('fans');
			that.fui
				.request(
					'wechat/basics/payparameters',
					'POST',
					{
						openid: fans.openid,
						trade_type: 'JSAPI',
						body: that.orderDetail.coupon_name,
						out_trade_no: that.orderDetail.order_number,
						total_fee: that.orderDetail.price
					},
					true
				)
				.then(parameters => {
					if (parameters.code == 200) {
						// 获取支付参数
						// 仅作为示例，非真实参数信息。
						uni.requestPayment({
							provider: 'wxpay',
							timeStamp: parameters.data.timestamp,
							nonceStr: parameters.data.nonceStr,
							package: parameters.data.package,
							signType: parameters.data.signType,
							paySign: parameters.data.paySign,
							success: function(res) {
								// uni.redirectTo({
								//     url: '/teahouse/mycoupon/mycoupon'
								// });
								uni.showToast({
									title: '购买成功',
									icon: 'none',
									duration: 3000
								});
								that.getHourse();
							},
							fail: function(err) {
								console.log('fail:' + JSON.stringify(err));
								let msg = err.errMsg == 'requestPayment:fail cancel' ? '取消支付' : err.errMsg;
								that.fui.toast(msg);
								return false;
							}
						});
					} else {
						that.fui.toast(parameters.message);
					}
					console.log(parameters);
				})
				.catch(err => {
					console.log('错误', err);
				});

			return false;
		},
		// 获取卡券对应房间信息
		getHourse() {
			let that = this;
			that.fui
				.request(
					'diandi_tea/order/gethourse',
					'GET',
					{
						coupon_id: that.goodsdetail.id
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						if (res.data.use_hourse.length != 0) {
							if (res.data.use_hourse.length > 1) {
								uni.redirectTo({
									url: '/teahouse/houseselect/houseselect'
								});
							} else {
								if (that.goodsdetail.type === 5) {
									uni.redirectTo({
										url: '/teahouse/predetermine/predetermine?' + 'id=' + res.data.use_hourse[0] + '&coupon_id=' + that.goodsdetail.id
										// url: '/teahouse/predetermine/predetermine?id=' + res.data.use_hourse[0]
									});
								} else {
									uni.redirectTo({
										url: '/teahouse/predetermine/predetermine?id=' + res.data.use_hourse[0]
									});
								}
								// uni.redirectTo({
								// 	url: '/teahouse/predetermine/predetermine?id=' + res.data.use_hourse[0]
								// });
							}
						} else {
							uni.redirectTo({
								url: '/teahouse/houseselect/houseselect'
							});
						}
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
		//余额支付
		balancePay() {
			let that = this;
			that.fui
				.request(
					'diandi_tea/balance/couponbalancepay',
					'POST',
					{
						order_number: that.orderDetail.order_number,
						price: that.orderDetail.price
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						uni.showToast({
							title: '购买成功',
							icon: 'none',
							duration: 3000
						});
						that.getHourse();
						// uni.redirectTo({
						//     url: '/teahouse/mycoupon/mycoupon'
						// });
						// that.$Router.push({
						// 	name: 'coupon'
						// });
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
		showPopup() {
			let that = this;
			that.creartOrder();
		},
		hidePopup() {
			this.showDetail = false;
		}
	}
};
</script>

<style>
.container {
	padding-bottom: 110rpx;
}

.fui-banner-swiper {
	position: relative;
}
.fui-slide-image {
	width: 100%;
	height: 459.12rpx;
}
.fui-border-radius {
	border-bottom-left-radius: 24rpx;
	border-bottom-right-radius: 24rpx;
	overflow: hidden;
}
.fui-pro-detail {
	box-sizing: border-box;
	color: #333;
}

.fui-product-title {
	background: #fff;
	padding: 30rpx 0;
}

.fui-pro-pricebox {
	display: flex;
	align-items: center;
	justify-content: space-between;
	color: #218569;
	font-size: 46rpx;
	line-height: 44rpx;
}

.fui-pro-price {
	display: flex;
	align-items: center;
}
.fui-original-price {
	font-size: 26rpx;
	line-height: 26rpx;
	padding: 10rpx 30rpx;
	box-sizing: border-box;
}
.fui-nomore-box {
	padding-top: 10rpx;
}
.tycard-detail {
	color: rgba(30, 38, 9, 1);
	font-size: 32.65rpx;
	margin: auto 18.81rpx;
}
.justify {
	width: 127rpx;
	float: left;
	font-size: 26.53rpx;
	overflow: hidden;
	text-align: justify;
	text-align-last: justify;
}
.reser-btn {
	height: 70.79rpx;
	width: 100%;
}

/*顶部菜单*/

.fui-menu-box {
	box-sizing: border-box;
}

.fui-menu-header {
	font-size: 34rpx;
	color: #fff;
	height: 32px;
	display: flex;
	align-items: center;
}

.fui-menu-itembox {
	color: #fff;
	padding: 40rpx 10rpx 0 10rpx;
	box-sizing: border-box;
	display: flex;
	flex-wrap: wrap;
	font-size: 26rpx;
}

.fui-menu-item {
	width: 22%;
	height: 160rpx;
	border-radius: 24rpx;
	display: flex;
	align-items: center;
	flex-direction: column;
	justify-content: center;
	background: rgba(0, 0, 0, 0.4);
	margin-right: 4%;
	margin-bottom: 4%;
}

.fui-menu-item:nth-of-type(4n) {
	margin-right: 0;
}

.fui-badge-box {
	position: relative;
}

.fui-badge-box .fui-badge-class {
	position: absolute;
	top: -8px;
	right: -8px;
}

.fui-msg-badge {
	top: -10px;
}

.fui-icon-up_box {
	width: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
}

.fui-menu-text {
	padding-top: 12rpx;
}

.fui-opcity .fui-menu-text,
.fui-opcity .fui-badge-box {
	opacity: 0.5;
	transition: opacity 0.2s ease-in-out;
}

/*顶部菜单*/

/*内容 部分*/

.fui-padding {
	padding: 0 30rpx;
	box-sizing: border-box;
}

.fui-ml-auto {
	margin-left: auto;
}

/* #ifdef H5 */
.fui-ptop {
	padding-top: 44px;
}

/* #endif */

.fui-size {
	font-size: 24rpx;
	line-height: 24rpx;
}

.fui-gray {
	color: #999;
}

.fui-icon-red {
	color: #ff201f;
}

.fui-border-radius {
	border-bottom-left-radius: 24rpx;
	border-bottom-right-radius: 24rpx;
	overflow: hidden;
}

.fui-radius-all {
	border-radius: 24rpx;
	overflow: hidden;
}

.fui-mtop {
	margin-top: 26rpx;
}

.fui-pro-detail {
	box-sizing: border-box;
	color: #333;
}

.fui-product-title {
	background: #fff;
	padding: 30rpx 0;
}

.fui-pro-pricebox {
	display: flex;
	align-items: center;
	justify-content: space-between;
	color: #ff201f;
	font-size: 36rpx;
	font-weight: bold;
	line-height: 44rpx;
}

.fui-pro-price {
	display: flex;
	align-items: center;
}

.fui-price {
	font-size: 58rpx;
}

.fui-original-price {
	font-size: 26rpx;
	line-height: 26rpx;
	padding: 10rpx 30rpx;
	box-sizing: border-box;
}

.fui-line-through {
	text-decoration: line-through;
}

.fui-collection {
	color: #333;
	display: flex;
	align-items: center;
	flex-direction: column;
	justify-content: center;
	height: 44rpx;
}

.fui-scale-collection {
	transform: scale(0.7);
	transform-origin: center 90%;
	line-height: 24rpx;
	font-weight: normal;
	margin-top: 4rpx;
}

.fui-pro-titbox {
	font-size: 32rpx;
	font-weight: 500;
	position: relative;
	padding: 0 150rpx 0 30rpx;
	box-sizing: border-box;
}

.fui-pro-title {
	padding-top: 20rpx;
}

.fui-share-btn {
	display: block;
	background: transparent;
	margin: 0;
	padding: 0;
	border-radius: 0;
	border: 0;
}

.fui-share-btn::after {
	border: 0;
}

.fui-share-box {
	display: flex;
	align-items: center;
}

.fui-share-position {
	position: absolute;
	right: 0;
	top: 10rpx;
}

.fui-share-text {
	padding-left: 8rpx;
}

.fui-sub-title {
	padding: 20rpx 0;
	line-height: 32rpx;
}

.fui-sale-info {
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding-top: 30rpx;
}

.fui-discount-box {
	background: #fff;
}

.fui-list-cell {
	width: 100%;
	position: relative;
	display: flex;
	align-items: center;
	font-size: 26rpx;
	line-height: 26rpx;
	padding: 36rpx 30rpx;
	box-sizing: border-box;
}

.fui-right {
	position: absolute;
	right: 30rpx;
	top: 30rpx;
}
.fui-bold {
	font-weight: bold;
}

.fui-list-cell::after {
	content: '';
	position: absolute;
	border-bottom: 1rpx solid #eaeef1;
	-webkit-transform: scaleY(0.5);
	transform: scaleY(0.5);
	bottom: 0;
	right: 0;
	left: 126rpx;
}
.fui-cmt {
	padding: 14rpx 0;
}
.fui-nomore-box {
	padding-top: 10rpx;
}
.fui-operation {
	width: 100%;
	height: 100rpx;
	background: rgba(255, 255, 255, 0.98);
	position: fixed;
	display: flex;
	align-items: center;
	justify-content: space-between;
	z-index: 10;
	bottom: 0;
	left: 0;
	padding-bottom: env(safe-area-inset-bottom);
}
.fui-operation::before {
	content: '';
	position: absolute;
	top: 0;
	right: 0;
	left: 0;
	border-top: 1rpx solid #eaeef1;
	-webkit-transform: scaleY(0.5);
	transform: scaleY(0.5);
}
.fui-operation-right {
	height: 100rpx;
	padding-top: 0;
}

.fui-right-flex {
	display: flex;
	align-items: center;
	justify-content: center;
}

.fui-flex-1 {
	flex: 1;
	padding: 16rpx;
}
.fui-popup-box {
	position: relative;
	padding: 30rpx 0 30rpx 0;
}
.fui-product-box {
	display: flex;
	align-items: flex-end;
	font-size: 24rpx;
	padding-bottom: 30rpx;
}

.fui-popup-img {
	height: 200rpx;
	width: 200rpx;
	border-radius: 24rpx;
	display: block;
}

.fui-popup-price {
	padding-left: 20rpx;
	padding-bottom: 8rpx;
}

.fui-amount {
	color: #ff201f;
	font-size: 36rpx;
}
</style>

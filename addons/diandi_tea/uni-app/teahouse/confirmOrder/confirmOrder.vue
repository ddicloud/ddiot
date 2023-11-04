<template>
	<view class="container">
		<view class="order-list">
			<view class="text-center font-weight-600">
				<view class="order-teaname">{{ orderDetail.hourse_name }}</view>
				<view class="margin-top26 color fui-font-size_34">{{ orderDetail.start_time }} - {{ orderDetail.end_time }}</view>
			</view>
			<view class="order-list-detail">
				<view class="order-list-name">
					<view class="order-list-padd">
						<view class="fui-font-size_32">会员名称</view>
						<view class="order-list-xinxi fui-font-size_28 color3">{{ orderDetail.nickName || nickname }}</view>
					</view>
				</view>
				<view class="order-list-name">
					<view class="order-list-padd">
						<view class="fui-font-size_32">卡券优惠</view>
						<view class="order-list-xinxi fui-font-size_28 color3">{{ orderDetail.coupon_name === null ? '无' : orderDetail.coupon_name }}</view>
					</view>
				</view>
				<view class="order-list-name order-list-boder">
					<view class="order-list-padd">
						<view class="fui-font-size_32">余额</view>
						<view class="order-list-xinxi fui-font-size_28 color3">{{ orderDetail.balance || 0}}元</view>
					</view>
				</view>
				<view class="order-list-name">
					<view class="order-list-padd">
						<view class="fui-font-size_32">应付金额</view>
						<view class="order-list-xinxi fui-font-size_28 color3">￥{{ orderDetail.amount_payable || 0}}</view>
					</view>
				</view>
				<view class="order-list-name">
					<view class="order-list-padd">
						<view class="fui-font-size_32">优惠</view>
						<view class="order-list-xinxi fui-font-size_28 color8">￥{{ orderDetail.discount || 0}}</view>
					</view>
				</view>
				<view class="order-list-name order-list-boder">
					<view class="order-list-padd">
						<view class="fui-font-size_32">实付金额</view>
						<view class="order-list-xinxi fui-font-size_28 color8">￥{{ orderDetail.real_pay || 0}}</view>
					</view>
				</view>
				<view class="order-list-bh">
					<view class="order-list-padd">
						<view class="fui-font-size_32">订单编号</view>
						<view class="order-list-xinxi fui-font-size_28 color">{{ orderDetail.order_number || ''}}</view>
					</view>
				</view>
			</view>
			<view class="fui-flex" v-if="Number(real_pay) > 0" style="margin: 51.02rpx 40.81rpx;">
				<view class="reser-btn color border2 border-radius-20 fui-font-size_32 font-weight-600" @click="wechatpay">微信支付</view>
				<view v-if="balance >= real_pay" class="reser-btn margin-left-32 color border2 border-radius-20 fui-font-size_32 font-weight-600" @click="balancePay">
					余额支付
				</view>
				<view v-if="balance < real_pay" class="reser-btn margin-left-32 fui-color-white bag-color border-radius-20 fui-font-size_32 font-weight-600" @click="recharge">
					去充值
				</view>
			</view>
			<view class="fui-flex" v-if="Number(real_pay) === 0" style="margin: 51.02rpx 40.81rpx;">
				<view class="reser-btn color border2 border-radius-20 fui-font-size_32 font-weight-600" @click="goindex">首页</view>
				<view class="reser-btn margin-left-32 fui-color-white bag-color border-radius-20 fui-font-size_32 font-weight-600" @click="selectPay">确认下单</view>
			</view>

			<!-- <view class="fui-flex" v-if="Number(real_pay)===0" style="margin: 51.02rpx 40.81rpx;">
				<view class="reser-btn color border2 border-radius-20 fui-font-size_32 font-weight-600" @click="goindex">首页</view>
				<view class="reser-btn margin-left-32 fui-color-white bag-color border-radius-20 fui-font-size_32 font-weight-600" @click="goorderDetail">
					订单详情
				</view>
			</view> -->
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			id: 0,
			orderDetail: [],
			msg_template:[],
			showtime: '',
			balance: 0,
			real_pay: 0,
			nickname: ''
		};
	},
	onShow() {
		let that = this;
		that.id = that.$Route.query.id;
		that.nickname = uni.getStorageSync('nickname');
		console.log('nickname', uni.getStorageSync('nickname'));
		that.getOrderDetail();
	},
	methods: {
		getOrderDetail() {
			let that = this;
			that.fui
				.request(
					'diandi_tea/order/orderdetail',
					'GET',
					{
						order_id: that.id
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						that.orderDetail = res.data;
						that.balance = Number(res.data.balance);
						that.real_pay = Number(res.data.real_pay);
						that.msg_template = res.data.msg_template
						if (res.data.diff.day === 0) {
							that.showtime = res.data.diff.H + ':' + res.data.diff.i;
						} else {
							that.showtime = res.data.diff.day + '天' + res.data.diff.H + res.data.diff.i;
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
		selectPay() {
			let that = this;
			if (Number(that.orderDetail.real_pay) === 0) {
				that.fui
					.request(
						'diandi_tea/notify/notify',
						'POST',
						{
							out_trade_no: that.orderDetail.order_number
						},
						true
					)
					.then(res => {
						if (res.code === 200) {
							uni.redirectTo({
								url: '/teahouse/orderDetail/orderDetail?id=' + that.orderDetail.id
							});
							// uni.redirectTo({
							//      url: '/teahouse/orderDetail/orderDetail?id='+that.orderDetail.id
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
			} else {
				that.wechatpay();
			}
		},
		async wechatpay() {
			let that = this;
			uni.requestSubscribeMessage({
				tmplIds: that.msg_template,
				success(res) {
					let fans = uni.getStorageSync('fans');
					that.fui
						.request(
							'wechat/basics/payparameters',
							'POST',
							{
								openid: fans.openid,
								trade_type: 'JSAPI',
								body: that.orderDetail.set_meal_name,
								out_trade_no: that.orderDetail.order_number,
								total_fee: that.orderDetail.real_pay
							},
							true
						)
						.then(parameters => {
							console.log('支付参数', parameters.code);
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
										uni.redirectTo({
											url: '/teahouse/orderDetail/orderDetail?id=' + that.orderDetail.id
										});
									},
									fail: function(err) {
										console.log('fail:' + JSON.stringify(err));
										let msg = err.errMsg == 'requestPayment:fail cancel' ? '取消支付' : err.errMsg;
										that.fui.toast(msg);
										return false;
									}
								});
							} else {
								console.log(parameters);
								that.fui.toast(parameters.message);
							}
							console.log(parameters);
						})
						.catch(err => {
							console.log('错误', err);
						});

					return false;
				},
				fail(res){
					uni.showToast({
						title: res.errMsg,
						icon: 'none'
					});
				}
			});
		},
		recharge() {
			let that = this;
			that.$Router.push({
				name: 'recharge'
			});
		},
		goindex() {
			let that = this;
			that.$Router.push({
				name: 'index'
			});
		},
		goorderDetail() {
			let that = this;
			uni.redirectTo({
				url: '/teahouse/orderDetail/orderDetail?id=' + that.orderDetail.id
			});
			// that.$Router.push({
			// 	name: 'orderDetail',
			// 	params: {
			// 		id: that.orderDetail.id
			// 	}
			// });
		},
		//余额支付
		balancePay() {
			let that = this;
			uni.requestSubscribeMessage({
				tmplIds: that.msg_template,
				success(res) {
					that.fui
						.request(
							'diandi_tea/balance/orderbalancepay',
							'POST',
							{
								order_number: that.orderDetail.order_number,
								real_pay: that.orderDetail.real_pay
							},
							true
						)
						.then(res => {
							if (res.code === 200) {
								uni.redirectTo({
									url: '/teahouse/orderDetail/orderDetail?id=' + that.orderDetail.id
								});
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
				fail(res){
					uni.showToast({
						title: res.errMsg,
						icon: 'none'
					});
				}
			});
		}
	}
};
</script>

<style>
.order-list {
}
.order-teaname {
	margin-top: 51.02rpx;
	font-size: 38.77rpx;
	line-height: 46.93rpx;
}
.order-list-detail {
	margin-top: 70.4rpx;
}
.order-list-name {
	height: 111.22rpx;
	border-bottom: 1.02rpx solid rgb(0, 0, 0, 0.1);
}
.order-list-boder {
	border-bottom: 20.4rpx solid rgb(203, 203, 203, 0.1);
}
.order-list-bh {
	height: 111.22rpx;
}
.order-list-padd {
	margin: auto 40.81rpx;
	position: relative;
	top: 50%;
	transform: translate(0, -50%);
	/* line-height:111.22rpx ; */
}
.order-list-xinxi {
	position: absolute;
	float: right;
	right: 0;
	top: 0;
}
.reser-btn {
	height: 89.79rpx;
	text-align: center;
	line-height: 89.79rpx;
	width: 100%;
}
</style>

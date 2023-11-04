<template>
	<view class="container">
		<view class="order-list">
			<view class="text-center font-weight-600">
				<view class="order-teaname">{{ orderDetail.hourse_name || '' }}</view>
				<view class="margin-top26 color fui-font-size_34">{{ orderDetail.start_time || '' }} - {{ orderDetail.end_time || '' }}</view>
				<!-- <view v-if="orderDetail.diff != 0" class="margin-top-14 fui-font-size_28 color8">距离预约时间还剩{{ showtime }}</view> -->
				<view v-if="orderDetail.diff != 0 && orderDetail.status === 2" class="margin-top-14 fui-font-size_28 color8 fui-flex fui-center">
					<view class="margin-right-sm">距离预约时间还剩</view>
					<fui-countdown v-if="showtime" :time="showtime" color="#000" width="30" height="30" @end="startOpen"></fui-countdown>
				</view>
			</view>
			<view class="order-list-detail">
				<view class="order-list-name" v-if="orderDetail.nickName">
					<view class="order-list-padd">
						<view class="fui-font-size_32">会员名称</view>
						<view class="order-list-xinxi fui-font-size_28 color3">{{ orderDetail.nickName || '' }}</view>
					</view>
				</view>
				<view class="order-list-name">
					<view class="order-list-padd">
						<view class="fui-font-size_32">卡券优惠</view>
						<view class="order-list-xinxi fui-font-size_28 color3">{{ orderDetail.coupon_name || '无' }}</view>
					</view>
				</view>
				<view class="order-list-name order-list-boder">
					<view class="order-list-padd">
						<view class="fui-font-size_32">余额</view>
						<view class="order-list-xinxi fui-font-size_28 color3">{{ orderDetail.balance || 0 }}元</view>
					</view>
				</view>
				<view class="order-list-name">
					<view class="order-list-padd">
						<view class="fui-font-size_32">应付金额</view>
						<view class="order-list-xinxi fui-font-size_28 color3">￥{{ orderDetail.amount_payable || 0 }}</view>
					</view>
				</view>
				<view class="order-list-name">
					<view class="order-list-padd">
						<view class="fui-font-size_32">优惠</view>
						<view class="order-list-xinxi fui-font-size_28 color8">￥{{ orderDetail.discount || 0 }}元</view>
					</view>
				</view>
				<view class="order-list-name">
					<view class="order-list-padd">
						<view class="fui-font-size_32">实付金额</view>
						<view class="order-list-xinxi fui-font-size_28 color8">￥{{ orderDetail.real_pay || 0 }}</view>
					</view>
				</view>
				<view class="order-list-name order-list-boder">
					<view class="order-list-padd" @click="renewalDetial">
						<view class="fui-font-size_32">续费明细</view>
						<view class="order-list-xinxi fui-font-size_28"><iconfont className="icon-right-1-copy" :size="19" color="#979E91"></iconfont></view>
					</view>
				</view>
				<view class="order-list-bh">
					<view class="order-list-padd">
						<view class="fui-font-size_32">订单编号</view>
						<view class="order-list-xinxi fui-font-size_28 color">{{ orderDetail.order_number }}</view>
					</view>
				</view>
			</view>

			<!-- 待付款 已完成 已取消 -->
			<view class="fui-flex" v-if="orderDetail.status === 3 || orderDetail.status === 1 || orderDetail.status === 4" style="margin: 51.02rpx 40.81rpx;">
				<view class="reser-btn  fui-color-white bag-color border-radius-20 fui-font-size_32 font-weight-600" v-if="orderDetail.status === 1" @click="goPay(orderDetail)">去付款</view>
				<view :class="{'margin-left-32':orderDetail.status === 1}" class="reser-btn  fui-color-white bag-color border-radius-20 fui-font-size_32 font-weight-600" @click="backIndex">返回主页</view>
			</view>
			<!-- 使用中 -->
			<!-- <view class="fui-flex" v-if="(orderDetail.is_open === 2 && orderDetail.status === 2) || (orderDetail.status === 2)" style="margin: 51.02rpx 40.81rpx;"> -->
			<view class="fui-flex" v-if="orderDetail.status === 2 && orderDetail.is_open === 2" style="margin: 51.02rpx 40.81rpx;">
				<view class="reser-btn color border2 border-radius-20 fui-font-size_32 font-weight-600" @click="modal = true">续费</view>
				<view class="reser-btn margin-left-32 fui-color-white bag-color border-radius-20 fui-font-size_32 font-weight-600" @click="opendoor = true">开锁</view>
			</view>
			<!-- 待使用 -->
			<view class="fui-flex" v-if="orderDetail.status === 2 && orderDetail.is_open === 1" style="margin: 51.02rpx 40.81rpx;">
				<view class="reser-btn color border2 border-radius-20 fui-font-size_32 font-weight-600" @click="backIndex">主页</view>
				<view class="reser-btn margin-left-32 fui-color-white bag-color border-radius-20 fui-font-size_32 font-weight-600" @click="opendoor = true">开锁</view>
				<!-- <view class="reser-btn margin-left-32 fui-color-white bg-dblack border-radius-20 fui-font-size_32 font-weight-600" @click="badresernow">开锁</view> -->
			</view>
		</view>
		
		<fui-modal :show="modal" @cancel="hide" :custom="true" fadeIn>
			<view class="fui-number-box fui-font-size_26">
				<view class="fui-title">续费时长(小时)</view>
				<fui-numberbox v-if="modal" :width="100" :iconSize="35" :min="0.5" :step="0.5" :value="time" @change="timeChange"></fui-numberbox>
			</view>
			<view class="fui-number-box fui-font-size_26">
				<view class="fui-title fui-col-11 ">金额</view>
				<view class="color font-weight-600">￥{{ price }}</view>
			</view>
			<view class="fui-flex fui-font-size_26 font-weight-600">
				<view class="reser-btn fui-center color border2 border-radius-20" @click="createOrder">微信支付</view>
				<view class="reser-btn fui-center margin-left-32 color border2 border-radius-20" @click="createBalance">余额支付</view>
				<!-- <view class="reser-btn fui-center margin-left-32 fui-color-white bag-color border-radius-20">去充值</view> -->
			</view>
		</fui-modal>

		<fui-modal :show="opendoor" @cancel="opendoorhide" :custom="true" fadeIn>
			<view class="text-df fui-center">请选择开门类型</view>
			<view class="fui-flex fui-font-size_26 font-weight-600 margin-top-lg">
				<view class="reser-doorbtn fui-center color border2 border-radius-20" @click="resernow(0)">{{is_loadding[0]?loaddingText:'开大门'}}</view>
				<view class="reser-doorbtn fui-center margin-left-32 color border2 border-radius-20" @click="resernow(1)">{{is_loadding[1]?loaddingText:'开房间'}}</view>
			</view>
		</fui-modal>
	</view>
</template>

<script>
export default {
	data() {
		return {
			opendoor: false,
			is_loadding:[false,false],
			loaddingText:'正在开锁',
			id: 0,
			startPrice: 0,
			isOpenTime: false,
			time: 0.5,
			price: 0,
			modal: false,
			orderDetail: [],
			showtime: '',
			plugin: null,
			status: ''
		};
	},
	onLoad(option) {
		console.log('optionoptionoption', option);
		let that = this;
		that.id = option.id;
		that.getRenewprice();
		that.getOrderDetail();
	},
	watch: {
		showtime(val) {
			console.log('showtime', val, this.showtime);
		}
	},
	onShow() {
		let that = this;
		// that.getRenewprice();
		// that.getOrderDetail();
	},
	methods: {
		startOpen(e) {
			console.log('到实际出发', e);
			this.isOpenTime = true;
		},
		renewalDetial() {
			let that = this;
			that.$Router.push({
				name: 'renewalDetial',
				params: {
					id: that.id
				}
			});
		},
		opendoorhide() {
			this.opendoor = false;
		}, // 开锁
		resernow(type) {
			let that = this;
			that.$set(that.is_loadding,type,true)
			that.fui
				.request(
					'diandi_tea/order/opendoor',
					// 'diandi_doorlock/lock/openlock',
					'GET',
					{
						order_id: that.id,
						lock_type: type
					},
					true
				)
				.then(res => {
					that.$set(that.is_loadding,type,false)
					uni.showToast({
						title: res.message,
						icon: 'none'
					});
				})
				.catch(res => {
					that.$set(that.is_loadding,type,false)
					uni.showToast({
						title: '开锁失败，请重新尝试',
						icon: 'none'
					});
				});
		},
		// 待使用开锁
		badresernow() {
			let that = this;
			uni.showToast({
				title: '未到预定时间，开锁失败',
				icon: 'none'
			});
		},
		//去付款
		goPay(item) {
			let that = this;
			that.$Router.push({
				name: 'confirmOrder',
				params: {
					id: item.id
				}
			});
		},
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
						that.showtime = res.data.diff;
						// if (res.data.diff.day === 0) {
						// 	// that.showtime = res.data.diff.H + ':' + res.data.diff.i;
						// } else {
						// 	that.showtime = res.data.diff.day + '天' + res.data.diff.H + res.data.diff.i;
						// }
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
		getRenewprice() {
			let that = this;
			that.fui
				.request(
					'diandi_tea/order/renewprice',
					'POST',
					{
						order_id: that.id
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						that.price = res.data.renew_price;
						that.startPrice = res.data.renew_price;
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
		timeChange(e) {
			let that = this;
			that.time = e.value;
			that.price = that.startPrice * 2 * that.time;
		},
		//微信支付
		createOrder() {
			let that = this;
			let renew_num = that.time / 0.5;
			that.fui
				.request(
					'diandi_tea/order/createorder',
					'POST',
					{
						renew_order_id: that.id,
						amount_payable: that.price,
						real_pay: that.price,
						order_type: 2,
						renew_num: renew_num
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						let id = res.data.id;
						that.wechatpay(res.data);
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
		async wechatpay(item) {
			let that = this;
			let fans = uni.getStorageSync('fans');
			that.fui
				.request(
					'wechat/basics/payparameters',
					'POST',
					{
						openid: fans.openid,
						trade_type: 'JSAPI',
						body: item.renew_num,
						out_trade_no: item.order_number,
						total_fee: item.real_pay
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
								that.$Router.push({
									name: 'reserve'
									// params: {
									// 	id: that.id
									// }
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
						that.fui.toast(parameters.message);
					}
					console.log(parameters);
				})
				.catch(err => {
					uni.showToast({
						title: res.message,
						icon: 'none'
					});
				});
			return false;
		},
		//余额支付
		createBalance() {
			let that = this;
			let renew_num = that.time / 0.5;
			that.fui
				.request(
					'diandi_tea/order/createorder',
					'POST',
					{
						renew_order_id: that.id,
						amount_payable: that.price,
						real_pay: that.price,
						order_type: 2,
						renew_num: renew_num
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						let id = res.data.id;
						that.balancePay(res.data);
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
		balancePay(item) {
			let that = this;
			that.fui
				.request(
					'diandi_tea/balance/orderbalancepay',
					'POST',
					{
						order_number: item.order_number,
						real_pay: item.real_pay
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						that.modal = false;
						that.$Router.push({
							name: 'reserve'
							// params: {
							// 	id: that.id
							// }
						});
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
		//返回主页
		backIndex() {
			let that = this;
			that.$Router.push({
				name: 'index'
			});
		},
		hide() {
			let that = this;
			this.modal = false;
			that.time = 0.5;
		}
	}
};
</script>

<style>
.container {
	background-color: #218569;
}
.order-list {
	height: 100%;
	background: #f7f7f7;
	border-radius: 24.48rpx;
	margin: 76.53rpx 40.81rpx;
}
.order-teaname {
	margin-top: 51.02rpx;
	font-size: 38.77rpx;
	line-height: 46.93rpx;
}
.order-list-detail {
	margin-top: 78.57rpx;
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
.fui-modal-mask {
	background-color: rgba(216, 216, 216, 0.8) !important;
}
.fui-number-box {
	width: 100%;
	box-sizing: border-box;
	margin-bottom: 20rpx;
	background: #fff;
	display: flex;
	font-size: 26.53rpx;
	align-items: center;
	justify-content: space-between;
}
.qd_btn {
	width: 100%;
	height: 60.4rpx;
}
.reser-doorbtn {
	height: 60rpx;
	width: 100%;
}
</style>

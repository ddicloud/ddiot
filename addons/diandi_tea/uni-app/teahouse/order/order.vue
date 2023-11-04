<template>
	<view class="container">
		<view class="order-type">
			<fui-tabs
				:height="40"
				:currentTab="currentTab"
				itemWidth="50%"
				:tabs="tabs"
				bold
				:bottom="0"
				:sliderWidth="112"
				:sliderHeight="15"
				color="#1E2609"
				selectedColor="#101D04"
				sliderBgColor="#C8E4DC"
				@change="tabchange"
			></fui-tabs>
		</view>
		<view  v-if="reserveList.length == 0"><fui-no-data :fixed="false" imgUrl="https://cnd.dzwztea.cn/toast/img_nodata.png">暂无数据</fui-no-data></view>
		<view class="tea-reserve" v-for="(item, index) in reserveList" :key="index">
			<view @click="orderDetail(item.id)">
				<view class="tea-reserve-use fui-font-size_24 text-center" :class="item.status == '已完成' ? 'bag-color2' : 'bag-color1'">{{ item.status }}</view>
				<view class="tea-reserve-time margin-left color font-weight-600">{{ item.start_time }} -{{ item.end_time.substr(10) }}</view>
				<view class="fui-flex margin-left margin-top12 fui-font-size_24">
					<view class="line-height colorus margin-rig-l24 font-weight-400">支付金额</view>
					<view class="line-height font-weight-600">{{ item.real_pay }}</view>
				</view>
				<view class="fui-flex margin-left margin-top10 fui-font-size_24">
					<view class="line-height colorus margin-rig-l24 font-weight-400">支付方式</view>
					<view class="line-height font-weight-600">{{ item.pay_type === 1 ? '现金支付' : '余额支付' }}</view>
				</view>
				<view class="fui-flex margin-left margin-top10 fui-font-size_24">
					<view class="line-height colorus margin-rig-l24 font-weight-400">订单编号</view>
					<view class="line-height font-weight-600">{{ item.order_number }}</view>
				</view>
				<view class="fui-flex margin-left margin-top10 fui-font-size_24">
					<view class="line-height colorus margin-rig-l24 font-weight-400">下单时间</view>
					<view class="line-height font-weight-600">{{ item.create_time }}</view>
				</view>
			</view>
			<view class="order-btn">
				<view class="fui-flex order-btn-wz">
					<view v-if="item.status == '待付款'" class="btn-padd fui-color-white bag-color border-radius-24 fui-font-size_24" @click="goPay(item)">去付款</view>
					<view
						v-if="item.status == '待付款' "
						class="btn-padd border-radius-24 fui-font-size_24 margin-left-sm border1"
						@click="qxOrder(item.id)"
					>
						取消订单
					</view>
					<view v-if="item.status == '使用中'" @click="getRenewprice(item)" class="btn-padd fui-color-white bag-color border-radius-24 fui-font-size_24">
						<!-- <view  @click="getRenewprice(item.id)" class="btn-padd fui-color-white bag-color border-radius-24 fui-font-size_24"> -->
						点击续费
					</view>
					<view
						v-if="item.status == '已完成' && item.is_have === 2"
						class="btn-padd fui-color-white bag-color border-radius-24 fui-font-size_24"
						@click="getVious(item.id)"
					>
						申请开票
					</view>
					<view
					    v-if="item.is_refund"
						class="btn-padd fui-color-white bag-color border-radius-24 fui-font-size_24 margin-left-sm"
						@click="getRefund(item.id)"
					>
						申请退款
					</view>
					<view v-if="item.status == '已完成'" @click="orderDetail(item.id)" class="btn-padd border-radius-24 fui-font-size_24 margin-left-sm border1">查看详情</view>
					<!-- <view v-if="item.status == '待使用'" class="btn-padd border-radius-24 fui-font-size_24 margin-left-sm border1" @click="qxOrder(item.id)">取消订单</view> -->
				</view>
				<fui-modal :show="modal" @cancel="hide" :custom="true" fadeIn>
					<view class="fui-number-box fui-font-size_26">
						<view class="fui-title ">续费时长(小时)</view>
						<fui-numberbox v-if="modal" :iconSize="35" :width="100" :min="0.5" :step="0.5" :value="time"  @change="timeChange"></fui-numberbox>
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
			</view>
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			id:0,
			startPrice: 0,
			time: 0.5,
			price: 0,
			modal: false,
			currentTab: 0,
			status: 0,
			tabs: [
				{
					name: '全部订单'
				},
				{
					name: '待付款'
				},
				{
					name: '支付成功'
				},
				{
					name: '已完成'
				},
				{
					name: '已取消'
				}
			],
			reserveList: []
		};
	},
	onShow() {
		this.getOrder();
	},
	methods: {
		//获取订单
		getOrder() {
			let that = this;
			that.fui
				.request(
					'diandi_tea/member/order',
					'POST',
					{
						status: that.status
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						that.reserveList = res.data;
						console.log(res);
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
		//切换
		qxOrder(id) {
			let that = this;
			that.fui
				.request(
					'diandi_tea/order/cancelorder',
					'POST',
					{
						order_id: id
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						that.getOrder();
						uni.showToast({
							title: res.message,
							icon: 'none'
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
		//获取续费价格
		getRenewprice(item) {
			let that = this;
			console.log(item);
			that.modal = true;
			that.id=item.id
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
		timeChange(e) {
			let that = this;
			that.time = e.value;
			that.price = that.startPrice * 2 * that.time;
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
						body: item.set_meal_name,
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
								that.modal = false;
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
							name: 'order'
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
		hide() {
			let that = this;
			this.modal = false;
			that.time = 0.5;
		},
		tabchange(e) {
			let that = this;
			that.currentTab = e.index;
			that.status = e.index;
			that.getOrder();
		},
		orderDetail(id) {
			let that = this;
			that.$Router.push({
				name: 'orderDetail',
				params: {
					id: id
				}
			});
		},
		// 申请发票
		getVious(id) {
			let that = this;
			that.$Router.push({
				name: 'invoice',
				params: {
					id: id
				}
			});
		},
		getRefund(id){
			let that = this;
			that.fui
				.request(
					'diandi_tea/order/refund',
					'POST',
					{
						order_id: id
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						that.getOrder();
						uni.showToast({
							title: res.message,
							icon: 'none'
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
		}
	}
};
</script>

<style>
.order-type {
	background-color: #ffffff;
	padding: 45.91rpx 0 22.44rpx 0;
	margin-bottom: 40.81rpx;
}
.tea-reserve {
	height: 368.36rpx;
	margin: 0 40.81rpx 40.81rpx;
	box-shadow: 0px 7.14rpx 20.4rpx 0px #e5eae0;
	border-radius: 25rpx;
}
.tea-reserve-use {
	line-height: 40.81rpx;
	color: #ffffff;
	float: right;
	width: 100rpx;
	height: 40.81rpx;
	border-radius: 0rpx 12.24rpx 0rpx 12.24rpx;
}
.tea-reserve-time {
	font-size: 30.61rpx;
	margin-top: 24.48rpx;
}
.order-btn {
	height: 96.93rpx;
	border-top: 2.04rpx solid rgb(0, 0, 0, 0.2);
	margin: 24.48rpx 30.61rpx 0;
	position: relative;
}
.order-btn-wz {
	height: 47.95rpx;
	position: absolute;
	top: 53%;
	right: 0;
	transform: translate(0, -50%);
}
.btn-padd {
	width: 159.18rpx;
	height: 47.95rpx;
	text-align: center;
	line-height: 47.95rpx;
}
.bag-color1 {
	color: #ffffff;
	background-color: #2fb278;
}
.bag-color2 {
	background-color: #c8e4dc;
	color: #218569;
}
.fui-modal-mask {
	background-color: rgba(216, 216, 216, 0.2) !important;
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
.reser-btn {
	height: 60.79rpx;
	width: 100%;
}
</style>

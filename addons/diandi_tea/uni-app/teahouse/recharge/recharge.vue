<template>
	<view class="container">
		<view class="text-center" v-show="rechsuccess">
			<image class="rechsuccess-image" src="https://cnd.dzwztea.cn/tea/images/recharge.png" mode=""></image>
			<view class="rechsuccess-size margin-left-sm font-weight-600">充值成功！</view>
			<view class="rechsuccess-btn bag-color border-radius-20 fui-font-size_32 font-weight-600" @click="predetermine">去预定</view>
			<view class="rechsuccess-back border2 text-center color border-radius-20 fui-font-size_32 font-weight-600" @click="successBack">返回主页</view>
		</view>
		<view class="" v-if="!rechsuccess">
			<view class="recharge-detail-list">
				<view v-for="(item, index) in cardList" :key="index" class="recharge-detail">
					<view class="border-radius-30 fui-news-item" @click="recharge(index)" :class="{ active_news_item: index == dynamic }">
						<view v-if="item.type === 1">
							<view class="margin-top21 expre-card font-weight-600 margin-left-18" :class="{ colorActive: index == dynamic }">
								<!-- {{item.price}}元 -->
								{{ Number(item.price).toFixed(0) }}元
							</view>
							<view class="color3 fui-font-size_20 margin-left-18" :class="{ colorActive2: index === dynamic }">
								<view>送{{ Number(item.give_money).toFixed(0) }}元</view>
								<!-- <view v-if="item.give_coupon_name">送{{ item.give_coupon_name }}</view> -->
								<view v-if="item.give_time">送 {{ item.give_time }}小时券</view>
							</view>
							<image class="expre-card-hd " src="https://cnd.dzwztea.cn/tea/images/hd.png" mode="widthFix"></image>
						</view>
						<view class="fui-give-crds margin-left-18" v-if="item.type === 2">
							<view class="margin-top21 expre-card font-weight-600 " :class="{ colorActive: index === dynamic }">{{ Number(item.price).toFixed(0) }}元</view>
							<view class="color3" :class="{ colorActive2: index === dynamic }">送{{ Number(item.give_money).toFixed(0) }}元</view>
						</view>
					</view>
				</view>
				<!-- <view class="fui-give-item border-radius-30" @click="recharge(index)" :class="{active_news_item : index === dynamic}" v-for="(item, index) in cardList" :key="index" v-if="item.type === 2">
					<view class="fui-give-crds margin-left-18">
						<view class="margin-top21 expre-card font-weight-600 ">{{ Number(item.price).toFixed(0) }}元</view>
						<view class="color3 ">送{{ Number(item.give_money).toFixed(0) }}元</view>
					</view>
				</view> -->
			</view>
			<view v-if="pays" class="reser-btn border-radius-20 fui-font-size_32 font-weight-600" @click="creartOrder">确定充值</view>
			<view v-if="paying" class="reser-btn border-radius-20 fui-font-size_32 font-weight-600">支付中</view>
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			//支付
			pays: true,
			//支付中
			paying: false,
			msg_template:[],
			dynamic: 0,
			rechsuccess: false,
			cardList: [],
			orderDetail: {}
		};
	},
	computed: {
		getImgUrl_() {
			return url => this.resourceUrl + url;
		}
	},
	onShow() {
		this.getRecharge();
		if (this.$Route.query.index) {
			this.recharge(this.$Route.query.index);
		} else {
			this.recharge(0);
		}
	},
	methods: {
		getRecharge() {
			let that = this;
			that.fui
				.request('diandi_tea/order/rechargeactivity', 'GET', {}, false)
				.then(res => {
					if (res.code === 200) {
						that.cardList = res.data.list;
						that.msg_template = res.data.msg_template;
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
		// 创建订单
		creartOrder() {
			let that = this;
			uni.requestSubscribeMessage({
				tmplIds: that.msg_template,
				success(res) {
					console.log('res',res);
						that.fui
							.request(
								'diandi_tea/order/createrechargeorder',
								'POST',
								{
									price: that.cardList[that.dynamic].price,
									recharge_id: that.cardList[that.dynamic].id
								},
								true
							)
							.then(res => {
								if (res.code === 200) {
									that.orderDetail = res.data;
									(that.pays = false),
										(that.paying = true),
									that.resernow();
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
				fail(res){
					console.log('res',res);
					uni.showToast({
						title: res.errMsg,
						icon: 'none'
					});
				}
			});
		},
		resernow() {
			let that = this;
			let fans = uni.getStorageSync('fans');
			that.fui
				.request(
					'wechat/basics/payparameters',
					'POST',
					{
						openid: fans.openid,
						trade_type: 'JSAPI',
						body: that.orderDetail.name,
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
								that.rechsuccess = true;
							},
							fail: function(err) {
								console.log('fail:' + JSON.stringify(err));
								let msg = err.errMsg == 'requestPayment:fail cancel' ? '取消支付' : err.errMsg;
								that.fui.toast(msg);
								return false;
							}
						});
						that.pays = true;
						that.paying = false;
					} else {
						that.fui.toast(parameters.message);
					}
					console.log(parameters);
				})
				.catch(err => {
					uni.showToast({
						title: err.message,
						icon: 'none'
					});
				});

			return false;
		},
		successBack() {
			let that = this;
			uni.reLaunch({
				url: '/pages/index/index'
			});
			// that.$Router.push({
			// 	name: 'index'
			// });
		},
		predetermine() {
			let that = this;
			uni.redirectTo({
				url: '/teahouse/houseselect/houseselect'
			});
			// that.$Router.push({
			// 	name: 'houseselect'
			// });
		},
		recharge(index) {
			let that = this;
			console.log('index', index, this.dynamic);
			that.dynamic = index;
		}
	}
};
</script>

<style>
.container {
	width: 100%;
	margin-top: 40.81rpx;
}
.recharge-detail-list {
	display: flex;
	flex-wrap: wrap;
	width: 100%;
	margin: 0 40.81rpx;
}
.recharge-detail {
	height: 197.95rpx;
	width: 217.34rpx;
	margin-right: 10.2rpx;
}
.colorActive {
	color: #218569 !important;
}
.colorActive2 {
	color: #2e302b !important;
}
.fui-news-item {
	position: absolute;
	width: 217.34rpx;
	height: 175.51rpx;
	border: 2.04rpx solid #dedede;
}
.active_news_item {
	border: 2.04rpx solid #1c4608;
	background-color: #c8e4dc;
}
.fui-give-item {
	width: 217.34rpx;
	height: 175.51rpx;
	background: #ffffff;
	margin-right: 10.2rpx;
	border: 2.04rpx solid #dedede;
	margin-top: 22.44rpx;
}
.fui-give-crds {
	width: fit-content;
	display: flex;
	text-align: -webkit-left;
	flex-flow: column;
}
.expre-card {
	color: #797979;
	font-size: 47.06rpx;
}
.expre-card-hd {
	position: absolute;
	bottom: 0;
	right: 0;
	width: 72.44rpx;
	height: 71.42rpx;
}
.reser-btn {
	width: 683.67rpx;
	height: 89.79rpx;
	background: #218569;
	box-shadow: 0px 7.14rpx 30.61rpx 0px #218569;
	color: #ffffff;
	text-align: center;
	line-height: 89.79rpx;
	margin: 61.22rpx auto;
}
.rechsuccess-image {
	width: 448.97rpx;
	height: 379.59rpx;
	margin-top: 219.38rpx;
}
.rechsuccess-size {
	font-size: 48.97rpx;
	color: #111f2c;
	line-height: 68.36rpx;
	margin-bottom: 334.69rpx;
}
.rechsuccess-btn {
	height: 89.79rpx;
	color: #ffffff;
	text-align: center;
	line-height: 89.79rpx;
	margin: 40.81rpx;
}
.rechsuccess-back {
	height: 89.79rpx;
	line-height: 89.79rpx;
	margin: 40.81rpx;
}
</style>

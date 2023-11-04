<template>
	<view class="container">
		<view v-if="mxList.length == 0">
			<fui-no-data :fixed="false" imgUrl="https://cnd.dzwztea.cn/toast/img_nodata.png">暂无数据</fui-no-data>
		</view>
		<view class="padding-lr-lg integral-sub margin-bottom_10" v-for="(item, index) in mxList" :key="index">
			<view class="margin-tb-auto">
				<view class="color5 font-weight-600">
					{{item.pay_type===1? '微信支付'+item.real_pay+'元' : '余额支付'+item.real_pay+'元'}}
					<!-- <text class="color3 fui-font-size_24 margin-left-xs">(赠送{{ item.zs }}元)</text> -->
				</view>
				<view class="fui-font-size_20 color6 margin-top10">{{ item.start_time }} - {{ item.end_time }}</view>
			</view>
			<view class="integral-right ">
				<!-- <view class="color5 font-weight-600">+{{ item.jq }}</view> -->
				<view class="color7 fui-font-size_24 margin-top10">余额{{ Number(item.balance) }}元</view>
			</view>
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			id:0,
			mxList: []
		};
	},
	onShow() {
		let that=this
		that.id = that.$Route.query.id;
		that.getOrderDetail()
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
						that.mxList=res.data.renew_order
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
	}
};
</script>

<style>
.integral-sub {
	height: 161.22rpx;
	background-color: #ffffff;
	display: flex;
}
.integral-right {
	margin: auto 0;
	margin-left: auto;
	text-align: right;
}
</style>

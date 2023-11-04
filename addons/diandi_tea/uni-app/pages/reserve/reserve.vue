<template>
	<view class="container">
		<view class="tea-reserve" v-for="(item, index) in reserveList" :key="index" @click="reserDetail(item.id)">
			<view class="tea-reserve-use fui-font-size_24 text-center" :class="item.status == '待使用' ? 'bag-color' : 'bag-colorus'">{{ item.status }}</view>
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
		<view class="" v-if="reserveList.length == 0">
			<fui-no-data :fixed="false" imgUrl="https://cdn.tuhuokeji.com/toast/img_nodata.png">暂无数据</fui-no-data>
		</view>
		<tab-bar :currentindex="currentTabIndex"></tab-bar>
	</view>
</template>

<script>
export default {
	data() {
		return {
			currentTabIndex: 2,
			reserveList: []
		};
	},
	onShow() {
		this.$nextTick(function(){
			this.getOrder();
		})
	},
	methods: {
		getOrder() {
			let that = this;
			that.fui
				.request(
					'diandi_tea/member/order',
					'POST',
					{
						type: 1
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
					console.log('shibai', res);
				});
		},
		reserDetail(id) {
			let that = this;
			that.$Router.push({
				name: 'orderDetail',
				params: {
					id: id
				}
			});
		}
	}
};
</script>

<style>
.container {
	margin-bottom: 200rpx;
}
.tea-reserve {
	height: 261.22rpx;
	margin: 30.61rpx 40.81rpx 40.81rpx 40.81rpx;
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
	margin-top: 16.32rpx;
}
</style>

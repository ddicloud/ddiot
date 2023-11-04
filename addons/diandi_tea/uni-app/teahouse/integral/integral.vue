<template>
	<view class="container">
		<view class="card-number">
			<view class="text-center fui-color-white card-num-my">
				<view class="font-weight-600">{{ mxList.user_integral }}</view>
				<view class="fui-font-size_28 option">我的积分</view>
			</view>
			<image class="cardnum-bag" src="https://cnd.dzwztea.cn/tea/images/bj3.png" mode="widthFix"></image>
		</view>
		<fui-tabs
			:height="110"
			:currentTab="currentTab > 1 ? 0 : currentTab"
			itemWidth="50%"
			:tabs="tabs"
			bold
			:sliderWidth="108"
			:sliderHeight="7"
			color="#1E2609"
			selectedColor="#F97E3B"
			sliderBgColor="#F97E3B"
			@change="tabchange"
		></fui-tabs>
		<view v-show="currentTab == 0">
			<view class="" v-if="mxList.integral.length == 0"><fui-no-data :fixed="false" imgUrl="https://cnd.dzwztea.cn/toast/img_nodata.png">暂无数据</fui-no-data></view>
			<block v-for="(item, index) in mxList.integral" :key="index">
				<fui-collapse :index="index" :current="current" :arrow="false" hdBgColor="#F7F7F7" @click="change">
					<template v-slot:title>
						<fui-list-cell :hover="false">
							<view class="fui-flex fui-font-size_28">
								{{ item.time }}
								<iconfont className="icon-xiangxia" :size="22" color="#1E2609"></iconfont>
							</view>
						</fui-list-cell>
					</template>
					<template v-slot:content>
						<view class="padding-lr-lg integral-sub" v-for="(itm, idx) in item.data" :key="idx">
							<view class="margin-tb-auto">
								<view class="color5 font-weight-600 fui-font-size_28">{{ itm.remark }}</view>
								<view class="fui-font-size_20 color6 margin-top10">{{ itm.create_time }}</view>
							</view>
							<view class="integral-right ">
								<view class="color5 font-weight-600 fui-font-size_28">{{ itm.money>0? '+'+itm.money:itm.money }}</view>
								<view class="color7 fui-font-size_24 margin-top10">剩余积分{{ itm.surplus_integral }}</view>
							</view>
						</view>
					</template>
				</fui-collapse>
			</block>
		</view>
		<view v-show="currentTab == 1">
			<view class="" v-if="jfList.length == 0"><fui-no-data :fixed="false" imgUrl="https://cnd.dzwztea.cn/toast/img_nodata.png">暂无数据</fui-no-data></view>
			<block v-for="(item, index) in jfList" :key="index">
				<fui-collapse :index="index" :current="current" :arrow="false" hdBgColor="#F7F7F7" @click="change">
					<template v-slot:title>
						<fui-list-cell :hover="false">
							<view class="fui-flex fui-font-size_28">
								{{ item.time }}
								<iconfont className="icon-xiangxia" :size="22" color="#1E2609"></iconfont>
							</view>
						</fui-list-cell>
					</template>
					<template v-slot:content>
						<view class="padding-lr-lg integral-sub margin-bottom_10" v-for="(itm, idx) in item.data" :key="idx">
							<image class="integral-sub-sp border-radius-30 margin-tb-auto" :src="itm.thumb" mode="widthFix"></image>
							<view class="margin-tb-auto ">
								<view class="color5 fui-font-size_24 margin-left-24">积分兑换商品</view>
								<view class="color5 font-weight-600 margin-left-24 fui-font-size_28">{{ itm.order_body }}</view>
								<view class="fui-font-size_20 color6 margin-top10 margin-left-24">{{ itm.pay_time }}</view>
							</view>
							<view class="integral-right ">
								<view class="color5 font-weight-600">-{{ itm.pay_price }}</view>
								<view class="color7 fui-font-size_24 margin-top10">剩余积分{{ itm.total_price }}</view>
							</view>
						</view>
					</template>
				</fui-collapse>
			</block>
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			current: 0,
			currentTab: 0,
			tabs: [
				{
					name: '积分明细'
				},
				{
					name: '兑换记录'
				}
			],
			result: '2022年2月12日',
			mxList: [],
			jfList: []
		};
	},
	onShow() {
		this.getIntegral();
		this.getExchangelist();
	},
	methods: {
		change(e) {
			console.log(e);
			let that = this;
			let index = e.index;
			if (that.current == index) {
				that.current = -1;
			} else {
				that.current = index;
			}
		},
		tabchange(e) {
			this.currentTab = e.index;
		},
		getIntegral() {
			let that = this;
			that.fui
				.request('diandi_tea/member/integral', 'GET', {}, true)
				.then(res => {
					if (res.code === 200) {
						that.mxList = res.data;
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
		getExchangelist() {
			let that = this;
			that.fui
				.request('diandi_integral/order/exchangelist', 'GET', {}, true)
				.then(res => {
					if (res.code === 200) {
						that.jfList = res.data;
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
		}
	}
};
</script>

<style>
.card-number {
	position: relative;
	width: 100%;
	height: 343.87rpx;
	background: linear-gradient(180deg, #ffd7a9 0%, #f97e3b 100%);
}
.cardnum-bag {
	height: 102.04rpx;
	width: 100%;
	bottom: 0;
	position: absolute;
}
.card-num-my {
	margin-top: 55.1rpx;
	font-size: 102.04rpx;
}
.integral-sub {
	height: 161.22rpx;
	background-color: #ffffff;
	display: flex;
	margin-top: 26.2rpx;
}
.integral-right {
	margin: auto 0;
	margin-left: auto;
	text-align: right;
}
.fui-list-cell {
	background-color: #f7f7f7 !important;
}
.integral-sub-sp {
	width: 124.48rpx;
	height: 124.48rpx;
}
.fui-list-class.data-v-9da99bba {
	padding: 0 !important;
}
.fui-header {
	padding: 0 30rpx 30rpx 20rpx !important;
}
</style>

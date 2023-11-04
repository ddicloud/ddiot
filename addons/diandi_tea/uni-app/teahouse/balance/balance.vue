<template>
	<view class="container">
		<view class="card-number">
			<view class="text-center fui-color-white card-num-my">
				<view class="fui-font-size_28 option">余额(元)</view>
				<view class="font-weight-600">{{ user_money }}</view>
				<view class="recharge-btn fui-font-size_28 color font-weight-600" @click="goPrepaid">去充值</view>
			</view>
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
			selectedColor="#218569"
			sliderBgColor="#218569"
			@change="tabchange"
		></fui-tabs>
		<view v-show="currentTab == 0">
			<view class="" v-if="mxList.length == 0"><fui-no-data :fixed="false" imgUrl="https://cnd.dzwztea.cn/toast/img_nodata.png">暂无数据</fui-no-data></view>
			<block v-for="(item, index) in mxList" :key="index">
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
								<view class="color5 font-weight-600 fui-font-size_28">
									微信充值{{ itm.price }}元
									<text class="color3 fui-font-size_24 margin-left-xs">(赠送{{ itm.recharge.give_money }}元)</text>
								</view>
								<view class="fui-flex margin-top-xs">
									<view class="fui-font-size_20 color6 margin-top10">{{ itm.create_time }}</view>
									<view v-if="itm.is_have===2" class="btn-padd fui-color-white fui-font-size_19 margin-left-sm" @click="getVious(itm.id)">申请开票</view>
								</view>
							</view>
							<view class="integral-right">
								<view class="color5 font-weight-600 fui-font-size_28">{{ itm.all_money>0? '+'+itm.all_money:itm.all_money}}</view>
								<view class="color7 fui-font-size_24 margin-top-xs">余额{{ itm.balance }}元</view>
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
							<view class="margin-tb-auto">
								<view class="color5 font-weight-600 fui-font-size_28">{{ itm.remark }}</view>
								<view class="fui-font-size_20 color6 margin-top10">{{ itm.create_time }}</view>
							</view>
							<view class="integral-right ">
								<view class="color5 font-weight-600 fui-font-size_28">{{ itm.money }}</view>
								<view class="color7 fui-font-size_24 margin-top10">余额{{ itm.s_money }}元</view>
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
			user_money: 0,
			currentTab: 0,
			tabs: [
				{
					name: '充值明细'
				},
				{
					name: '使用明细'
				}
			],
			result: '2022年2月12日',
			mxList: [],
			jfList: []
		};
	},
	onShow() {
		let that = this;
		that.user_money = this.$Route.query.user_money;
		this.getBalance();
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
		getBalance() {
			let that = this;
			that.fui
				.request('diandi_tea/member/balance', 'GET', {}, true)
				.then(res => {
					if (res.code === 200) {
						console.log(res);
						that.mxList = res.data.recharge_list;
						that.jfList = res.data.order_list;
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
		goPrepaid() {
			let that = this;
			that.$Router.push({
				name: 'recharge'
			});
		},
		// 申请发票
		getVious(id) {
			let that = this;
			console.log(id);
			that.$Router.push({
				name: 'invoice',
				params: {
					id: id,
					type:2
				}
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
	background: linear-gradient(180deg, #91e29f 0%, #218569 100%);
}
.recharge-btn {
	width: 171.42rpx;
	height: 59.18rpx;
	background: #ffffff;
	border-radius: 8.16rpx;
	margin: 12.24rpx auto;
	line-height: 59.18rpx;
}
.card-num-my {
	margin-top: 55.1rpx;
	font-size: 81.63rpx;
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
.fui-list-class.data-v-9da99bba {
	padding: 0 !important;
}
.fui-header {
	padding: 0 30rpx 30rpx 20rpx !important;
}
.btn-padd {
	text-align: center;
	padding: 3rpx 10rpx;
	background-color: #0b9e75;
	border-radius: 10rpx;
}
</style>

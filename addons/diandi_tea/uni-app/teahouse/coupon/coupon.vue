<template>
	<view class="container">
		<view  v-if="couponList.length == 0"><fui-no-data :fixed="false" imgUrl="https://cdn.tuhuokeji.com/toast/img_nodata.png">暂无数据</fui-no-data></view>
		<view class="tea-infomation" v-for="(item, index) in couponList" :key="index" @click="couponDetail(item.id)">
			<view class="tycard-image" :style="{ 'background-image': 'url(' + item.background + ')' }">
				<view class="margin-top_976 tycard-detail ">
					<view class="tycard-name text-center font-weight-600">{{ item.type_str }}</view>
					<view class="">
						<view class="fui-flex fui-font-size_22 margin-left-sm">
							<view class="color3 justify">有效期</view>
							<view class="margin-left-sm color4">至{{ item.enable_end || 0 }}</view>
						</view>
						<view class="fui-flex fui-font-size_22 margin-left-sm margin-top12">
							<view class="color3 justify">使用时间</view>
							<view class="margin-left-sm color4">{{ item.use_start }}-{{ item.use_end }}</view>
						</view>
						<view class="fui-flex fui-font-size_22 margin-left-sm margin-top12" v-if="item.type===2 || item.type===3 || item.type===5">
							<view class="color3 justify">使用时长</view>
							<view class="margin-left-sm color4">{{ item.max_time || '' }}小时</view>
						</view>
						<view class="fui-flex fui-font-size_22 margin-left-sm margin-top12" v-if="item.type===1">
							<view class="color3 justify">代金券</view>
							<view class="margin-left-sm color4">{{ item.cash || '' }}元</view>
						</view>
						<view class="fui-flex fui-font-size_22 margin-left-sm margin-top12" v-if="item.type===4">
							<view class="color3 justify">折扣</view>
							<view class="margin-left-sm color4">{{ item.discount  || '' }}折</view>
						</view>
						<view class="fui-flex fui-font-size_22 margin-left-sm margin-top12">
							<view class="color3 justify">使用限制</view>
							<view class="margin-left-sm color4">{{ item.max_num || 0 }}次</view>
						</view>
					</view>
					<view class="tycard-price bag-color fui-color-white fui-font-size_28 text-center">￥{{ item.price }}</view>
				</view>
			</view>
		</view>
		<!-- 	<view class="tea-infomation">
			<view class="tycard-image" style="background-image:url('https://cnd.dzwztea.cn/tea/images/分组%202.png')">
				<view class="margin-top_976 tycard-detail ">
					<view class="tycard-name font-weight-600 text-center">VIP</br>尊享券</view>
					<view class="">
						<view class="fui-flex fui-font-size_22 margin-left-sm">
							<view class="color3 justify">有效期</view>
							<view class="margin-left-sm color4">自购买起30天内</view>
						</view>
						<view class="fui-flex fui-font-size_22 margin-left-sm margin-top12">
							<view class="color3 justify">使用时期</view>
							<view class="margin-left-sm color4">自购买起30天内</view>
						</view>
						<view class="fui-flex fui-font-size_22 margin-left-sm margin-top12">
							<view class="color3 justify">专享时间</view>
							<view class="margin-left-sm color4">自购买起30天内</view>
						</view>
					</view>
					<view class="tycard-price bag-color1 fui-color-white fui-font-size_28 text-center font-weight-600">￥100.00</view>
				</view>
			</view>
		</view> -->
	</view>
</template>

<script>
export default {
	data() {
		return {
			couponList: []
		};
	},
	computed: {
		getImgUrl_() {
			return url => this.resourceUrl + url;
		}
	},
	onShow() {
		this.getCoupon();
	},
	methods: {
		getCoupon() {
			let that = this;
			that.fui
				.request('diandi_tea/order/couponlist', 'GET', {}, true)
				.then(res => {
					if (res.code === 200) {
						console.log(res);
						that.couponList = res.data;
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
		couponDetail(id) {
			let that = this;
			that.$Router.push({
				name: 'couponDetail',
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
	margin-bottom: 100rpx;
}
.tea-infomation {
	margin: 40.81rpx 40.81rpx 0 40.81rpx;
}
.tycard-image {
	border-radius: 10.2rpx;
	height: 328.57rpx;
	width: 683.67rpx;
	display: block;
	background-size: cover;
	align-items: center;
	display: grid;
}
.tycard-detail {
	color: rgba(30, 38, 9, 1);
	font-size: 32.65rpx;
	display: flex;
	margin: auto 0;
	/* top: 25%; */
}
.tycard-name {
	margin: auto;
	width: 106.98rpx;
}
.tycard-price {
	border-radius: 32.65rpx;
	height: 65.3rpx;
	width: 139.79rpx;
	margin: auto;
	line-height: 65.3rpx;
	padding: 0 3px;
}
.justify {
	width: 100rpx;
	float: left;
	overflow: hidden;
	text-align: justify;
	text-align-last: justify;
}
</style>

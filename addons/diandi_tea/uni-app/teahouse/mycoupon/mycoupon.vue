<template>
	<view class="container">
		<view class="tea-infomation" v-for="(item, index) in couponList" :key="index">
			<view class="tycard-image" :style="{ 'background-image': 'url(' + item.background + ')' }">
				<view class="margin-top_976 tycard-detail ">
					<view class="tycard-name text-center font-weight-600">{{ item.coupon_name || 0 }}</view>
					<view>
						<view class="fui-flex fui-font-size_22 margin-left-sm">
							<view class="color3 justify">有效期</view>
							<view class="margin-left-sm color4">至{{ item.enable_end || 0 }}</view>
						</view>
						<view class="fui-flex fui-font-size_22 margin-left-sm margin-top12">
							<view class="color3 justify">使用时间</view>
							<view class="margin-left-sm color4">{{ item.use_start || 0 }}-{{ item.use_end || 0 }}</view>
						</view>
						<!-- <view class="fui-flex fui-font-size_22 margin-left-sm margin-top12">
							<view class="color3 justify">使用时长</view>
							<view class="margin-left-sm color4">{{ item.max_time || 0 }}小时</view>
						</view> -->
						<view class="fui-flex fui-font-size_22 margin-left-sm margin-top12" v-if="item.coupon_type === 2 || item.coupon_type === 3 || item.coupon_type === 5">
							<view class="color3 justify">使用时长</view>
							<view class="margin-left-sm color4">{{ item.max_time || '' }}小时</view>
						</view>
						<view class="fui-flex fui-font-size_22 margin-left-sm margin-top12" v-if="item.coupon_type === 1">
							<view class="color3 justify">代金券</view>
							<view class="margin-left-sm color4">{{ item.cash || '' }}元</view>
						</view>
						<view class="fui-flex fui-font-size_22 margin-left-sm margin-top12" v-if="item.coupon_type === 4">
							<view class="color3 justify">折扣</view>
							<view class="margin-left-sm color4">{{ item.discount || '' }}折</view>
						</view>
						<view class="fui-flex fui-font-size_22 margin-left-sm margin-top12">
							<view class="color3 justify">使用限制</view>
							<view class="margin-left-sm color4">{{ item.surplus_num || 0 }}次</view>
						</view>
					</view>
					<!-- <view class="tycard-price bag-color fui-color-white fui-font-size_28 text-center">￥{{ item.coupon.price || 0 }}</view> -->
					<view class="tycard-price bag-color fui-color-white fui-font-size_24 text-center" @click="getHourse(item)">立即使用</view>
				</view>
			</view>
		</view>
		<view v-if="couponList.length == 0"><fui-no-data :fixed="false" imgUrl="https://cnd.dzwztea.cn/toast/img_nodata.png">暂无数据</fui-no-data></view>
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
		// 获取卡券对应房间信息
		getHourse(item) {
			let that = this;
			that.fui
				.request(
					'diandi_tea/order/gethourse',
					'GET',
					{
						coupon_id: item.coupon_id
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
								if (item.coupon_type === 5) {
									uni.redirectTo({
										url: '/teahouse/predetermine/predetermine?' + 'id=' + res.data.use_hourse[0] + '&coupon_id=' + item.coupon_id
										// url: '/teahouse/predetermine/predetermine?id=' + res.data.use_hourse[0]
									});
								} else {
									uni.redirectTo({
										url: '/teahouse/predetermine/predetermine?id=' + res.data.use_hourse[0]
									});
								}
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
		getCoupon() {
			let that = this;
			that.fui
				.request('diandi_tea/order/mycoupon', 'GET', {}, true)
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
	/* width: 96rpx; */
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
	width: 50px;
	float: left;
	overflow: hidden;
	text-align: justify;
	text-align-last: justify;
}
</style>

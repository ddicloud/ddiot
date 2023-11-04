<template>
	<view class="container">
		<!-- <cu-custom :isBack="true">
			<block slot="backText"><image :src="list.logo" class="padding-left-lg tea-logo" mode="scaleToFill" lazy-load /></block>
		</cu-custom> -->
		<view class="fui-banner-box">
			<swiper :autoplay="true" :interval="4000" :duration="150" class="fui-banner-swiper" :circular="true" @change="change">
				<swiper-item v-for="(item, index) in list.store_slide" :key="index" class="fui-banner-item">
					<image :src="item" class="fui-slide-image" mode="heightFix" style="height: 600rpx;" lazy-load />
				</swiper-item>
			</swiper>
			<view class="tea-address">
				<image :src="list.logo" class="margin-left-lg tea-logo" mode="scaleToFill" lazy-load />
				<view class="margin-left-lg tea-name fui-color-white text-xxl">{{ list.name }}</view>
				<view class="fui-flex margin-top-14">
					<view class="fui-color-white fui-col-10 margin-left-lg tea-intro">{{ list.store_introduce }}</view>
					<view class="fui-col-1 tea-swiper-num fui-center">{{ current + 1 }}/{{ list.store_slide.length }}</view>
				</view>
			</view>
		</view>
		<view class="tea-infomation">
			<!-- <view class="tea-guangao">
				<swiper
					:autoplay="true"
					indicator-dots
					indicator-color="#D8DDD3"
					indicator-active-color="#218569"
					:interval="4000"
					:duration="150"
					class="fui-banner-swipers"
					:circular="true"
					@change="change"
				>
					<swiper-item v-for="(item, index) in list.adv_slide" :key="index" class="fui-banner-item">
						<image :src="item" class="fui-slide-ggimage" mode="scaleToFill" lazy-load />
					</swiper-item>
				</swiper>
			</view> -->
			<view class="tea-infoma-xj fui-flex">
				<view class="fui-col-11">
					<view class="fui-flex" @click="goPhone">
						<image class="tea-infomation-phone" src="https://cnd.dzwztea.cn/tea/images/dianhua.png" mode="widthFix"></image>
						<text class="color1 fui-font-size_28 text-bold line-height">{{ list.mobile || '' }}</text>
					</view>
					<view class="fui-font-size_24 color2 fui-col-11 margin-top6">{{ list.address || '' }}</view>
				</view>
				<image @click="getLocation" class="tea-navigation fui-col-1" src="https://cnd.dzwztea.cn/tea/images/dh.png" mode="widthFix"></image>
			</view>

			<!-- <view class="fui-rolling-news">
				<swiper indicator-active-color="#5E8B33" indicator-dots indicator-color="#D8DDD3" :current="0" :display-multiple-items="2.6" circular class="fui-swiper">
					<swiper-item v-for="(item, index) in cardList" :key="index" class="fui-swiper-item">
						<view class="fui-news-item border-radius-30 ">
							<view class="margin-top21 expre-card font-weight-600 text-center">{{ item.num1 }}元</view>
							<view class="margin-left-18 margin-rig-16 color3 fui-font-size_20">
								<view>送{{ item.num2 }}元</view>
								<view>{{ item.name }}</view>
							</view>
							<image class="expre-card-hd " src="https://cnd.dzwztea.cn/tea/images/hd.png" mode="widthFix"></image>
						</view>
					</swiper-item>
				</swiper>
				<view class="card-more fui-flex">
					<view class="color2 fui-font-size_20">了解更多</view>
					<iconfont className="icon-right-1-copy" :size="9" color="#979E91"></iconfont>
				</view>
			</view> -->
			<view
				class="tycard-image margin-top24"
				@click="gocoupon(emperience_coupon)"
				v-if="emperience_coupon.length != 0"
				:style="{ 'background-image': 'url(' + emperience_coupon.background + ')' }"
			>
				<view class="tycard-detail ">
					<view class="tycard-name font-weight-600 fui-font-size_32">{{ emperience_coupon.name || '' }}</view>
					<view style="width: 306.12rpx;">
						<view class="fui-flex fui-font-size_22 margin-left-sm">
							<view class="color3 justify">有效期</view>
							<view class="margin-left-sm color4">至{{ emperience_coupon.enable_end || 0 }}</view>
							<!-- <view class="margin-left-sm color4">自购买起 {{ list.emperience_coupon.day || ''}} 天内</view> -->
							<!-- <view class="margin-left-sm color4">{{ list.emperience_coupon.enable_start }}-{{ end }}</view> -->
						</view>
						<view class="fui-flex fui-font-size_22 margin-left-sm margin-top12">
							<view class="color3 justify">使用时间</view>
							<view class="margin-left-sm color4">{{ emperience_coupon.use_start || '' }}-{{ emperience_coupon.use_end || '' }}</view>
						</view>
						<view class="fui-flex fui-font-size_22 margin-left-sm margin-top12">
							<view class="color3 justify">体验时间</view>
							<view class="margin-left-sm color4">{{ emperience_coupon.max_time || '' }}小时</view>
						</view>
						<view class="fui-flex fui-font-size_22 margin-left-sm margin-top12">
							<view class="color3 justify">使用限制</view>
							<view class="margin-left-sm color4">{{ emperience_coupon.max_num || 0 }}次</view>
						</view>
					</view>
					<view class="tycard-price bag-color fui-color-white text-center">￥{{ emperience_coupon.price || '' }}</view>
				</view>
			</view>
			<view class="cz_border border-radius-20 margin-top-lg">
				<view class="cz_border_top  margin-lr-auto fui-center">
					<view class="fui-flex" style="margin-top: -55.71rpx;">
						<image class="cz_border_left" src="https://cnd.dzwztea.cn/tea/images/left.png" mode="widthFix"></image>
						<view class="color fui-font-size_30 font-weight-600">为惬意充值</view>
						<image class="cz_border_left" src="https://cnd.dzwztea.cn/tea/images/right.png" mode="widthFix"></image>
					</view>
				</view>
				<view class="cs_border_card_list">
					<!-- <view class="cs_border_card border-radius-20" style="margin-top: 34.69rpx;">
						<view class="cs_border_card_detail fui-flex fui-center">
							<view class="fui-col-4">
								<view class="fui-flex fui-font-size_24">
									<text class="color10 margin-rig-6">充</text>
									<view class="cs_border_card_money  fui-center color11 font-weight-600">
										900
										<text class="margin-left-4 font-weight-600">元</text>
									</view>
								</view>
								<view class="fui-flex fui-font-size_24 margin-top6">
									<text class="color10 margin-rig-6">得</text>
									<view class="cs_border_card_money fui-center color11 font-weight-600">
										900
										<text class="margin-left-4 font-weight-600">元</text>
									</view>
								</view>
							</view>
							<view class="cs_border_card_bor fui-col-1"></view>
							<view class="cs_border_card_add fui-col-1 color3 margin-left-xs">+</view>
							<view class="cs_border_card_card fui-col-5 fui-center">体验卡</view>
							<view class="cs_border_card_logo fui-col-2 margin-left-40"></view>
						</view>
					</view> -->
					<view class="cs_border_card border-radius-20 margin-top16" v-for="(item, index) in list.rechargeList" :key="index">
						<view class="cs_border_card_detail fui-flex fui-center">
							<view class="fui-col-4">
								<view class="fui-flex fui-font-size_24">
									<text class="color10 margin-rig-6">充</text>
									<view class="cs_border_card_money  fui-center color font-weight-600">
										{{ item.price }}
										<text class="margin-left-4 font-weight-600">元</text>
									</view>
								</view>
								<view class="fui-flex fui-font-size_24 margin-top6">
									<text class="color10 margin-rig-6">送</text>
									<view class="cs_border_card_money fui-center color font-weight-600">
										{{ item.give_money }}
										<text class="margin-left-4 font-weight-600">元</text>
									</view>
								</view>
							</view>
							<view class="cs_border_card_bor fui-col-1"></view>
							<view class="cs_border_card_add fui-col-1 color3 margin-left-xs">+</view>
							<view class="cs_border_card_cardvip fui-col-5">
								<view class="color12 fui-center">卡券</view>
								<view class="color12 fui-center fui-font-size_24" v-if="item.give_coupon_money">{{ item.time }}小时</view>
							</view>
							<image
								@click="recharge(index)"
								class="cs_border_card_logo fui-col-2 margin-left-40"
								src="https://cnd.dzwztea.cn/tea/images/chong.png"
								mode="widthFix"
							></image>
							<!-- <view class="cs_border_card_logo fui-col-2 margin-left-40 fui-center fui-font-size_32 font-weight-600 fui-color-white" @click="recharge(index)">充</view> -->
						</view>
					</view>
				</view>
			</view>
			
			<view class="margin-top40 reser-btn border-radius-20 fui-font-size_32 font-weight-600 fui-center" @click="resernow">立即预定</view>
		</view>
		<fui-fab :width="60" :height="60" :left="0" :right="15" :bottom="150" bgColor="#218569" :btnList="btnList" :isShow="true" @click="fabHand"></fui-fab>
		<tab-bar :currentindex="currentTabIndex"></tab-bar>
	</view>
</template>

<script>
export default {
	data() {
		return {
			end: '',
			currentTabIndex: 0,
			current: 0,
			list: {},
			emperience_coupon:[],
			latitude: 0,
			longitude: 0,
			btnList: [
				{
					bgColor: '#ff557f',
					//图标/图片地址
					imgUrl: '/static/images/yuyue.png',
					//图片高度 rpx
					imgHeight: 40,
					//图片宽度 rpx
					imgWidth: 40,
					//名称
					text: '预订',
					//字体大小
					fontSize: 25,
					//字体颜色
					color: '#218569',
					url: '/'
				},
				{
					bgColor: '#16C2C2',
					//图标/图片地址
					imgUrl: '/static/images/xufei.png',
					//图片高度 rpx
					imgHeight: 40,
					//图片宽度 rpx
					imgWidth: 40,
					//名称
					text: '续费',
					//字体大小
					fontSize: 25,
					//字体颜色
					color: '#218569',
					url: 'storeorder'
				}
			],
			cardList: [
				{
					num1: '3000',
					num2: '100',
					name: '送VIP尊享券'
				},
				{
					num1: '4000',
					num2: '100',
					name: '送VIP尊享券'
				},
				{
					num1: '5000',
					num2: '100',
					name: '送VIP尊享券'
				}
			]
		};
	},
	computed: {
		getImgUrl_() {
			return url => this.resourceUrl + url;
		}
	},
	onShow() {
		this.getinfomation();
	},
	onLoad() {
		// this.getinfomation();
	},
	methods: {
		// dy(){
		// 	uni.requestSubscribeMessage({
		// 	  tmplIds: ['ZG0vtIbZTvi9GadYPbjmP3mIHhUAQ6AAdWzPtUW89Zg','iJZlSCJMJ3dIeqDxvrbDc30-O9PSk3eFgNzxhu6VCOI','03-jZC33RautR0we3Wi8v6r_6SEUoADMopjaC4ZIfLU'],
		// 	  success (res) {
		// 		  console.log(res);
		// 	  }
		// 	})
		// },
		getPhoneNumber(e) {
			console.log(e);
		},
		getTest() {
			let that = this;
			that.fui
				.request('diandi_tea/api/test', 'GET', {}, true)
				.then(res => {
					if (res.code === 200) {
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
		getinfomation() {
			let that = this;
			that.fui
				.request('diandi_tea/index/top', 'GET', {}, false)
				.then(res => {
					if (res.code === 200) {
						that.list = res.data.list;
						that.emperience_coupon = res.data.list.emperience_coupon;
						
						(that.latitude = res.data.list.latitude),
							(that.longitude = res.data.list.longitude),
							(that.end = res.data.list.emperience_coupon.length > 0 ? res.data.list.emperience_coupon.enable_end.substr(10) : '');
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
		// 获取卡券对应房间信息
		getHourse() {
			let that = this;
			that.fui
				.request(
					'diandi_tea/order/gethourse',
					'GET',
					{
						coupon_id: that.list.emperience_coupon.id
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						if (res.data.use_hourse.length != 0) {
							if (res.data.use_hourse.length > 1) {
								uni.navigateTo({
									url: '/teahouse/houseselect/houseselect'
								});
							} else {
								uni.navigateTo({
									// url: '/teahouse/predetermine/predetermine?id=' + res.data.use_hourse[0]
									url: '/teahouse/predetermine/predetermine?' + 'id=' + res.data.use_hourse[0] + '&coupon_id=' + that.list.emperience_coupon.id
								});
							}
						} else {
							uni.navigateTo({
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
		resernow() {
			let that = this;
			that.$Router.push({
				name: 'houseselect',
				params: {}
			});
		},
		fabHand(e) {
			let that = this;
			let index = e.index;
			console.log(index);
			if (index === 0) {
				that.$Router.push({
					name: 'houseselect',
					params: {}
				});
			} else if (index === 1) {
				that.getOrderEnd();
			}
		},
		getLocation() {
			let that = this;
			console.log(that.latitude, that.longitude);
			wx.getLocation({
				type: 'gcj02',
				success: function(res) {
					wx.openLocation({
						//​使用微信内置地图查看位置。
						latitude: Number(that.latitude), //要去的纬度-地址
						longitude: Number(that.longitude), //要去的经度-地址
						name: that.list.name
						// address: '华侨城商业中心'
					});
				}
			});
		},
		goPhone() {
			let that = this;
			wx.makePhoneCall({
				phoneNumber: that.list.mobile
			});
		},
		getOrderEnd() {
			let that = this;
			that.fui
				.request('diandi_tea/order/noworder', 'GET', {}, true)
				.then(res => {
					console.log('200', res.data.order_id);
					if (res.code === 200) {
						console.log(res.data.order_id);
						that.$Router.push({
							name: 'orderDetail',
							params: {
								id: res.data.order_id
							}
						});
					}
				})
				.catch(res => {
					console.log('shibai', res);
					uni.showToast({
						title: res.message,
						icon: 'none',
						duration: 2000,
						success() {
							setTimeout(function() {
								that.$Router.push({
									name: 'houseselect',
									params: {}
								});
							}, 1000);
						}
					});
				});
		},
		gocoupon(data) {
			let that = this;
			if (that.fui.isLogin()) {
				if (data.is_have) {
					that.getHourse();
				} else {
					that.$Router.push({
						name: 'couponDetail',
						params: {
							id: data.id
						}
					});
				}
			} else {
				that.fui.toLogin(402);
			}
		},
		change: function(e) {
			this.current = e.detail.current;
		},
		recharge(index) {
			let that = this;
			that.$Router.push({
				name: 'recharge',
				params: {
					index: index
				}
			});
		}
	}
};
</script>

<style>
.container {
	/* font-family: cursive; */
}
.fui-banner-box {
	width: 100%;
	box-sizing: border-box;
}

.fui-banner-swiper {
	width: 100%;
	height: 600rpx;
}
.fui-banner-swipers {
	width: 100%;
	height: 231rpx;
}
.fui-banner-item {
	box-sizing: border-box;
}

.fui-slide-image {
	width: 100%;
	height: 600rpx;
	display: block;
	z-index: -1;
	position: relative;
}
.tea-address {
	font-size: 20px;
	position: absolute;
	z-index: 1;
	display: inline;
	top: 0;
	width: 100%;
	/* height: 100%; */
}
.tea-logo {
	width: 84rpx;
	height: 84rpx;
	margin-top: 71rpx;
	border-radius: 84rpx;
}
.tea-name {
	font-size: 48rpx;
	margin-top: 310rpx;
}
.tea-swiper-num {
	width: 65rpx;
	height: 36rpx;
	background: #000000;
	border-radius: 18rpx;
	opacity: 0.3;
	color: #ffffff;
	font-size: 18rpx;
}
.tea-intro {
	font-size: 24rpx;
	opacity: 0.49;
	font-weight: 600;
}
.tea-infomation {
	margin: 0 40rpx;
}
.tea-guangao {
	width: 683rpx;
	height: 183rpx;
	top: 612rpx;
	position: absolute;
	z-index: 1;
}
.fui-slide-ggimage {
	width: 683rpx;
	height: 183rpx;
	border-radius: 12rpx;
}
.tea-infoma-xj {
	margin-top: 19rpx;
}
.tea-infomation-phone {
	width: 16rpx;
	height: 22rpx;
	margin-right: 5rpx;
}
.tea-navigation {
	/* margin-top: -10rpx; */
	width: 63rpx;
	height: 69rpx;
}
.tea-discount {
	margin: 40.81rpx auto;
}
/* .fui-rolling-news {
	width: 100%;
	display: flex;
}

.fui-swiper {
	flex: 1;
}

.fui-swiper-item {
	display: flex;
	align-items: center;
}
.fui-news-item {
	position: absolute;
	width: 217.34rpx;
	height: 175.51rpx;
	background: #ffffff;
	border: 2.04rpx solid #ffba50;
}
.expre-card {
	color: #ae741b;
	font-size: 53.06rpx;
}
.expre-card-hd {
	position: absolute;
	bottom: 0;
	right: 0;
	width: 72.44rpx;
	height: 71.42rpx;
}
.card-more {
	z-index: 2;
	width: 61.22rpx;
	height: 175.51rpx;
	background: #ffffff;
	margin: auto 0;
	box-shadow: -9.18rpx 0px 10.2rpx 0px rgba(0, 0, 0, 0.12);
} */
.tycard-image {
	border-radius: 10.2rpx;
	background-size: 100% 100%;
	height: 260rpx;
	width: 670rpx;
	display: block;
	align-items: center;
	display: grid;
}
.tycard-detail {
	color: rgba(30, 38, 9, 1);
	font-size: 32rpx;
	display: flex;
	margin: auto 0;
	/* top: 25%; */
}
.tycard-name {
	margin: auto;
	color: #1e2609;
	width: 96rpx;
}
.tycard-price {
	border-radius: 32rpx;
	height: 64rpx;
	width: 137rpx;
	margin: auto 32rpx;
	line-height: 65rpx;
}

.cz_border {
	width: 670rpx;
	height: 500rpx;
	background: #ffffff;
	box-shadow: 0rpx 7rpx 20rpx 0rpx rgba(229, 234, 224, 1);
}
.cz_border_top {
	height: 0;
	width: 300rpx;
	margin-bottom: 16rpx;
	border-top: 60rpx solid #c8e4dc;
	border-left: 29rpx solid transparent;
	border-right: 29rpx solid transparent;
	border-radius: 0px 0px 20rpx 20rpx;
}
.cz_border_left {
	/* background: linear-gradient(to left, #1c4608, #388c0e, #3e9d0e); */
	width: 47rpx;
	height: 6rpx;
}
/* .cz_border_right {
	background: linear-gradient(to right, #1c4608, #388c0e, #3e9d0e);
	width: 44rpx;
	height: 5rpx;
} */
.cs_border_card_list {
	margin: 0 auto;
	width: 581.63rpx;
}
.cs_border_card {
	width: 581.63rpx;
	height: 112.24rpx;
	background: #ffffff;
	border: 1.02rpx solid #c6d8b5;
	position: relative;
}
.cs_border_card_detail {
	margin: auto 40rpx;
	height: 112.24rpx;
}
.cs_border_card_money {
	width: 128rpx;
	height: 38rpx;
	background: #c8e4dc;
	border-radius: 21rpx;
}
.cs_border_card_bor {
	width: 34.69rpx;
	height: 43.87rpx;
	border-radius: 0px 8.16rpx 8.16rpx 0px;
	border-top: 2.04rpx solid #979e91;
	border-bottom: 2.04rpx solid #979e91;
	border-right: 2.04rpx solid #979e91;
}
.cs_border_card_add {
	font-size: 41.4rpx;
}
.cs_border_card_card {
	font-size: 28.57rpx;
	font-weight: bold;
	color: #223406;
	width: 134.69rpx;
	height: 79.38rpx;
	color: #223406;
	background: linear-gradient(180deg, #a9b992 0%, #909d7c 100%);
}
.cs_border_card_cardvip {
	font-size: 28rpx;
	font-weight: bold;
	color: #936b23;
	width: 132rpx;
	height: 68rpx;
	background: linear-gradient(180deg, #ffe1b2 0%, #f5d8ab 100%);
	display: block;
	border-radius: 12rpx;
}
.cs_border_card_logo {
	width: 78rpx;
	height: 78rpx;
	/* border-radius: 100%;
	background: linear-gradient(180deg, #97bf62 0%, #218569 100%); */
}
.cs_border_card::after {
	width: 20px;
	height: 20px;
	content: '';
	right: -20px;
	top: 50%;
	transform: translate(-50%, -50%);
	position: absolute;
	background: #ffffff;
	border-radius: 100%;
	border-left: 1.02rpx solid #c6d8b5;
}
.cs_border_card::before {
	position: absolute;
	content: '';
	width: 20px;
	height: 20px;
	background: #ffffff;
	border-radius: 100%;
	left: 0;
	top: 50%;
	transform: translate(-50%, -50%);
	border-right: 1.02rpx solid #c6d8b5;
}
.reser-btn {
	width: 670rpx;
	height: 88rpx;
	background: #218569;
	box-shadow: 0rpx 7rpx 30rpx 0rpx rgba(33, 133, 105, 0.4);
	color: #ffffff;
	margin-bottom: 204rpx;
}
.justify {
	/* color:#5F676A; */
	width: 95.91rpx;
	float: left;
	overflow: hidden;
	text-align: justify;
	text-align-last: justify;
}

/* .fui-banner-swipers .wx-swiper-dot {
	border-radius: 50.4rpx;
	display: inline-flex;
	justify-content: space-between;
}
.fui-banner-swipers .wx-swiper-dot::before {
	content: '';
	flex-grow: 1;
	border-radius: 50%;
	overflow: hidden;
}
.fui-banner-swipers .wx-swiper-dot.wx-swiper-dot-active {
	width: 24rpx;
} */
</style>

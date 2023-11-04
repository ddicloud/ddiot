<template>
	<view class="container">
		<!--banner-->
		<view class="fui-banner-swiper" v-if="goodsdetail.slides">
			<swiper :autoplay="true" :interval="5000" :duration="150" :circular="true" :style="{ height: scrollH + 'px' }" @change="bannerChange">
				<block v-for="(item, index) in goodsdetail.slides" :key="index">
					<swiper-item :data-index="index" @tap.stop="previewImage">
						<image :src="item.url" class="fui-slide-image" :style="{ height: scrollH + 'px' }" v-if="item.type == 'image'" />
						<!-- <video :src="item.url" class="fui-slide-image" :autoplay="false" loop :show-play-btn="true"
							:controls="true" :poster="goodsdetail.thumb" objectFit="cover"
							v-if="item.type=='video' && item.url"></video> -->
					</swiper-item>
				</block>
			</swiper>
			<view class="fui-banner-tag">
				<fui-tag padding="12rpx 18rpx" type="translucent" shape="circleLeft" :scaleMultiple="0.82" originRight>
					{{ bannerIndex + 1 }}/{{ goodsdetail.slides.length }}
				</fui-tag>
			</view>
		</view>

		<!--banner-->

		<view class="fui-pro-detail" v-if="goodsdetail.goods_integral">
			<view class="fui-product-title fui-border-radius">
				<view class="fui-pro-pricebox fui-padding">
					<view class="fui-pro-price">
						<view class="fui-price">
							<iconfont className="icon-jifen" size="28">
								<text class="padding-left-xs">{{ goodsdetail.goods_integral }}</text>
							</iconfont>
						</view>
						<!-- <fui-tag padding="10rpx 20rpx" size="24rpx" plain type="high-green" shape="circle" :scaleMultiple="0.8" v-if="goodsdetail.label"> -->
						<fui-tag padding="10rpx 20rpx" size="24rpx" plain type="high-green" shape="circle" :scaleMultiple="0.8">
							<!-- {{ goodsdetail.label }} -->积分
						</fui-tag>
					</view>
				</view>
				<view class="fui-original-price">
					市场价
					<text class="fui-line-through">￥{{ goodsdetail.goods_price }}</text>
				</view>
				<view class="fui-padding">
					<view class="fui-sale-info fui-size">
						<view>兑换量:{{ goodsdetail.sales_initial }}</view>
						<view>库存: {{ goodsdetail.stock }}</view>
						<view>浏览量: {{ goodsdetail.browse }}</view>
					</view>
				</view>
			</view>

			<view class="fui-discount-box fui-radius-all fui-mtop">
				<!-- <view class="fui-list-cell" @tap="coupon">
					<view class="fui-bold fui-cell-title">领券</view>
					<view class="fui-flex-center">
						<fui-tag type="red" shape="circle" padding="12rpx 24rpx" size="24rpx">满99减8</fui-tag>
						<fui-tag margin="0 0 0 20rpx" type="red" padding="12rpx 24rpx" size="24rpx" shape="circle">满59减5</fui-tag>
					</view>
					<view class="fui-ml-auto">
						<fui-icon name="more-fill" :size="20" color="#666"></fui-icon>
					</view>
				</view> -->
			</view>

			<view class="fui-basic-info fui-mtop fui-radius-all">
				<view class="fui-list-cell" @tap="showPopup" v-if="goodsdetail.spec_type == 1">
					<view class="fui-bold fui-cell-title">已选</view>
					<view class="fui-selected-box">
						<text class="selected-text" v-for="(sItem, sIndex) in specSelected" :key="sIndex">{{ sItem.name }}</text>
					</view>
					<!-- <view class="fui-ml-auto"><fui-icon name="more-fill" :size="20" color="#666"></fui-icon></view> -->
				</view>
			</view>

			<view class="fui-nomore-box"><fui-nomore text="宝贝详情" backgroundColor="#f7f7f7"></fui-nomore></view>
			<view class="padding-sm fui-radius-all">
				<u-parse :content="goodsdetail.content" @preview="preview" @navigate="navigate"></u-parse>
				<!-- <rich-text :nodes="goodsdetail.content"></rich-text> -->
			</view>
			<fui-nomore text="已经到最底了" backgroundColor="#f7f7f7"></fui-nomore>
			<view class="fui-safearea-bottom"></view>
		</view>

		<!--底部操作栏-->
		<view class="fui-operation">
			<view class="fui-operation-right fui-right-flex fui-col-8 fui-btnbox-4">
				<view class="fui-flex-1" v-if="goodsdetail.stock!=0">
					<fui-button height="72rpx" :size="28" type="gray" shape="circle" v-if="goodsdetail.goods_integral > user_integral">
						您的积分不足，不能兑换
					</fui-button>
					<fui-button height="72rpx" :size="28" type="bluegreen" shape="circle" v-if="goodsdetail.goods_integral <= user_integral" @click="showPopup">立即兑换</fui-button>
					<!-- <fui-button height="72rpx" :size="28" type="bluegreen" shape="circle"  @click="showPopup">立即兑换</fui-button> -->
				</view>
				<view class="fui-flex-1" v-if="goodsdetail.stock===0">
					<fui-button height="72rpx" :size="28" type="danger" shape="circle">库存不足，不能兑换</fui-button>
				</view>
			</view>
		</view>

		<!--底部操作栏--->

		<!--顶部下拉菜单-->
		<fui-top-dropdown backgroundColor="rgba(76, 76, 76, 0.95)" :show="menuShow" :height="0" @close="closeMenu">
			<view class="fui-menu-box fui-padding fui-ptop">
				<view class="fui-menu-header" :style="{ paddingTop: top + 'px' }">功能直达</view>
				<view class="fui-menu-itembox">
					<view class="fui-menu-item" v-for="(item, index) in topMenu" :key="index" hover-class="fui-opcity" :hover-stay-time="150" @tap="btnTopMenu(index)">
						<view class="fui-badge-box">
							<iconfont :className="item.icon" color="#fff" :size="item.size"></iconfont>
							<fui-badge type="red" :scaleRatio="0.8" absolute right="-8rpx" v-if="item.badge">{{ item.badge }}</fui-badge>
						</view>
						<view class="fui-menu-text">{{ item.text }}</view>
					</view>
				</view>
				<view class="fui-icon-up_box"><iconfont className="up" color="#fff" :size="26" @click="closeMenu"></iconfont></view>
			</view>
		</fui-top-dropdown>
		<!---顶部下拉菜单-->

		<!--底部选择层-->
		<fui-bottom-popup :show="popupShow" @close="hidePopup">
			<view class="fui-popup-box">
				<view class="fui-product-box fui-padding" v-if="goodsdetail.spec_type == 1">
					<image :src="thumb[specitem]" class="fui-popup-img"></image>
					<view class="fui-popup-price">
						<view class="fui-amount fui-bold">￥{{ specsVal[specKey].goods_price }}/库存：{{ specsVal[specKey].stock_num }}件</view>
						<view class="fui-number">
							<text class="selected-text" v-for="(sItem, sIndex) in specSelected" :key="sIndex">{{ sItem.name }}</text>
						</view>
					</view>
				</view>
				<view class="fui-product-box fui-padding" v-if="goodsdetail.spec_type == 0">
					<image :src="goodsdetail.thumb" class="fui-popup-img"></image>
					<view class="fui-popup-price">
						<view class="fui-amount fui-bold">￥{{ goodsdetail.goods_price }}/库存：{{ goodsdetail.stock }}件</view>
					</view>
				</view>
				<scroll-view scroll-y class="fui-popup-scroll" :style="{ height: scrollheight + 'rpx' }">
					<view class="fui-scrollview-box">
						<block v-for="(item, index) in specs" :key="index" v-if="item">
							<view class="fui-bold fui-attr-title">{{ index }}</view>
							<view class="fui-attr-box">
								<view
									class="fui-attr-item"
									v-for="(childItem, childIndex) in item"
									:key="childIndex"
									:class="{ selected: childItem.selected }"
									@click="selectSpec(index, childIndex, childItem.id)"
								>
									{{ childItem.name }}
								</view>
							</view>
						</block>

						<view class="fui-number-box fui-bold fui-attr-title">
							<view class="fui-attr-title">数量</view>
							<fui-numberbox :max="99" :min="1" :value="value" @change="change"></fui-numberbox>
						</view>
					</view>
				</scroll-view>
				<view class="fui-operation fui-operation-right fui-right-flex fui-popup-btn">
					<view class="fui-flex-1">
						<fui-button height="72rpx" :size="28" type="gray" shape="circle" v-if="goodsdetail.goods_integral > user_integral">
							您的积分不足，不能兑换
						</fui-button>
						<fui-button height="72rpx" :size="28" type="bluegreen" shape="circle" v-if="goodsdetail.goods_integral <= user_integral" @click="submit">立即兑换</fui-button>
						<!-- <fui-button height="72rpx" :size="28" type="bluegreen" shape="circle"  @click="submit">立即兑换</fui-button> -->
					</view>
				</view>
				<view class="fui-right" @click="hidePopup"><iconfont className="icon-tubiaozhizuomoban-01" :size="22" color="#333"></iconfont></view>
			</view>
		</fui-bottom-popup>
	</view>
</template>

<script>
import uParse from '@/components/u-parse/u-parse.vue';
export default {
	components: {
		uParse
	},
	data() {
		return {
			share: {},
			wxOpenTags: '',
			isShare: false,
			islogin: false,
			user_integral: 0,
			poster: '',
			path: '',
			goods_type: 1,
			order_type: 1,
			isShowPopup: false,
			member_id: 0, //推荐人
			modalWidth: 0,
			isShowPainter: false,
			goodsDis: {},
			scrollheight: 600,
			goods_id: 0,
			goodsdetail: {},
			specs: {},
			thumb: {},
			specitem: '',
			specKey: '',
			specsVal: {},
			specSelected: [],
			goodsNumber: 1,
			totalNumber: 0,
			storeData: {},
			height: 64, //header高度
			top: 26, //标题图标距离顶部距离
			scrollH: 0, //滚动总高度
			opcity: 0,
			iconOpcity: 0.5,
			banner: [],
			bannerIndex: 0,
			width: 0,
			menuShow: false,
			popupShow: false,
			value: 1,
			collected: false,
			specKeyId: '',
			board: {},
			conf: {}
		};
	},
	onLoad: function(options) {
		let obj = {};
		let that = this;
		that.islogin = that.fui.isLogin();
		if (!that.iGlobal.isUndefined(that.$Route.query)) {
			that.member_id = parseInt(that.$Route.query.member_id) || '';

			console.log('member_id', that.member_id, that.iGlobal.isNumber(that.member_id));

			if (that.iGlobal.isNumber(that.member_id) && that.member_id > 0) {
				that.link(that.member_id);
			}
		}
		console.log('页面如此', options, this.$Route.query.goods_id);
		that.goods_id = this.$Route.query.goods_id;
		if (that.iGlobal.isNumber(this.$Route.query.goods_type)) {
			that.goods_type = this.$Route.query.goods_type;
		}
		that.fui
			.store()
			.then(res => {
				console.log('AAAAAAAAAA', res);
				that.storeData = res;
				console.log('商家信息', res.hotSearch, res.hotSearch.split(','));
			})
			.catch(res => {
				console.log('shibai', res);
			});

		// #ifdef MP-WEIXIN
		obj = wx.getMenuButtonBoundingClientRect();
		// #endif
		// #ifdef MP-BAIDU
		obj = swan.getMenuButtonBoundingClientRect();
		// #endif
		// #ifdef MP-ALIPAY
		my.hideAddToDesktopMenu();
		// #endif

		setTimeout(() => {
			uni.getSystemInfo({
				success: res => {
					this.width = obj.left || res.windowWidth;
					this.board.width = (this.width * 90) / 100;
					this.modalWidth = (this.width * 84) / 100;
					this.height = obj.top ? obj.top + obj.height + 8 : res.statusBarHeight + 44;
					this.top = obj.top ? obj.top + (obj.height - 32) / 2 : res.statusBarHeight + 6;
					this.scrollH = res.windowWidth;
				}
			});
		}, 0);
		if (that.islogin) {
			that.initPage();
			that.getMember();
			that.getConf();
		}
		that.getdetail();
	},
	onShow() {
		let that = this;
	},
	methods: {
		link(member_id) {
			let that = this;
			that.fui
				.request('diandi_distribution/level/link', 'POST', {
					member_id: member_id
				})
				.then(res => {
					console.log(res);
					if (res.code == 200) {
						uni.removeStorageSync('inviteCode');
						console.log(res);
					} else {
						this.fui.toast(res.message);
					}
				})
				.catch(res => {});
		},
		getConf: function() {
			let that = this;
			that.fui
				.request('diandi_distribution/store/conf', 'GET', {}, false)
				.then(res => {
					if (res.code == 200) {
						console.log(res.data.user_integral_name);
						that.conf = res.data;
					} else {
						that.fui.toast(res.message);
					}
				})
				.catch(res => {
					console.log('配置获取失败', res);
				});
		},
		getMember() {
			let that = this;
			that.fui
				.request('diandi_distribution/member/info', 'GET', {})
				.then(res => {
					console.log(res);
					if (res.code == 200) {
						that.user_integral = res.data.account.user_integral;
					} else {
						that.fui.toast(res.message);
					}
				})
				.catch(res => {
					console.log(res);
				});
		},
		fail(v) {
			console.log(v);
		},
		initPage() {
			let that = this;
			that.getCartlist();
		},
		toCart() {
			let that = this;
			that.$Router.push({
				name: 'shopcart'
			});
		},
		hidePainter: function(e) {
			let that = this;
			that.isShowPopup = false;
		},
		bannerChange: function(e) {
			this.bannerIndex = e.detail.current;
		},
		previewImage: function(e) {
			let that = this;
			let index = e.currentTarget.dataset.index;
			console.log(this.goodsdetail.slides, index);
			let slides = [];
			that.goodsdetail.slides.forEach((item, index) => {
				if (item.type == 'image') {
					slides.push(item.url);
				}
			});
			uni.previewImage({
				current: slides[index],
				urls: slides
			});
		},
		back: function() {
			let that = this;
			that.$Router.back(1);
			// uni.navigateBack();
		},
		openMenu: function() {
			this.menuShow = true;
		},
		closeMenu: function() {
			this.menuShow = false;
		},
		showPopup: function() {
			this.popupShow = true;
		},
		hidePopup: function() {
			this.popupShow = false;
		},
		change: function(e) {
			this.value = e.value;
			this.goodsNumber = e.value;
		},
		common: function() {
			this.fui.toast('功能开发中~');
		},
		// 获取详情
		getdetail() {
			let that = this;
			let goods_id = that.goods_id;
			that.fui
				.request(
					'diandi_integral/goods/detail',
					'GET',
					{
						goods_id: goods_id,
						goods_type: that.goods_type
					},
					false
				)
				.then(res => {
					console.log('商品详情获取成功', res.code == 200, res.code, res.data);
					if (res.code == 200) {
						that.order_type = res.data.order_type;
						let goodsdetail = res.data.goods;
						that.goodsDis = res.data.dis;
						that.goodsdetail = goodsdetail;
						console.log('lailailai01');
						// 规格
						if (goodsdetail.specs.length) {
						}
						that.specs = goodsdetail.specs.list;
						console.log('lailailai02');
						that.specsVal = goodsdetail.specs.specVal;
						console.log('lailailai03');
						that.thumb = goodsdetail.specs.thumb;
						console.log('lailailai04');
						that.specitem = goodsdetail.specs.specitem;
						console.log('lailailai05', goodsdetail.specs.list);
						let specKey = [];
						let specSelected = [];
						let specKeyId = [];
						// 初始默认选项

						if (goodsdetail.spec_type == 0) {
							that.scrollheight = 100;
							console.log('修改高度', that.scrollheight);
						} else {
							let specs = Object.values(goodsdetail.specs.list);
							console.log('lailailai05 specs', specs);
							specs.forEach((item, index) => {
								console.log(item, index);
								item.forEach((sp, k) => {
									if (sp.selected) {
										specSelected.push(sp);
										specKey.push(sp.name);
										specKeyId.push(sp.id);
									}
									console.log(sp, k, index);
								});
							});
							that.specSelected = specSelected;
							that.specKeyId = specKeyId.join('_');
							that.specKey = specKey.join('_');
						}

						console.log('cccc', specKey.join('_'));
					}
					console.log('商品详情222', goodsdetail);
				})
				.catch(res => {
					console.log('商品详情获取错误', res);
				});
		},
		//选择规格
		selectSpec(group, index, id) {
			let _this = this;
			let list = _this.specs;
			console.log(list, '222');
			_this.specSelected = [];
			let specKey = [];
			let specKeyId = [];
			for (var key in list) {
				for (let child in list[key]) {
					if (group == key) {
						if (list[key][child].id == id) {
							_this.specitem = list[key][child].name;
							_this.$set(list[key][child], 'selected', true);
						} else {
							_this.$set(list[key][child], 'selected', false);
						}
					}
					if (list[key][child].selected) {
						specKey.push(list[key][child].name);
						specKeyId.push(list[key][child].id);
						_this.specSelected.push(list[key][child]);
					}
				}
			}
			console.log('选中', _this.specSelected);
			console.log(_this.specitem);
			_this.specKey = specKey.join('_');
			_this.specKeyId = specKeyId.join('_');
			_this.specs = list;
			_this.$forceUpdate();
		},
		//新增商品计算价格
		addGoodsChange() {
			console.log('5675');
			var that = this;
			let goodsNumber = Number(that.goodsNumber);
			let totalPrice = 0;
			let totalNumber = 0;
			let existedGoods = false;
			let goods_id = that.goods_id;
			console.log('选中', that.specKeyId);
			that.fui
				.request('diandi_distribution/cart/add', 'POST', {
					goods_id: goods_id,
					num: goodsNumber,
					spec_id: that.specKeyId
				})
				.then(res => {
					uni.hideLoading();
					console.log('商品详情', res.code == 200, res.code, res.data);
					if (res.code == 200) {
						that.shoppCart = res.data;
						that.goodsTotalPrice = res.data.goodsTotalPrice;
						//总价
						totalPrice = res.data.total_price;
						that.totalNumber = res.data.goodsTotalNumber;
						that.popupShow = false;
						that.fui.toast(res.message);
					} else {
						that.fui.toast(res.message);
					}
					console.log('商品详情222', res.data);
				})
				.catch(res => {
					console.log('错误', err);
				});
			//购物车商品数据缓存至本地
			// uni.setStorageSync(that.shoppingCartStorageName, that.shoppingCartAll);
		},
		getCartlist() {
			var that = this;
			let totalPrice = 0;
			let totalNumber = 0;

			that.fui
				.request('diandi_distribution/cart/list', 'POST', {
					goods_id: that.goods_id,
					goods_type: that.goods_type
				})
				.then(res => {
					console.log('商品详情', res.code == 200, res.code, res.data);
					if (res.code == 200) {
						that.shoppCart = res.data;
						that.goodsTotalPrice = res.data.goodsTotalPrice;
						that.collected = res.data.is_collect;
						//总价
						that.totalPrice = res.data.total_price;
						that.totalNumber = res.data.goodsTotalNumber;
					} else {
						that.fui.toast(res.message);
					}
					console.log('商品详情222', res.data);
				})
				.catch(res => {});
		},
		btnTopMenu(index) {
			this.closeMenu();
			if (index == 4) {
				this.contact();
			} else if (index == 6) {
				// #ifdef MP
				this.common();
				// #endif

				// #ifndef MP
				this.onShare();
				// #endif
			} else {
				let url = {
					0: '/message',
					1: '/',
					2: '/member',
					3: '/shopcart',
					5: '/feedback?page=mall'
				}[index];
				url && this.fui.href(url);
			}
		},
		submit() {
			let that = this;
			let goodsNumber = Number(that.goodsNumber);
			let totalPrice = 0;
			let totalNumber = 0;
			let existedGoods = false;
			let goods_id = that.goods_id;
			let specKeyId = that.specKeyId;

			console.log('选中', that.specKeyId);

			that.popupShow = false;

			that.$Router.push({
				name: 'integralconfirmOrder',
				params: {
					goods_type: that.goods_type,
					order_type: that.order_type,
					goods_id: goods_id,
					goodsNumber: goodsNumber,
					specKeyId: specKeyId
				}
			});
		},
		coupon() {
			uni.navigateTo({
				url: '../coupon/coupon'
			});
		},
		onShare() {
			let that = this;
			that.isShare = true;
			// that.getQrcode()
		},
		preview(src, e) {
			// do something
		},
		navigate(href, e) {
			// do something
		}
	},
	onPageScroll(e) {
		let scroll = e.scrollTop <= 0 ? 0 : e.scrollTop;
		let opcity = scroll / this.scrollH;
		if (this.opcity >= 1 && opcity >= 1) {
			return;
		}
		this.opcity = opcity;
		this.iconOpcity = 0.5 * (1 - opcity < 0 ? 0 : 1 - opcity);
	}
};
</script>

<style>
page {
	background-color: #f7f7f7;
}

.poster-img {
	width: 100%;
	height: 100%;
}

.painter-box {
	width: 85vw;
}

.container {
	padding-bottom: 110rpx;
}

.fui-header-box {
	width: 100%;
	position: fixed;
	left: 0;
	top: 0;
	z-index: 995;
}

.fui-header {
	width: 100%;
	font-size: 18px;
	line-height: 18px;
	font-weight: 500;
	height: 32px;
	display: flex;
	align-items: center;
	justify-content: center;
}

.fui-header-icon {
	position: fixed;
	top: 0;
	left: 10px;
	display: flex;
	align-items: flex-start;
	justify-content: space-between;
	height: 32px;
	transform: translateZ(0);
	z-index: 9999;
}

.fui-header-icon .fui-badge {
	background: #e41f19 !important;
	position: absolute;
	right: -4px;
}

.fui-icon-ml {
	margin-left: 20rpx;
}

.fui-icon-box {
	position: relative;
	height: 20px !important;
	width: 20px !important;
	padding: 6px !important;

	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
}

.fui-banner-swiper {
	position: relative;
}

.fui-banner-tag {
	position: absolute;
	color: #fff;
	bottom: 30rpx;
	right: 0;
}

.fui-slide-image {
	width: 100%;
	height: 100%;
	display: block;
}

/*顶部菜单*/

.fui-menu-box {
	box-sizing: border-box;
}

.fui-menu-header {
	font-size: 34rpx;
	color: #fff;
	height: 32px;
	display: flex;
	align-items: center;
}

.fui-menu-itembox {
	color: #fff;
	padding: 40rpx 10rpx 0 10rpx;
	box-sizing: border-box;
	display: flex;
	flex-wrap: wrap;
	font-size: 26rpx;
}

.fui-menu-item {
	width: 22%;
	height: 160rpx;
	border-radius: 24rpx;
	display: flex;
	align-items: center;
	flex-direction: column;
	justify-content: center;
	background: rgba(0, 0, 0, 0.4);
	margin-right: 4%;
	margin-bottom: 4%;
}

.fui-menu-item:nth-of-type(4n) {
	margin-right: 0;
}

.fui-badge-box {
	position: relative;
}

.fui-badge-box .fui-badge-class {
	position: absolute;
	top: -8px;
	right: -8px;
}

.fui-msg-badge {
	top: -10px;
}

.fui-icon-up_box {
	width: 100%;
	display: flex;
	align-items: center;
	justify-content: center;
}

.fui-menu-text {
	padding-top: 12rpx;
}

.fui-opcity .fui-menu-text,
.fui-opcity .fui-badge-box {
	opacity: 0.5;
	transition: opacity 0.2s ease-in-out;
}

/*顶部菜单*/

/*内容 部分*/

.fui-padding {
	padding: 0 30rpx;
	box-sizing: border-box;
}

.fui-ml-auto {
	margin-left: auto;
}

/* #ifdef H5 */
.fui-ptop {
	padding-top: 44px;
}

/* #endif */

.fui-size {
	font-size: 24rpx;
	line-height: 24rpx;
}

.fui-gray {
	color: #999;
}

.fui-icon-red {
	color: #ff201f;
}

.fui-border-radius {
	border-bottom-left-radius: 24rpx;
	border-bottom-right-radius: 24rpx;
	overflow: hidden;
}

.fui-radius-all {
	border-radius: 24rpx;
	overflow: hidden;
}

.fui-mtop {
	margin-top: 26rpx;
}

.fui-pro-detail {
	box-sizing: border-box;
	color: #333;
}

.fui-product-title {
	background: #fff;
	padding: 30rpx 0;
}

.fui-pro-pricebox {
	display: flex;
	align-items: center;
	justify-content: space-between;
	color: #ff201f;
	font-size: 36rpx;
	font-weight: bold;
	line-height: 44rpx;
}

.fui-pro-price {
	display: flex;
	align-items: center;
}

.fui-price {
	font-size: 58rpx;
}

.fui-original-price {
	font-size: 26rpx;
	line-height: 26rpx;
	padding: 10rpx 30rpx;
	box-sizing: border-box;
}

.fui-line-through {
	text-decoration: line-through;
}

.fui-collection {
	color: #333;
	display: flex;
	align-items: center;
	flex-direction: column;
	justify-content: center;
	height: 44rpx;
}

.fui-scale-collection {
	transform: scale(0.7);
	transform-origin: center 90%;
	line-height: 24rpx;
	font-weight: normal;
	margin-top: 4rpx;
}

.fui-pro-titbox {
	font-size: 32rpx;
	font-weight: 500;
	position: relative;
	padding: 0 150rpx 0 30rpx;
	box-sizing: border-box;
}

.fui-pro-title {
	padding-top: 20rpx;
}

.fui-share-btn {
	display: block;
	background: transparent;
	margin: 0;
	padding: 0;
	border-radius: 0;
	border: 0;
}

.fui-share-btn::after {
	border: 0;
}

.fui-share-box {
	display: flex;
	align-items: center;
}

.fui-share-position {
	position: absolute;
	right: 0;
	top: 10rpx;
}

.fui-share-text {
	padding-left: 8rpx;
}

.fui-sub-title {
	padding: 20rpx 0;
	line-height: 32rpx;
}

.fui-sale-info {
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding-top: 30rpx;
}

.fui-discount-box {
	background: #fff;
}

.fui-list-cell {
	width: 100%;
	position: relative;
	display: flex;
	align-items: center;
	font-size: 26rpx;
	line-height: 26rpx;
	padding: 36rpx 30rpx;
	box-sizing: border-box;
}

.fui-right {
	position: absolute;
	right: 30rpx;
	top: 30rpx;
}

.fui-top40 {
	top: 40rpx !important;
}

.fui-bold {
	font-weight: bold;
}

.fui-list-cell::after {
	content: '';
	position: absolute;
	border-bottom: 1rpx solid #eaeef1;
	-webkit-transform: scaleY(0.5);
	transform: scaleY(0.5);
	bottom: 0;
	right: 0;
	left: 126rpx;
}

.fui-last::after {
	border-bottom: 0 !important;
}

.fui-flex-center {
	display: flex;
	align-items: center;
}

.fui-cell-title {
	width: 66rpx;
	padding-right: 30rpx;
	flex-shrink: 0;
}

.fui-promotion-box {
	display: -webkit-box;
	-webkit-box-align: center;
	-webkit-align-items: center;
	align-items: center;
	padding: 1px 0;
	width: 100%;
}

.fui-promotion-box text {
	width: 60rpx;
	text-align: center;
	display: inline-block;
	line-height: 1;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}

.fui-basic-info {
	background: #fff;
}

.fui-addr-box {
	width: 76%;
}

.fui-addr-item {
	padding: 10rpx;
	line-height: 34rpx;
}

.fui-guarantee {
	background: #fdfdfd;
	display: flex;
	flex-wrap: wrap;
	padding: 20rpx 30rpx 30rpx 30rpx;
	font-size: 24rpx;
}

.fui-guarantee-item {
	color: #999;
	padding-right: 30rpx;
	padding-top: 10rpx;
}

.fui-pl {
	padding-left: 4rpx;
}

.fui-cmt-box {
	background: #fff;
}

.fui-between {
	justify-content: space-between !important;
}

.fui-cmt-all {
	color: #ff201f;
	padding-right: 8rpx;
}

.fui-cmt-content {
	font-size: 26rpx;
}

.fui-cmt-user {
	display: flex;
	align-items: center;
}

.fui-acatar {
	width: 60rpx;
	height: 60rpx;
	border-radius: 30rpx;
	display: block;
	margin-right: 16rpx;
}

.fui-cmt {
	padding: 14rpx 0;
}

.fui-attr {
	font-size: 24rpx;
	color: #999;
	padding: 6rpx 0;
}

.fui-cmt-btn {
	padding: 50rpx 0 30rpx 0;
	box-sizing: border-box;
	display: flex;
	align-items: center;
	justify-content: center;
}

.fui-nomore-box {
	padding-top: 10rpx;
}

.fui-product-img {
	display: flex;
	flex-direction: column;
	transform: translateZ(0);
}

.fui-product-img image {
	width: 100%;
	display: block;
}

/*底部操作栏*/

.fui-col-7 {
	width: 58.33333333%;
}

.fui-col-5 {
	width: 41.66666667%;
}

.fui-operation {
	width: 100%;
	height: 100rpx;
	background: rgba(255, 255, 255, 0.98);
	position: fixed;
	display: flex;
	align-items: center;
	justify-content: space-between;
	z-index: 10;
	bottom: 0;
	left: 0;
	padding-bottom: env(safe-area-inset-bottom);
}

.fui-safearea-bottom {
	width: 100%;
	height: env(safe-area-inset-bottom);
}

.fui-operation::before {
	content: '';
	position: absolute;
	top: 0;
	right: 0;
	left: 0;
	border-top: 1rpx solid #eaeef1;
	-webkit-transform: scaleY(0.5);
	transform: scaleY(0.5);
}

.fui-operation-left {
	display: flex;
	align-items: center;
}

.fui-operation-item {
	flex: 1;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	position: relative;
}

.fui-operation-text {
	font-size: 22rpx;
	color: #333;
}

.fui-opacity {
	opacity: 0.5;
}

.fui-scale-small {
	transform: scale(0.9);
	transform-origin: center center;
}

.fui-operation-right {
	height: 100rpx;
	padding-top: 0;
}

.fui-right-flex {
	display: flex;
	align-items: center;
	justify-content: center;
}

.fui-flex-1 {
	flex: 1;
	padding: 16rpx;
}

/*底部操作栏*/

/*底部选择弹层*/

.fui-popup-class {
	border-top-left-radius: 24rpx;
	border-top-right-radius: 24rpx;
	padding-bottom: env(safe-area-inset-bottom);
}

.fui-popup-box {
	position: relative;
	padding: 30rpx 0 100rpx 0;
}

.fui-popup-btn {
	width: 100%;
	position: absolute;
	left: 0;
	bottom: 0;
}

/* .fui-popup-btn .fui-btn-class {
		width: 90% !important;
		display: block !important;
		font-size: 28rpx !important;
	} */

/* .fui-icon-close {
		position: absolute;
		top: 30rpx;
		right: 30rpx;
	} */
.selected {
	background: #eb0909 !important;
	color: #ffffff;
}

.fui-product-box {
	display: flex;
	align-items: flex-end;
	font-size: 24rpx;
	padding-bottom: 30rpx;
}

.fui-popup-img {
	height: 200rpx;
	width: 200rpx;
	border-radius: 24rpx;
	display: block;
}

.fui-popup-price {
	padding-left: 20rpx;
	padding-bottom: 8rpx;
}

.fui-amount {
	color: #ff201f;
	font-size: 36rpx;
}

.fui-number {
	font-size: 24rpx;
	line-height: 24rpx;
	padding-top: 12rpx;
	color: #999;
}

.fui-popup-scroll {
	font-size: 26rpx;
}

.selected-text {
	margin-left: 6.25rpx;
	color: #fc872d;
}

.fui-scrollview-box {
	padding: 0 30rpx 60rpx 30rpx;
	box-sizing: border-box;
}

.fui-attr-title {
	padding: 10rpx 0;
	color: #333;
}

.fui-attr-box {
	font-size: 0;
	padding: 20rpx 0;
}

.clearbutton {
	padding: 0;
	outline: none;
	border: none;
	list-style: none;
	background-color: rgba(0, 0, 0, 0);
	line-height: 34rpx;
}

.fui-attr-item {
	max-width: 100%;
	min-width: 200rpx;
	height: 64rpx;
	display: -webkit-inline-flex;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	background: #f7f7f7;
	padding: 0 26rpx;
	box-sizing: border-box;
	border-radius: 32rpx;
	margin-right: 20rpx;
	margin-bottom: 20rpx;
	font-size: 26rpx;
}

.fui-attr-active {
	background: #fcedea !important;
	color: #e41f19;
	font-weight: bold;
	position: relative;
}

.fui-attr-active::after {
	content: '';
	position: absolute;
	border: 1rpx solid #e41f19;
	width: 100%;
	height: 100%;
	border-radius: 40rpx;
	left: 0;
	top: 0;
}

.fui-number-box {
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding: 20rpx 0 30rpx 0;
	box-sizing: border-box;
}

.fui-list-cell-ac {
	display: flex;
	align-items: center;
	font-size: 11px;
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
	padding-top: 16.32rpx;
	padding-bottom: 16.32rpx;
	padding-left: 30.61rpx;
}

/*底部选择弹层*/

p > img {
	width: 100%;
}
.tinstall {
	margin-top: 250px;
	text-align: right;
	width: 100%;
	position: fixed;
}
</style>

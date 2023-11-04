<template>
	<view class="container">
		<!--header-->
		<view class="cu-bar search index-top">
			<view class="search-form round">
				<text class="cuIcon-back">
				</text>
				<input v-model="keywords" :adjust-position="false" type="text" 
				placeholder="输入你想要的" confirm-type="search"></input>
			</view>
			<view class="action" @click="searchGoods">
				<text class="text-white">搜索</text> 
			</view>
		</view>
		<!--header-->
		
		<!-- slide -->
		<view class="fui-banner-box">
			<swiper
				:indicator-dots="true"
				:autoplay="true"
				:interval="5000"
				:duration="150"
				class="fui-banner-swiper"
				:circular="true"
				indicator-color="rgba(255, 255, 255, 0.8)"
				indicator-active-color="#fff"
			>
				<swiper-item v-for="(item,index) in slide" :key="index" >
					<image :src="item.slide" class="fui-slide-image" mode="widthFix" style="width: 100%;"/>
				</swiper-item>
			</swiper>
		</view>
		<!-- slide -->
		
		<!-- 分类显示 -->
		<view class="fui-product-category margin-tb-xs">
			<view class="fui-category-item fui-skeleton-rect" 
				v-for="(item,index) in category"
			:key="index"
			:data-category_id="item.category_id" 
			:data-key="item.name" 
			@tap="moreList"
			>
				<image :src="item.image_id" class="fui-category-img fui-skeleton-rect" mode="scaleToFill"></image>
				<view class="fui-category-name fui-skeleton-rect">{{ item.name }}</view>
			</view>
		</view>
		<!-- 分类显示 -->
		
		<!--screen-->
		<view class="fui-header-screen" >
			<view class="fui-screen-top">
				<view class="fui-top-item fui-icon-ml" :class="[tabIndex == 0 ? 'fui-active fui-bold' : '']" data-index="0" @tap="screen">
					<view>{{ selectedName }}</view>
					<!-- <fui-icon :name="selectH > 0 ? 'arrowup' : 'arrowdown'" :size="14" :color="tabIndex == 0 ? '#e41f19' : '#444'"></fui-icon> -->
				</view>
				<view class="fui-top-item" :class="[tabIndex == 1 ? 'fui-active fui-bold' : '']" @tap="screen" data-index="1">销量</view>
				<!-- <view class="fui-top-item" @tap="screen" data-index="2"> -->
					<!-- <fui-icon :name="isList ? 'manage' : 'listview'" :size="isList ? 22 : 18" :bold="isList ? false : true" color="#333"></fui-icon> -->
				<!-- </view> -->

				<!--下拉选择列表--综合-->
				<view class="fui-dropdownlist" :class="[selectH > 0 ? 'fui-dropdownlist-show' : '']" :style="{ height: selectH + 'rpx' }">
					<view
						class="fui-dropdownlist-item fui-icon-middle"
						:class="[item.selected ? 'fui-bold' : '']"
						v-for="(item, index) in dropdownList"
						:key="index"
						@tap.stop="dropdownItem"
						:data-index="index"
					>
						<text class="fui-ml fui-middle">{{ item.name }}</text>
						<!-- <fui-icon name="check" :size="16" color="#e41f19" :bold="true" v-if="item.selected"></fui-icon> -->
					</view>
				</view>
				<view class="fui-dropdownlist-mask" :class="[selectH > 0 ? 'fui-mask-show' : '']" @tap.stop="hideDropdownList"></view>
				<!--下拉选择列表--综合-->
			</view>
		</view>
		<!--screen-->

		<!--list-->
		<view class="fui-product-list padding-lr-sm padding-top-xs" v-if="goodsList">
			<view class="fui-product-container">
				<view class="margin-lr-xs" v-for="(item, index) in goodsList" :key="index" style="width: 331.63rpx">
					<!-- <template is="productItem" data="{{item,index:index,isList:isList}}" /> -->
					<!--商品列表-->
					<view class="fui-pro-item" :class="[isList ? 'fui-flex-list' : '']" hover-class="hover" 
						:hover-start-time="150" 
						 :data-goods_id="item.goods_id"
						 :data-goods_type="item.goods_type"
						  @tap="detail($event)"
						>
						<image :src="item.thumb" class="fui-pro-img" :class="[isList ? 'fui-proimg-list' : '']" mode="widthFix" />
						<view class="fui-pro-content">
							<view class="fui-pro-tit">{{ item.goods_name }}</view>
							<view>
								<view class="fui-pro-price">
									<text class="fui-sale-price">
										<iconfont className="icon-jifen" size="20">
											<text class="padding-left-xs">{{ item.goods_integral }}</text>
										</iconfont>
									</text>
									<text class="text-gray text-sm">市场价:￥{{ item.goods_price }}</text>
								</view>
								<view class="fui-pro-pay">{{ item.sales_actual }}人兑换</view>
							</view>
						</view>
					</view>
					<!--商品列表-->
				</view>
			</view>
		</view>

		<!--list-->


		<!--加载loadding-->
		<fui-loadmore v-if="loadding" :index="3" type="red"></fui-loadmore>
		<fui-nomore v-if="!pullUpOn && isList" backgroundColor="#f7f7f7"></fui-nomore>
		<!--加载loadding-->
	</view>
</template>

<script>
export default {
	data() {
		return {
			slide:[],
			keywords:'',
			page:1,
			pageSize:20,
			category_pid:0,
			category_id:0,
			label:0,
			goodsList:[],
			category:[],
			goods_price:'',//价格排序
			sales_initial:'',//销量排序
			width: 200, //header宽度
			height: 64, //header高度
			inputTop: 0, //搜索框距离顶部距离
			arrowTop: 0, //箭头距离顶部距离
			dropScreenH: 0, //下拉筛选框距顶部距离
			attrData: [],
			attrIndex: -1,
			dropScreenShow: false,
			scrollTop: 0,
			tabIndex: 0, //顶部筛选索引
			isList: false, //是否以列表展示  | 列表或大图
			drawer: false,
			drawerH: 0, //抽屉内部scrollview高度
			selectedName: '综合',
			selectH: 0,
			dropdownList: [
				{
					name: '综合',
					selected: true
				},
				{
					name: '价格升序',
					selected: false
				},
				{
					name: '价格降序',
					selected: false
				}
			],
			productList: [],
			pageIndex: 1,
			loadding: false,
			pullUpOn: true
		};
	},
	onLoad: function(options) {
		let that = this
		this.label        = that.$Route.query.label || '';
		this.category_id  = that.$Route.query.category_id || '';
		this.category_pid = that.$Route.query.category_pid || '';
		let obj = {};
		// #ifdef MP-WEIXIN
		obj = wx.getMenuButtonBoundingClientRect();
		// #endif
		// #ifdef MP-BAIDU
		obj = swan.getMenuButtonBoundingClientRect();
		// #endif
		// #ifdef MP-ALIPAY
		my.hideAddToDesktopMenu();
		// #endif
		uni.getSystemInfo({
			success: res => {
				this.width = obj.left || res.windowWidth;
				this.height = obj.top ? obj.top + obj.height + 8 : res.statusBarHeight + 44;
				this.inputTop = obj.top ? obj.top + (obj.height - 30) / 2 : res.statusBarHeight + 7;
				this.arrowTop = obj.top ? obj.top + (obj.height - 32) / 2 : res.statusBarHeight + 11;
				console.log(this.height,res.windowWidth)
				//略小，避免误差带来的影响
				this.dropScreenH = (this.height * 750) / res.windowWidth + 10;
				this.drawerH = res.windowHeight - uni.upx2px(100) - this.height;
			}
		});
		that.initPage();
	},
	methods: {
		initPage(){
			let that = this
			that.searchGoods();
			that.getcate()
			that.getslide()
		},
		moreList:function(e){
			let that = this
		    let category_id = e.currentTarget.dataset.category_id || ''; 
			that.category_pid = category_id
			console.log(category_id)
			that.searchGoods()
		},
		getcate(){
			this.fui.request("diandi_integral/category/list","GET",{}).then((res)=>{
				console.log(res)
				if (res.code == 200) {
					this.category = res.data
				} else {
					this.fui.toast(res.message);
				}
			}).catch((res)=>{})
		},
		getslide(){
			this.fui.request("diandi_integral/goods/getslide","GET",{}).then((res)=>{
				console.log(res)
				if (res.code == 200) {
					this.slide = res.data
				} else {
					this.fui.toast(res.message);
				}
			}).catch((res)=>{})
		},
		px(num) {
			return uni.upx2px(num) + 'px';
		},
		searchGoods(){
			let that = this;
			let keywords = that.keywords
			let page =  that.page
			let pageSize = that.pageSize
			
			that.fui.request("diandi_integral/goods/lists","GET",{
				page:page,
				pageSize:pageSize,
				keywords:keywords,
				goods_price:that.goods_price,
				sales_initial:that.sales_initial,
				category_id:that.category_id,
				category_pid:that.category_pid,
				label_id:this.label
			}).then((res)=>{
				console.log(res)
				if (res.code == 200) {
					let goodsList = res.data;
					if(goodsList.length>0){
						that.isShowKeywordList = true;
					}else{
						that.fui.toast('暂无有关的商品，请重新搜索')
					}
					
					if(goodsList.length == pageSize){
						that.goodsList = that.goodsList.concat(goodsList) 
						that.page++
						that.loadding = true
					}else{
						that.goodsList = goodsList
						that.loadding = false
					}
				} else {
					that.fui.toast(res.message);
				}
			}).catch((res)=>{
				console.log("错误le ma ",res);
			})
		},
		btnDropChange: function(e) {
			let index = e.currentTarget.dataset.index;
			let arr = JSON.parse(JSON.stringify(this.attrArr[index].list));
			if (arr.length === 0) {
				this.btnCloseDrop();
				this.$set(this.attrArr[index], 'isActive', !this.attrArr[index].isActive);
			} else {
				this.attrData = arr;
				this.attrIndex = index;
				this.dropScreenShow = true;
				this.$set(this.attrArr[index], 'isActive', false);
				this.scrollTop = 1;
				this.$nextTick(() => {
					this.scrollTop = 0;
				});
			}
		},
		btnSelected: function(e) {
			let index = e.currentTarget.dataset.index;
			this.$set(this.attrData[index], 'selected', !this.attrData[index].selected);
		},
		reset() {
			let arr = this.attrData;
			for (let item of arr) {
				item.selected = false;
			}
			this.attrData = arr;
		},
		btnCloseDrop() {
			this.scrollTop = 1;
			this.$nextTick(() => {
				this.scrollTop = 0;
			});
			this.dropScreenShow = false;
			this.attrIndex = -1;
		},
		btnSure: function() {
			let index = this.attrIndex;
			let arr = this.attrData;
			let active = false;
			let attrName = '';
			//这里只是为了展示选中效果,并非实际场景
			for (let item of arr) {
				if (item.selected) {
					active = true;
					attrName += attrName ? ';' + item.name : item.name;
				}
			}
			let obj = this.attrArr[index];
			this.btnCloseDrop();
			this.$set(obj, 'isActive', active);
			this.$set(obj, 'selectedName', attrName);
		},
		showDropdownList: function() {
			this.selectH = 246;
			this.tabIndex = 0;
		},
		hideDropdownList: function() {
			this.selectH = 0;
		},
		dropdownItem: function(e) {
			let index = e.currentTarget.dataset.index;
			let arr = this.dropdownList;
			for (let i = 0; i < arr.length; i++) {
				if (i === index) {
					arr[i].selected = true;
				} else {
					arr[i].selected = false;
				}
			}
			let  sort =['','asc','desc'];
			this.goods_price=sort[index]//价格排序
			
			this.dropdownList = arr;
			this.selectedName = index == 0 ? '综合' : '价格';
			this.selectH = 0;
			this.searchGoods();
		},
		screen: function(e) {
			let index = e.currentTarget.dataset.index;
			this.hideDropdownList();
			this.btnCloseDrop();
			if (index == 0) {
				this.showDropdownList();
			} else if (index == 1) {
				this.sales_initial ='desc'
				this.tabIndex = 1;
			} else if (index == 2) {
				this.isList = !this.isList;
			} else if (index == 3) {
				this.drawer = true;
			}
			this.searchGoods();
		},
		closeDrawer: function() {
			this.drawer = false;
		},
		back: function() {
			if (this.drawer) {
				this.closeDrawer();
			} else {
				this.$Router.back(1)
			}
		},
		search: function() {
			uni.navigateTo({
				url: '../../news/search/search'
			});
		},
		detail: function(event) {
			let that = this
			let goods_id = event.currentTarget.dataset.goods_id
			let goods_type = event.currentTarget.dataset.goods_type
			console.log('商品idsss',goods_id)
			that.$Router.push({ name: 'integralDetail', params: { goods_id:goods_id ,goods_type:goods_type}})
		}
	},
	onReachBottom() {
		//只是测试效果，逻辑以实际数据为准
		let that = this
		this.pullUpOn = true
		if(this.loadding){
			setTimeout(() => {
				this.loadding = false
				this.pullUpOn = false
				that.searchGoods()
			}, 1000)
		}
	},
};
</script>

<style>
page {
	background-color: #f7f7f7;
}


.fui-banner-box {
	width: 100%;
	box-sizing: border-box;
	margin-top:5.1rpx;
	/* overflow: hidden; */
	z-index: 99;
	bottom: -80rpx;
	left: 0;
}

.fui-banner-swiper {
	width: 100%;
	height: 306.12rpx;
	overflow: hidden;
	transform: translateY(0);
}

.tower-swiper .tower-item {
	transform: scale(calc(0.5 + var(--index) / 10));
	margin-left: calc(var(--left) * 100upx - 150upx);
	z-index: var(--index);
}

.container {
	padding-bottom: env(safe-area-inset-bottom);
}

/* 隐藏scroll-view滚动条*/

::-webkit-scrollbar {
	width: 0;
	height: 0;
	color: transparent;
}

.fui-header-box {
	width: 100%;
	background: #fff;
	position: fixed;
	z-index: 99998;
	left: 0;
	top: 0;
}

.index-top{
    background:#218569;
}

.fui-header {
	display: flex;
	align-items: flex-start;
}

.fui-back {
	margin-left: 8rpx;
	height: 32px !important;
	width: 32px !important;
}

.fui-searchbox {
	width: 100%;
	height: 30px;
	margin-right: 30rpx;
	border-radius: 15px;
	font-size: 12px;
	background: #f7f7f7;
	padding: 3px 10px;
	box-sizing: border-box;
	color: #999;
	display: flex;
	align-items: center;
	overflow: hidden;
}

/* #ifdef MP */
.fui-search-mr {
	margin-right: 20rpx !important;
}
/* #endif */

.fui-search-text {
	padding-left: 16rpx;
}

.fui-search-key {
	max-width: 80%;
	height: 100%;
	padding: 0 16rpx;
	margin-left: 12rpx;
	display: flex;
	align-items: center;
	border-radius: 15px;
	background: rgba(0, 0, 0, 0.5);
	color: #fff;
}

.fui-key-text {
	box-sizing: border-box;
	padding-right: 12rpx;
	font-size: 12px;
	line-height: 12px;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}

/*screen*/

.fui-header-screen {
	width: 100%;
	box-sizing: border-box;
	background: #fff;
}

.fui-screen-top,
.fui-screen-bottom {
	display: flex;
	align-items: center;
	justify-content: space-between;
	font-size: 28rpx;
	color: #333;
}

.fui-screen-top {
	height: 88rpx;
	position: relative;
	background: #fff;
}

.fui-top-item {
	height: 28rpx;
	line-height: 28rpx;
	flex: 1;
	display: flex;
	align-items: center;
	justify-content: center;
}

.fui-topitem-active {
	color: #e41f19;
}

.fui-screen-bottom {
	height: 100rpx;
	padding: 0 30rpx;
	box-sizing: border-box;
	font-size: 24rpx;
	align-items: center;
	overflow: hidden;
}

.fui-bottom-text {
	line-height: 26rpx;
	max-width: 82%;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}

.fui-bottom-item {
	flex: 1;
	width: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 0 12rpx;
	box-sizing: border-box;
	background-color: #f7f7f7;
	margin-right: 20rpx;
	white-space: nowrap;
	height: 60rpx;
	border-radius: 40rpx;
}

.fui-bottom-item:last-child {
	margin-right: 0;
}

.fui-btmItem-active {
	background-color: #fcedea !important;
	color: #e41f19;
	font-weight: bold;
	position: relative;
}

.fui-btmItem-active::after {
	content: '';
	position: absolute;
	border: 1rpx solid #e41f19;
	width: 100%;
	height: 100%;
	border-radius: 40rpx;
	left: 0;
	top: 0;
}

.fui-btmItem-tap {
	position: relative;
	border-bottom-left-radius: 0;
	border-bottom-right-radius: 0;
}

.fui-btmItem-tap::after {
	content: '';
	position: absolute;
	width: 100%;
	height: 22rpx;
	background: #f7f7f7;
	left: 0;
	top: 58rpx;
}

.fui-bold {
	font-weight: bold;
}

.fui-active {
	color:#218569 ;
}

.fui-addr-left {
	padding-left: 6rpx;
}

.fui-seizeaseat-20 {
	height: 20rpx;
}

.fui-seizeaseat-30 {
	height: 30rpx;
}

/*screen*/

/*顶部下拉选择 属性*/

.fui-scroll-box {
	width: 100%;
	height: 480rpx;
	box-sizing: border-box;
	position: relative;
	z-index: 99;
	color: #fff;
	font-size: 30rpx;
	word-break: break-all;
}

.fui-drop-item {
	color: #333;
	height: 80rpx;
	font-size: 28rpx;
	padding: 20rpx 40rpx 20rpx 40rpx;
	box-sizing: border-box;
	display: inline-block;
	width: 50%;
}

.fui-drop-btnbox {
	width: 100%;
	height: 100rpx;
	position: absolute;
	left: 0;
	bottom: 0;
	box-sizing: border-box;
	display: flex;
}

.fui-drop-btn {
	width: 50%;
	font-size: 32rpx;
	text-align: center;
	height: 100rpx;
	line-height: 100rpx;
	border: 0;
}

.fui-btn-red {
	background: #e41f19;
	color: #fff;
}

.fui-red-hover {
	background: #c51a15 !important;
	color: #e5e5e5;
}

.fui-btn-white {
	background: #fff;
	color: #333;
}

.fui-white-hover {
	background: #e5e5e5;
	color: #2e2e2e;
}

/*顶部下拉选择 属性*/

/*顶部下拉选择 综合*/

.fui-dropdownlist {
	width: 100%;
	position: absolute;
	background-color: #fff;
	border-bottom-left-radius: 24rpx;
	border-bottom-right-radius: 24rpx;
	overflow: hidden;
	box-sizing: border-box;
	padding-top: 10rpx;
	padding-bottom: 26rpx;
	left: 0;
	top: 88rpx;
	visibility: hidden;
	transition: all 0.2s ease-in-out;
	z-index: 999;
}

.fui-dropdownlist-show {
	visibility: visible;
}

.fui-dropdownlist-mask {
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: rgba(0, 0, 0, 0.6);
	z-index: -1;
	transition: all 0.2s ease-in-out;
	opacity: 0;
	visibility: hidden;
}

.fui-mask-show {
	opacity: 1;
	visibility: visible;
}

.fui-dropdownlist-item {
	color: #333;
	height: 70rpx;
	font-size: 28rpx;
	padding: 0 40rpx;
	box-sizing: border-box;
	display: flex;
	align-items: center;
	justify-content: space-between;
}

/*顶部下拉选择 综合*/

.fui-drawer-box {
	width: 686rpx;
	font-size: 24rpx;
	overflow: hidden;
	position: relative;
	padding-bottom: 100rpx;
}

.fui-drawer-title {
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding: 0 30rpx;
	box-sizing: border-box;
	height: 80rpx;
}

.fui-title-bold {
	font-size: 26rpx;
	font-weight: bold;
	flex-shrink: 0;
}

.fui-location {
	margin-right: 6rpx;
}

.fui-attr-right {
	width: 70%;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
	text-align: right;
}

.fui-all-box {
	width: 90%;
	white-space: nowrap;
	display: flex;
	align-items: center;
	justify-content: flex-end;
}

.fui-drawer-content {
	padding: 16rpx 30rpx 30rpx 30rpx;
	display: flex;
	align-items: center;
	justify-content: space-between;
	box-sizing: border-box;
}

.fui-input {
	border: 0;
	height: 64rpx;
	border-radius: 32rpx;
	width: 45%;
	background-color: #f7f7f7;
	text-align: center;
	font-size: 24rpx;
	color: #333;
}

.fui-phcolor {
	text-align: center;
	color: #b2b2b2;
	font-size: 24rpx;
}

.fui-flex-attr {
	flex-wrap: wrap;
	justify-content: flex-start;
}
.screen-swiper{
	margin-top: 10.2rpx;
}
.fui-attr-item {
	width: 30%;
	height: 64rpx;
	background-color: #f7f7f7;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 0 4rpx;
	box-sizing: border-box;
	border-radius: 32rpx;
	margin-right: 5%;
	margin-bottom: 5%;
}

.fui-attr-ellipsis {
	white-space: nowrap;
	text-overflow: ellipsis;
	overflow: hidden;
	width: 96%;
	text-align: center;
}

.fui-attr-item:nth-of-type(3n) {
	margin-right: 0%;
}

.fui-attr-btnbox {
	width: 100%;
	position: absolute;
	left: 0;
	bottom: 0;
	box-sizing: border-box;
	padding: 0 30rpx;
	background: #fff;
}

.fui-attr-safearea {
	height: 100rpx;
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding-bottom: env(safe-area-inset-bottom);
}

.fui-safearea-bottom {
	width: 100%;
	height: env(safe-area-inset-bottom);
}

.fui-attr-btnbox::before {
	content: '';
	position: absolute;
	top: 0;
	right: 0;
	left: 0;
	border-top: 1px solid #eaeef1;
	transform: scaleY(0.5) translateZ(0);
	transform-origin: 0 0;
}

.fui-drawer-btn {
	width: 47%;
	text-align: center;
	height: 60rpx;
	border-radius: 30rpx;
	flex-shrink: 0;
	display: flex;
	align-items: center;
	justify-content: center;
	box-sizing: border-box;
}

.fui-drawerbtn-black {
	border: 1rpx solid #555;
}

.fui-drawerbtn-primary {
	background: #e41f19;
	color: #fff;
}

/* 商品列表*/

.fui-product-list {
	display: flex;
	justify-content: space-between;
	flex-direction: row;
	flex-wrap: wrap;
	box-sizing: border-box;
}

.fui-product-container {
	display:flex;
	flex-wrap: wrap;
	width:700.16rpx;
	margin: 20.4rpx auto;
}

.fui-product-container:last-child {
	margin-right: 0;
}

.fui-pro-item {
	width: 100%;
	margin-bottom: 10rpx;
	background: #fff;
	box-sizing: border-box;
	border-radius: 12rpx;
	overflow: hidden;
	transition: all 0.15s ease-in-out;
}

.fui-flex-list {
	display: flex;
	/* margin-bottom: 1rpx !important; */
}

.fui-pro-img {
	width: 100%;
	display: block;
}

.fui-product-category {
	background-color: #fff;
	padding: 20rpx 20rpx 30rpx 20rpx;
	box-sizing: border-box;
	display: flex;
	align-items: center;
	/* justify-content: space-between; */
	flex-wrap: wrap;
	font-size: 24rpx;
	color: #555;
}

.fui-category-item {
	width: 20%;
	height: 118rpx;
	display: flex;
	align-items: center;
	justify-content: space-between;
	flex-direction: column;
	padding-top: 30rpx;
}

.fui-category-img {
	height: 80rpx;
	width: 80rpx;
	border-radius: 10.2rpx;
	display: block;
}

.fui-category-name {
	line-height: 24rpx;
}

.fui-proimg-list {
	width: 260rpx;
	height: 260rpx !important;
	flex-shrink: 0;
	border-radius: 12rpx;
}

.fui-pro-content {
	display: flex;
	flex-direction: column;
	justify-content: space-between;
	box-sizing: border-box;
	padding: 20rpx;
}

.fui-pro-tit {
	color: #2e2e2e;
	font-size: 26rpx;
	word-break: break-all;
	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-webkit-line-clamp: 2;
}

.fui-pro-price {
	padding-top: 18rpx;
}

.fui-sale-price {
	font-size: 34rpx;
	font-weight: 500;
	color: #e41f19;
}

.fui-factory-price {
	font-size: 24rpx;
	color: #a0a0a0;
	text-decoration: line-through;
	padding-left: 12rpx;
}

.fui-pro-pay {
	padding-top: 10rpx;
	font-size: 24rpx;
	color: #656565;
}

/* 商品列表*/
</style>

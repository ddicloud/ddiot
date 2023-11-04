<template>
	<view>
		<!-- 单行显示 -->

		<view class="fui-product-container fui-skeleton-rect margin-top-xs" v-if="tyleNum==1">
			<!--商品列表-->
			<!--list-->
			<view class="fui-product-list bg-white">
				<view class="fui-product-container fui-skeleton-rect">

					<view class="fui-flex-box solids-bottom" v-for="(item, index) in list" :key="index"
						:data-goods_id="item.goods_id" :data-goods_type="item.goods.goods_type" @tap="detail($event)">
						<view class="fui-flex">
							<view class="fui-center  fui-col-4">
								<view class="fui-proimg-list">
									
									<fui-loadimage mode="widthFix"
									:data-goods_id="item.goods.goods_id" :view-height="height"
										:data-goods_type="item.goods.goods_type" :src="item.goods.thumb"
										@tap="detail($event)" class="fui-pro-img  fui-skeleton-rect"
										
										:scroll-top="scrollTop" loadingMode="spin-circle"
										:image-src="item.goods.thumb" ></fui-loadimage>
									

								</view>
							</view>
							<view class="fui-col-8">
								<view class="fui-pro-content fui-skeleton-rect">
									<view class="fui-pro-tit fui-skeleton-rect">{{ item.goods.goods_name }}</view>
									<view>
										<view class="fui-pro-price fui-skeleton-rect">
											<text
												class="fui-factory-price fui-skeleton-rect">￥{{ item.goods.line_price }}</text>
											<text
												class="fui-sale-price fui-skeleton-rect">￥{{ item.goods.goods_price }}</text>
										</view>
										<view class="fui-pro-pay fui-skeleton-rect">{{ item.goods.sales_initial }}人付款
										</view>
									</view>
								</view>
							</view>

						</view>
					</view>
				</view>
			</view>
		</view>


		<!-- 一行两个 -->
		<view class="fui-product-list fui-skeleton-rec" v-if="tyleNum==2">
			<view class="fui-product-container fui-skeleton-rec">
				<fui-grid v-for="(items,index) in list" :key="index">
					<block v-for="(item,key) in items" :key="key">
						<fui-grid-item :cell="2" >
							<view class="fui-pro-item fui-skeleton-rec" hover-class="hover" :hover-start-time="150"
								:data-goods_id="item.goods_id" :data-goods_type="item.goods.goods_type"
								@tap="detail($event)">
								<!-- <image :src="item.goods.label_img" class="fui-new-label goods-img" v-if="item.goods.label !=''"></image> -->
								 <fui-loadimage mode="widthFix"
												:scroll-top="scrollTop" loadingMode="spin-circle"
												:image-src="item.goods.thumb" ></fui-loadimage>
												
								<view class="fui-pro-content">
									<view class="fui-pro-tit fui-skeleton-rect">{{ item.goods.goods_name }}</view>
									<view>
										<view class="fui-pro-price fui-skeleton-rec">
											<text
												class="fui-factory-price fui-skeleton-rect">￥{{ item.goods.line_price }}</text>
											<text
												class="fui-sale-price fui-skeleton-rect ">￥{{ item.goods.goods_price }}</text>
										</view>
										<view class="fui-pro-pay fui-skeleton-rect">{{ item.goods.sales_initial}}人付款
										</view>
									</view>
								</view>
							</view>
						</fui-grid-item>
					</block>
				</fui-grid>
			</view>
		</view>

		<!-- 一行显示两个迷你模式 -->
		<view class="fui-new-box fui-skeleton-rec" v-if="tyleNum==3">
			<block v-for="(items, index) in list" :key="index">
				<view class="fui-new-item margin-bottom-xs fui-skeleton-rec"
					:class="[index != 0 && index != 1 ? 'fui-new-mtop' : '']" 
					:data-goods_id="item.goods_id"
					:data-goods_type="item.goods.goods_type" @tap="detail($event)" 
					v-for="(item, key) in items" :key="key">

					<fui-loadimage class="fui-new-img fui-skeleton-rec padding-right-sm" mode="widthFix"
						:scroll-top="scrollTop" loadingMode="spin-circle"
						:image-src="item.goods.thumb" ></fui-loadimage>
						

					<view class="fui-title-box fui-col-7">
						<view class="fui-new-title fui-skeleton-rect">{{ item.goods.goods_name }}</view>
						<view class="fui-new-price fui-skeleton-rect">
							<text class="fui-new-original ">￥{{ item.goods.line_price}}</text>
						</view>
						<view class="fui-new-price fui-skeleton-rect">
							<text class="fui-new-present">￥{{item.goods.goods_price }}</text>
						</view>
					</view>

				</view>
			</block>

		</view>

		<!-- 单图片模式 -->
		<view class="fui-activity-box fui-skeleton-rect bg-white" v-if="tyleNum==4">
			<view class="one-img-box solid-bottom" v-for="(item, index) in list" :key="index"
				:data-goods_id="item.goods_id" :data-goods_type="item.goods.goods_type" @tap="detail($event)">
				<view class="fui-center  margin-bottom-xs">
					<fui-loadimage class="one-img fui-skeleton-rec"  mode="widthFix"
						:scroll-top="scrollTop" loadingMode="spin-circle"
						:image-src="item.goods.thumb" ></fui-loadimage>
				</view>
			</view>
		</view>

		<!-- 一行显示两图模式 -->
		<view class="fui-activity-box fui-skeleton-rec" v-if="tyleNum==5">
			<fui-grid v-for="(items,index) in list" :key="index">
				<block v-for="(item,key) in items" :key="key">
					<fui-grid-item :cell="2" >
						<view class="fui-grid-icon fui-skeleton-rec">
							<!-- <image :src="item.goods.label_img" class="fui-new-label goods-img" v-if="item.goods.label !=''"></image> -->
							
							<fui-loadimage :data-goods_id="item.goods.goods_id" :data-goods_type="item.goods.goods_type"
									:src="item.goods.thumb" @tap="detail($event)" 
									class="fui-pro-img fui-skeleton-rect goods-img"  mode="widthFix"
								:scroll-top="scrollTop" loadingMode="spin-circle"
								:image-src="item.goods.thumb" ></fui-loadimage>
							
						</view>
						<!-- <text class="fui-grid-label">{{item.name}}</text> -->
					</fui-grid-item>
				</block>
			</fui-grid>
		</view>

		<!-- 一行三个 -->
		<view class="fui-product-list fui-skeleton-rec" v-if="tyleNum==6">
			<view class="fui-product-container fui-skeleton-rec">
				<fui-grid v-for="(items,index) in list" :key="index">
					<block v-for="(item,key) in items" :key="key">
						<fui-grid-item :cell="3">
							<view class="fui-pro-item fui-skeleton-rec" hover-class="hover" 
								:hover-start-time="150" :data-goods_id="item.goods_id"
								:data-goods_type="item.goods.goods_type" @tap="detail($event)">
								<!-- <image :src="item.goods.label_img" class="fui-new-label goods-img" v-if="item.goods.label !=''"></image> -->
								
								<fui-loadimage class="fui-pro-img fui-skeleton-rect goods-img fui-skeleton-rec"  mode="widthFix"
									:scroll-top="scrollTop" loadingMode="spin-circle"
									:image-src="item.goods.thumb" ></fui-loadimage>
									
								<view class="fui-pro-content">
									<view class="fui-pro-tit fui-skeleton-rect">{{ item.goods.goods_name }}</view>
									<view>
										<view class="fui-pro-price fui-skeleton-rec">
											<text
												class="fui-sale-price fui-skeleton-rect ">￥{{ item.goods.goods_price }}</text>
										</view>
										<view class="fui-pro-pay fui-skeleton-rect">
											<text
												class="fui-factory-price-cell fui-skeleton-rect">￥{{ item.goods.line_price }}</text>
										</view>
									</view>
								</view>
							</view>
						</fui-grid-item>
					</block>
				</fui-grid>
			</view>
		</view>


	</view>
</template>

<script>
	export default {
		name: 'goods-list',
		data() {
			return {
				skeletonShow: true
			};
		},
		props: {
			lazyLoad: {
				type: Boolean,
				default: true
			},
			list: {
				type: Array,
				default: function() {
					return [];
				}
			},
			tyleNum: {
				type: Number,
				default: function() {
					return 1;
				}
			},
			height: {
				type: Number,
				default: function() {
					return 1;
				}
			},
			scrollTop: {
				type: Number,
				default: function() {
					return 0;
				}
			}
		},
		created() {
			let that = this;
		},
		mounted(){
			
		},
		methods: {
			detail: function(e) {
				let that = this
				console.log(e)
				let goods_id = e.currentTarget.dataset.goods_id

				let goods_type = e.currentTarget.dataset.goods_type

				that.$Router.push({
					name: 'productDetail',
					params: {
						goods_id: goods_id,
						goods_type: goods_type
					}
				})
			}
		}
	}
</script>

<style scoped>
	/* 懒加载css */
	.list{display: flex;justify-content: space-between;flex-wrap: wrap;padding: 32rpx;background: #F1F1F1;}
	.list .item{width: 48%;background: #fff;margin-bottom: 80rpx;border-radius: 20rpx;}
	.list .item >>> .easy-loadimage{
		width: 100%;
		/* height: 500rpx; */
		margin-bottom: 38rpx;
	}
	.list .item >>> .origin-img{
		border-radius: 20rpx;
	}
	/* mode为widthFix即图片高度自适应时要设置占位图默认高度 */
	.list .item >>> .loadfail-img,.list .item >>>.loading-img{
		height: 500rpx;
	}
	/* 懒加载css */
	.fui-flex-list {
		display: flex;
	}

	.fui-product-list {
		display: flex;
		justify-content: space-between;
		flex-direction: row;
		flex-wrap: wrap;
		box-sizing: border-box;
		/* padding-top: 20rpx; */
	}

	.fui-proimg-list {
		width: 100%;
		padding: 10px;
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

	.fui-product-container {
		flex: 1;
	}

	.solid-bottom::after {
		border-bottom: 1upx solid rgba(0, 0, 0, .1)
	}

	.fui-factory-price-cell {
		font-size: 11px;
		color: #a0a0a0;
		text-decoration: line-through;
	}

	.fui-product-container:last-child {
		margin-right: 0;
	}

	.one-img-box {
		width: 100%;
		display: block;
	}

	.one-img {
		border-radius: 5rpx;
	}

	.fui-pro-item {
		box-sizing: border-box;
		position: relative;
	}

	.fui-pro-img {
		width: 100%;
		display: block;
	}

	.fui-pro-content {
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		box-sizing: border-box;
		padding: 20rpx;
	}

	.fui-new-box {
		display: flex;
		align-items: center;
		justify-content: space-between;
		flex-wrap: wrap;
	}

	.fui-new-item {
		width: 49%;
		height: 200rpx;
		padding: 0 20rpx;
		box-sizing: border-box;
		display: flex;
		align-items: center;
		background: #f5f2f9;
		position: relative;
		border-radius: 12rpx;
	}

	.fui-new-mtop {
		margin-top: 2%;
	}

	.fui-title-box {
		font-size: 24rpx;
	}

	.fui-new-title {
		line-height: 32rpx;
		word-break: break-all;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 2;
	}

	.fui-new-price {
		padding-top: 18rpx;
	}

	.fui-new-present {
		color: #ff201f;
		font-weight: bold;
	}

	.fui-new-original {
		display: inline-block;
		color: #a0a0a0;
		text-decoration: line-through;
		padding-left: 12rpx;
		transform: scale(0.8);
		transform-origin: center center;
	}

	.fui-new-img {
		width: 160rpx;
		height: 160rpx;
		display: block;
		flex-shrink: 0;
	}

	.fui-new-label {
		width: 56rpx;
		height: 56rpx;
		border-top-left-radius: 12rpx;
		position: absolute;
		left: 0;
		top: 0;
		z-index: 1;
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

	.goods-img {
		border-radius: 5rpx;
	}

	img[lazy=loading] {}

	img[lazy=error] {}

	img[lazy=loaded] {}
</style>

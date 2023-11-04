<template>
	<!-- 今日必拼 -->
	<view class="group-goods pa20 mx20 mb10" v-if="goodsList.length">
		<view class="goods-box swiper-box x-f">
			<swiper class="carousel" circular @change="swiperChange" :autoplay="true" duration="2000">
				<swiper-item v-for="(goods, index) in goodsList" :key="index" class="carousel-item">
					<view class="goods-list-box x-f">
						<block v-for="(mgoods,indexs) in goods" :key="mgoods.id">
							<fui-grid-item :cell="4" >
								<fire-activity-goods :detail="mgoods" class="goods-item">
									<!-- <block slot="titleText">立减￥8.5</block> -->
								</fire-activity-goods>
							</fui-grid-item>
						</block>
					</view>
				</swiper-item>
			</swiper>
			<view class="swiper-dots" v-if="goodsList.length > 1">
				<text :class="swiperCurrent === index ? 'dot-active' : 'dot'" v-for="(dot, index) in goodsList.length" :key="index"></text>
			</view>
		</view>
	</view>
</template>

<script>
/**
 * 自定义之拼团卡片
 * @property {Object} detail - 拼团商品信息
 */
import fireActivityGoods from './fire-activity-goods.vue';
export default {
	name: 'fireGroupon',
	components: {
		fireActivityGoods
	},
	data() {
		return {
			goodsList: [],
			swiperCurrent: 0
		};
	},
	props: {
		detail: {}
	},
	computed: {},
	created() {
		this.getGoodsList();
	},
	methods: {
		swiperChange(e) {
			this.swiperCurrent = e.detail.current;
		},
		// 数据分层
		sortData(oArr, length) {
			let arr = [];
			let minArr = [];
			oArr.forEach(c => {
				if (minArr.length === length) {
					minArr = [];
				}
				if (minArr.length === 0) {
					arr.push(minArr);
				}
				minArr.push(c);
			});

			return arr;
		},
		jump(path, parmas) {
			this.$Router.push({
				path: path,
				query: parmas
			});
		},
		// 获取拼团商品
		getGoodsList() {
			let that = this;
			that.fui.request("/diandi_tuan/goods/adv","POST",{
				activity_id: that.detail.id
			},false).then((res)=>{
				console.log(res)
				if (res.code == 200) {
					console.log('拼团商品',res.data)		
					
					that.goodsList = res.data;
					console.log(res)
				} 
				// else {
				
				// 	this.fui.toast(res.message);
				// }
			}).catch((res)=>{})
		
		}
	}
};
</script>

<style lang="scss">
.swiper-box,
.carousel {
	width: 700rpx;
	height: 240upx;
	position: relative;
	border-radius: 20rpx;

	.carousel-item {
		width: 100%;
		height: 100%;
		// padding: 0 28upx;
		overflow: hidden;
	}

	.swiper-image {
		width: 100%;
		height: 100%;
		// border-radius: 10upx;
		background: #ccc;
	}
}

.swiper-dots {
	display: flex;
	position: absolute;
	left: 50%;
	transform: translateX(-50%);
	bottom: 0rpx;
	z-index: 66;

	.dot {
		width: 45rpx;
		height: 3rpx;
		background: #eee;
		border-radius: 50%;
		margin-right: 10rpx;
	}

	.dot-active {
		width: 45rpx;
		height: 3rpx;
		background: #a8700d;
		border-radius: 50%;
		margin-right: 10rpx;
	}
}
// 今日必拼+限时抢购
.group-goods {
	background: #fff;
	border-radius: 20rpx;
	overflow: hidden;
	.title-box {
		padding-bottom: 20rpx;

		.title {
			font-size: 32rpx;
			font-weight: bold;
		}

		.group-people {
			.time-box {
				font-size: 26rpx;
				color: #edbf62;
				.count-text-box {
					width: 30rpx;
					height: 34rpx;
					background: #edbf62;
					text-align: center;
					line-height: 34rpx;
					font-size: 24rpx;
					border-radius: 6rpx;
					color: rgba(#fff, 0.9);
					margin: 0 8rpx;
				}
			}

			.head-box {
				.head-img {
					width: 40rpx;
					height: 40rpx;
					border-radius: 50%;
					background: #ccc;
				}
			}

			.tip {
				font-size: 28rpx;
				padding-left: 30rpx;
				color: #666;
			}

			.cuIcon-right {
				font-size: 30rpx;
				line-height: 28rpx;
				color: #666;
			}
		}
	}

	.goods-box {
		.goods-item {
			margin-right: 22rpx;
			&:nth-child(4n) {
				margin-right: 0;
			}
		}
	}
}
</style>

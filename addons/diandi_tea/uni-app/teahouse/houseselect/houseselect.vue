<template>
	<view class="container">
		<view class=" house-detail-list">
			<view class="house-detail margin-bottom_20 margin-lr-sm fui-shadow-gray" v-for="(item, index) in houseList" :key="index" @click="predetermine(item)">
				<image class="house-image" :src="item.picture" mode=" aspectFit"></image>
				<view class="fui-flex margin-left-24 padding-top-sm">
					<view class="margin-left-xs color3 fui-font-size_20">
						<text class="fui-font-size_32 color">{{ item.name }}</text>
					</view>
				</view>
				<view class="margin-top10 margin-bottom_20 margin-left-24 color4 fui-font-size_24">
					<view class="fui-flex">
						<view class="fui-col-4">
							<text class="margin-left-xs color3 fui-font-size_20">可容纳 {{ item.max_num }}人</text>
						</view>
						<view class="fui-col-4 margin-left-xs">
							月销
							<text class="margin-left-xs">{{ item.month_num }}</text>
						</view>
						<view class="fui-col-4">
							<view class="margin-left-xs color3 fui-font-size_20">
								服务:
								<fui-rate current="5" size="15" :disabled="true" normal="#ccc" active="#ff7900"></fui-rate>
							</view>
						</view>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			houseList: [],
			color: ''
		};
	},
	onShow() {
		this.getImage();
	},
	methods: {
		getImage() {
			let that = this;
			that.fui
				.request('diandi_tea/index/top', 'GET', {}, false)
				.then(res => {
					if (res.code === 200) {
						console.log(res);
						that.houseList = res.data.list.hourse_list;
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
		predetermine(item) {
			let that = this;
			uni.navigateTo({
				url: '/teahouse/predetermine/predetermine?id=' + item.id
			});
			// that.$Router.push({
			// 	name: 'predetermine',
			// 	params:{
			// 		id:item.id
			// 	}
			// });
		}
	}
};
</script>

<style>
.house-detail-list {
	display: flex;
	flex-wrap: wrap;
	width: 740rpx;
	margin: 20rpx auto;
}
.house-detail {
	box-shadow: 0px 7rpx 20rpx 0px rgba(229, 234, 224, 1);
	background-color: rgba(255, 255, 255, 1);
	border-radius: 20rpx;
	height: 460rpx;
	/* width: 325rpx; */
	width: 100%;
}
.house-image {
	height: 325rpx;
	/* width: 338rpx; */
	width: 100%;
}
.iconOne {
	margin-top: -9rpx;
	background-image: linear-gradient(180deg, #fff0ba 0%, #ffbf29 100%);
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
	font-size: 22rpx !important;
}
</style>

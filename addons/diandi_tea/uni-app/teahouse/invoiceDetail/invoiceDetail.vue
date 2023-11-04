<template>
	<view class="container">
		<view  v-if="invoicelist.length == 0"><fui-no-data :fixed="false" imgUrl="https://cdn.tuhuokeji.com/toast/img_nodata.png">暂无数据</fui-no-data></view>
		<view class="tea-reserve" v-for="(item, index) in invoicelist" :key="index">
			<view>
				<view class="tea-reserve-use fui-font-size_24 text-center" :class="item.status == 1 ? 'bag-color2' : 'bag-color1'">
					{{ item.status === 1 ? '已开票' : '未开票' }}
				</view>
				<!-- <view class="tea-reserve-time margin-left color font-weight-600">{{ item.start_time }} -{{ item.end_time.substr(10) }}</view> -->
				<view class="fui-flex margin-left margin-top12 fui-font-size_24 line-height padding-top-lg">
					<view class=" colorus margin-rig-l24 font-weight-400 justify">公司电话</view>
					<view class="line-height font-weight-600">{{ item.phone || '' }}</view>
				</view>
				<view class="fui-flex margin-left margin-top10 fui-font-size_24 line-height">
					<view class="colorus margin-rig-l24 font-weight-400 justify">公司名称</view>
					<view class="font-weight-600">{{ item.company || ''}}</view>
				</view>
				<view class="fui-flex margin-left margin-top10 fui-font-size_24 line-height">
					<view class="colorus margin-rig-l24 font-weight-400 justify">公司地址</view>
					<view class="font-weight-600">{{ item.company_address || ''}}</view>
				</view>
				<!-- <view class="fui-flex margin-left margin-top10 fui-font-size_24 line-height">
					<view class="colorus margin-rig-l24 font-weight-400 justify">社会同一代码</view>
					<view class="font-weight-600">{{ item.social_code || ''}}</view>
				</view> -->
				<view class="fui-flex margin-left margin-top10 fui-font-size_24 line-height">
					<view class="colorus margin-rig-l24 font-weight-400 justify">银行账号</view>
					<view class="font-weight-600">{{ item.bank || ''}}</view>
				</view>
				<view class="fui-flex margin-left margin-top10 fui-font-size_24 line-height">
					<view class="colorus margin-rig-l24 font-weight-400 justify">银行开户地</view>
					<view class="font-weight-600">{{ item.bank_address || ''}}</view>
				</view>
				
				<view class="fui-flex margin-left margin-top10 fui-font-size_24 line-height">
					<view class="colorus margin-rig-l24 font-weight-400 justify">纳税人识别号</view>
					<view class="font-weight-600">{{ item.taxpayer_no || ''}}</view>
				</view>
				<view class="fui-flex margin-left margin-top10 fui-font-size_24 line-height">
					<view class="colorus margin-rig-l24 font-weight-400 justify">下单时间</view>
					<view class="font-weight-600">{{ item.create_time || ''}}</view>
				</view>
				<view class="fui-flex margin-left margin-top10 fui-font-size_24 line-height">
					<view class="colorus margin-rig-l24 font-weight-400 justify">邮箱</view>
					<view class="font-weight-600">{{ item.email || ''}}</view>
				</view>
				<view class="fui-flex margin-left margin-top10 fui-font-size_24 line-height padding-bottom-lg">
					<view class="colorus margin-rig-l24 font-weight-400 justify">发票图片</view>
					<!-- <view class="font-weight-600">{{ item.invoice_url }}</view> -->
					<view v-if="item.status === 1" class="btn-padd fui-color-white bag-color fui-font-size_20" @click="dlogimage(item.invoice_url)">点击预览</view>
					<view v-if="item.status != 1" class="font-weight-600">暂未开票</view>
				</view>
			</view>
			<!-- 	<view class="order-btn">
				<view class="fui-flex order-btn-wz">
					<view v-if="item.status == '使用中'" @click="getRenewprice(item.id)" class="btn-padd fui-color-white bag-color border-radius-24 fui-font-size_24">
						点击续费
					</view>
					<view v-if="item.status == '已完成'" class="btn-padd fui-color-white bag-color border-radius-24 fui-font-size_24" @click="getVious(item.id)">申请开票</view>
					<view v-if="item.status == '已完成'" @click="orderDetail(item.id)" class="btn-padd border-radius-24 fui-font-size_24 margin-left-sm border1">查看详情</view>
				</view>
			</view> -->
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			invoicelist: []
		};
	},
	onShow() {
		this.getInvoicelist();
	},
	methods: {
		//获取订单
		getInvoicelist() {
			let that = this;
			that.fui
				.request('diandi_tea/order/invoicelist', 'GET', {}, true)
				.then(res => {
					if (res.code === 200) {
						that.invoicelist = res.data;
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
		dlogimage(item) {
			console.log(item);
			let that = this;
			// uni.showLoading({
			// 	title: '下载中...',
			// 	mask: true
			// });
			var images = [];
			item.forEach((itm,index)=>{
				images.push(itm.url);
			})
			console.log(images); // ["http://192.168.100.251:8970/6_1597822634094.png"]
			uni.previewImage({
				// 预览图片  图片路径必须是一个数组 => ["http://192.168.100.251:8970/6_1597822634094.png"]
				current: 0,
				urls: images,
				longPressActions: {
					//长按保存图片到相册
					itemList: ['保存图片'],
					success: data => {
						console.log(data);
						uni.saveImageToPhotosAlbum({
							//保存图片到相册
							filePath: payUrl,
							success: function() {
								uni.showToast({ icon: 'success', title: '保存成功' });
							},
							fail: err => {
								uni.showToast({ icon: 'none', title: '保存失败，请重新尝试' });
							}
						});
					},
					fail: err => {
			  	console.log(err.errMsg);
					}
				}
			});
			// uni.downloadFile({
			// 	url: url,
			// 	success: res => {
			// 		if (res.statusCode === 200) {
			// 			uni.saveImageToPhotosAlbum({
			// 				filePath: res.tempFilePath,
			// 				success: function() {
			// 					console.log(res.tempFilePath);
			// 					uni.showToast({ title: '保存成功' });
			// 				},
			// 				fail: function() {
			// 					uni.showToast({ title: '保存失败，请稍后重试', icon: 'none' });
			// 				}
			// 			});
			// 		} else {
			// 			uni.showToast({ title: '下载失败', icon: 'none' });
			// 		}
			// 	}
			// });
		}
	}
};
</script>

<style>
.tea-reserve {
	height: 100%;
	margin: 0 40.81rpx 40.81rpx;
	box-shadow: 0px 7.14rpx 20.4rpx 0px #e5eae0;
	border-radius: 25rpx;
}
.tea-reserve-use {
	line-height: 40.81rpx;
	color: #ffffff;
	float: right;
	width: 100rpx;
	height: 40.81rpx;
	border-radius: 0rpx 12.24rpx 0rpx 12.24rpx;
}
.tea-reserve-time {
	font-size: 30.61rpx;
	margin-top: 24.48rpx;
}
.order-btn {
	height: 16.93rpx;
	border-top: 2.04rpx solid rgb(0, 0, 0, 0.2);
	/* margin: 24.48rpx 30.61rpx 0; */
	position: relative;
}
.btn-padd {
	padding: 5.2rpx 10.61rpx;
	/* height: 47.95rpx; */
	text-align: center;
	/* line-height: 47.95rpx; */
	border-radius: 10.2rpx;
}
.bag-color1 {
	color: #ffffff;
	background-color: #2fb278;
}
.bag-color2 {
	background-color: #c8e4dc;
	color: #218569;
}
.fui-modal-mask {
	background-color: rgba(216, 216, 216, 0.2) !important;
}
.fui-number-box {
	width: 100%;
	box-sizing: border-box;
	margin-bottom: 20rpx;
	background: #fff;
	display: flex;
	font-size: 26.53rpx;
	align-items: center;
	justify-content: space-between;
}
.qd_btn {
	width: 100%;
	height: 60.4rpx;
}
.reser-btn {
	height: 60.79rpx;
	width: 100%;
}
.order-btn-wz {
	height: 47.95rpx;
	position: absolute;
	top: 50%;
	right: 0;
	transform: translate(0, -50%);
}
.justify {
	width: 167rpx;
	float: left;
	overflow: hidden;
	text-align: justify;
	text-align-last: justify;
}
</style>

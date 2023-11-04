<template>
	<view class="container">
		<view class="client_list margin-top10">
			<view class="fui-flex">
				<view class="color3 fui-font-size_28 fui-col-3">美团卡券</view>
				<input class="clien fui-col-9" v-model="meituan_code" placeholder="美团卡券" type="text" />
			</view>
		</view>
		<view class="client_list margin-top10">
			<view class="fui-flex" @click="showhourseSheet = true">
				<view class="color3 fui-font-size_28 fui-col-3">房间</view>
				<input class="clien fui-col-8" disabled v-model="hourse_name" placeholder="房间" type="text" />
				<iconfont class="fui-col-1" className="icon-right-1-copy" :size="25" color="#979E91"></iconfont>
			</view>
		</view>
		<view class="client_list margin-top10">
			<view class="fui-flex" @click="showcouponSheet = true">
				<view class="color3 fui-font-size_28 fui-col-3">优惠券</view>
				<input class="clien fui-col-8" disabled v-model="coupon_name" placeholder="优惠券" type="text" />
				<iconfont class="fui-col-1" className="icon-right-1-copy" :size="25" color="#979E91"></iconfont>
			</view>
		</view>
		<view class="reser-btn border-radius-20 fui-font-size_28 font-weight-600" @click="setMeituan">确定</view>
		<view class="margin-left margin-top10 line-height" v-if="qcordImage">
			<view class="fui-flex margin-tb-lg">
				<view class="fui-font-size_28">二维码下载</view>
				<view class="fui-font-size_24 margin-left-sm color" @click="dlogimage()">(点击下载)</view>
			</view>
			<view class="qcord_image"><image class="image_item" :src="qcordImage" mode="aspectFit"></image></view>
		</view>
		<fui-actionsheet
			:show="showcouponSheet"
			:item-list="couponList"
			:mask-closable="maskClosable"
			:color="color"
			:size="size"
			:is-cancel="isCancel"
			@click="couponClick"
			@cancel="closeActionSheet"
		></fui-actionsheet>
		<fui-actionsheet
			:show="showhourseSheet"
			:item-list="hourseList"
			:mask-closable="maskClosable"
			:color="color"
			:size="size"
			:is-cancel="isCancel"
			@click="houseClick"
			@cancel="closehouse"
		></fui-actionsheet>
	</view>
</template>

<script>
export default {
	data() {
		return {
			showcouponSheet: false,
			showhourseSheet: false,
			maskClosable: true,
			isCancel: true,
			couponList: [],
			hourseList: [],
			meituan_code: '',
			coupon_id: 0,
			coupon_name: '',
			hourse_id: '',
			hourse_name: '',
			havecouponList: [],
			havehouseList: [],
			qcordImage: ''
		};
	},
	onShow: function() {
		let that = this;
		that.getGive();
	},
	methods: {
		//选择卡券
		couponClick(e) {
			let that = this;
			console.log(e.index)
			that.coupon_id = that.havecouponList[e.index].id;
			that.coupon_name = that.havecouponList[e.index].name;
			that.closeActionSheet();
		},
		closeActionSheet() {
			this.showcouponSheet = false;
		},
		//选择房间
		houseClick(e) {
			let that = this;
			that.hourse_id = that.havehouseList[e.index].id;
			that.hourse_name = that.havehouseList[e.index].name;
			that.closehouse();
		},
		closehouse() {
			this.showhourseSheet = false;
		},
		getGive() {
			let that = this;
			that.fui
				.request('diandi_tea/meituan/give', 'POST', {}, true)
				.then(res => {
					if (res.code === 200) {
						let data = res.data;
						let couponList=[]
						let hourseList=[]
						data.coupon.forEach(item => {
							couponList.push({
								text: item.name,
								id: item.id
							});
						});
						that.couponList=couponList
						data.hourse.forEach(item => {
							hourseList.push({
								text: item.name,
								id: item.id
							});
						});
						that.hourseList=hourseList
						that.havecouponList = data.coupon;
						that.havehouseList = data.hourse;
					} else {
						uni.showToast({
							title: res.message,
							icon: 'none'
						});
					}
				})
				.catch(res => {
					uni.showToast({
						title: res.message,
						icon: 'none'
					});
				});
		},
		setMeituan() {
			let that = this;
			if (!that.meituan_code) {
				this.fui.toast('请输入美团卡券');
				return false;
			}
			if (!that.hourse_id) {
				this.fui.toast('请输入房间');
				return false;
			}
			if (!that.coupon_id) {
				this.fui.toast('请选择优惠券');
				return false;
			}
			that.fui
				.request(
					'diandi_tea/meituan/add',
					'POST',
					{
						meituan_code: that.meituan_code,
						coupon_id: that.coupon_id,
						hourse_id: that.hourse_id
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						uni.showToast({
							title: res.message,
							icon: 'none',
							success() {
								console.log('res.data', res.data);
								that.getqrcode(res.data.data.id);
							}
						});
					} else {
						uni.showToast({
							title: res.message,
							icon: 'none'
						});
					}
				})
				.catch(res => {
					console.log(res);
				});
		},
		getqrcode(id) {
			let that = this;
			that.fui
				.request(
					'wechat/qrcode/getqrcode',
					'POST',
					{
						module_name: 'diandi_tea',
						path: 'teahouse/predetermine/predetermine',
						width: '200',
						scene: id
					},
					true
				)
				.then(res => {
					console.log('res', res);
					if (res.code === 200) {
						that.qcordImage = res.data.codePath;
					} else {
						uni.showToast({
							title: res.message,
							icon: 'none'
						});
					}
				})
				.catch(res => {
					console.log(res);
				});
		},
		dlogimage() {
			uni.downloadFile({
				url: this.qcordImage,
				success: res => {
					if (res.statusCode === 200) {
						uni.saveImageToPhotosAlbum({
							filePath: res.tempFilePath,
							success: function() {
								console.log(res.tempFilePath);
								uni.showToast({ title: '保存成功' });
							},
							fail: function() {
								uni.showToast({ title: '保存失败，请稍后重试', icon: 'none' });
							}
						});
					} else {
						uni.showToast({ title: '下载失败', icon: 'none' });
					}
				}
			});
		}
	}
};
</script>

<style>
.name-sub {
	margin: 52rpx 50rpx;
}
.client_list {
	background-color: #ffffff;
	padding: 33.67rpx 40.81rpx;
}
.clien {
	color: #4b4f47;
	font-size: 32.65rpx;
	font-weight: 400;
}
.reser-btn {
	height: 89.79rpx;
	background: #218569;
	color: #ffffff;
	text-align: center;
	line-height: 89.79rpx;
	margin: 40.81rpx;
}
.qcord_image {
	left: 15%;
	position: absolute;
}
.image_item {
	width: 500rpx;
	height: 400rpx;
}
</style>

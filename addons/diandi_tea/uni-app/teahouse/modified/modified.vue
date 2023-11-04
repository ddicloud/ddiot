<template>
	<view class="container">
		<view class="client_list margin-top24">
			<view class="fui-flex">
				<view class="color3 fui-font-size_28 fui-col-3">头像</view>
				<fui-upload
					:limit="1"
					:value="avatarUrlStr"
					fileKeyName="avatar"
					:serverUrl="serverUrl"
					@complete="resultactive($event, 0)"
					@remove="removeactive($event, 0)"
				></fui-upload>
			</view>
		</view>
		<view class="client_list margin-top10">
			<view class="fui-flex">
				<view class="color3 fui-font-size_28 fui-col-3">手机号码</view>
				<input class="clien fui-col-9" v-model="myinfoma.mobile" placeholder="手机号码" type="text" />
			</view>
		</view>
		<view class="client_list margin-top10">
			<view class="fui-flex">
				<view class="color3 fui-font-size_28 fui-col-3">昵称</view>
				<input class="clien fui-col-9" v-model="myinfoma.nickName" placeholder="昵称" type="text" />
			</view>
		</view>
		<view class="client_list margin-top10">
			<view class="fui-flex">
				<view class="color3 fui-font-size_28 fui-col-3">姓名</view>
				<input class="clien fui-col-9" v-model="myinfoma.username" placeholder="姓名" type="text" />
			</view>
		</view>
		<view class="client_list margin-top10">
			<view class="fui-flex" @click="showActionSheet = true">
				<view class="color3 fui-font-size_28 fui-col-3">性别</view>
				<input class="clien fui-col-8" disabled v-model="gender" placeholder="性别" type="text" />
				<iconfont class="fui-col-1" className="icon-right-1-copy" :size="25" color="#979E91"></iconfont>
			</view>
		</view>
		<!-- <view class="client_list margin-top10">
			<view class="fui-flex">
				<view class="color3 fui-font-size_28 fui-col-3">会员等级</view>
				<input class="clien fui-col-9" disabled v-model="myinfoma.level" placeholder="会员等级" type="text" />
			</view>
		</view> -->
		<!-- <view class="client_list margin-top10">
			<view class="fui-flex">
				<view class="color3 fui-font-size_28 fui-col-3">会员卡号</view>
				<input class="clien fui-col-9" disabled v-model="myinfoma.studentid" placeholder="会员卡号" type="text" />
			</view>
		</view> -->
		<view @click="setUpinfo">
			<button open-type="getPhoneNumber" class="reser-btn border-radius-20 fui-font-size_32 font-weight-600"  bindgetphonenumber="getPhoneNumber">确定</button></view>
		<fui-actionsheet
			:show="showActionSheet"
			:item-list="itemList"
			:mask-closable="maskClosable"
			:color="color"
			:size="size"
			:is-cancel="isCancel"
			@click="itemClick"
			@cancel="closeActionSheet"
		></fui-actionsheet>
	</view>
</template>

<script>
export default {
	data() {
		return {
			gender:'',
			serverUrl: '',
			myinfoma: {
				username: '',
				mobile: '',
				nickName: '',
				gender: '',
				level: '',
				studentid: '',
				avatarUrl: ''
			},
			avatarUrls: [],
			avatarUrlStr: [],
			showActionSheet: false,
			maskClosable: true,
			itemList: [
				{
					text: '男',
					color: '#2B2B2B'
				},
				{
					text: '女',
					color: '#2B2B2B'
				}
			],
			isCancel: true
		};
	},
	onShow: function() {
		let that = this;
		that.getUserInfo();
		console.log(that.avatarUrls);
	},
	methods: {
		itemClick(e) {
			let that = this;
			that.closeActionSheet();
			that.myinfoma.gender=e.index
			if (e.index === 0) {
				that.gender = '男';
			} else if (e.index === 1) {
				that.gender = '女';
			}
		},
		closeActionSheet() {
			this.showActionSheet = false;
		},
		getUserInfo() {
			let that = this;
			that.fui
				.request('diandi_tea/member/info', 'GET', {}, true)
				.then(res => {
					if (res.code === 200) {
						that.myinfoma = res.data;
						that.$set(that.avatarUrlStr, 0, res.data.avatarUrl);
						that.$set(that.avatarUrls, 0, res.data.avatarUrl);
						if (res.data.gender === 0) {
							that.gender = '男';
						} else if (res.data.gender === 1) {
							that.gender = '女';
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
		setUpinfo() {
			let that = this;
			if (!that.myinfoma.mobile) {
				this.fui.toast('请输入手机号');
				return false;
			}
			if (!that.iGlobal.isMobile(that.myinfoma.mobile)) {
				this.fui.toast('请输入正确的手机号');
				return false;
			}
			that.fui
				.request(
					'diandi_tea/member/editmember',
					'POST',
					{
						username: that.myinfoma.username,
						mobile: that.myinfoma.mobile,
						nickName: that.myinfoma.nickName,
						gender: that.myinfoma.gender,
						avatarUrl: that.avatarUrls[0]
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						uni.showToast({
							title: res.message,
							icon: 'none'
						});
						that.$Router.push({ name: 'my' });
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
		resultactive: function(e, index) {
			let that = this;
			console.log('图片列表', e.imgArr);
			if (e.imgArr.length === 0) {
				return false;
			}
			this.fui
				.uploadFile(e.imgArr[0])
				.then(res => {
					console.log('resultactive', index, res.attachment, res);
					that.$set(that.avatarUrlStr, 0, res.url);
					that.$set(this.avatarUrls, index, res.attachment);
				})
				.catch(res => {
					console.log('cuowu', res, this.myinfoma.avatarUrl);
				});
		},
		removeactive: function(e, k) {
			let that = this;
			//移除图片
			console.log('移除图片', e, k);
			this.myinfoma.avatarUrl = [];
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
</style>

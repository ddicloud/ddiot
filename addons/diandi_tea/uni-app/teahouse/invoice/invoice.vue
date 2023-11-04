<template>
	<view class="container">
		<view class="client_list margin-top10">
			<view class="fui-flex">
				<view class="color3 fui-font-size_28 fui-col-4">公司名称</view>
				<input class="clien fui-col-9" v-model="invicoe.company" placeholder="公司名称" type="text" />
			</view>
		</view>
		<!-- <view class="client_list margin-top10">
			<view class="fui-flex">
				<view class="color3 fui-font-size_28 fui-col-4">社会统一代码</view>
				<input class="clien fui-col-9" v-model="invicoe.social_code" placeholder="社会统一代码" type="text" />
			</view>
		</view> -->
		<view class="client_list margin-top10">
			<view class="fui-flex">
				<view class="color3 fui-font-size_28 fui-col-4">公司电话</view>
				<input class="clien fui-col-9" v-model="invicoe.phone" placeholder="公司电话" type="text" />
			</view>
		</view>
		<view class="client_list margin-top10">
			<view class="fui-flex">
				<view class="color3 fui-font-size_28 fui-col-4">公司地址</view>
				<input class="clien fui-col-9" v-model="invicoe.company_address" placeholder="公司地址" type="text" />
			</view>
		</view>
		<view class="client_list margin-top10">
			<view class="fui-flex">
				<view class="color3 fui-font-size_28 fui-col-4">银行账号</view>
				<input class="clien fui-col-9" v-model="invicoe.bank" placeholder="银行账号" type="text" />
			</view>
		</view>
		<view class="client_list margin-top10">
			<view class="fui-flex">
				<view class="color3 fui-font-size_28 fui-col-4">开户行地址</view>
				<input class="clien fui-col-9" v-model="invicoe.bank_address" placeholder="开户行地址" type="text" />
			</view>
		</view>
		<view class="client_list margin-top10">
			<view class="fui-flex">
				<view class="color3 fui-font-size_28 fui-col-4">纳税人识别号</view>
				<input class="clien fui-col-9" v-model="invicoe.taxpayer_no" placeholder="纳税人识别号" type="text" />
			</view>
		</view>
		<view class="client_list margin-top10">
			<view class="fui-flex">
				<view class="color3 fui-font-size_28 fui-col-4">邮箱</view>
				<input class="clien fui-col-9" v-model="invicoe.email" placeholder="邮箱" type="text" />
			</view>
		</view>
		<view class="reser-btn border-radius-20 fui-font-size_32 font-weight-600" @click="setInvoice">确定</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			order_id: 0,
			invicoe: {
				company: '',
				phone: '',
				email: '',
				// social_code: '',
				taxpayer_no:'',
				company_address:'',
				bank:'',
				bank_address:''
			},
			type:0
		};
	},
	onLoad: function() {
		let that = this;
		that.order_id = that.$Route.query.id;
		if(that.$Route.query.type){
			that.type = that.$Route.query.type;
		}
		console.log('that.order_id',that.order_id,that.type );
	},
	methods: {
		setInvoice() {
			let that = this;
			if (!that.invicoe.company) {
				this.fui.toast('请输入公司名称');
				return false;
			}
			// if (!that.invicoe.social_code) {
			// 	this.fui.toast('请输入社会统一代码');
			// 	return false;
			// }
			if (!that.invicoe.phone) {
				this.fui.toast('请输入公司电话');
				return false;
			}
			if (!that.invicoe.company_address) {
				this.fui.toast('请输入公司地址');
				return false;
			}
			if (!that.invicoe.bank) {
				this.fui.toast('请输入银行账号');
				return false;
			}
			if (!that.invicoe.bank_address) {
				this.fui.toast('请输入银行开户地');
				return false;
			}
			if (!that.invicoe.taxpayer_no) {
				this.fui.toast('请输入纳税人识别号');
				return false;
			}
			if (!that.invicoe.email) {
				this.fui.toast('请输入邮箱号码');
				return false;
			}
			// if (!that.iGlobal.isMobile(that.invicoe.phone)) {
			// 	this.fui.toast('请输入正确的手机号');
			// 	return false;
			// }
			if (!that.iGlobal.isEmail(that.invicoe.email)) {
				this.fui.toast('请输入正确的邮箱号码');
				return false;
			}
			that.fui
				.request(
					'diandi_tea/order/invoice',
					'POST',
					{
						company: that.invicoe.company,
						phone: that.invicoe.phone,
						email: that.invicoe.email,
						// social_code: that.invicoe.social_code,
						order_id:that.order_id,
						type:that.type,
						taxpayer_no:that.invicoe.taxpayer_no,
						bank:that.invicoe.bank,
						bank_address:that.invicoe.bank_address,
						company_address:that.invicoe.company_address
					},
					true
				)
				.then(res => {
					if (res.code === 200) {
						uni.showToast({
							title: res.message,
							icon: 'none'
						});
						uni.redirectTo({
						    url: '/teahouse/invoiceDetail/invoiceDetail'
						});
						// that.$Router.push({ name: 'invoiceDetail' });
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
	margin: 140.81rpx 40.81rpx;
}
</style>

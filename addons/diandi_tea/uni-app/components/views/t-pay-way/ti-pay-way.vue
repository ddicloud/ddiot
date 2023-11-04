<template>
	<view>
		<fui-bottom-popup :show="show" @close="close">
			<fui-list-cell :hover="false">
				<view class="fui-pay-item__title">
					<view>请选择支付方式</view>
					<view>支付金额：<text class="fui-pay-amuont">￥100.00</text></view>
				</view>
			</fui-list-cell>
			<radio-group>
				<fui-list-cell unlined :hover="false">
					<label class="fui-pay-item">
						<image src="https://cnd.dzwztea.cn/tea/images/mall/pay/icon_pay_balance.png" class="fui-pay-logo"></image>
						<text>余额支付（余额0，余额不足）</text>
						<view class="fui-radio" v-if="false">
							<radio color="#EB0909" name="pay"></radio>
						</view>
						<view class="fui-recharge">去充值</view>
					</label>
				</fui-list-cell>
				<fui-list-cell unlined>
					<label class="fui-pay-item">
						<image src="https://cnd.dzwztea.cn/tea/images/mall/pay/icon_pay_weixin.png" class="fui-pay-logo"></image>
						<text>微信支付</text>
						<view class="fui-radio">
							<radio color="#EB0909" name="pay"></radio>
						</view>
					</label>
				</fui-list-cell>
				<fui-list-cell unlined>
					<label class="fui-pay-item">
						<image src="https://cnd.dzwztea.cn/tea/images/mall/pay/icon_pay_zhifubao.png" class="fui-pay-logo"></image>
						<text>支付宝支付</text>
						<view class="fui-radio">
							<radio color="#EB0909" name="pay"></radio>
						</view>
					</label>
				</fui-list-cell>
			</radio-group>
			<view class="fui-btn-pay">
				<fui-button height="88rpx" type="danger" shape="circle" shadow @click="btnPay">去付款</fui-button>
			</view>
		</fui-bottom-popup>
	</view>
</template>

<script>
	export default {
		name: 'tPayWay',
		props: {
			//控制显示
			show: {
				type: Boolean,
				default: false
			},
			page:{
				type:Number,
				default:1
			}
		},
		data() {
			return {

			};
		},
		methods: {
			close() {
				this.$emit("close",{})
			},
			btnPay(){
				this.close();
				this.fui.href("/pages/template/mall/success/success")
			}
		}
	}
</script>

<style scoped>
	.fui-pay-item__title {
		width: 100%;
		height: 90rpx;
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 0 20rpx;
		box-sizing: border-box;
		font-size: 28rpx;
	}

	.fui-pay-amuont {
		color: #eb0909;
		font-weight: 500;
		font-size: 34rpx;
	}

	.fui-pay-item {
		width: 100%;
		height: 80rpx;
		display: flex;
		align-items: center;
		padding: 0 20rpx;
		box-sizing: border-box;
		font-size: 28rpx;
	}

	.fui-pay-logo {
		width: 48rpx;
		height: 48rpx;
		margin-right: 15rpx;
	}

	.fui-radio {
		margin-left: auto;
		transform: scale(0.8);
		transform-origin: 100% center;
	}

	.fui-btn-pay {
		width: 100%;
		padding: 68rpx 35rpx 50rpx 35rpx;
		box-sizing: border-box;
	}

	.fui-recharge {
		color: #fc872d;
		margin-left: auto;
		padding: 12rpx 0;
	}
</style>

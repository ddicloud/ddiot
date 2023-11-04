<template>
	<view class="fui-keyboard-input fui-pwd-box" :style="{backgroundColor:backgroundColor}">
		<view class="fui-inner-box">
			<view class="fui-input" :class="[inputvalue.length===4?'fui-margin-right':'']" :style="{fontSize:size+'rpx',color:color,width:(inputvalue.length===4?90:70)+'rpx' }"
			 v-for="(item,index) in inputvalue" :key="index">{{item}}</view>
		</view>
	</view>
</template>

<script>
	export default {
		name: "fuiKeyboardInput",
		props: {
			//背景颜色
			backgroundColor: {
				type: String,
				default: "#fff"
			},
			size: {
				type: Number,
				default: 32
			},
			color: {
				type: String,
				default: "#333"
			},
			//输入框的值：数组格式，长度即为输入框个数
			inputvalue: {
				type: Array,
				default: ["", "", "", "", "", ""] //密码圆点 ●
			}
		},
		data() {
			return {

			};
		}
	}
</script>

<style scoped>
	.fui-pwd-box {
		display: flex;
		align-items: center;
		justify-content: center;
		box-sizing: border-box;
		vertical-align: top;
	}

	.fui-inner-box {
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.fui-input {
		height: 80rpx;
		position: relative;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-right: 20rpx;
		border-bottom: 2px solid #666;
	}

	.fui-margin-right {
		margin-right: 30rpx;
	}

	.fui-input:last-child {
		margin-right: 0 !important;
	}
</style>

<template>
	<view @touchmove.stop.prevent>
		<view class="fui-modal-box" :style="{width:width,padding:padding,borderRadius:radius}" :class="[(fadeIn || show)?'fui-modal-normal':'fui-modal-scale',show?'fui-modal-show':'']">
			<view v-if="!custom">
				<view class="fui-modal-title" v-if="title">{{title}}</view>
				<view class="fui-modal-content" :class="[title?'':'fui-mtop']" :style="{color:color,fontSize:size+'rpx'}">{{content}}</view>
				<view class="fui-modalBtn-box" :class="[button.length!=2?'fui-flex-column':'']">
					<block v-for="(item,index) in button" :key="index">
						<button class="fui-modal-btn" :class="['fui-'+(item.type || 'primary')+(item.plain?'-outline':''),button.length!=2?'fui-btn-width':'',button.length>2?'fui-mbtm':'',shape=='circle'?'fui-circle-btn':'']"
						 :hover-class="'fui-'+(item.plain?'outline':(item.type || 'primary'))+'-hover'" :data-index="index" @tap="handleClick">{{item.text || "确定"}}</button>
					</block>
				</view>
			</view>
			<view v-else>
				<slot></slot>
			</view>
		</view>
		<view class="fui-modal-mask" :class="[show?'fui-mask-show':'']" @tap="handleClickCancel"></view>

	</view>
</template>

<script>
	export default {
		name: "fuiModal",
		props: {
			//是否显示
			show: {
				type: Boolean,
				default: false
			},
			width: {
				type: String,
				default: "84%"
			},
			padding: {
				type: String,
				default: "40rpx 64rpx"
			},
			radius: {
				type: String,
				default: "24rpx"
			},
			//标题
			title: {
				type: String,
				default: ""
			},
			//内容
			content: {
				type: String,
				default: ""
			},
			//内容字体颜色
			color: {
				type: String,
				default: "#999"
			},
			//内容字体大小 rpx
			size: {
				type: Number,
				default: 28
			},
			//形状 circle, square
			shape: {
				type: String,
				default: 'square'
			},
			button: {
				type: Array,
				default: function() {
					return [{
						text: "取消",
						type: "red",
						plain: true //是否空心
					}, {
						text: "确定",
						type: "red",
						plain: false
					}]
				}
			},
			//点击遮罩 是否可关闭
			maskClosable: {
				type: Boolean,
				default: true
			},
			//淡入效果，自定义弹框插入input输入框时传true
			fadeIn: {
				type: Boolean,
				default: false
			},
			//自定义弹窗内容
			custom: {
				type: Boolean,
				default: false
			}
		},
		data() {
			return {

			};
		},
		methods: {
			handleClick(e) {
				if (!this.show) return;
				const dataset = e.currentTarget.dataset;
				this.$emit('click', {
					index: Number(dataset.index)
				});
			},
			handleClickCancel() {
				if (!this.maskClosable) return;
				this.$emit('cancel');
			}
		}
	}
</script>

<style scoped>
	.fui-modal-box {
		position: fixed;
		left: 50%;
		top: 50%;
		margin: auto;
		background-color: #fff;
		z-index: 9999998;
		transition: all 0.3s ease-in-out;
		opacity: 0;
		box-sizing: border-box;
		visibility: hidden;
	}

	.fui-modal-scale {
		transform: translate(-50%, -50%) scale(0);
	}

	.fui-modal-normal {
		transform: translate(-50%, -50%) scale(1);
	}

	.fui-modal-show {
		opacity: 1;
		visibility: visible;
	}

	.fui-modal-mask {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: rgba(0, 0, 0, 0.6);
		z-index: 9999996;
		transition: all 0.3s ease-in-out;
		opacity: 0;
		visibility: hidden;
	}

	.fui-mask-show {
		visibility: visible;
		opacity: 1;
	}

	.fui-modal-title {
		text-align: center;
		font-size: 34rpx;
		color: #333;
		padding-top: 20rpx;
		font-weight: bold;
	}

	.fui-modal-content {
		text-align: center;
		color: #999;
		font-size: 28rpx;
		padding-top: 20rpx;
		padding-bottom: 60rpx;
	}

	.fui-mtop {
		margin-top: 30rpx;
	}

	.fui-mbtm {
		margin-bottom: 30rpx;
	}

	.fui-modalBtn-box {
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: space-between
	}

	.fui-flex-column {
		flex-direction: column;
	}

	.fui-modal-btn {
		width: 46%;
		height: 68rpx;
		line-height: 68rpx;
		position: relative;
		border-radius: 10rpx;
		font-size: 26rpx;
		overflow: visible;
		margin-left: 0;
		margin-right: 0;
	}

	.fui-modal-btn::after {
		content: " ";
		position: absolute;
		width: 200%;
		height: 200%;
		-webkit-transform-origin: 0 0;
		transform-origin: 0 0;
		-webkit-transform: scale(0.5, 0.5);
		transform: scale(0.5, 0.5);
		left: 0;
		top: 0;
		border-radius: 20rpx;
	}

	.fui-btn-width {
		width: 80% !important;
	}

	.fui-primary {
		background: #5677fc;
		color: #fff;
	}

	.fui-primary-hover {
		background: #4a67d6;
		color: #e5e5e5;
	}

	.fui-primary-outline {
		color: #5677fc;
		background: transparent;
	}

	.fui-primary-outline::after {
		border: 1px solid #5677fc;
	}

	.fui-danger {
		background: #ed3f14;
		color: #fff;
	}

	.fui-danger-hover {
		background: #d53912;
		color: #e5e5e5;
	}

	.fui-danger-outline {
		color: #ed3f14;
		background: transparent;
	}

	.fui-danger-outline::after {
		border: 1px solid #ed3f14;
	}

	.fui-red {
		background: #e41f19;
		color: #fff;
	}

	.fui-red-hover {
		background: #c51a15;
		color: #e5e5e5;
	}

	.fui-red-outline {
		color: #e41f19;
		background: transparent;
	}

	.fui-red-outline::after {
		border: 1px solid #e41f19;
	}

	.fui-warning {
		background: #ff7900;
		color: #fff;
	}

	.fui-warning-hover {
		background: #e56d00;
		color: #e5e5e5;
	}

	.fui-warning-outline {
		color: #ff7900;
		background: transparent;
	}

	.fui-warning-outline::after {
		border: 1px solid #ff7900;
	}

	.fui-green {
		background: #19be6b;
		color: #fff;
	}

	.fui-green-hover {
		background: #16ab60;
		color: #e5e5e5;
	}

	.fui-green-outline {
		color: #19be6b;
		background: transparent;
	}

	.fui-green-outline::after {
		border: 1px solid #19be6b;
	}

	.fui-white {
		background: #fff;
		color: #333;
	}

	.fui-white-hover {
		background: #f7f7f9;
		color: #666;
	}

	.fui-white-outline {
		color: #333;
		background: transparent;
	}

	.fui-white-outline::after {
		border: 1px solid #333;
	}

	.fui-gray {
		background: #ededed;
		color: #999;
	}

	.fui-gray-hover {
		background: #d5d5d5;
		color: #898989;
	}

	.fui-gray-outline {
		color: #999;
		background: transparent;
	}

	.fui-gray-outline::after {
		border: 1px solid #999;
	}

	.fui-outline-hover {
		opacity: 0.6;
	}

	.fui-circle-btn {
		border-radius: 40rpx !important;
	}

	.fui-circle-btn::after {
		border-radius: 80rpx !important;
	}
</style>

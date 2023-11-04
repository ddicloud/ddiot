<template>
	<view @touchmove.stop.prevent>
		<view class="fui-actionsheet" :class="{'fui-actionsheet-show':show,'fui-actionsheet-radius':radius}">
			<view class="fui-actionsheet-tips" :style="{fontSize:size+'rpx',color:color}" v-if="tips">
				{{tips}}
			</view>
			<view :class="[isCancel?'fui-operate-box':'']">
				<block v-for="(item,index) in itemList" :key="index">
					<view class="fui-actionsheet-btn fui-actionsheet-viewider" :class="{'fui-btn-last':!isCancel && index==itemList.length-1}"
					 hover-class="fui-actionsheet-hover" :hover-stay-time="150" :data-index="index" :style="{color:item.color || '#2B2B2B'}"
					 @tap="handleClickItem">{{item.text}}</view>
				</block>
			</view>
			<view class="fui-actionsheet-btn fui-actionsheet-cancel" hover-class="fui-actionsheet-hover" :hover-stay-time="150"
			 v-if="isCancel" @tap="handleClickCancel">取消</view>
		</view>
		<view class="fui-actionsheet-mask" :class="{'fui-mask-show':show}" @tap="handleClickMask"></view>
	</view>
</template>

<script>
	export default {
		name: "fuiActionsheet",
		props: {
			//点击遮罩 是否可关闭
			maskClosable: {
				type: Boolean,
				default: true
			},
			//显示操作菜单
			show: {
				type: Boolean,
				default: false
			},
			//菜单按钮数组，自定义文本颜色，红色参考色：#e53a37
			itemList: {
				type: Array,
				default: function() {
					return [{
						text: "确定",
						color: "#2B2B2B"
					}]
				}
			},
			//提示文字
			tips: {
				type: String,
				default: ""
			},
			//提示文字颜色
			color: {
				type: String,
				default: "#808080"
			},
			//提示文字大小 rpx
			size: {
				type: Number,
				default: 26
			},
			//是否需要圆角
			radius: {
				type: Boolean,
				default: true
			},
			//是否需要取消按钮
			isCancel: {
				type: Boolean,
				default: true
			}
		},
		methods: {
			handleClickMask() {
				if (!this.maskClosable) return;
				this.handleClickCancel();
			},
			handleClickItem(e) {
				if (!this.show) return;
				const dataset = e.currentTarget.dataset;
				this.$emit('click', {
					index: Number(dataset.index)
				});
			},
			handleClickCancel() {
				this.$emit('cancel');
			}
		}
	}
</script>

<style scoped>
	.fui-actionsheet {
		width: 100%;
		position: fixed;
		left: 0;
		right: 0;
		bottom: 0;
		z-index: 9999;
		visibility: hidden;
		transform: translate3d(0, 100%, 0);
		transform-origin: center;
		transition: all 0.25s ease-in-out;
		background-color: #F7F7F7;
		min-height: 100rpx;
	}

	.fui-actionsheet-radius {
		border-top-left-radius: 20rpx;
		border-top-right-radius: 20rpx;
		overflow: hidden;
	}

	.fui-actionsheet-show {
		transform: translate3d(0, 0, 0);
		visibility: visible;
	}

	.fui-actionsheet-tips {
		width: 100%;
		padding: 40rpx 60rpx;
		box-sizing: border-box;
		text-align: center;
		background-color: #fff;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.fui-operate-box {
		padding-bottom: 12rpx;
	}

	.fui-actionsheet-btn {
		width: 100%;
		height: 100rpx;
		background-color: #fff;
		display: flex;
		align-items: center;
		justify-content: center;
		text-align: center;
		font-size: 34rpx;
		position: relative;
	}

	.fui-btn-last {
		padding-bottom: env(safe-area-inset-bottom);
	}

	.fui-actionsheet-viewider::before {
		content: '';
		width: 100%;
		border-top: 1rpx solid #E7E7E7;
		position: absolute;
		top: 0;
		left: 0;
		-webkit-transform: scaleY(0.5);
		transform: scaleY(0.5);
	}

	.fui-actionsheet-cancel {
		color: #1a1a1a;
		padding-bottom: env(safe-area-inset-bottom);
	}

	.fui-actionsheet-hover {
		background-color: #f7f7f9;
	}

	.fui-actionsheet-mask {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: rgba(0, 0, 0, 0.6);
		z-index: 9996;
		transition: all 0.3s ease-in-out;
		opacity: 0;
		visibility: hidden;
	}

	.fui-mask-show {
		opacity: 1;
		visibility: visible;
	}
</style>

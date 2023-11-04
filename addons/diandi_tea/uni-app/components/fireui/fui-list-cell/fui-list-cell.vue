<template>
	<view class="fui-list-class fui-list-cell" :class="[
			arrow ? 'fui-cell-arrow' : '',
			arrow && arrowRight ? '' : 'fui-arrow-right',
			unlined ? 'fui-cell-unlined' : '',
			lineLeft ? 'fui-line-left' : '',
			lineRight ? 'fui-line-right' : '',
			arrow && arrowColor ? 'fui-arrow-' + arrowColor : '',
			radius ? 'fui-radius' : ''
		]" :hover-class="hover ? 'fui-cell-hover' : ''"
		:style="{ backgroundColor: backgroundColor, fontSize: size + 'rpx', color: color, padding: padding }"
		:hover-stay-time="150" @tap="handleClick">
		<slot></slot>
	</view>
</template>

<script>
	export default {
		name: 'fuiListCell',
		props: {
			//是否有箭头
			arrow: {
				type: Boolean,
				default: false
			},
			//箭头颜色 传值： white，gray,warning,danger
			arrowColor: {
				type: String,
				default: ''
			},
			//是否有点击效果
			hover: {
				type: Boolean,
				default: true
			},
			//隐藏线条
			unlined: {
				type: Boolean,
				default: false
			},
			//线条是否有左偏移距离
			lineLeft: {
				type: Boolean,
				default: true
			},
			//线条是否有右偏移距离
			lineRight: {
				type: Boolean,
				default: false
			},
			padding: {
				type: String,
				default: '26rpx 30rpx'
			},
			//背景颜色
			backgroundColor: {
				type: String,
				default: '#fff'
			},
			//字体大小
			size: {
				type: Number,
				default: 28
			},
			//字体颜色
			color: {
				type: String,
				default: '#333'
			},
			//是否加圆角
			radius: {
				type: Boolean,
				default: false
			},
			//箭头是否有偏移距离
			arrowRight: {
				type: Boolean,
				default: true
			},
			index: {
				type: Number,
				default: 0
			}
		},
		methods: {
			handleClick() {
				this.$emit('click', {
					index: this.index
				});
			}
		}
	};
</script>

<style scoped>
	.fui-list-cell {
		position: relative;
		width: 100%;
		box-sizing: border-box;
	}

	.fui-radius {
		border-radius: 6rpx;
		overflow: hidden;
	}

	.fui-cell-hover {
		background-color: #f1f1f1 !important;
	}

	.fui-list-cell::after {
		content: '';
		position: absolute;
		border-bottom: 1px solid #eaeef1;
		-webkit-transform: scaleY(0.5) translateZ(0);
		transform: scaleY(0.5) translateZ(0);
		transform-origin: 0 100%;
		bottom: 0;
		right: 0;
		left: 0;
	}

	.fui-line-left::after {
		left: 30rpx !important;
	}

	.fui-line-right::after {
		right: 30rpx !important;
	}

	.fui-cell-unlined::after {
		border-bottom: 0 !important;
	}

	.fui-cell-arrow::before {
		content: ' ';
		height: 10px;
		width: 10px;
		border-width: 2px 2px 0 0;
		border-color: #c0c0c0;
		border-style: solid;
		-webkit-transform: matrix(0.5, 0.5, -0.5, 0.5, 0, 0);
		transform: matrix(0.5, 0.5, -0.5, 0.5, 0, 0);
		position: absolute;
		top: 50%;
		margin-top: -6px;
		right: 30rpx;
	}

	.fui-arrow-right::before {
		right: 0 !important;
	}

	.fui-arrow-gray::before {
		border-color: #666666 !important;
	}

	.fui-arrow-white::before {
		border-color: #ffffff !important;
	}

	.fui-arrow-warning::before {
		border-color: #ff7900 !important;
	}

	.fui-arrow-success::before {
		border-color: #19be6b !important;
	}

	.fui-arrow-danger::before {
		border-color: #eb0909 !important;
	}
	.fui-list-class{
		/* margin-top: 35rpx; */
	}
</style>

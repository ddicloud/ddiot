<template>
	<button class="fui-btn" :class="[
			plain ? 'fui-' + type + '-outline' : 'fui-btn-' + (type || 'primary'),
			getDisabledClass(disabled, type, plain),
			getShapeClass(shape, plain),
			getShadowClass(type, shadow, plain)
		]"
	 :hover-class="getHoverClass(disabled, type, plain)" :style="{ width: width, height: height, lineHeight: height, fontSize: size + 'rpx',margin:margin }"
	 :loading="loading" :open-type="openType" @getuserinfo="bindgetuserinfo" :disabled="disabled" @tap="handleClick">
		<slot></slot>
	</button>
</template>

<script>
	export default {
		name: 'fuiButton',
		props: {
			//样式类型 primary, white, danger, warning, green,blue, gray，black,bluegreen
			type: {
				type: String,
				default: 'primary'
			},
			//是否加阴影
			shadow: {
				type: Boolean,
				default: false
			},
			// 宽度 rpx或 %
			width: {
				type: String,
				default: '100%'
			},
			//高度 rpx
			height: {
				type: String,
				default: '96rpx'
			},
			//字体大小 rpx
			size: {
				type: Number,
				default: 32
			},
			margin: {
				type: String,
				default: "0"
			},
			//形状 circle(圆角), square(默认方形)，rightAngle(平角)
			shape: {
				type: String,
				default: 'square'
			},
			plain: {
				type: Boolean,
				default: false
			},
			disabled: {
				type: Boolean,
				default: false
			},
			//禁用后背景是否为灰色 （非空心button生效）
			disabledGray: {
				type: Boolean,
				default: false
			},
			loading: {
				type: Boolean,
				default: false
			},
			openType: {
				type: String,
				default: ''
			},
			index: {
				type: [Number, String],
				default: 0
			}
		},
		methods: {
			handleClick() {
				if (this.disabled) return false;
				this.$emit('click', {
					index: Number(this.index)
				});
			},
			bindgetuserinfo({
				detail = {}
			} = {}) {
				this.$emit('getuserinfo', detail);
			},
			getShadowClass: function(type, shadow, plain) {
				let className = '';
				if (shadow && type != 'white' && !plain) {
					className = 'fui-shadow-' + type;
				}
				return className;
			},
			getDisabledClass: function(disabled, type, plain) {
				let className = '';
				if (disabled && type != 'white') {
					let classVal = this.disabledGray ? 'fui-gray-disabled' : 'fui-dark-disabled';
					className = plain ? 'fui-dark-disabled-outline' : classVal;
				}
				return className;
			},
			getShapeClass: function(shape, plain) {
				let className = '';
				if (shape == 'circle') {
					className = plain ? 'fui-outline-fillet' : 'fui-fillet';
				} else if (shape == 'rightAngle') {
					className = plain ? 'fui-outline-rightAngle' : 'fui-rightAngle';
				}
				return className;
			},
			getHoverClass: function(disabled, type, plain) {
				let className = '';
				if (!disabled) {
					className = plain ? 'fui-outline-hover' : 'fui-' + (type || 'primary') + '-hover';
				}
				return className;
			}
		}
	};
</script>

<style scoped>
	.fui-btn-primary {
		background: #5677fc !important;
		color: #fff;
	}
.fui-btn-bluegreen {
		background: #218569 !important;
		color: #fff;
	}
	.fui-shadow-primary {
		box-shadow: 0 10rpx 14rpx 0 rgba(86, 119, 252, 0.2);
	}

	.fui-btn-danger {
		background: #eb0909 !important;
		color: #fff;
	}

	.fui-shadow-danger {
		box-shadow: 0 10rpx 14rpx 0 rgba(235, 9, 9, 0.2);
	}

	.fui-btn-warning {
		background: #fc872d !important;
		color: #fff;
	}

	.fui-shadow-warning {
		box-shadow: 0 10rpx 14rpx 0 rgba(252, 135, 45, 0.2);
	}

	.fui-btn-green {
		background: #35b06a !important;
		color: #fff;
	}

	.fui-shadow-green {
		box-shadow: 0 10rpx 14rpx 0 rgba(53, 176, 106, 0.2);
	}

	.fui-btn-blue {
		background: #007AFF !important;
		color: #fff;
	}

	.fui-shadow-blue {
		box-shadow: 0 10rpx 14rpx 0 rgba(0, 122, 255, 0.2);
	}

	.fui-btn-white {
		background: #fff !important;
		color: #333 !important;
	}

	.fui-btn-gray {
		background: #bfbfbf !important;
		color: #fff !important;
	}

	.fui-btn-black {
		background: #333 !important;
		color: #fff !important;
	}

	.fui-shadow-gray {
		box-shadow: 0 10rpx 14rpx 0 rgba(191, 191, 191, 0.2);
	}

	.fui-hover-gray {
		background: #f7f7f9 !important;
	}

	.fui-black-hover {
		background: #555 !important;
		color: #e5e5e5 !important;
	}

	/* button start*/

	.fui-btn {
		width: 100%;
		position: relative;
		border: 0 !important;
		border-radius: 6rpx;
		padding-left: 0;
		padding-right: 0;
		overflow: visible;
	}

	.fui-btn::after {
		content: '';
		position: absolute;
		width: 200%;
		height: 200%;
		transform-origin: 0 0;
		transform: scale(0.5, 0.5) translateZ(0);
		box-sizing: border-box;
		left: 0;
		top: 0;
		border-radius: 12rpx;
		border: 0;
	}

	.fui-btn-white::after {
		border: 1rpx solid #bfbfbf;
	}

	.fui-white-hover {
		background: #e5e5e5 !important;
		color: #2e2e2e !important;
	}

	.fui-dark-disabled {
		opacity: 0.6 !important;
		color: #fafbfc !important;
	}

	.fui-dark-disabled-outline {
		opacity: 0.5 !important;
	}

	.fui-gray-disabled {
		background: #f3f3f3 !important;
		color: #919191 !important;
		box-shadow: none;
	}

	.fui-outline-hover {
		opacity: 0.5;
	}

	.fui-primary-hover {
		background: #4a67d6 !important;
		color: #e5e5e5 !important;
	}

	.fui-primary-outline::after {
		border: 1rpx solid #5677fc !important;
	}

	.fui-primary-outline {
		color: #5677fc !important;
		background: transparent;
	}

	.fui-danger-outline::after {
		border: 1rpx solid #eb0909 !important;
	}

	.fui-warning-hover {
		background: #d67326 !important;
		color: #e5e5e5 !important;
	}

	.fui-warning-outline {
		color: #fc872d !important;
		background: transparent;
	}

	.fui-warning-outline::after {
		border: 1px solid #fc872d !important;
	}


	.fui-bluegreen-outline {
		color: #218569 !important;
		background: transparent;
	}

	.fui-bluegreen-outline::after {
		border: 1px solid #218569 !important;
	}

	.fui-green-hover {
		background: #2d965a !important;
		color: #e5e5e5 !important;
	}

	.fui-green-outline {
		color: #35b06a !important;
		background: transparent;
	}

	.fui-green-outline::after {
		border: 1rpx solid #35b06a !important;
	}

	.fui-blue-hover {
		background: #0062CC !important;
		color: #e5e5e5 !important;
	}

	.fui-blue-outline {
		color: #007AFF !important;
		background: transparent;
	}

	.fui-blue-outline::after {
		border: 1rpx solid #007AFF !important;
	}

	/* #ifndef APP-NVUE */
	.fui-btn-gradual {
		background: linear-gradient(90deg, rgb(255, 89, 38), rgb(240, 14, 44)) !important;
		color: #fff !important;
	}

	.fui-shadow-gradual {
		box-shadow: 0 10rpx 14rpx 0 rgba(235, 9, 9, 0.15);
	}

	/* #endif */

	.fui-gray-hover {
		background: #a3a3a3 !important;
		color: #898989;
	}

	/* #ifndef APP-NVUE */
	.fui-gradual-hover {
		background: linear-gradient(90deg, #d74620, #cd1225) !important;
		color: #fff !important;
	}

	/* #endif */

	.fui-gray-outline {
		color: #999 !important;
		background: transparent !important;
	}

	.fui-white-outline {
		color: #fff !important;
		background: transparent !important;
	}

	.fui-black-outline {
		background: transparent !important;
		color: #333 !important;
	}

	.fui-gray-outline::after {
		border: 1rpx solid #ccc !important;
	}

	.fui-white-outline::after {
		border: 1px solid #fff !important;
	}

	.fui-black-outline::after {
		border: 1px solid #333 !important;
	}

	/*圆角 */

	.fui-fillet {
		border-radius: 50rpx;
	}

	.fui-btn-white.fui-fillet::after {
		border-radius: 98rpx;
	}

	.fui-outline-fillet::after {
		border-radius: 98rpx;
	}

	/*平角*/
	.fui-rightAngle {
		border-radius: 0;
	}

	.fui-btn-white.fui-rightAngle::after {
		border-radius: 0;
	}

	.fui-outline-rightAngle::after {
		border-radius: 0;
	}
</style>

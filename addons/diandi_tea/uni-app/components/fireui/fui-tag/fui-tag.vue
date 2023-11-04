<template>
	<view
		class="fui-tag"
		:hover-class="hover ? 'fui-tag-opcity' : ''"
		:hover-stay-time="150"
		:class="[originLeft ? 'fui-origin-left' : '', originRight ? 'fui-origin-right' : '', getClassName(shape, plain), getTypeClass(type, plain)]"
		:style="{ transform: `scale(${scaleMultiple})`, padding: padding, margin: margin, fontSize: size, lineHeight: size ,width:width}"
		@tap="handleClick"
	>
		<slot></slot>
	</view>
</template>

<script>
export default {
	name: 'fuiTag',
	props: {
		type: {
			type: String,
			default: 'primary'
		},
		//padding
		padding: {
			type: String,
			default: '16rpx 26rpx'
		},
		margin: {
			type: String,
			default: '0'
		},
		//文字大小 rpx
		size: {
			type: String,
			default: '28rpx'
		},
		width:{
			type: String,
			default: 'auto'
		},
		// circle, square，circleLeft，circleRight
		shape: {
			type: String,
			default: 'square'
		},
		//是否空心
		plain: {
			type: Boolean,
			default: false
		},
		//点击效果
		hover: {
			type: Boolean,
			default: false
		},
		//缩放倍数
		scaleMultiple: {
			type: Number,
			default: 1
		},
		originLeft: {
			type: Boolean,
			default: false
		},
		originRight: {
			type: Boolean,
			default: false
		},
		index: {
			type: Number,
			default: 0
		}
	},
	methods: {
		handleClick() {
			this.$emit('click', { index: this.index });
		},
		getTypeClass: function(type, plain) {
			return plain ? 'fui-' + type + '-outline' : 'fui-' + type;
		},
		getClassName: function(shape, plain) {
			//circle, square，circleLeft，circleRight
			var className = plain ? 'fui-tag-outline ' : '';
			if (shape != 'square') {
				if (shape == 'circle') {
					className = className + (plain ? 'fui-tag-outline-fillet' : 'fui-tag-fillet');
				} else if (shape == 'circleLeft') {
					className = className + 'fui-tag-fillet-left';
				} else if (shape == 'circleRight') {
					className = className + 'fui-tag-fillet-right';
				}
			}
			return className;
		}
	}
};
</script>

<style scoped>
/* color start*/

.fui-primary {
	background-color: #5677fc !important;
	color: #fff;
}

.fui-light-primary {
	background-color: #5c8dff !important;
	color: #fff;
}

.fui-dark-primary {
	background-color: #4a67d6 !important;
	color: #fff;
}

.fui-dLight-primary {
	background-color: #4e77d9 !important;
	color: #fff;
}

.fui-danger {
	background-color: #ed3f14 !important;
	color: #fff;
}

.fui-red {
	background-color: #ff201f !important;
	color: #fff;
}

.fui-warning {
	background-color: #ff7900 !important;
	color: #fff;
}

.fui-green {
	background-color: #19be6b !important;
	color: #fff;
}

.fui-high-green {
	background-color: #52dcae !important;
	color: #52dcae;
}

.fui-black {
	background-color: #000 !important;
	color: #fff;
}

.fui-white {
	background-color: #fff !important;
	color: #333 !important;
}

.fui-translucent {
	background-color: rgba(0, 0, 0, 0.7);
}

.fui-light-black {
	background-color: #333 !important;
}

.fui-gray {
	background-color: #ededed !important;
}

.fui-phcolor-gray {
	background-color: #ccc !important;
}

.fui-viewider-gray {
	background-color: #eaeef1 !important;
}

.fui-btn-gray {
	background-color: #ededed !important;
	color: #999 !important;
}

.fui-hover-gray {
	background-color: #f7f7f9 !important;
}

.fui-bg-gray {
	background-color: #fafafa !important;
}

.fui-light-blue {
	background-color: #ecf6fd;
	color: #4dabeb !important;
}

.fui-light-brownish {
	background-color: #fcebef;
	color: #8a5966 !important;
}

.fui-light-orange {
	background-color: #fef5eb;
	color: #faa851 !important;
}

.fui-light-green {
	background-color: #e8f6e8;
	color: #44cf85 !important;
}

.fui-primary-outline::after {
	border: 1px solid #5677fc !important;
}

.fui-primary-outline {
	color: #5677fc !important;
	background-color: none;
}

.fui-danger-outline {
	color: #ed3f14 !important;
	background-color: none;
}

.fui-danger-outline::after {
	border: 1px solid #ed3f14 !important;
}

.fui-red-outline {
	color: #ff201f !important;
	background-color: none;
}

.fui-red-outline::after {
	border: 1px solid #ff201f !important;
}

.fui-warning-outline {
	color: #ff7900 !important;
	background-color: none;
}

.fui-warning-outline::after {
	border: 1px solid #ff7900 !important;
}

.fui-green-outline {
	color: #44cf85 !important;
	background-color: none;
}

.fui-green-outline::after {
	border: 1px solid #44cf85 !important;
}

.fui-high-green-outline {
	color: #52dcae !important;
	background-color: none;
}

.fui-high-green-outline::after {
	border: 1px solid #52dcae !important;
}

.fui-gray-outline {
	color: #999 !important;
	background-color: none;
}

.fui-gray-outline::after {
	border: 1px solid #ccc !important;
}

.fui-black-outline {
	color: #333 !important;
	background-color: none;
}

.fui-black-outline::after {
	border: 1px solid #333 !important;
}

.fui-white-outline {
	color: #fff !important;
	background-color: none;
}

.fui-white-outline::after {
	border: 1px solid #fff !important;
}

/* color end*/

/* tag start*/

.fui-tag {
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 6rpx;
	flex-shrink: 0;
}

.fui-tag-outline {
	position: relative;
	background-color: none;
	color: #5677fc;
}

.fui-tag-outline::after {
	content: '';
	position: absolute;
	width: 200%;
	height: 200%;
	-webkit-transform-origin: 0 0;
	transform-origin: 0 0;
	-webkit-transform: scale(0.5, 0.5);
	transform: scale(0.5, 0.5);
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
	left: 0;
	top: 0;
	border-radius: 12rpx;
}

.fui-tag-fillet {
	border-radius: 50rpx;
}

.fui-white.fui-tag-fillet::after {
	border-radius: 80rpx;
}

.fui-tag-outline-fillet::after {
	border-radius: 80rpx;
}

.fui-tag-fillet-left {
	border-radius: 50rpx 0 0 50rpx;
}

.fui-tag-fillet-right {
	border-radius: 0 50rpx 50rpx 0;
}

.fui-tag-fillet-left.fui-tag-outline::after {
	border-radius: 100rpx 0 0 100rpx;
}

.fui-tag-fillet-right.fui-tag-outline::after {
	border-radius: 0 100rpx 100rpx 0;
}

/* tag end*/
.fui-origin-left {
	transform-origin: 0 center;
}
.fui-origin-right {
	transform-origin: 100% center;
}
.fui-tag-opcity {
	opacity: 0.5;
}
</style>

<template>
	<view class="fui-viewider" :style="{ height: height + 'rpx' }">
		<view class="fui-viewider-line" :style="{ width: width, background: getBgColor(gradual, gradualColor, viewiderColor) }"></view>
		<view
			class="fui-viewider-text"
			:style="{ color: color, fontSize: size + 'rpx', lineHeight: size + 'rpx', backgroundColor: backgroundColor, fontWeight: bold ? 'bold' : 'normal' }"
		>
			<slot></slot>
		</view>
	</view>
</template>

<script>
export default {
	name: 'fuiDivider',
	props: {
		//viewider占据高度
		height: {
			type: Number,
			default: 100
		},
		//viewider宽度，可填写具体长度，如400rpx
		width: {
			type: String,
			default: '100%'
		},
		//viewider颜色，如果为渐变线条，此属性失效
		viewiderColor: {
			type: String,
			default: '#e5e5e5'
		},
		//文字颜色
		color: {
			type: String,
			default: '#999'
		},
		//文字大小 rpx
		size: {
			type: Number,
			default: 24
		},
		bold: {
			type: Boolean,
			default: false
		},
		//背景颜色，和当前页面背景色保持一致
		backgroundColor: {
			type: String,
			default: '#fafafa'
		},
		//是否为渐变线条，为true，viewideColor失效
		gradual: {
			type: Boolean,
			default: false
		},
		//渐变色值，to right ，提供两个色值即可，由浅至深
		gradualColor: {
			type: Array,
			default: function() {
				return ['#eee', '#ccc'];
			}
		}
	},
	methods: {
		getBgColor: function(gradual, gradualColor, viewiderColor) {
			let bgColor = viewiderColor;
			if (gradual) {
				bgColor = 'linear-gradient(to right,' + gradualColor[0] + ',' + gradualColor[1] + ',' + gradualColor[1] + ',' + gradualColor[0] + ')';
			}
			return bgColor;
		}
	}
};
</script>

<style scoped>
.fui-viewider {
	width: 100%;
	position: relative;
	text-align: center;
	display: flex;
	justify-content: center;
	align-items: center;
	box-sizing: border-box;
	overflow: hidden;
}

.fui-viewider-line {
	position: absolute;
	height: 1rpx;
	top: 50%;
	left: 50%;
	-webkit-transform: scaleY(0.5) translateX(-50%) translateZ(0);
	transform: scaleY(0.5) translateX(-50%) translateZ(0);
}

.fui-viewider-text {
	position: relative;
	text-align: center;
	padding: 0 18rpx;
	z-index: 1;
}
</style>

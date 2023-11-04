<template>
	<view class="fui-scroll-top_box" v-show="isIndex || isShare || (visible && toggle)" :style="{ bottom: bottom + 'rpx', right: right + 'rpx' }">
		<view class="fui-scroll-top_item" v-if="isIndex" @tap.stop="goIndex">
			<image class="fui-scroll-top_img" :src="indexIcon"></image>
			<view class="fui-scroll-top_text">首页</view>
		</view>
		<button open-type="share" class="fui-share-btn" v-if="isShare && !customShare">
			<view class="fui-scroll-top_item" :class="{ 'fui-scroll-item_top': isIndex }"><image class="fui-scroll-top_img" :src="shareIcon"></image></view>
		</button>
		<view class="fui-scroll-top_item" :class="{ 'fui-scroll-item_top': isIndex }" v-if="isShare && customShare" @tap.stop="share">
			<image class="fui-scroll-top_img" :src="shareIcon"></image>
		</view>
		<view class="fui-scroll-top_item" :class="{ 'fui-scroll-item_top': isIndex || isShare }" v-show="visible && toggle" @tap.stop="goTop">
			<image class="fui-scroll-top_img" :src="topIcon"></image>
			<view class="fui-scroll-top_text fui-color-white">顶部</view>
		</view>
	</view>
</template>

<script>
/**
 * 注意：组件中使用的图片地址，将文件复制到自己项目中
 * 如果图片位置与组件同级，编译成小程序时图片会丢失
 * 拷贝static下整个components文件夹
 * 也可直接转成base64（不建议）
 * */
export default {
	name: 'fuiScrollTop',
	props: {
		//回顶部按钮距离底部距离 rpx
		bottom: {
			type: Number,
			default: 180
		},
		//回顶部按钮距离右侧距离 rpx
		right: {
			type: Number,
			default: 25
		},
		//距离顶部多少距离显示 px
		top: {
			type: Number,
			default: 200
		},
		//滚动距离
		scrollTop: {
			type: Number
		},
		//回顶部滚动时间
		duration: {
			type: Number,
			default: 120
		},
		//是否显示返回首页按钮
		isIndex: {
			type: Boolean,
			default: false
		},
		//是否显示分享图标
		isShare: {
			type: Boolean,
			default: false
		},
		//自定义分享(小程序可使用button=>open-type="share")
		customShare: {
			type: Boolean,
			default: false
		},
		//回顶部icon
		topIcon: {
			type: String,
			default: '/static/components/scroll-top/icon_top_3x.png'
		},
		//回首页icon
		indexIcon: {
			type: String,
			default: '/static/components/scroll-top/icon_index_3x.png'
		},
		//分享icon
		shareIcon: {
			type: String,
			default: '/static/components/scroll-top/icon_share_3x.png'
		}
	},
	watch: {
		scrollTop(newValue, oldValue) {
			this.change();
		}
	},
	data() {
		return {
			//判断是否显示
			visible: false,
			//控制显示，主要解决调用api滚到顶部fixed元素抖动的问题
			toggle: true
		};
	},
	methods: {
		goTop: function() {
			this.toggle = false;
			uni.pageScrollTo({
				scrollTop: 0,
				duration: this.duration
			});
			setTimeout(() => {
				this.toggle = true;
			}, 220);
		},
		goIndex: function() {
			this.$emit('index', {});
		},
		share() {
			this.$emit('share', {});
		},
		change() {
			let show = this.scrollTop > this.top;
			if ((show && this.visible) || (!show && !this.visible)) {
				return;
			}
			this.visible = show;
		}
	}
};
</script>

<style scoped>
.fui-scroll-top_box {
	width: 80rpx;
	height: 270rpx;
	position: fixed;
	z-index: 9999;
	right: 30rpx;
	bottom: 30rpx;
	font-weight: 400;
}

.fui-scroll-top_item {
	width: 80rpx;
	height: 80rpx;
	position: relative;
}

.fui-scroll-item_top {
	margin-top: 30rpx;
}

.fui-scroll-top_img {
	width: 80rpx;
	height: 80rpx;
	display: block;
}

.fui-scroll-top_text {
	width: 80rpx;
	text-align: center;
	font-size: 24rpx;
	line-height: 24rpx;
	transform: scale(0.92);
	transform-origin: center center;
	position: absolute;
	left: 0;
	bottom: 15rpx;
}

.fui-color-white {
	color: #fff;
}
.fui-share-btn {
	background: transparent !important;
	padding: 0;
	margin: 0;
	display: inline;
	border: 0;
}
.fui-share-btn::after {
	border: 0;
}
</style>

<template>
	<view class="fui-list-view fui-view-class" :style="{backgroundColor:backgroundColor}">
		<view class="fui-list-title" v-if="title">{{title}}</view>
		<view class="fui-list-content" :class="[unlined?'fui-border-'+unlined:'']">
			<slot></slot>
		</view>
	</view>
</template>

<script>
	export default {
		name: "fuiListView",
		props: {
			title: {
				type: String,
				default: ''
			},
			backgroundColor:{
				type: String,
				default: 'transparent'
			},
			unlined: {
				type: String,
				default: '' //top,bottom,all
			}
		}
	}
</script>

<style scoped>
	.fui-list-title {
		width: 100%;
		padding: 30rpx;
		box-sizing: border-box;
		font-size: 30rpx;
		line-height: 30rpx;
		color: #666;
	}

	.fui-list-content {
		width: 100%;
		position: relative;
	}

	.fui-list-content::before {
		content: " ";
		position: absolute;
		top: 0;
		right: 0;
		left: 0;
		border-top: 1rpx solid #eaeef1;
		-webkit-transform: scaleY(0.5) translateZ(0);
		transform: scaleY(0.5) translateZ(0);
		transform-origin: 0 0;
		z-index: 2;
		pointer-events: none;
	}

	.fui-list-content::after {
		content: '';
		width: 100%;
		position: absolute;
		border-bottom: 1rpx solid #eaeef1;
		-webkit-transform: scaleY(0.5) translateZ(0);
		transform: scaleY(0.5) translateZ(0);
		transform-origin: 0 100%;
		bottom: 0;
		right: 0;
		left: 0;
	}

	.fui-border-top::before {
		border-top: 0;
	}

	.fui-border-bottom::after {
		border-bottom: 0;
	}

	.fui-border-all::after {
		border-bottom: 0;
	}

	.fui-border-all::before {
		border-top: 0;
	}
</style>

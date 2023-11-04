<template>
	<view class="fui-grid" :class="[bottom?'':'fui-grid-bottom','fui-grid-'+(cell<2?3:cell)]" :hover-class="hover?'fui-item-hover':''"
	 :hover-stay-time="150" :style="{backgroundColor:backgroundColor}" @tap="handleClick">
		<view class='fui-grid-bg'>
			<slot></slot>
		</view>
	</view>
</template>

<script>
	export default {
		name: "fuiGridItem",
		props: {
			cell: {
				type: [Number,String],
				default: 3
			},
			backgroundColor: {
				type: String,
				default: "#fff"
			},
			//是否有点击效果
			hover: {
				type: Boolean,
				default: true
			},
			//底部线条
			bottom: {
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
	}
</script>

<style scoped>
	.fui-grid {
		position: relative;
		padding: 12.5rpx 6.25rpx;
		box-sizing: border-box;
		background: #fff;
		float: left;
	}

	.fui-grid-2 {
		width: 50%;
	}

	.fui-grid-3 {
		width: 33.333333333%;
	}

	.fui-grid-4 {
		width: 25%;
		padding: 30rpx 20rpx !important;
	}

	.fui-grid-5 {
		width: 20%;
		padding: 20rpx !important;
	}

	.fui-grid-2:nth-of-type(2n)::before {
		width: 0;
		border-right: 0;
	}

	.fui-grid-3:nth-of-type(3n)::before {
		width: 0;
		border-right: 0;
	}

	.fui-grid-4:nth-of-type(4n)::before {
		width: 0;
		border-right: 0;
	}

	.fui-grid-5:nth-of-type(5n)::before {
		width: 0;
		border-right: 0;
	}

	.fui-grid::before {
		content: " ";
		position: absolute;
		right: 0;
		top: 0;
		width: 1px;
		bottom: 0;
		border-right: 1px solid #eaeef1;
		-webkit-transform-origin: 100% 0;
		transform-origin: 100% 0;
		-webkit-transform: scaleX(0.5);
		transform: scaleX(0.5);
	}

	.fui-grid::after {
		content: " ";
		position: absolute;
		left: 0;
		bottom: 0;
		right: 0;
		height: 1px;
		border-bottom: 1px solid #eaeef1;
		-webkit-transform-origin: 0 100%;
		transform-origin: 0 100%;
		-webkit-transform: scaleY(0.5);
		transform: scaleY(0.5);
	}

	.fui-grid-bottom::after {
		height: 0 !important;
		border-bottom: 0 !important
	}

	.fui-grid-bg {
		position: relative;
		padding: 0;
		width: 100%;
		box-sizing: border-box;
	}

	.fui-item-hover {
		background-color: #f7f7f9 !important;
	}
</style>

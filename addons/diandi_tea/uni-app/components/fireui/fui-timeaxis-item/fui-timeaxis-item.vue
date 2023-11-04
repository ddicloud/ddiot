<template>
	<view class="fui-timeaxis-item">
		<slot name="content"></slot>
		<view class="fui-timeaxis-node" :style="{backgroundColor:backgroundColor}">
			<slot name="node"></slot>
		</view>
	</view>
</template>

<script>
	export default {
		name: "fuiTimeaxisItem",
		props: {
			//节点背景色
			backgroundColor: {
				type: String,
				default: "#fafafa"
			}
		},
		data() {
			return {

			};
		}
	}
</script>

<style scoped>
	.fui-timeaxis-item {
		position: relative;
		width: 100%;
		display: flex;
		flex-direction: column;
		margin-bottom: 25px;
	}

	.fui-timeaxis-node {
		position: absolute;
		top: 0;
		left: -20px;
		transform-origin: 0;
		transform: translateX(-50%);
		display: flex;
		align-items: center;
		justify-content: center;
		z-index: 99;
		background-color: #fafafa;
		font-size: 24rpx;
	}
</style>

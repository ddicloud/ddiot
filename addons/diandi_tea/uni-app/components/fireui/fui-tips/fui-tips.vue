<template>
	<block v-if="position=='top'">
		<view class='fui-tips-class fui-toptips' :class="['fui-'+type,show?'fui-top-show':'']">{{msg}}</view>
	</block>
	<block v-else>
		<view class='fui-tips-class fui-toast' :class="[position=='center'?'fui-centertips':'fui-bottomtips',show?'fui-toast-show':'']">
			<view class="fui-tips-content" :class="['fui-'+type]">
				{{msg}}
			</view>
		</view>
	</block>
</template>

<script>
	export default {
		name: "fuiTips",
		props: {
			//top bottom center
			position: {
				type: String,
				default: "top"
			}
		},
		data() {
			return {
				timer: null,
				show: false,
				msg: "无法连接到服务器~",
				//translucent,primary,green,warning,danger
				type: "translucent"
			};
		},
		methods: {
			showTips: function(options) {
				const {
					type = 'translucent',
						duration = 2000
				} = options;
				clearTimeout(this.timer);
				this.show = true;
				// this.duration = duration < 2000 ? 2000 : duration;
				this.type = type;
				this.msg = options.msg;
				this.timer = setTimeout(() => {
					this.show = false;
					clearTimeout(this.timer);
					this.timer = null;
				}, duration);
			}
		}
	}
</script>

<style scoped>
	/*顶部消息提醒 start*/
	.fui-toptips {
		width: 100%;
		padding: 18rpx 30rpx;
		box-sizing: border-box;
		position: fixed;
		z-index: 9999;
		color: #fff;
		font-size: 30rpx;
		left: 0;
		top: 0;
		display: flex;
		align-items: center;
		justify-content: center;
		word-break: break-all;
		opacity: 0;
		transform: translateZ(0) translateY(-100%);
		transition: all 0.3s ease-in-out;
	}

	.fui-top-show {
		transform: translateZ(0) translateY(0);
		opacity: 1;
	}

	/*顶部消息提醒 end*/

	/*toast消息提醒 start*/

	/*注意问题：
 1、fixed 元素宽度无法自适应，所以增加了子元素
 2、fixed 和 display冲突导致动画效果消失，暂时使用visibility替代
*/
	.fui-toast {
		width: 80%;
		box-sizing: border-box;
		color: #fff;
		font-size: 28rpx;
		position: fixed;
		visibility: hidden;
		opacity: 0;
		left: 50%;
		transition: all 0.3s ease-in-out;
		z-index: 9999;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.fui-toast-show {
		visibility: visible;
		opacity: 1;
	}

	.fui-tips-content {
		word-wrap: break-word;
		word-break: break-all;
		border-radius: 8rpx;
		padding: 18rpx 30rpx;
	}

	/*底部消息提醒 start*/
	.fui-bottomtips {
		bottom: 120rpx;
		-webkit-transform: translateX(-50%);
		transform: translateX(-50%);
	}

	/*底部消息提醒 end*/

	/*居中消息提醒 start*/
	.fui-centertips {
		top: 50%;
		-webkit-transform: translate(-50%, -50%);
		transform: translate(-50%, -50%);
	}

	/*居中消息提醒 end*/

	/*toast消息提醒 end*/

	/*背景颜色 start*/

	.fui-primary {
		background-color: #5677fc;
	}

	.fui-green {
		background-color: #19be6b;
	}

	.fui-warning {
		background-color: #ff7900;
	}

	.fui-danger {
		background-color: #ed3f14;
	}

	.fui-translucent {
		background-color: rgba(0, 0, 0, 0.7);
	}

	/*背景颜色 end*/

	/*消息提醒 end*/
</style>

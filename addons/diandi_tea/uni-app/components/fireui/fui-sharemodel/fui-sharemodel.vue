<template>
	<!--底部分享弹窗-->
	<fui-bottom-popup :show="popupShow">
		<view class="fui-share">
			<view class="fui-share-title">分享到</view>
			<view class="padding-right-sm share-main">
				<view class="fui-share-top fui-flex">
					<view class="fui-share-item fui-col-6" :class="[shareList[0].share.length-1===index?'fui-item-last':'']" v-for="(item,index) in shareList[0].share"
					 :key="index" :data-index="index" @tap="sharbutton($event)">
						<view class="fui-share-icon" hover-class="fui-hover" :hover-stay-time="150">
							<iconfont :className="item.icon" :color="item.color" :size="item.size?item.size:36"></iconfont>
							<!-- <fui-icon :name="item.icon" :color="item.color" :size="item.size?item.size:36"></fui-icon> -->
						</view>
						<view class="fui-share-text">{{item.name}}</view>
					</view>
					<view class="fui-empty">!</view>
				</view>
	
			</view>
	
		
			<view class="fui-btn-cancle" @tap="popup">取消</view>
		</view>
	</fui-bottom-popup>
	<!--底部分享弹窗-->
</template>

<script>
	export default {
		name: 'fuiSharemodel',
		data() {
			return {
				popupShowstatus:false,
				shareList: [{
					share: [ {
						name: "微信",
						icon: "icon-weixinzhifu",
						color: "#80D640"
					}, {
						name: "海报",
						icon: "icon-haibaofenxiang",
						color: "#80D640",
						size: 32
					}]
				}]
			};
		},
		props:{
			//是否显示分享model
			popupShow: {
				type: Boolean,
				default: false
			},
			contentHeight:{
				type: Number,
				default: 0
			},
			//是否是tabbar页面
			hasTabbar:{
				type: Boolean,
				default: false
			},
			// shareList:{
			// 	type: Array,
			// 	default: function(){
			// 		return [];
			// 	}
			// }
		},
		created() {
			this.popupShowstatus = this.popupShow
			console.log('当前状态',this.popupShow)
		},
		methods:{
			popup: function() {
				this.popupShow = !this.popupShow
			},
			sharbutton(event){
				console.log(event,event.currentTarget.dataset.index)
				this.$emit("sharbutton", event.currentTarget.dataset.index);
			}
		},
		
	}
</script>

<style>
	.share-main{
		min-height:125rpx;
		padding-bottom: 120rpx;
	}
	.fui-share {
		background: #e8e8e8;
		position: relative;
		padding-bottom: env(safe-area-inset-bottom);
	}
	
	.fui-share-title {
		font-size: 26rpx;
		color: #7E7E7E;
		text-align: center;
		line-height: 26rpx;
		padding: 20rpx 0 50rpx 0;
	}
	
	.fui-share-top,
	.fui-share-bottom {
		min-width: 101%;
		padding: 0 20rpx 0 30rpx;
		white-space: nowrap;
	}
	
	.fui-mt {
		margin-top: 30rpx;
		padding-bottom: 150rpx;
	}
	
	.fui-share-item {
		/* width: 126rpx;
		display: inline-block;
		margin-right: 24rpx; */
		text-align: center;
	}
	
	.fui-item-last {
		margin: 0;
	}
	
	.fui-empty {
		display: inline-block;
		width: 30rpx;
		visibility: hidden;
	}
	
	.fui-share-icon {
		display: flex;
		align-items: center;
		justify-content: center;
		background: #fafafa;
		height: 126rpx;
		width: 126rpx;
		border-radius: 32rpx;
		margin: 0 auto;
	}
	
	.fui-share-text {
		font-size: 24rpx;
		color: #7E7E7E;
		line-height: 24rpx;
		padding: 20rpx 0;
		white-space: nowrap;
	}
	
	.fui-btn-cancle {
		width: 100%;
		height: 100rpx;
		position: absolute;
		left: 0;
		bottom: 0;
		background: #f6f6f6;
		font-size: 36rpx;
		color: #3e3e3e;
		display: flex;
		align-items: center;
		justify-content: center;
		padding-bottom: env(safe-area-inset-bottom);
	}
	
	.fui-hover {
		background: rgba(0, 0, 0, 0.2)
	}
</style>

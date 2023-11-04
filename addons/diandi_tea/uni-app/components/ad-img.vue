<template>
	<view>
		<view class="cu-modal" :class="adStatus">
			<view class="cu-dialog">
				<view class="bg-img" 
					@click="previewImage"
				style="height:380px;background-size: auto;" 
				:style="{'background-image':'url('+img+')'}">
					<view class="cu-bar justify-end text-white">
						<view class="action" @tap="hideModal">
							<text class="cuIcon-close "></text>
						</view>
					</view>
				</view>
				<view class="cu-bar bg-white">
					<view class="action margin-0 flex-sub  solid-left" @tap="hideModal">{{adBtnText}}</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				adStatus:'hide'
			};
		},
		props:{
			showStatus:{
				type: String,
				default: 'hide'
			},
			adBtnText:{
				type: String,
				default: '关闭'
			},
			img:{
				type: String,
				default: ''
			}
		},
		watch:{
			 showStatus(val, oldVal){//普通的watch监听
					this.adStatus = val
					 console.log("a: "+val, oldVal);
			 },
		},
		created() {
			console.log('广告图片',this.showStatus)
			this.adStatus = this.showStatus
		},
		methods:{
			hideModal(e) {
				this.adStatus = 'hide'
			},
			previewImage: function(e) {
				let that = this
				console.log(that.img)
				uni.previewImage({
					current: that.img,
					urls: [that.img]
				});
			},
		}
	}
</script>

<style>
	button .cu-tag {
		position: absolute;
		top: 8upx;
		right: 8upx;
	}
	
	
/* ==================
         模态窗口
 ==================== */

.cu-modal {
	position: fixed;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	z-index: 1110;
	opacity: 0;
	outline: 0;
	text-align: center;
	-ms-transform: scale(1.185);
	transform: scale(1.185);
	backface-visibility: hidden;
	perspective: 2000upx;
	background: rgba(0, 0, 0, 0.6);
	transition: all 0.3s ease-in-out 0s;
	pointer-events: none;
}

.cu-modal::before {
	content: "\200B";
	display: inline-block;
	height: 100%;
	vertical-align: middle;
}

.cu-modal.show {
	opacity: 1;
	transition-duration: 0.3s;
	-ms-transform: scale(1);
	transform: scale(1);
	overflow-x: hidden;
	overflow-y: auto;
	pointer-events: auto;
}

.cu-dialog {
	position: relative;
	display: inline-block;
	vertical-align: middle;
	margin-left: auto;
	margin-right: auto;
	width: 80%;
	max-width: 100%;
	background-color: #f8f8f8;
	border-radius: 10upx;
	overflow: hidden;
}

.cu-modal.bottom-modal::before {
	vertical-align: bottom;
}

.cu-modal.bottom-modal .cu-dialog {
	width: 100%;
	border-radius: 0;
}

.cu-modal.bottom-modal {
	margin-bottom: -1000upx;
}

.cu-modal.bottom-modal.show {
	margin-bottom: 0;
}

.cu-modal.drawer-modal {
	transform: scale(1);
	display: flex;
}

.cu-modal.drawer-modal .cu-dialog {
	height: 100%;
	min-width: 200upx;
	border-radius: 0;
	margin: initial;
	transition-duration: 0.3s;
}

.cu-modal.drawer-modal.justify-start .cu-dialog {
	transform: translateX(-100%);
}

.cu-modal.drawer-modal.justify-end .cu-dialog {
	transform: translateX(100%);
}

.cu-modal.drawer-modal.show .cu-dialog {
	transform: translateX(0%);
}
.cu-modal .cu-dialog>.cu-bar:first-child .action{
  min-width: 100rpx;
  margin-right: 0;
  min-height: 100rpx;
}
</style>
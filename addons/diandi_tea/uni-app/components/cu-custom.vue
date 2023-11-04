<template>
	<view>
		<view class="cu-custom" :style="[{height:CustomBarH + 'px'}]">
			<view class="cu-bar fixed" :style="style" :class="[bgImage!=''?'none-bg text-white bg-img':'',bgColor]">
				<view class="action" @tap="BackPage" v-if="isBack">
					<text class="cuIcon-back"></text>
					<slot name="backText"></slot>
				</view>
				<view class="content" :style="[{top:isTop? StatusBar+ 'px' : 0 + 'px'}]">
					<slot name="content"></slot>
				</view>
				<slot name="right"></slot>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				StatusBar: this.StatusBar,
				CustomBarH: 0,
				isTop:true
			};
		},
		name: 'cu-custom',
		computed: {
			style() {
				var StatusBar= this.isTop? this.StatusBar: 0;
				var CustomBar= this.CustomBar;
				var bgImage = this.bgImage;
				
				var style = `height:${CustomBar-this.StatusBar}px;padding-top:${StatusBar}px;`;
				console.log('style',style,CustomBar)
				if (this.bgImage) {
					style = `${style}background-image:url(${bgImage});`;
				}
				return style
			}
		},
		props: {
			bgColor: {
				type: String,
				default: ''
			},
			isBack: {
				type: [Boolean, String],
				default: false
			},
			bgImage: {
				type: String,
				default: ''
			},
		},
		created() {
			// #ifndef MP 
			this.isTop=true
			// #endif 
			// #ifdef MP
			this.isTop=false
			// #endif 
			 this.CustomBarH=this.CustomBar? this.CustomBar-this.StatusBar: this.isTop
		},
		methods: {
			BackPage() {
				if (getCurrentPages().length < 2 && 'undefined' !== typeof __wxConfig) {
					let url = '/' + __wxConfig.pages[0]
					return uni.redirectTo({url})
				}
				uni.navigateBack({
					delta: 1
				});
			}
		}
	}
</script>

<style>

</style>

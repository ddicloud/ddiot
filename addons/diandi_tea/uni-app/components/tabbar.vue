<template>
	<view>
		<fui-tabbar :tabBar="tabBar2" :selectedColor="selectedColor"  
		:hump="hump" :current="current" @click="tabbarSwitch">
		</fui-tabbar>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				hump:false,
				current: 0,
				selectedColor:"#000000",
				tabBar2: [{
						"pagePath": "index",
						"text": "首页",
						"iconPath": "https://cdn.dzwztea.cn/tea/images/sy1.png",
						"selectedIconPath": "https://cdn.dzwztea.cn/tea/images/sy2.png",
					},
					{
						"pagePath": "mecenter",
						"text": "VIP",
						"iconPath": "https://cdn.dzwztea.cn/tea/images/vip1.png",
						"selectedIconPath": "https://cdn.dzwztea.cn/tea/images/vip2.png",
						"isDot": true,
						"verify": true
					},
					{
						"pagePath": "reserve",
						"text": "订单",
						"iconPath": "https://cdn.dzwztea.cn/tea/images/yd1.png",
						"selectedIconPath": "https://cdn.dzwztea.cn/tea/images/yd2.png",
						"isDot": true,
						"verify": true
					},
					{
						"pagePath": "my",
						"text": "我的",
						"iconPath": "https://cdn.dzwztea.cn/tea/images/my1.png",
						"selectedIconPath": "https://cdn.dzwztea.cn/tea/images/my2.png",
						"isDot": true,
						"verify": true
					}
				],
			}
		},
		props:{
			currentindex:{
				type: Number,
				default: 0
			}
		},
		created() {
			let that = this
			if(this.currentindex){
				this.current = this.currentindex
			}else{
				this.current = that.$store.state.currentindex
			}
			console.log('切换页面',this.current)
		},
		methods: {
			tabbarSwitch(e) {
				let that = this
				//获取登录状态，此处默认未登录
				let isLogin=false
				console.log('切换页面',e.pagePath,e,e.index)
				that.$store.state.currentindex = e.index
				that.$forceUpdate()
				console.log('当前第几个',e.index)
				// if(e.index == 3){
				// 	that.$Router.push({name:e.pagePath})
				// }else{
				// }
				that.$Router.replaceAll({name:e.pagePath})
			},
		}
	}
</script>

<style>
	
</style>

<template>
	<view class="container">
		<view class="fui-title">订单汇总</view>
		<view>
			<block v-for="(item,index) in dataList" :key="index">
				<fui-collapse :index="index" :current="current" @click="change">
					<template v-slot:title>
						<fui-list-cell>{{item.name}}</fui-list-cell>
					</template>
					<template v-slot:content>
						<view class="fui-content " v-for="(order,idx) in item.order" :key="idx">
							<view class="fui-flex padding-left-lg">
								<view class="fui-col-2">
									第{{idx+1}}单
								</view>
								<view class="fui-col-10">
									<view class="fui-col-12">
										开始时间： {{order.start_time}}
									</view>
									<view class="fui-col-12">
										结束时间： {{order.end_time}}
									</view>
								</view>
								
							</view>
						</view>
						<view class="text-center fui-font-size_18" v-if="item.order.length ===0">
							暂无订单数据
						</view>
					</template>
				</fui-collapse>
			</block>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				dataList: [{
						name: "杜甫",
						intro: "杜甫的思想核心是儒家的仁政思想，他有“致君尧舜上，再使风俗淳”的宏伟抱负。杜甫虽然在世时名声并不显赫，但后来声名远播，对中国文学和日本文学都产生了深远的影响。杜甫共有约1500首诗歌被保留了下来，大多集于《杜工部集》。",
						current: 0,
						disabled: false
					},
					{
						name: "李清照",
						intro: "李清照出生于书香门第，早期生活优裕，其父李格非藏书甚富，她小时候就在良好的家庭环境中打下文学基础。出嫁后与夫赵明诚共同致力于书画金石的搜集整理。金兵入据中原时，流寓南方，境遇孤苦。所作词，前期多写其悠闲生活，后期多悲叹身世，情调感伤。形式上善用白描手法，自辟途径，语言清丽。",
						current: -1,
						disabled: false
					},
					{
						name: "鲁迅",
						intro: "鲁迅一生在文学创作、文学批评、思想研究、文学史研究、翻译、美术理论引进、基础科学介绍和古籍校勘与研究等多个领域具有重大贡献。他对于五四运动以后的中国社会思想文化发展具有重大影响，蜚声世界文坛，尤其在韩国、日本思想文化领域有极其重要的地位和影响，被誉为“二十世纪东亚文化地图上占最大领土的作家”。",
						current: -1,
						disabled: false
					}
				],
				current:0,
			}
		},
		onShow() {
			this.getOrder()
		},
		methods: {
			getOrder() {
				let that = this;
				that.fui
					.request('diandi_tea/order/info', 'GET', {}, true)
					.then(res => {
						if (res.code === 200) {
							that.dataList=res.data
						} else {
							uni.showToast({
								title: res.message,
								icon: 'none'
							});
						}
					})
					.catch(res => {
						uni.showToast({
							title: res.message,
							icon: 'none'
						});
					});
			},
			change(e) {
				let index = e.index;
				let item = this.dataList[index];
				this.current = index
			},
			change2(e) {
				let index = e.index;
				let item = this.dataList2[index];
				item.current = item.current == index ? -1 : index
			},
			change3(e) {
				//可关闭自身
				this.current = this.current == e.index ? -1 : e.index
			},
			change4(e) {
				//不可关闭自身
				this.current2 = e.index
			}
		}
	}
</script>

<style>
	.container {
		padding: 20rpx 0 120rpx 0;
		box-sizing: border-box;
	}

	.fui-title {
		padding: 40rpx 30rpx 20rpx;
		box-sizing: border-box;
		font-size: 32rpx;
	}

	.fui-content {
		padding: 20rpx 30rpx;
		background-color: #fff;
		color: #555;
		font-size: 26rpx;
	}
</style>

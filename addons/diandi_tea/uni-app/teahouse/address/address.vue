<template>
	<view class="fui-safe-area">
		<view class="padding-tb-sm bg-white text-xs">
			<text class="fui-text-left padding-left-sm">温馨提示：向左滑动可以编辑和删除地址</text>
		</view>
		<view class="fui-address">
			<block v-for="(item,index) in addressLists" :key="index">
				<fui-swipe-action :actions="actions"  @click="handlerButton($event,item.address_id)" :data-id="item.address_id">
					<template v-slot:content>
						<fui-list-cell padding="0" >
							<view class="fui-address-flex"  @click="RadioChange" :data-id="item.address_id" :data-index="index">
								<view class="fui-address-left">
									<view class="fui-address-main">
										<view class="fui-address-name fui-ellipsis">{{item.name}}</view>
										<view class="fui-address-tel">{{item.phone}}</view>
									</view>
									<view class="fui-address-detail">
										<view class="fui-address-label" v-if="item.is_default===1">默认</view>
										<view class="fui-address-label" >{{item.regions.merger_name}}</view>
										<text>{{item.detail}}</text>
									</view>
								</view>
								<view class="fui-address-imgbox" @click="editAddr(index)">
									<image class="fui-address-img" src="https://cnd.dzwztea.cn/tea/images/mall/my/icon_addr_edit.png" />
								</view>
							</view>
						</fui-list-cell>
					</template>
				</fui-swipe-action>
				
				
			</block>
			
			<view class="fui-cart-cell  fui-mtop text-center" v-if="addressLists.length==0">
				<view class="flex-sub  text-xl padding-top text-grey">
					<iconfont className="icon-meiyoudingdan-01" size="100" color="#e5e5e5"></iconfont>
					没有收货地址
				</view>
			</view>
			
		</view>
		<!-- 新增地址 -->
		<view class="fui-address-new" >
			<fui-button shadow shape="circle" type="bluegreen" height="88rpx" @click="addAddr">+ 新增收货地址</fui-button>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				actions: [
					{
						name: '删除',
						color: '#fff',
						fontsize: 30, //单位rpx
						width: 70, //单位px
						background: '#FD3B31'
					},
					{
						name: '修改',
						color: '#fff',
						fontsize: 30,
						width: 70,
						background: '#5677fc'
					}
				],
				addressList: [1,2,3],
				addressLists:[],
			}
		},
		onShow(){
			let that = this
			that.initPage()
		},
		onLoad(){
			
		},
		methods: {
			initPage(){
				let that = this
				that.getlist()
			},
			addAddr(){
				let that = this
				that.$Router.push({name:'editAddress'})
			},
			editAddr(index, addressType) {
				let that = this
				console.log(that.addressLists,index)
				uni.navigateTo({
					url: "../editAddress/editAddress?id="+that.addressLists[index].address_id
				})
			},
			handlerButton(e,id) {
				let that = this
				let index = e.index;
				console.log(e,id)
				console.log(index)
				if(index==0){
					that.del(id)
				}else if(index==1){
					that.$Router.push({name:'editAddress',params:{id:id}})
				}
			},
			RadioChange(e) {
				let that = this
				console.log(e)
				let radio = e.currentTarget.dataset.id
				let index = e.currentTarget.dataset.index
				uni.setStorageSync('addressSet',that.addressLists[index])
				uni.navigateBack({
					delta:1
				})
			},
			getlist(){
				let that = this
				that.fui.request("diandi_distribution/address/lists","POST",true,{}).then((res)=>{
					uni.hideLoading();
					if(res.code==200){
						that.addressLists = res.data
						res.data.forEach(items=>{
							if(items.is_default==1){
								that.radio = items.address_id
							}
						})
						console.log('默认收货地址',res)
					}else{
						that.fui.toast(res.message);
					}
					console.log('商品详情222',res.data);
				}).catch((err)=>{
					console.log("错误",err);
				});
				
				
			},
			del(id){
				let that = this
				that.fui.request("diandi_distribution/address/deletes","POST",{
						'address_id':id
				}).then((res)=>{
					uni.hideLoading();
					if(res.code==200){
						that.addressLists = res.data
						res.data.forEach(items=>{
							if(items.is_default==1){
								that.radio = items.address_id
							}
						})
						console.log('默认收货地址',res)
					}else{
						that.fui.toast(res.message);
					}
				}).catch((err)=>{
					console.log("错误",err);
				});
				
			
			}
		}
	}
</script>

<style>
	.fui-address {
		width: 100%;
		padding-top: 20rpx;
		padding-bottom: 160rpx;
	}
	.fui-address-flex {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.fui-address-main {
		width: 600rpx;
		height: 70rpx;
		display: flex;
		font-size: 30rpx;
		line-height: 86rpx;
		padding-left: 30rpx;
	}

	.fui-address-name {
		width: 120rpx;
		height: 60rpx;
	}

	.fui-address-tel {
		margin-left: 10rpx;
	}

	.fui-address-detail {
		font-size: 24rpx;
		word-break: break-all;
		padding-bottom: 25rpx;
		padding-left: 25rpx;
		padding-right: 120rpx;
	}

	.fui-address-label {
		padding: 5rpx 8rpx;
		flex-shrink: 0;
		background: #218569;
		border-radius: 6rpx;
		color: #fff;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		font-size: 25rpx;
		line-height: 25rpx;
		transform: scale(0.8);
		transform-origin: center center;
		margin-right: 6rpx;
	}

	.fui-address-imgbox {
		width: 80rpx;
		height: 100rpx;
		position: absolute;
		display: flex;
		justify-content: center;
		align-items: center;
		right: 10rpx;
	}

	.fui-address-img {
		width: 36rpx;
		height: 36rpx;
	}

	.fui-address-new {
		width: 100%;
		position: fixed;
		left: 0;
		bottom: 0;
		z-index: 999;
		padding: 20rpx 25rpx 30rpx;
		box-sizing: border-box;
		background: #fafafa;
	}

	.fui-safe-area {
		padding-bottom: env(safe-area-inset-bottom);
	}
</style>

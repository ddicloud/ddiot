<template>
	<view class="container">
		<view class="fui-box">
			<fui-list-cell :arrow="true" unlined :radius="true" @click="chooseAddr">
				<view class="fui-address">
					<view v-if="userAddress.name">
						<view class="fui-userinfo">
							<text class="fui-name">{{userAddress.name}}</text>{{userAddress.phone}}
						</view>
						<view class="fui-addr">
							<view class="fui-addr-tag">{{userAddress.regions.merger_name}}</view>
							<text>{{userAddress.detail}}</text>
						</view>
					</view>
					<view class="fui-none-addr" v-else>
						<image src="https://cnd.dzwztea.cn/tea/images/index/map.png" class="fui-addr-img" mode="widthFix"></image>
						<text>选择收货地址</text>
					</view>
				</view>
				<view class="fui-bg-img"></view>
			</fui-list-cell>
			
		
			
			<view class="fui-top fui-goods-info">
				<fui-list-cell :hover="false" :lineLeft="false">
					<view class="fui-goods-title">
						商品信息
					</view>
				</fui-list-cell>
				<block v-for="(item,index) in goodslist" :key="index">
					<fui-list-cell :hover="false" padding="0">
						<view class="fui-goods-item">
							<image :src="item.goods.thumb" class="fui-goods-img"></image>
							<view class="fui-goods-center">
								<view class="fui-goods-name">{{item.goods.goods_name}}</view>
								<!-- <view class="fui-goods-attr">{{item.spec_val}}</view> -->
							</view>
							<view class="fui-price-right">
								<view>x{{item.number}}</view>
							</view>
						</view>
					</fui-list-cell>
				</block>
				<fui-list-cell :hover="false">
					<view class="fui-padding fui-flex">
						<view>团豆总额</view>
						<view>
							<iconfont className="icon-jifen" size="20">
								<text class="padding-left-xs">{{total_integral}}</text>
							</iconfont>
						</view>
					</view>
				</fui-list-cell>
				<!-- <fui-list-cell :arrow="hasCoupon" :hover="hasCoupon">
					<view class="fui-padding fui-flex">
						<view>优惠券</view>
						<view :class="{'fui-color-red':hasCoupon}">{{hasCoupon?"满5减1":'没有可用优惠券'}}</view>
					</view>
				</fui-list-cell>
				<fui-list-cell :hover="true" :arrow="true">
					<view class="fui-padding fui-flex">
						<view>发票</view>
						<view class="fui-invoice-text">不开发票</view>
					</view>
				</fui-list-cell> -->
				<fui-list-cell :hover="false">
					<view class="fui-padding fui-flex">
						<view>配送费</view>
						<view>￥{{freight}}</view>
					</view>
				</fui-list-cell>
				<fui-list-cell :hover="false" :lineLeft="false" padding="0">
					<view class="fui-remark-box fui-padding fui-flex">
						<view>订单备注</view>
						<input type="text" class="fui-remark" 
							placeholder="选填: 请先和商家协商一致" 
							placeholder-class="fui-phcolor"
							 @input="textareaBInput" 
						></input>
					</view>
				</fui-list-cell>
				<fui-list-cell :hover="false" unlined>
					<view class="fui-padding fui-flex fui-total-flex">
						<view class="fui-flex-end color15">
							<view class="text-grey">合计： </view>
							<view >
								<iconfont className="icon-fl-renminbi" size="15">
									<text class="fui-price-large">{{payPrice}}</text> +
								</iconfont>
							</view>
							<view>
								<iconfont className="icon-jifen" size="15">
									<text class="fui-price-large">{{total_integral}}</text>
								</iconfont>
							</view>
						</view>
					</view>
				</fui-list-cell>
			</view>

			<!-- <view class="fui-top">
				<fui-list-cell unlined :hover="insufficient" :radius="true" :arrow="insufficient">
					<view class="fui-flex">
						<view class="fui-balance">余额支付<text class="fui-gray">(￥2019.00)</text></view>
						<switch color="#19be6b" class="fui-scale-small" v-show="!insufficient" />
						<view class="fui-pr-30 fui-light-dark" v-show="insufficient">余额不足, 去充值</view>
					</view>
				</fui-list-cell>
			</view> -->
		</view>
		<view class="fui-safe-area"></view>
		<view class="fui-tabbar">
			<view class="fui-flex-end color15 fui-pr-20" >
				运费：{{payPrice}}+
				<view>
					<iconfont className="icon-jifen" size="25" >
						<text class="padding-left-xs fui-price-large">
								{{total_integral}}
						</text>
					</iconfont>
				</view>
			</view>
			<view class="fui-pr25">
				<fui-button width="200rpx" height="70rpx" :size="28" type="bluegreen" shape="circle" @click="nowsuborder" >确认兑换</fui-button>
			</view>
		</view>
		
		<t-pay-way :show="show" @close="popupClose"></t-pay-way>
	</view>
</template>

<script>
	import tPayWay from "@/components/views/t-pay-way/ti-pay-way"
	export default {
		components: {
			tPayWay
		},
		data() {
			return {
				expressType_open:true,
				total_integral:0,
				opensub:false,
				storeData:{},
				shoppingCart:[],
				userAddress:{},
				totalPrice:0,
				payPrice:0,
				freight:0,
				is_usecache:0,
				remark:'',
				region_id:0,
				goodslist:[],
				cartIds:'',
				hasCoupon: true,
				insufficient: false,
				show: false,
				goods_id:'',
				goodsNumber:'',
				spec_id:'',
				subType:0,
				goods_type:0,
				order_type:0,
				// 配送方式选择
				expressType:[
					{name:'快递配送'},
					{name:'到店自提'},
				],
				currentTab:0
			}
		},
		onLoad(options) {
			let that = this
			that.goods_id     = that.$Route.query.goods_id;
			that.goodsNumber  = that.$Route.query.goodsNumber;
			that.spec_id      = that.$Route.query.specKeyId || '';
			that.goods_type   = that.$Route.query.goods_type;
			that.order_type   = that.$Route.query.order_type;
			that.cartIds = that.$Route.query.cartIds || '';
			console.log('订单请求参数',that)
			if(that.goods_id){
				that.subType = 1
			}
			
			// that.fui.store().then((res)=>{
			// 	console.log('AAAAAAAAAA',res)
			// 	that.storeData = res
			// 	if(res.send_type.length != 2){
			// 		console.log('send_type',res.send_type,res.send_type[0])
			// 		if(res.send_type[0]==0){
			// 			that.currentTab = 0
			// 		}else if(res.send_type[0]==1){
			// 			that.currentTab = 1
			// 		}	
			// 		that.expressType_open = false
			// 	}
				
			// }).catch((res)=>{
			// 	console.log('shibai',res)
			// });
			
			console.log('初始1',that.cartIds,that.spec_id)
		},
		onShow() {
			let that = this
			that.initPage()
			
			uni.getStorage({
			    key: 'addressSet',
			    success: function (res) {
					console.log('地址缓存',res)
					if(res.data.name){
						that.is_usecache = 1
						that.userAddress = res.data
						that.address_id = res.data.address_id
					}
					
			    },
				complete(res) {
					console.log('地址缓存错误',res)
					console.log(res)
				}
			});
		},
		methods: {
			initPage(){
				let that = this
				
				if(that.subType==0){
					that.getCartlist()
				}else if(that.subType==1){
					that.getdetail()
				}
				
				if(that.is_usecache==0){
					that.getdefalut()
				}
				
			},
			textareaBInput(e) {
				this.remark = e.detail.value
			},
			change(e) {
				var that = this;
				that.currentTab = e.index
				that.initPage()
			},
			getdefalut(){
				let that = this
				that.fui.request("diandi_distribution/address/getdefault","POST",{}).then((res)=>{
					if(res.code==200){
						that.userAddress = res.data
						console.log('默认收货地址',res)
						that.address_id = res.data.address_id
						that.userName = res.data.member.username
						that.mobile = res.data.member.mobile
						that.address = res.data.member.address
						that.region_id = res.data.city.id
						
					}else{
						that.fui.toast(res.message);
					}
					console.log('商品详情222',res.data);
				}).catch((err)=>{
					console.log("错误",err);
				});
			},
			// 获取详情
			getdetail(){
				let that = this
				let goods_id = that.goods_id
				
				that.fui.request("diandi_integral/order/orderdetail","GET",{
					goods_id:goods_id,
					goods_number: that.goodsNumber,
					spec_id: that.spec_id,
					goods_type: that.goods_type,
					region_id:that.region_id,
					express_type:that.currentTab
				}).then((res)=>{
					console.log('商品详情立即购买',res.code==200,res.code,res.data)
					if(res.code==200){
						let  goodsNumber = that.goodsNumber
						let  spec_id     = that.spec_id
						that.goodslist  = res.data.goods
						// 总积分
						that.total_integral = res.data.total_integral
						
						console.log('that.goodslist详情',that.goodslist,res.data.pay_price)
						//总价
						that.payPrice  = res.data.pay_price
						that.freight   = res.data.freight;
						that.totalNumber  = res.data.goodsTotalNumber;
					}else{
						that.opensub = true
						that.fui.toast(res.message);
					}
				}).catch((res)=>{
					console.log('获取详情失败',res)
				})
				
			},	
			selectAreas(){
				uni.navigateTo({
					url:"../address/selects"
				})
			},
			nowsuborder(){
				let that = this
				console.log()
				if(that.is_distance==1){
					that.fui.toast('超出配送范围，不能下单')
					return false;
				}
				
				if(that.is_submit){
					return false;
				} 
				let address_id = that.address_id
				let ids = []
				ids.push(that.goods_id)
				console.log('购物车id',ids,JSON.stringify(ids))
				
				
				let data = {
					goods: JSON.stringify(ids),
					spec_id:that.spec_id,
					goods_id:that.goods_id,
					goods_num:that.goodsNumber,
					order_type: that.order_type,
					goods_type: that.goods_type,
					total_price: that.totalPrice,
					express_price: that.freight,
					express_type: that.currentTab,
					name: that.userName,
					phone: that.mobile,
					delivery_time:'',
					detail: that.address,
					address_id:address_id,
					remark:that.remark
				}
				
				
				that.fui.request("diandi_integral/order/creategoodsorder","POST",data,true).then((res)=>{
						console.log('订单提交',res)
						if(res.code==200){
							let orderInfo = res.data
							that.orderInfo = orderInfo
							that.is_submit = true
							let  body = orderInfo.body,
							out_trade_no=orderInfo.order_no,
							total_fee = orderInfo.pay_price,
							order_id = orderInfo.order_id
							
							if(that.freight == 0){
									// 直接兑换
									that.exchageCredit(order_id);
							}else{
								that.fui.wechatpay(body,out_trade_no,total_fee,order_id,function(res){
									// console.log(res)
									that.$Router.push({name:'success',params:{order_id,order_id}})
								});
							}
							
						}else{
							that.fui.toast(res.message);
						}
					// console.log('商品详情222',res.data);
				}).catch((err)=>{
					that.fui.toast(res.message);
					console.log("错误",err);
				});
			},
			exchageCredit(order_id){
				let that = this
				that.fui.request("diandi_integral/order/exchange","POST",{
					order_id:order_id
				},true).then((res)=>{
					if(res.code==200){
						that.fui.modal("兑换提示", res.message, false,() => {
							that.$Router.push({name:'index'})
						},'','我知道了')
						
					}else{
						that.fui.toast(res.message);
					}
					
				}).catch((err)=>{
					console.log("错误",err);
				});
			},
			chooseAddr() {
				let that = this
				that.is_submit = false
				that.$Router.push({name:'address'})
			},
			btnPay() {
				this.show = true
			},
			popupClose() {
				this.show = false
			}
		}
	}
</script>

<style>
	.container {
		padding-bottom: 98rpx;
	}

	.fui-box {
		padding: 20rpx 0 118rpx;
		box-sizing: border-box;
	}

	.fui-address {
		min-height: 80rpx;
		padding: 10rpx 0;
		box-sizing: border-box;
		position: relative;
	}

	.fui-userinfo {
		font-size: 30rpx;
		font-weight: 500;
		line-height: 30rpx;
		padding-bottom: 12rpx;
	}

	.fui-name {
		padding-right: 40rpx;
	}

	.fui-addr {
		font-size: 24rpx;
		word-break: break-all;
		padding-right: 25rpx;
	}

	.fui-addr-tag {
		padding: 5rpx 8rpx;
		flex-shrink: 0;
		background: #218569;
		color: #fff;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		font-size: 25rpx;
		line-height: 25rpx;
		transform: scale(0.8);
		transform-origin: 0 center;
		border-radius: 6rpx;
	}

	.fui-bg-img {
		position: absolute;
		width: 100%;
		height: 8rpx;
		left: 0;
		bottom: 0;
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAL0AAAAECAMAAADszM6/AAAAOVBMVEUAAAAVqfH/fp//vWH/vWEVqfH/fp8VqfH/fp//vWEVqfH/fp8VqfH/fp//vWH/vWEVqfH/fp//vWHpE7b6AAAAEHRSTlMA6urqqlVVFRUVq6upqVZUDT4vVAAAAEZJREFUKM/t0CcOACAQRFF6r3v/w6IQJGwyDsPT882IQzQE0E3chToByjG5LwMgLZN3TQATmdypCciBya0cgOT3/h//9PgF49kd+6lTSIIAAAAASUVORK5CYII=") repeat;
	}

	.fui-top {
		margin-top: 20rpx;
		overflow: hidden;
	}

	.fui-goods-title {
		font-size: 28rpx;
		display: flex;
		align-items: center;
	}

	.fui-padding {
		box-sizing: border-box;
	}

	.fui-goods-item {
		width: 100%;
		padding: 20rpx 30rpx;
		box-sizing: border-box;
		display: flex;
		justify-content: space-between;
	}

	.fui-goods-img {
		width: 180rpx;
		height: 180rpx;
		display: block;
		flex-shrink: 0;
	}

	.fui-goods-center {
		flex: 1;
		padding: 20rpx 8rpx;
		box-sizing: border-box;
	}

	.fui-goods-name {
		max-width: 310rpx;
		word-break: break-all;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 2;
		font-size: 26rpx;
		line-height: 32rpx;
	}

	.fui-goods-attr {
		font-size: 22rpx;
		color: #888888;
		line-height: 32rpx;
		padding-top: 20rpx;
		word-break: break-all;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-box-orient: vertical;
		-webkit-line-clamp: 2;
	}

	.fui-price-right {
		text-align: right;
		font-size: 24rpx;
		color: #888888;
		line-height: 30rpx;
		padding-top: 20rpx;
	}

	.fui-flex {
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: space-between;
		font-size: 26rpx;
	}

	.fui-total-flex {
		justify-content: flex-end;
	}

	.fui-color-red,
	.fui-invoice-text {
		color: #E41F19;
		padding-right: 30rpx;
	}

	.fui-balance {
		font-size: 28rpx;
		font-weight: 500;
	}

	.fui-black {
		color: #222;
		line-height: 30rpx;
	}

	.fui-gray {
		color: #888888;
		font-weight: 400;
	}

	.fui-light-dark {
		color: #666;
	}

	.fui-goods-price {
		display: flex;
		align-items: center;
		padding-top: 20rpx;
	}

	.fui-size-26 {
		font-size: 26rpx;
		line-height: 26rpx;
	}

	.fui-price-large {
		font-size: 34rpx;
		line-height: 32rpx;
		font-weight: 600;
	}

	.fui-flex-end {
		display: flex;
		align-items: flex-end;
		padding-right: 0;
	}

	.fui-phcolor {
		color: #B3B3B3;
		font-size: 26rpx;
	}

	/* #ifndef H5 */
	.fui-remark-box {
		padding: 22rpx 30rpx;
	}

	/* #endif */
	/* #ifdef H5 */
	.fui-remark-box {
		padding: 26rpx 30rpx;
	}

	/* #endif */

	.fui-remark {
		flex: 1;
		font-size: 26rpx;
		padding-left: 64rpx;
	}

	.fui-scale-small {
		transform: scale(0.8);
		transform-origin: 100% center;
	}

	.fui-scale-small .wx-switch-input {
		margin: 0 !important;
	}

	/* #ifdef H5 */
	>>>uni-switch .uni-switch-input {
		margin-right: 0 !important;
	}

	/* #endif */
	.fui-tabbar {
		width: 100%;
		height: 98rpx;
		background: #fff;
		position: fixed;
		left: 0;
		bottom: 0;
		display: flex;
		align-items: center;
		justify-content: flex-end;
		font-size: 26rpx;
		box-shadow: 0 0 1px rgba(0, 0, 0, .3);
		padding-bottom: env(safe-area-inset-bottom);
		z-index: 996;
	}

	.fui-pr-30 {
		padding-right: 30rpx;
	}

	.fui-pr-20 {
		padding-right: 20rpx;
	}

	.fui-none-addr {
		height: 80rpx;
		padding-left: 5rpx;
		display: flex;
		align-items: center;
	}

	.fui-addr-img {
		width: 36rpx;
		height: 46rpx;
		display: block;
		margin-right: 15rpx;
	}


	.fui-pr25 {
		padding-right: 25rpx;
	}

	.fui-safe-area {
		height: 1rpx;
		padding-bottom: env(safe-area-inset-bottom);
	}
	
	.fui-item-box {
		width: 100%;
		display: flex;
		align-items: center;
	}
	
	.fui-list-cell_name {
		padding-left: 20rpx;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	
	.fui-ml-auto {
		margin-left: auto;
	}
	
	.fui-right {
		margin-left: auto;
		margin-right: 34rpx;
		font-size: 26rpx;
		color: #999;
	}
	
	.fui-logo {
		height: 52rpx;
		width: 52rpx;
		flex-shrink: 0;
	}
	
	.fui-flex {
		display: flex;
		align-items: center;
	}
	
	.fui-msg-box {
		display: flex;
		align-items: center;
	}
	
	.fui-msg-pic {
		width: 100rpx;
		height: 100rpx;
		border-radius: 50%;
		display: block;
		margin-right: 24rpx;
		flex-shrink: 0;
	}
	
	.fui-msg-item {
		max-width: 500rpx;
		min-height: 80rpx;
		overflow: hidden;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}
	
	.fui-msg-name {
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
		font-size: 34rpx;
		line-height: 1;
		color: #262b3a;
	}
	
	.fui-msg-content {
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
		font-size: 26rpx;
		line-height: 1;
		color: #9397a4;
	}
	
	.fui-msg-right {
		max-width: 120rpx;
		height: 88rpx;
		margin-left: auto;
		text-align: right;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		align-items: flex-end;
	}
	
	.fui-right-dot {
		height: 76rpx !important;
		padding-bottom: 10rpx !important;
	
	}
	
	.fui-msg-time {
		width: 100%;
		font-size: 24rpx;
		line-height: 24rpx;
		color: #9397a4;
	}
</style>

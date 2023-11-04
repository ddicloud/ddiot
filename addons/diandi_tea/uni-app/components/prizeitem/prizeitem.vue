<template>
	<view>
		<view class="container">
			<view class="prizeitem">
				<view class="cu-form-group">
					<view class="title">{{levelname}}等奖</view>
					<view class="fui-center  fui-col-6">
						<view class="fui-col-6" :data-level="prizeitemindex" @click="prizeType($event,0)">
								<fui-tag margin="20rpx 20rpx 0 0" plain :type="prizeTypes[prizeitemindex]=='实物'?'warning':'black'" >实物</fui-tag>
						</view>
						<view class="fui-col-6" :data-level="prizeitemindex"  @click="prizeType($event,1)">
							<fui-tag margin="20rpx 20rpx 0 0" plain :type="prizeTypes[prizeitemindex]=='虚拟'?'warning':'black'" >虚拟</fui-tag>
						</view>
					</view>
				</view>
				
				<view class="cu-form-group fui-flex">
						<view class="fui-default fui-col-12 margin-sm" v-if="imgList[prizeitemindex]">
							<view class="prizelevelimg" @click="chooseImage(prizeitemindex)">
								<image :src="imgList[prizeitemindex]" class="fui-article-pic" mode="aspectFit"></image>
							</view>
						</view>
						<view class=" selectimg fui-col-12 bg-gray text-center" v-if="!imgList[prizeitemindex]">
							
							<button class="cu-btn round bg-white" @click="chooseImage(prizeitemindex)" >上传图片</button>
						</view>
				</view>
				
				
				<view class="cu-form-group">
					<view class="title">奖品名称</view>
					<input placeholder="请输入40字以内" @input="prizeName" v-model="prizeNames[prizeitemindex]"  :name="names[prizeitemindex]"></input>
				</view>
				<view class="cu-form-group">
					<view class="title">奖品份数</view>
					<input placeholder="请输入(999以内)" @input="prizeStock" v-model="prizeStocks[prizeitemindex]"  type="number"  :name="stocks[prizeitemindex]"></input>
				</view>
				
				<view class="cu-form-group margin-top">
					<view class="title">奖品需邮寄</view>
					<switch @change="switchChange($event)" :class="is_postages[prizeitemindex]?'checked':''" :checked="is_postages[prizeitemindex]?true:false"></switch>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				// prizeitemindex:1,
				levelname:'一',
				// is_postages:[],
				names:[],
				prize_names:[],
				types:['实物','虚拟'],
				// prizeTypes:[],
				stocks:[],
				thumbs:[],
				textArr:[
					  {name:0,value:'十'},            
					  {name:1,value:'一'},
					  {name:2,value:'二'},
					  {name:3,value:'三'},
					  {name:4,value:'四'},
					  {name:5,value:'五'},
					  {name:6,value:'六'},
					  {name:7,value:'七'},
					  {name:8,value:'八'},
					  {name:9,value:'九'}
			    ]
			};
		},
		props: {
			prizeitemindex: {
				type: Number,
				default: 1
			},
			imgList:{
				type:Array,
				default: function(){
					return [];
				}
			},
			is_postages:{
				type:Array,
				default: function(){
					return [];
				}
			},
			prizeTypes:{
				type:Array,
				default: function(){
					return [];
				}
			},
			prizeNames:{
				type:Array,
				default: function(){
					return [];
				}
			},
			prizeStocks:{
				type:Array,
				default: function(){
					return [];
				}
			},
			levelImage:{
				type:Array,
				default: function(){
					return [];
				}
			},
		},
		watch:{
			specStatus(val) {
				console.log(val,345)
				this.specClass = val;
			},
			prizeNames(val){
				console.log('jiant',val)
			}
		},
		created() {
			let that = this
			let text = this.numText(this.prizeitemindex);
			this.levelname = text;
			console.log('奖品名称',this.prizeNames,this.prizeStocks)
			console.log(this.prizeitemindex,text);
			
			that.$set(that.levelImage,this.prizeitemindex,'')
			that.$set(that.imgList,this.prizeitemindex,'')
			
			this.$set(this.prizeTypes,this.prizeitemindex,'实物')  
			this.$set(this.is_postages,this.prizeitemindex,false);
			this.$emit("prizeType",this.prizeTypes);
			this.$emit("switchChange",this.is_postages);
			
		},
		methods:{      
			  chooseImage(levelnum) {
				  let that = this
				  console.log('多少级了',that.prizeitemindex) 
			  	//uni.chooseImage 返回的 tempFilePaths 如果为空，检查自己的开发工具是否为最新版
			  	uni.chooseImage({
			  		count: 1,
			  		sizeType: ['original', 'compressed'],
			  		sourceType: ['album', 'camera'],
			  		success: res => {
			  			const tempFilePaths = res.tempFilePaths[0];
						that.fui.uploadFile(tempFilePaths).then((res)=>{
								console.log('行不行',res)
								let thumbs = []
								let levelImage = []
								that.$set(thumbs,levelnum,res.url)
								that.$set(levelImage,levelnum,res.attachment)
								
								console.log('上传后',thumbs)
								
								uni.setStorageSync('thumbs',thumbs)
								uni.setStorageSync('levelImage',levelImage)
								console.log('that.levelImage',that.levelImage)	
								let levelImageVal = []
								that.levelImage.forEach((item,index)=>{
									if(levelnum==index){
										item = res.attachment
									}
									that.$set(that.levelImage,index,item)
									
								})
								console.log('that.levelImage 11',that.levelImage)
								
								console.log('that.imgList',that.imgList)
								let imgListVal = []
								that.imgList.forEach((item,index)=>{
									if(levelnum==index){
										item = res.url
									}
									that.$set(that.imgList,index,item)
								})
								console.log('that.imgList 111',that.imgList)
								this.$emit("getthumbs",that.imgList);
								this.$emit("levelImageVal",that.levelImage);
								
								that.$forceUpdate();
						}).catch((res)=>{});
			  		}
			  	});
			  },
		      //数字转中文
		      numText(num){
		         var numArr = num.toString().split('');
		         var that = this;            
		         var result  = []; 
		         numArr.forEach(res=>{
		             that.textArr.forEach(item=>{                 
		                if(item.name==res){ result.push(item.value) }  
		             })
		         })
		         return result.join('');
		      },
			  prizeName(e){
				  let that = this
				  this.prize_name = e.detail.value
				  that.$set(that.prize_names,that.prizeitemindex,this.prize_name)
				  console.log('输入改变',that.prize_names,that.prizeitemindex,this.prize_name)
				  that.$emit("prizeName",that.prize_names);
			  },
			  prizeStock(e){
				  let that = this
				  this.prize_stock = e.detail.value
				  that.$set(that.stocks,that.prizeitemindex,this.prize_stock)
				  that.$emit("prizeStock",that.stocks);
			 },
			 prizeType(event,type){
				let that = this 
				console.log('获取第几个',event.currentTarget.dataset.level)
				console.log('值',that.types)
				console.log('全值',that.prizeTypes)
				
				let t = that.types[type];
				that.$set(that.prizeTypes,event.currentTarget.dataset.level,t)
				console.log('全值',that.prizeTypes)
				that.$emit("prizeType",that.prizeTypes);
			 },
			 switchChange(event){
				 let that = this;
				 console.log(event)
				 let s = event.detail.value
				 that.$set(that.is_postages,that.prizeitemindex,s)
				 that.$emit("switchChange",that.is_postages);
			 	console.log(event)
			 },
	    }
	}
</script>

<style>
.selectimg{
	height: 200rpx;
	align-items: center;
}
.changeimg{
	position: inherit;
	top: 20px;
	left: calc(50%-10px);
}
.prizelevelimg{
	margin: 0 auto;
}
.fui-article-pic {
	width: 100%;
	display: block;
}

</style>

<template>
	<view>
		<view class=" fui-col-12 border">
			<view class="cu-form-group">
				<view class="title">{{text}}</view>	
				<input class="num-inp" :placeholder="text" name="input"></input>	
			</view>
			<view class="form-help fui-col-12 text-sm  text-brown padding-left" >
				{{details}}
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		name:"inputDetail",
		props: {
			text:{
				type: String,
			},
			details:{
				type: String,
			}
		}
	}
</script>

<style>
    .border{
       border-top: 1upx solid #eee;
       border-bottom: 1upx solid #eee;
    }
</style>

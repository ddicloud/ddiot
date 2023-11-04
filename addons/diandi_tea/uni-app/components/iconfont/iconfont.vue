<template>
  <view>
    <span class="iconfont" :style="{ color: color, 'font-size': size + 'px' }" :class="className"></span>
    <slot></slot>
  </view>
</template>
   
<script>
export default {
  name: 'iconfont',
  props: {
	color: {
		type: String,
		default: '#333333'
	},
	className:{
			type: String,
			default:'text-black'
	},
	size: {
		type: [Number, String],
		default: 16
	}
  }
}
</script>
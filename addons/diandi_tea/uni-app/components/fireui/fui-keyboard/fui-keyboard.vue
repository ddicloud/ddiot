<template>
	<view>
		<view class="fui-keyboard-mask" :class="[show?'fui-mask-show':'']" v-if="mask" @tap="handleClose"></view>
		<view class="fui-keyboard" :class="{'fui-keyboard-radius':radius,'fui-keyboard-action':action,'fui-keyboard-show':show}">
			<slot></slot>
			<view class="fui-keyboard-grids">
				<!--{{(index==9 || index==10 || index==11)?'fui-grid-bottom':''}}-->
				<view class="fui-keyboard-grid" :class="{'fui-bg-gray':index==9 || index==11}" v-for="(item,index) in itemList"
				 :key="index" hover-class="fui-keyboard-hover" :hover-stay-time="150" @tap="handleClick" :data-index="index">
					<view v-if="index<11" class="fui-keyboard-item" :class="{'fui-fontsize-32':index==9}">{{getKeyBoard(index,action)}}</view>
					<view v-else class="fui-keyboard-item">
						<view class="fui-icon fui-keyboard-delete"></view>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		name: "fuiKeyboard",
		props: {
			//是否需要mask
			mask: {
				type: Boolean,
				default: true
			},
			//控制键盘显示
			show: {
				type: Boolean,
				default: false
			},
			//是否直接显示，不需要动画，一般使用在锁屏密码
			action: {
				type: Boolean,
				default: true
			},
			//是否带圆角
			radius: {
				type: Boolean,
				default: false
			}
		},
		data() {
			return {
				itemList: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
			};
		},
		methods: {
			getKeyBoard: function(index, action) {
				var content = index + 1;
				if (index == 9) {
					content = action ? "取消" : "清除";
				} else if (index == 10) {
					content = 0;
				}
				return content;
			},
			//关闭
			handleClose() {
				if (!this.show) {
					return;
				}
				this.$emit('close', {});
			},
			handleClick(e) {
				if (!this.show) {
					return;
				}
				const dataset = e.currentTarget.dataset;
				this.$emit('click', {
					index: Number(dataset.index)
				})
			}
		}
	}
</script>

<style scoped>
	@font-face {
		font-family: 'keyboardFont';
		src: url(data:application/font-woff;charset=utf-8;base64,d09GRgABAAAAAASgAA0AAAAABugAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABGRlRNAAAEhAAAABoAAAAch/nJvUdERUYAAARkAAAAHgAAAB4AKQAKT1MvMgAAAZwAAABDAAAAVj4mSapjbWFwAAAB8AAAAD4AAAFCAA/rY2dhc3AAAARcAAAACAAAAAj//wADZ2x5ZgAAAjwAAACsAAAA0BLVU2FoZWFkAAABMAAAAC0AAAA2FXPmsWhoZWEAAAFgAAAAHAAAACQH3gOFaG10eAAAAeAAAAAOAAAAEAwAAABsb2NhAAACMAAAAAoAAAAKAGgAAG1heHAAAAF8AAAAHwAAACABEQBLbmFtZQAAAugAAAFJAAACiCnmEVVwb3N0AAAENAAAACgAAAA6nLlLs3jaY2BkYGAAYukqK754fpuvDNwsDCBwU+tiFBKtwMLA9ABIczAwgUQB4ccH+gAAAHjaY2BkYGBu+N/AEMPCAAJAkpEBFbAAAEcKAm142mNgZGBgYGGwZ2BmAAEmIOYCQgaG/2A+AwAPIgFdAHjaY2BkYWCcwMDKwMDUyXSGgYGhH0IzvmYwYuQAijKwMjNgBQFprikMDs93PN/B3PC/gSGGuYGhASjMCJIDAPenDU0AeNpjYYAAFigGAACAAA0AAHjaY2BgYGaAYBkGRgYQsAHyGMF8FgYFIM0ChED+8x3//0NICW+oSgZGNgYYk4GRCUgwMaACRoZhDwAItAhZAAAAAAAAAAAAAABoAAB42l3MTQqCUBSG4fNpqBxECS/+YFTXRGcFKteZjW0nuoqWVtOgPbgKZ1cqaBDN3snzkklE+xUZEwUkqSOCzGx4EGGEsJYd2vURgQdbomhayC0iu8h8lEVmiR1sS4TVGVFYqeaEVjXmVT8TsWjf83yYIjFq1QM9I0/1c9HMMI06zfHgmMeRY8HDwOKnjSlYZvdQ5u4yB+gVbqrX97cAOxsHn9GF/9G3iV4WbSWBeNp9kD1OAzEQhZ/zByQSQiCoXVEA2vyUKRMp9Ailo0g23pBo1155nUg5AS0VB6DlGByAGyDRcgpelkmTImvt6PObmeexAZzjGwr/3yXuhBWO8ShcwREy4Sr1F+Ea+V24jhY+hRvUf4SbuFUD4RYu1BsdVO2Eu5vSbcsKZxgIV3CKJ+Eq9ZVwjfwqXMcVPoQb1L+EmxjjV7iFa2WpDOFhMEFgnEFjig3jAjEcLJIyBtahOfRmEsxMTzd6ETubOBso71dilwMeaDnngCntPbdmvkon/mDLgdSYbh4FS7YpjS4idCgbXyyc1d2oc7D9nu22tNi/a4E1x+xRDWzU/D3bM9JIbAyvkJI18jK3pBJTj2hrrPG7ZynW814IiU68y/SIx5o0dTr3bmniwOLn8owcfbS5kj33qBw+Y1kIeb/dTsQgil2GP5PYcRkAAAB42mNgYoAALjDJyIAOWMCiTIxM/FmZiXkFiXnxxRmJeckZpQA1nQZRAAAAAf//AAIAAQAAAAwAAAAWAAAAAgABAAMAAwABAAQAAAACAAAAAHjaY2BgYGQAgqtL1DlA9E2ti1EwGgA9dwYGAAA=) format('woff');
		font-weight: normal;
		font-style: normal;
	}

	.fui-icon {
		font-family: "keyboardFont" !important;
		font-size: 22px;
		font-style: normal;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
		line-height: 1;
		color: #333;
	}

	.fui-keyboard-delete:before {
		content: "\e7b8";
	}

	.fui-keyboard-mask {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: rgba(0, 0, 0, 0.6);
		z-index: 998;
		transition: all 0.3s ease-in-out;
		opacity: 0;
		visibility: hidden;
	}

	.fui-mask-show {
		opacity: 1;
		visibility: visible;
	}

	.fui-keyboard {
		width: 100%;
		position: fixed;
		left: 0;
		right: 0;
		bottom: 0;
		z-index: 999;
		padding-bottom: env(safe-area-inset-bottom);
		background-color: #fff;
	}

	.fui-keyboard-radius {
		border-top-left-radius: 16rpx;
		border-top-right-radius: 16rpx;
		overflow: hidden;
	}

	.fui-keyboard-action {
		visibility: hidden;
		transform: translate3d(0, 100%, 0);
		transform-origin: center;
		transition: all 0.3s ease-in-out;
	}

	.fui-keyboard-show {
		transform: translate3d(0, 0, 0);
		visibility: visible;
	}

	.fui-bg-gray {
		background-color: #e7e6eb !important;
	}

	.fui-keyboard-grids {
		width: 100%;
		position: relative;
		overflow: hidden;
		display: flex;
		display: -webkit-flex;
		flex-direction: row;
		flex-wrap: wrap;
	}

	.fui-keyboard-grids::after {
		content: " ";
		position: absolute;
		left: 0;
		top: 0;
		width: 100%;
		height: 1px;
		border-top: 1px solid #eaeef1;
		-webkit-transform-origin: 0 0;
		transform-origin: 0 0;
		-webkit-transform: scaleY(0.5);
		transform: scaleY(0.5);
	}

	.fui-keyboard-grid {
		position: relative;
		padding: 24rpx 20rpx;
		box-sizing: border-box;
		background-color: #fff;
		width: 33.33333333%;
	}

	.fui-keyboard-grid:nth-of-type(3n)::before {
		width: 0;
		border-right: 0;
	}

	.fui-keyboard-grid::before {
		content: " ";
		position: absolute;
		right: 0;
		top: 0;
		width: 1px;
		bottom: 0;
		border-right: 1px solid #eaeef1;
		-webkit-transform-origin: 100% 0;
		transform-origin: 100% 0;
		-webkit-transform: scaleX(0.5);
		transform: scaleX(0.5);
	}

	.fui-keyboard-grid::after {
		content: " ";
		position: absolute;
		left: 0;
		bottom: 0;
		right: 0;
		height: 1px;
		border-bottom: 1px solid #eaeef1;
		-webkit-transform-origin: 0 100%;
		transform-origin: 0 100%;
		-webkit-transform: scaleY(0.5);
		transform: scaleY(0.5);
	}

	.fui-grid-bottom::after {
		height: 0 !important;
		border-bottom: 0 !important;
	}

	.fui-keyboard-hover {
		background-color: #f7f7f9 !important;
	}

	.fui-keyboard-item {
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 48rpx;
		height: 60rpx;
		color: #000;
	}

	.fui-fontsize-32 {
		font-size: 32rpx;
		color: #333 !important;
	}
</style>

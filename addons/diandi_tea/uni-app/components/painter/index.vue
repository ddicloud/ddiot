<template>
	<canvas v-if="isUse2dCanvas" :id="canvasId" type="2d" :style="style"></canvas>
	<canvas v-else :canvas-id="canvasId" :style="style"></canvas>
</template>

<script>
import { toPx, dataURItoBlob, base64ToPath} from './utils';
import { Draw } from './draw';
import { adaptor } from './canvas'
export default {
	// version: '1.5.5',
	name: 'l-painter',
	props: {
		board: Object,
		fileType: {
			type: String,
			default: 'jpg'
		},
		width: [Number, String],
		height: [Number, String],
		pixelRatio: Number,
		customStyle: String,
		isRenderImage: Boolean,
		isBase64ToPath: Boolean,
		type: {
			type: String,
			default: '2d',
		},
	},
	data() {
		// #ifndef MP-WEIXIN
		const canvasId = `l-painter_${JSON.stringify(Math.random()).split('.')[1]}`
		// #endif
		// #ifdef MP-WEIXIN
		const canvasId = `l-painter`
		// #endif
		return {
			canvasId,
			use2dCanvas: this.type ==='2d' ? true : false ,
			draw: null,
			ctx: null
		};
	},
	watch: {
		board: {
			handler(val) {
				if (JSON.stringify(val) === '{}') return;
				this.render();
			},
			immediate: true,
			deep: true
		}
	},
	computed: {
		isUse2dCanvas() {
			return this.type === '2d' && this.use2dCanvas
		},
		style() {
			return `width:${this.boardWidth}px; height: ${this.boardHeight}px; ${this.customStyle}`;
		},
		dpr() {
			return this.pixelRatio || uni.getSystemInfoSync().pixelRatio;
		},
		boardWidth() {
			const { width = 200 } = this.board || {};
			return toPx(this.width || width);
		},
		boardHeight() {
			const { height = 200 } = this.board || {};
			return toPx(this.height || height);
		}
	},
	methods: {
		render(args = {}) {
			this.getContext().then(async (ctx) => {
				if(!this.ctx) {
					this.ctx = ctx
				}
				const { use2dCanvas, boardWidth, boardHeight, board, canvas, isBase64ToPath } = this;
				const {width, height} = args
				if (use2dCanvas && !canvas) {
					return Promise.reject(new Error('render: fail canvas has not been created'));
				}
				this.boundary = {
				  top: 0,
				  left: 0,
				  width: boardWidth || width,
				  height: boardHeight || height,
				}
				this.ctx.clearRect(0, 0, boardWidth, boardHeight);
				if(!this.draw) {
					this.draw = new Draw(this.ctx, canvas, use2dCanvas);
				} 
				await this.draw.drawBoard(JSON.stringify(args) != '{}' ? args : board);
				if (!use2dCanvas) {
					await this.canvasDraw(this.ctx, this.isRenderImage);
				}
				if(this.isRenderImage) {
					this.canvasToTempFilePath()
					.then(async res => {
						if(/^data:image\/(\w+);base64/.test(res.tempFilePath) && isBase64ToPath) {
							const img = await base64ToPath(res.tempFilePath)
							this.$emit('success', img)
						} else {
							this.$emit('success', res.tempFilePath)
						}
					})
					.catch(err => {
						this.$emit('fail', err)
						new Error(JSON.stringify(err))
						console.error(JSON.stringify(err))
					})
				}
				return Promise.resolve(true);
			});
		},
		canvasDraw(ctx = this.ctx , reserve = true) {
			return new Promise(resolve => {
				ctx.draw(reserve, () => {
					resolve(true);
				});
			});
		},
		getContext() {
			const { type, isUse2dCanvas, dpr, boardWidth, boardHeight } = this;
			// #ifndef MP-WEIXIN
			const ctx = uni.createCanvasContext(this.canvasId, this);
			this.use2dCanvas = false;
			return Promise.resolve(ctx);
			// #endif
			
			if(!isUse2dCanvas) {
				const ctx = uni.createCanvasContext(this.canvasId, this);
				return Promise.resolve(ctx);
			}
			return new Promise(resolve => {
				uni.createSelectorQuery()
					.in(this)
					.select('#l-painter')
					// .fields({node: true, size: true})
					.node()
					.exec(res => {
						const canvas = res[0].node;
						if(!canvas) {
							this.use2dCanvas = false;
							return this.getContext()
						}
						const ctx = canvas.getContext(type);
						if (!this.inited) {
							this.inited = true;
							canvas.width = boardWidth * dpr;
							canvas.height = boardHeight * dpr;
							this.use2dCanvas = true;
							this.canvas = canvas
							ctx.scale(dpr, dpr);
						}
						resolve(adaptor(ctx));
					});
				
			});
		},
		canvasToTempFilePath(args = {}) {
		  const {use2dCanvas, canvasId} = this
		  return new Promise((resolve, reject) => {
		    const { top = 0, left = 0, width, height } = this.boundary
		
		    const copyArgs = {
		      x: left,
		      y: top,
		      width,
		      height,
		      destWidth: width * this.dpr,
		      destHeight: height * this.dpr,
		      canvasId,
		      fileType: args.fileType || this.fileType || 'png',
		      quality: args.quality || 1,
		      success: resolve,
		      fail: reject
		    }
		
		    if (use2dCanvas) {
		      delete copyArgs.canvasId
		      copyArgs.canvas = this.canvas
		    }
		    uni.canvasToTempFilePath(copyArgs, this)
		  })
		}
	}
};
</script>

<style></style>

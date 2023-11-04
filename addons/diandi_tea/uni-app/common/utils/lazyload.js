class LazyLoad {
	/**
	 * 构造函数
	 */
	constructor(selector) {
		// 获取需要懒加载的图片数组
		this.images = Array.from(document.querySelectorAll(selector));
		// 初始化
		this.initImage();
	}

	/**
	 * 初始化图片
	 */
	initImage() {
		// 没有图片则不执行下一步
		if (!this.images.length) return;
		// 隐藏所有图片的加载地址
		this.images.forEach(e => {
			e.setAttribute('data-src', e.src);
			e.src = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
		});
		// 获取窗口可用高度
		this.windowHeight = window.innerHeight;
		// 处理初始可加载的图片
		this.loadImage();
		// 添加窗口滚动监听事件，滚动时自动图片懒加载
		window.addEventListener('scroll', this.loadImage);
	}

	/**
	 * 加载图片
	 */
	loadImage = () => {
		// 没有图片则不执行下一步
		if (!this.images.length) {
			// 清除滚动监听
			window.removeEventListener('scroll', this.loadImage);
			return;
		}
		// 循环判断每一张图片是否可加载
		for (let i = this.images.length; i--;) {
			if (this.canLoad(this.images[i])) {
				// 绑定图片的加载地址
				this.images[i].src = this.images[i].getAttribute('data-src');
				// 从需要判断的图片数组里清除
				this.images.splice(i, 1);
			}
		}
	}

	/**
	 * 判断该图片是否可加载
	 * @param {Object} image
	 */
	canLoad(image) {
		// 获取当前图片相对于浏览器窗口顶部的距离
		const windowTop = image.getBoundingClientRect().top;
		// 距离顶部的距离小于窗口高度，该图片将被可视
		return windowTop <= this.windowHeight;
	}
}

export default LazyLoad;

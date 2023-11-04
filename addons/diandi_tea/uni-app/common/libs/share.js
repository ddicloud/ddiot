export default {
	data() {
		return {
			// 默认的全局分享内容
			share: {
				title: '点到智能茶室',
				path: '/pages/index/index',    // 全局分享的路径，比如 首页
				imageUrl: 'https://dev.hopesfire.com/attachment/202206/12/10f5d094-22b0-36d5-bcc9-f9a0294a6512.jpg',    // 全局分享的图片(可本地可网络)
			}
		}
	},
	// 定义全局分享
	// 1.发送给朋友
    onShareAppMessage(res) {
        return {
			title: this.share.title,
			path: this.share.path,
			imageUrl: this.share.imageUrl,
		}
    },
	//2.分享到朋友圈
    onShareTimeline(res) {
        return {
			title: this.share.title,
			path: this.share.path,
			imageUrl: this.share.imageUrl,
		}
    },
}
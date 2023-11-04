/**
 * 版本：1.0.0
 * @author i@tech.top
 * 有问题和疑问可以发邮件联系~
 */

// 使用proxy转换为异步化的uni方法
const uniAsync = new Proxy({}, {
	get(target, name) {
		return (obj) => new Promise((resolve, reject) => {
			uni[name]({
				...obj,
				success: ret => {
					resolve(ret)
				},
				fail: err => {
					reject(err)
				}
			})
		})
	}
})

export default uniAsync

const screen = uni.getSystemInfoSync().windowWidth / 750
export function toPx(value, baseSize) {
	// 如果是数字
	if (typeof value === 'number') {
		return value
	}
	// 如果是字符串数字
	if (isNumber(value)) {
		return value * 1
	}
	// 如果有单位
	if (typeof value === 'string') {
		const reg = /^-?[0-9]+([.]{1}[0-9]+){0,1}(rpx|px|%)$/g
		const results = reg.exec(value);
		if (!value || !results) {
			return 0;
		}
		const unit = results[2];
		value = parseFloat(value);
		let res = 0;
		if (unit === 'rpx') {
			res = Math.round(value * (screen || 0.5) * 1);
		} else if (unit === 'px') {
			res = Math.round(value * 1);
		} else if (unit === '%') {
			res = Math.round(value * toPx(baseSize) / 100);
		}
		return res;
	}
}

export function isNumber(value) {
	return /^-?\d+(\.\d+)?$/.test(value);
}

/** 从 0x20 开始到 0x80 的字符宽度数据 */
export const CHAR_WIDTH_SCALE_MAP = [0.296, 0.313, 0.436, 0.638, 0.586, 0.89, 0.87, 0.256, 0.334, 0.334, 0.455, 0.742,
	0.241, 0.433, 0.241, 0.427, 0.586, 0.586, 0.586, 0.586, 0.586, 0.586, 0.586, 0.586, 0.586, 0.586, 0.241, 0.241, 0.742,
	0.742, 0.742, 0.483, 1.031, 0.704, 0.627, 0.669, 0.762, 0.55, 0.531, 0.744, 0.773, 0.294, 0.396, 0.635, 0.513, 0.977,
	0.813, 0.815, 0.612, 0.815, 0.653, 0.577, 0.573, 0.747, 0.676, 1.018, 0.645, 0.604, 0.62, 0.334, 0.416, 0.334, 0.742,
	0.448, 0.295, 0.553, 0.639, 0.501, 0.64, 0.567, 0.347, 0.64, 0.616, 0.266, 0.267, 0.544, 0.266, 0.937, 0.616, 0.636,
	0.639, 0.64, 0.382, 0.463, 0.373, 0.616, 0.525, 0.79, 0.507, 0.529, 0.492, 0.334, 0.269, 0.334, 0.742, 0.296
];

/**
 * base64转路径
 * @param {Object} base64
 */
export function base64ToPath(base64) {
	return new Promise((resolve, reject) => {
		// #ifdef MP
		const fs = uni.getFileSystemManager()
		//自定义文件名
		const [, format, bodyData] = /data:image\/(\w+);base64,(.*)/.exec(base64) || [];
		if (!format) {
			reject(new Error('ERROR_BASE64SRC_PARSE'))
		}
		const time = new Date().getTime();
		// #ifdef MP-TOUTIAO
		const filePath = `${tt.env.USER_DATA_PATH}/${time}.${format}`
		// #endif
		// #ifdef MP-WEIXIN
		const filePath = `${wx.env.USER_DATA_PATH}/${time}.${format}`
		// #endif
		// #ifdef MP-BAIDU
		const filePath = `${bd.env.USER_DATA_PATH}/${time}.${format}`
		// #endif
		// #ifdef MP-ALIPAY
		const filePath = `${my.env.USER_DATA_PATH}/${time}.${format}`
		// #endif
		// #ifdef MP-QQ
		const filePath = `${qq.env.USER_DATA_PATH}/${time}.${format}`
		// #endif
		// #ifdef MP-360
		const filePath = `${qh.env.USER_DATA_PATH}/${time}.${format}`
		// #endif
		const buffer = uni.base64ToArrayBuffer(bodyData)
		fs.writeFile({
			filePath,
			data: buffer,
			encoding: 'binary',
			success() {
				resolve(filePath)
			},
			fail(err) {
				console.error('获取base64图片失败', JSON.stringify(err))
				reject(err)
			}
		})
		// #endif
		
		// #ifdef H5
		
		let mimeString = base64.split(',')[0].split(':')[1].split(';')[0]; // mime类型
		let byteString = atob(base64.split(',')[1]); //base64 解码
		let arrayBuffer = new ArrayBuffer(byteString.length); //创建缓冲数组
		let intArray = new Uint8Array(arrayBuffer); //创建视图
		
		for (let i = 0; i < byteString.length; i++) {
			intArray[i] = byteString.charCodeAt(i);
		}
		resolve(URL.createObjectURL(new Blob([intArray], { type: mimeString })))
		// #endif
		
		// #ifdef APP-PLUS
		const bitmap = new plus.nativeObj.Bitmap('bitmap' + Date.now())
		bitmap.loadBase64Data(base64, () => {
			//自定义文件名
			const [, format, bodyData] = /data:image\/(\w+);base64,(.*)/.exec(base64) || [];
			console.log('format', format)
			if (!format) {
				reject(new Error('ERROR_BASE64SRC_PARSE'))
			}
			const time = new Date().getTime();
			const filePath = `_doc/uniapp_temp/${time}.${format}`
			
			bitmap.save(filePath, {}, 
				() => {
					bitmap.clear()
					resolve(filePath)
				}, 
				(error) => {
					bitmap.clear()
					reject(error)
				})
		}, (error) => {
			bitmap.clear()
			reject(error)
		})
		// #endif
		
	})
}


export function pathToBase64(path) {
	return new Promise((resolve, reject) => {
		// #ifdef H5
		if(/^blob/.test(path) && typeof FileReader === 'function') {
			const fileReader = new FileReader();
			fileReader.onload = (e) => {
			    resolve(e.target.result);
			};
			fileReader.readAsDataURL(path);
			fileReader.onerror = (error) => {
				console.error('blobToBase64 error:', JSON.stringify(error))
			    reject(new Error('blobToBase64 error'));
			};
		} else {
			let image = new Image();
			image.onload = () => {
				let canvas = document.createElement('canvas');
				// 获取图片原始宽高
				canvas.width = this.naturalWidth;
				canvas.height = this.naturalHeight;
				// 将图片插入画布并开始绘制
				canvas.getContext('2d').drawImage(image, 0, 0);
				// result
				let result = canvas.toDataURL('image/png')
				resolve(result);
				canvas.height = canvas.width = 0
			}
			image.setAttribute("crossOrigin",'Anonymous');
			image.src = path;
			// 图片加载失败的错误处理
			image.onerror = (error) => {
				console.error('urlToBase64 error:', JSON.stringify(error))
			    reject(new Error('urlToBase64 error'));
			};
		}
		// #endif
		
		// #ifdef MP
		if(uni.canIUse('getFileSystemManager')) {
			uni.getFileSystemManager().readFile({
			    filePath: path,
			    encoding: 'base64',
			    success: (res) => {
			        resolve('data:image/png;base64,' + res.data)
			    },
			    fail: (error) => {
					console.error('urlToBase64 error:', JSON.stringify(error))
			        reject(error)
			    }
			})
		}
		// #endif
		
		// #ifdef APP-PLUS
		plus.io.resolveLocalFileSystemURL(getLocalFilePath(path), (entry) => {
		    entry.file((file) => {
		        const fileReader = new plus.io.FileReader()
		        fileReader.onload = (data) => {
		            resolve(data.target.result)
		        }
		        fileReader.onerror = (error) => {
					console.error('pathToBase64 error:', JSON.stringify(error))
		            reject(error)
		        }
		        fileReader.readAsDataURL(file)
		    }, (error) => {
				console.error('pathToBase64 error:', JSON.stringify(error))
		        reject(error)
		    })
		}, (error) => {
			console.error('pathToBase64 error:', JSON.stringify(error))
		    reject(error)
		})
		// #endif
		reject(new Error('not support'))
	})
}

// #ifdef APP-PLUS
function getLocalFilePath(path) {
    if (path.indexOf('_www') === 0 || path.indexOf('_doc') === 0 || path.indexOf('_documents') === 0 || path.indexOf('_downloads') === 0) {
        return path
    }
    if (path.indexOf('file://') === 0) {
        return path
    }
    if (path.indexOf('/storage/emulated/0/') === 0) {
        return path
    }
    if (path.indexOf('/') === 0) {
        var localFilePath = plus.io.convertAbsoluteFileSystem(path)
        if (localFilePath !== path) {
            return localFilePath
        } else {
            path = path.substr(1)
        }
    }
    return '_www/' + path
}
// #endif
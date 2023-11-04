# Painter 画板
> 可根据自身需求配置生成海报的画板
> [查看更多](http://liangei.gitee.io/limeui-docs/components/painter/) 

<br>


### 平台兼容

| H5  | 微信小程序 | 支付宝小程序 | 百度小程序 | 头条小程序 | QQ 小程序 | App |
| --- | ---------- | ------------ | ---------- | ---------- | --------- | --- |
| √   | √          | 未测         | 未测       | √          | 未测      | √   |

<br>


### 代码演示
#### 基本用法

定一个画板对象，包含`width`、`height`、`background`，`views`为画板里的元素集，它是一个数组对象。<br>
元素类型目前有`view`、`text`、`image`<br>
css 对象里的位置都是相对于画板的绝对定位，支持`rpx`、`px`

```html
<l-painter :board="base"/>
```

```js
export default {
    data() {
        return {
            base {
                width: '686rpx',
				height: '130rpx',
				views: [
					{
						type: 'view',
						css: {
							left: '0rpx',
							top: '0rpx',
							background: '#07c160',
							width: '120rpx',
							height: '120rpx'
						}
					},
                    {
						type: 'view',
						css: {
							left: '180rpx',
							top: '18rpx',
							background: '#1989fa',
							width: '80rpx',
							height: '80rpx',
							rotate: 50
						}
					}
				]
            };
        }
    }
}

```

<br><br>

#### 圆角

为可元素定一个圆角`radius`,支持`rpx`、`px`、`%`

```html
<l-painter :board="base"/>
```

```js
export default {
data() {
    return {
        base: {
            width: '686rpx',
            height: '130rpx',
            views: [
                {
                    type: 'view',
                    css: {
                        left: '0rpx',
                        top: '0rpx',
                        background: '#07c160',
                        width: '120rpx',
                        height: '120rpx',
                        radius: '16rpx 30rpx 10rpx 80rpx'
                    }
                },
                {
                    type: 'view',
                    css: {
                        left: '150rpx',
                        top: '0rpx',
                        background: '#1989fa',
                        width: '120rpx',
                        height: '120rpx',
                        radius: '16rpx 60rpx'
                    }
                },
                {
                    type: 'view',
                    css: {
                        left: '300rpx',
                        top: '0rpx',
                        background: '#ff976a',
                        width: '120rpx',
                        height: '120rpx',
                        radius: '50%'
                    }
                }
            ]
        };
    }
}
}

```

<br><br>

#### 描边投影

为可元素定一个描边`border`和投影`shadow`,支持`rpx`、`px`

```html
<l-painter :board="base"/>
```

```js
export default {
data() {
    return {
        base: {
            width: '686rpx',
            height: '130rpx',
            views: [
                {
                    type: 'view',
                    css: {
                        left: '10rpx',
                        top: '10rpx',
                        background: 'rgba(7,193,96,.1)',
                        width: '120rpx',
                        height: '120rpx',
                        radius: '50%',
                        border: '2rpx dashed rgb(7,193,96)'
                    }
                },
                {
                    type: 'view',
                    css: {
                        left: '150rpx',
                        top: '10rpx',
                        background: 'rgba(25,137,250,.4)',
                        width: '120rpx',
                        height: '120rpx',
                        radius: '50%',
                        shadow: '0 5rpx 10rpx rgba(25,137,250,.8)'
                    }
                },
                {
                    type: 'view',
                    css: {
                        left: '300rpx',
                        top: '10rpx',
                        background: 'rgba(255, 151, 106, .1)',
                        width: '120rpx',
                        height: '120rpx',
                        radius: '50%',
                        border: '2rpx solid #ff976a'
                    }
                }
            ]
        };
    }
}
}

```

<br><br>

#### 图片

元素类型为`image`时，需要一个图片地址`src`,图片地址支持`相对路径`和`网络地址`<br>

::: warning 温馨提示
当为网络地址时，
H5：需要解决跨域问题 <br>
小程序：需要配置 downloadFile 域名 <br>
建议使用 base64 图片
:::

```html
<l-painter :board="base"/>
```

```js
export default {
data() {
    return {
        base: {
            width: '686rpx',
            height: '130rpx',
            views: [
                {
                    type: 'image',
                    src: 'https://cnd.dzwztea.cn/tea/avatar-1.jpeg',
                    css: {
                        left: '0rpx',
                        top: '0rpx',
                        width: '120rpx',
                        height: '120rpx'
                    }
                },
                {
                    type: 'image',
                    src: 'https://cnd.dzwztea.cn/tea/avatar-2.jpg',
                    css: {
                        left: '150rpx',
                        top: '0rpx',
                        width: '120rpx',
                        height: '120rpx',
                        radius: '16rpx'
                    }
                },
                {
                    type: 'image',
                    src:'https://cnd.dzwztea.cn/tea/avatar-3.jpeg',
                    css: {
                        left: '300rpx',
                        top: '0rpx',
                        background: '#ff976a',
                        width: '120rpx',
                        height: '120rpx',
                        radius: '50%'
                    }
                }
            ]
        };
    }
}
}

```

<br><br>

#### 文字

元素类型`text`时，内容写在`text`里，支持`\n`换行符，css 的属性有字体大小`fontSize`、行高`lineHeight`、对齐`textAlign`、修饰`textDecoration`、粗细`fontWeight`、 宽度`width`、最大行数`maxLines`。
设置了最大行数和宽度时，当文字内容超过会显示省略号。

```html
<l-painter :board="base"/>
```

```js
export default {
data() {
    return {
        base: {
            width: '686rpx',
            height: '500rpx',
            views: [
                {
                    type: 'text',
                    text: '左对齐,下划线\n无风才到地，有风还满空\n缘渠偏似雪，莫近鬓毛生',
                    css: {
                        left: '0rpx',
                        top: '10rpx',
                        fontSize: '28rpx',
                        lineHeight: '36rpx',
                        textDecoration: 'underline'
                    }
                },
                {
                    type: 'text',
                    text: '居中,上划线\n无风才到地，有风还满空\n缘渠偏似雪，莫近鬓毛生',
                    css: {
                        left: '0rpx',
                        top: '150rpx',
                        fontSize: '28rpx',
                        lineHeight: '36rpx',
                        textAlign: 'center',
                        textDecoration: 'overline'
                    }
                },
                {
                    type: 'text',
                    text: '右对齐,中划线\n无风才到地，有风还满空\n缘渠偏似雪，莫近鬓毛生',
                    css: {
                        left: '0rpx',
                        top: '290rpx',
                        fontSize: '28rpx',
                        lineHeight: '36rpx',
                        textAlign: 'right',
                        textDecoration: 'line-through',
                    }
                },
                {
                    type: 'text',
                    text: '省略号\n明月几时有？把酒问青天。不知天上宫阙，今夕是何年。我欲乘风归去，又恐琼楼玉宇，高处不胜寒。起舞弄清影，何似在人间。',
                    css: {
                        left: '0rpx',
                        top: '420rpx',
                        fontSize: '28rpx',
                        maxLines: 2,
                        width: '686rpx',
                        lineHeight: '36rpx'
                    }
                }
            ]
        };
    }
}
}

```

<br>

#### 调用接口
插件也允许通过`ref`获取内部方法来实现绘制和生成图片。
需要设置画板的`width`和`height`
```html
<l-painter ref="painter" width="686rpx"  height="130rpx" />
<image :src="path" />
```

```js
export default {
	data() {
		return {
			base {
				views: [
					{
						type: 'view',
						css: {
							left: '0rpx',
							top: '0rpx',
							background: '#07c160',
							width: '120rpx',
							height: '120rpx'
						}
					}
				]
			};
			path: '',
		}
	},
	methods: {
		onRender() {
			// 支持通过调用render传入参数
			const painter = this.$refs.painter
			painter.render(this.base)
		},
		canvasToTempFilePath() {
			const painter = this.$refs.painter
			// 支持通过调用canvasToTempFilePath方法传入参数 调取生成图片
			painter.canvasToTempFilePath().then(res => this.path = res.tempFilePath)
		}
		
		
	}
}
```


<br><br>

#### 提供一份海报样式案例

是否生成图片:`isRenderImage` <br>
生成图片成功:`success`返回一个图片临时地址。

```html
<l-painter
  v-if="isShowPainter"
  isRenderImage
  custom-style="position: fixed; left: 200%;"
  :board="base"
  @success="path = $event"
/>
```

```js
export default {
data() {
    return {
        base: {
            width: '750rpx',
            height: '1114rpx',
            background: '#F6F7FB',
            views: [
                {
                    type: 'view',
                    css: {
                        left: '40rpx',
                        top: '144rpx',
                        background: '#fff',
                        radius: '16rpx',
                        width: '670rpx',
                        height: '930rpx',
                        shadow: '0 20rpx 48rpx rgba(0,0,0,.05)'
                    }
                },
                {
                    type: 'image',
                    src: 'https://cnd.dzwztea.cn/tea/avatar-2.jpg',
                    mode: 'widthFix',
                    css: {
                        left: '40rpx',
                        top: '40rpx',
                        width: '84rpx',
                        height: '84rpx',
                        radius: '50%',
                        color: '#999'
                    }
                },
                {
                    type: 'text',
                    text: '隔壁老王',
                    css: {
                        color: '#333',
                        left: '144rpx',
                        top: '40rpx',
                        fontSize: '32rpx',
                        fontWeight: 'bold'
                    }
                },
                {
                    type: 'text',
                    text: '为您挑选了一个好物',
                    css: {
                        color: '#666',
                        left: '144rpx',
                        top: '90rpx',
                        fontSize: '24rpx'
                    }
                },
                {
                    type: 'image',
                    src: 'https://cnd.dzwztea.cn/tea/goods.jpg',
                    mode: 'widthFix',
                    css: {
                        left: '72rpx',
                        top: '176rpx',
                        width: '606rpx',
                        height: '606rpx',
                        radius: '12rpx'
                    }
                },
                {
                    type: 'text',
                    text: '￥39.90',
                    css: {
                        color: '#FF0000',
                        left: '66rpx',
                        top: '812rpx',
                        fontSize: '56rpx',
                        fontWeight: 'bold'
                    }
                },
                {
                    type: 'text',
                    text: '360儿童电话手表9X 智能语音问答定位支付手表 4G全网通20米游泳级防水视频通话拍照手表男女孩星空蓝',
                    css: {
                        maxLines: 2,
                        width: '396rpx',
                        color: '#333',
                        left: '72rpx',
                        top: '948rpx',
                        fontSize: '36rpx',
                        lineHeight: '50rpx'
                    }
                },
                {
                    type: 'image',
                    src: 'https://cnd.dzwztea.cn/tea/qr.png',
                    mode: 'widthFix',
                    css: {
                        left: '500rpx',
                        top: '864rpx',
                        width: '178rpx',
                        height: '178rpx'
                    }
                }
            ]
		};
    }
},
methods: {
    saveImage() {
        this.isShowPopup = false
        uni.saveImageToPhotosAlbum({
            filePath: this.path,
            success(res) {
                uni.showToast({
                    title: '已保存到相册',
                    icon: 'success',
                    duration: 2000
                })
            }
        })
    },
}
}

```

### API

#### Props

| 参数          | 说明         | 类型             | 默认值       |
| ------------- | ------------ | ---------------- | ------------ |
| board         | 画板对象     | <em>object</em>  | 参数请向下看 |
| customStyle   | 自定义样式   | <em>string</em>  |              |
| isRenderImage | 是否生成图片 | <em>boolean</em> | `false`      |

<br>

#### Board

| 参数       | 说明                               | 类型            |
| ---------- | ---------------------------------- | --------------- |
| width      | 画板的宽度                         | <em>string</em> |
| height     | 画板的高度                         | <em>string</em> |
| background | 画板的背景色                       | <em>string</em> |
| views      | 画板的元素集，请向下看各元素的参数 | <em>object</em> |

<br>

#### 元素 View

| 参数 | 说明                                                                                                |
| ---- | --------------------------------------------------------------------------------------------------- |
| type | 元素类型`view`                                                                                      |
| css  | 元素的样式，`top`、`left`、`width`、`height`、`background`、`radius`、`border`、`shadow` 、`rotate` |

<br>

#### 元素 text

| 参数 | 说明                                                                                                                                                                        |
| ---- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| type | 元素类型`text`                                                                                                                                                              |
| text | 文本内容                                                                                                                                                                    |
| css  | 元素的样式，`top`、`left`、`fontSize`、`fontWeight`、`fontFamily`、`width`、`lineHeight`、`color`、`textDecoration`、`textAlign`：center, left, right、最大行数：`maxLines` |

<br>

#### 元素 image

| 参数 | 说明                                                                       |
| ---- | -------------------------------------------------------------------------- |
| type | 元素类型`image`                                                            |
| src  | 图片地址                                                                   |
| css  | 元素的样式，`top`、`left`、`width`、`height`、`radius`、`border`、`shadow` |

<br>

#### 事件 Events

| 事件名  | 说明         | 回调           |
| ------- | ------------ | -------------- |
| success | 生成图片成功 | $event        |
| fail    | 生成图片失败 | {error: error} |

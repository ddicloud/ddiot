# diy表单

```js

export const form = {
    'blocs': {
        'type': 'cascader-store',
        'label': '选择公司'
    },
    'ishot': {
        'type': 'radio',
        'label': '是否热门',
        isOptions: true,
        options: [{
            text: '是',
            value: 1
        },
            {
                text: '否',
                value: 2
            }
        ]
    },
    pcate: {
        label: '一级分类',
        // 只需要在这里指定为 tree-select 即可
        type: 'tree-select',
        // 属性参考: https://vue-treeselect.js.org/
        attrs: {
            multiple: false,
            clearable: true
        },
        options: async data => {
            console.log('编 号', data.name)

            const res = await initCate(0)
            console.log('编 号', res.data)
            const arr = [{
                id: 0,
                label: '一级分类'
            }]
            console.log('父级菜单', res.data)
            return arr.concat(res.data)
        }

    },
    ccate: {
        label: '二级分类',
        // 只需要在这里指定为 tree-select 即可
        type: 'tree-select',
        // 属性参考: https://vue-treeselect.js.org/
        attrs: {
            multiple: false,
            clearable: true
        },
        vif: data => data.pcate,
        // 这里必须制定 optionsLinkageFields 做为关联字段，当次字段值发生变化时，会重新出发请求
        optionsLinkageFields: ['pcate'],
        options: async data => {
            console.log('编 号', data.name)
            if (data.pcate) {
                const res = await initCate(data.pcate)
                console.log('编 号', res.data)
                const arr = [{
                    id: 0,
                    label: '二级分类'
                }]
                console.log('父级菜单', res.data)
                return arr.concat(res.data)
            }
        }
    },
    'page': {
        'type': 'select',
        'label': '页面标识',
        'isOptions': true,
        'options': [{
            text: '手机端-首页',
            value: 'mobileHome'
        },
            {
                text: '手机端-会展服务',
                value: 'mobileService'
            },
            {
                text: '电脑端-首页',
                value: 'pc-index'
            },
            {
                text: '电脑端-行业资讯',
                value: 'pc-Industry'
            }
        ]
    },
    'page1': {
        'type': 'select',
        'label': '页面标识',
        'isOptions': true,
        'options': async data => {
            console.log('编 号', data.name)
            if (data.pcate) {
                const res = await initCate(data.pcate)
                console.log('编 号', res.data)
                const arr = [{
                    id: 0,
                    label: '二级分类'
                }]
                console.log('父级菜单', res.data)
                return arr.concat(res.data)
            }
        }
    },
    'title': {
        'type': 'input',
        'label': '标题'
    },
    'description': {
        'type': 'textarea',
        'label': '简介'
    },
    'content': {
        'type': 'fire-editor',
        'label': '详情'
    },
    'thumb': {
        'type': 'image-uploader',
        'label': '图片'
    },
    'source': {
        'type': 'input',
        'label': '来源'
    },
    'author': {
        'type': 'input',
        'label': '作者'
    },
    'displayorder': {
        'type': 'input',
        'label': '排序'
    },
    'linkurl': {
        'type': 'input',
        'label': '链接地址'
    },
    'is_top': {
        'type': 'radio',
        'label': '是否置顶',
        'isOptions': true,
        'options': [{
            'text': '是',
            'value': 1
        },
            {
                'text': '否',
                'value': 2
            }
        ]
    },
    'name': {
        'type': 'input',
        'label': '卡券名'
    },
    num_sort: {
        type: 'input',
        label: '排序',
        attrs: {
            type: 'number'
        }
    },
    meal_type: {
        type: 'radio',
        label: '默认套餐类型',
        isOptions: true,
        options: [
            {
                text: '1小时',
                value: 1
            },
            {
                text: '2小时',
                value: 2
            },
            {
                text: '4小时',
                value: 4
            }
        ]
    },
    type: {
        type: 'radio',
        label: '卡券类型',
        isOptions: true,
        options: [
            {
                text: '代金券',
                value: 1
            },
            {
                text: '时长卡',
                value: 2
            },
            {
                text: '次卡',
                value: 3
            },
            {
                text: '折扣券',
                value: 4
            },
            {
                text: '体验券',
                value: 5
            }
        ],
        on: {
            input: (data) => {
                console.log(data)
                this.showNum = data
            }
        }
    },
    explain: {
        type: 'input',
        label: '卡券说明'
    },
    price: {
        type: 'input',
        label: '卡券金额(元)',
        attrs: {
            type: 'number'
        }
    },
    use_start: {
        type: 'time',
        label: '时间限制-开始时间',
        attrs: {
            pickerOptions: {
                start: '00:30',
                step: '00:30',
                end: '24:00'
            }
        }
    },
    use_end: {
        type: 'time',
        label: '时间限制-结束时间',
        attrs: {
            pickerOptions: {
                start: '00:30',
                step: '00:30',
                end: '24:00'
            }
        }
    },
    enable_start: {
        type: 'datetime',
        label: '有效期开始时间',
        attrs: {
            valueFormat: 'yyyy-MM-dd HH:mm:ss'
        }
    },
    coupon_img: {
        label: '卡券主图',
        type: 'image-uploader',
        attrs: {
          multiple: true,
          limit: 10
        }
    },
    background: {
        label: '卡券背景',
        type: 'image-uploader' // 只需要在这里指定为 image-uploader 即可
    },
    parent: {
        label: "父级菜单",
        // 只需要在这里指定为 tree-select 即可
        type: "tree-select",
        // 属性参考: https://vue-treeselect.js.org/
        attrs: {
            multiple: false,
            clearable: true,
        },
        vif: (data) => data.module_name,
        // 这里必须制定 optionsLinkageFields 做为关联字段，当次字段值发生变化时，会重新出发请求
        optionsLinkageFields: ["module_name"],
        options: async (data) => {
            if (data.name || data.module_name) {
                const obj = {};
                this.$set(obj, "Menu[module_name]", data.module_name);
                const res = await fetchList(obj);
                const arr = [
                    {
                        id: 0,
                        label: "一级菜单",
                    },
                ];
                return arr.concat(res.data.list);
            }
        },
    },
}
```

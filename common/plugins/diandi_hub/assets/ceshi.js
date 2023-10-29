/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-06 15:06:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-06-07 00:23:18
 */
// import VueResource from '../node_modules/vue-resource/dist/vue-resource.js'
let _levels,_attribute,_goods_id,_prices;
// import {im} from 'common/importJs.js'
new Vue({
    el: '#hub-goods-form',
    data: function () {
        return {
            specVal: [],
            specList: [],
            specKey: [],
            type: '1',
            typemark: '%',
            levels: _levels,
            visible: false,
            labelPosition: 'top',
            prices: _prices,
            formLabelAlign: {
                name: '',
                region: '',
                type: ''
            },
            html: '',
            goods: {

            },
            HubGoods: {
                goods_id: _goods_id,
                region: '',
                date1: '',
                date2: '',
                delivery: false,
                type: [],
                resource: '',
                desc: ''
            },
            attribute: {

            },
            goodslist: [],
            keywords: '',
            page: 1,
            menu: '我们真的不一样'
        }
    },
    created: function () {
        let that = this;
        let attribute = _attribute;
        that.attribute = attribute
        that.selectGoods();
        console.log('全局设置是否可以',attribute, that.prices, that.levels)
        console.log('a is: ' + this.HubGoods)
    },
    methods: {
        arraySpanMethod({
            row,
            column,
            rowIndex,
            columnIndex
        }) {
            console.log(row)
            if (rowIndex % 2 === 0) {
                if (columnIndex === 0) {
                    return [1, 3];
                } else if (columnIndex === 1) {
                    return [0, 0];
                }
            }
        },
        objectSpanMethod({
            row,
            column,
            rowIndex,
            columnIndex
        }) {
            if (columnIndex === 0) {
                if (rowIndex % 2 === 0) {
                    return {
                        rowspan: 3,
                        colspan: 1
                    };
                } else {
                    return {
                        rowspan: 0,
                        colspan: 0
                    };
                }
            }
        },
        selectGoods() {
            let that = this
            console.log(that)
            //Lambda写法
            that.$http.get('goodslist', {
                params: {
                    'keywords': that.keywords,
                    'page': that.page,
                }
            }, {
                // headers: {
                //     '<?php echo \yii\web\Request::CSRF_HEADER; ?>': '<?php echo Yii::$App->request->csrfToken; ?>' // _csrf验证
                // }
            }).then((response) => {
                //响应成功回调
                this.visible = true
                if (response.data.code == 200) {
                    this.goodslist = response.data.data
                }
            }, (response) => {
                //响应错误回调
                console.log(response)
            });
        },
        onSubmit() {
            console.log('t56u676')
        },
        typeselect() {
            let that = this
            that.typemark = that.type == '2' ? '￥' : '%';
            console.log(that.type)

        },
        handleEdit(index, row) {
            let that = this
            that.HubGoods = row
            that.goods = row
            that.specVal = Object.values(that.HubGoods.specs.specVal)
            that.specList = Object.values(that.HubGoods.specs.list)
            that.specKey = Object.keys(that.HubGoods.specs.list)

            console.log('specKey', that.specKey)
            console.log('speclist', that.specList)
            console.log(index, row, that.HubGoods.specs.list)
            that.visible = false

            that.$http.post('gethtml', {
                goods_id: row.goods_id
            }, {
                headers: {
                    '<?php echo \yii\web\Request::CSRF_HEADER; ?>': '<?php echo Yii::$App->request->csrfToken; ?>' // _csrf验证
                }
            }).then((response) => {

                if (response.data.code == 200) {
                    if (response.data.data.length > 0) {
                        console.log('多规格处理')
                    }
                    that.html = response.data.data[0]
                    console.log('html', response.data.data)
                }
            }, (response) => {
                //响应错误回调
                console.log(response)
            });

        }

    }
})
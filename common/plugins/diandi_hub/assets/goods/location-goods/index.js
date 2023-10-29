/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-06 15:06:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-06-07 19:32:12
 */
// import VueResource from '../node_modules/vue-resource/dist/vue-resource.js'

// import {im} from 'common/importJs.js'
    // 以form data 方式进行post请求
  
new Vue({
    el: '#hub-goods-form',
    data: function () {
        return {
          // 属性
            HubGoods: {
              bloc_id:0,
              store_id:0,
              goods_id:0,
              member_price :0,
              price1:0,
              price2:0,
              price3:0,
              price4:0,
              price5:0,
              price6:0,
              type:1,
            },
            // dialog
            visible: false,
            specVal: [],
            specList: [],
            specKey: [],
            type: '1',
            typemark: '%',
            levels: [],
            labelPosition: 'top',
            prices: [],
            formLabelAlign: {
                name: '',
                region: '',
                type: ''
            },
            html: '',
            goods: {

            },
            goods_id:0,
           
            attribute: {

            },
            goodslist: [],
            keywords: '',
            page: 1,
            menu: '我们真的不一样',
            tableData7:[],
            index: "",
            shopType: [],
            form: {
              name: "",
              color: "",
              size: "",
              materials: "",
              weight: ""
            },
            newList: [],
            newData: [],
            spanArr: [],
            filedsprefix:'pra',
            pos: [],
        }
    },
    created: function () {
        let that = this;
        that.init();
        // let attribute = _attribute;
        // that.attribute = attribute
        // that.selectGoods();
        console.log('全局设置是否可以',window.sysinfo)
        console.log('a is: ' + this.HubGoods)
    },
    methods: {
      init(){
        let that = this;
        that.$http.post('attribute', {}).then((response) => {
            //响应成功回调
            if (response.data.code == 200) {
              that.attribute =  that.global.objToar(response.data.data.attribute)
              that.prices = Object.values(response.data.data.prices)
            }
            return false;
        }, (response) => {
            //响应错误回调
            console.log(response)
        });
        
      },
      selectGoods() {
            let that = this
            console.log(that)
            that.tableData7=[]
            //Lambda写法
            that.$http.post('goodslist', {
                    'keywords': that.keywords,
                    'page': that.page,
            }).then((response) => {
              console.log('response',response)
              // return false;
                //响应成功回调
                if (response.data.code == 200) {  
                  that.goodslist = response.data.data.list
                  that.levels = response.data.data.levels
                  that.goodslist = response.data.data.list
                  console.log(that.goodslist,that.prices,that.levels,that.goodslist)
                  that.visible = true

                }
            }, (response) => {
                //响应错误回调
                console.log('错误了',response)
            });
    },
    handleEdit(index, row) {
      let that = this
      console.log(index, row)
      Vue.set(that.HubGoods,'goods_id',row.goods_id);
      that.HubGoods = row
      that.goods = row
      //  多规格商品 
      if(row.spec_type==1){
        that.specVal = Object.values(row.specs.specVal)
        that.specList = that.global.objToar(row.specs.list)
      
        that.paramsTo(row.specs.list)
        
        console.log('specKey', that.specKey)
        console.log('speclist', that.specList)
        console.log(index, row, that.HubGoods.specs.list)        
      } 

      that.visible = false
      that.processing()

  },
  //返回所属规格名字
  retName(index) {
    console.log('返回所属规格名字',index,this.shopType)
    return this.shopType[index].name;
    if (index == 1) {
      if (this.shopType.length > 1) {
        return this.shopType[0].name;
      }
    } else if (index == 2) {
      if (this.shopType.length > 1) {
        return this.shopType[1].name;
      }
    } else if (index == 3) {
      if (this.shopType.length > 1) {
        return this.shopType[2].name;
      }
    } else {
      return "";
    }
  },
  //添加小的规格
  create(index) {
      console.log(index);
      if (this.shopType[index].input) {
        this.shopType[index].typeNames.push({
          type: this.shopType[index].input,
          img: ""
        });
      }

      // for (let index = 0; index < this.shopType.length; index++) {
      //     console.log(this.shopType)
      // }
    },
    //处理数据
    processing() {
      this.newData = [];
      for (let i = 0; i < this.shopType.length; i++) {
        
        var newlist = [];
        for (
          let index = 0;
          index < this.shopType[i].typeNames.length;
          index++
        ) {
          newlist.push(this.shopType[i].typeNames[index].type);
        }
        this.newData.push(newlist);
      }
      this.getList();
    },
    //转换数据
    getList() {
      this.tableData7 = [];
      this.newList = this.global.descartes(this.newData);
      // console.log('计算完成后',this.newList)
      for (let index = 0; index < this.newList.length; index++) {
        let par = {} 
        this.newList[index].forEach((item,idex)=>{
          // 形成字段
          // that.fileds.push()
          Vue.set(par,this.filedsprefix+idex,this.newList[index][idex])          
        })
        console.log()
        console.log('parparparpar',par)
        this.tableData7.push(par);
      }

      this.getSpanArr(this.tableData7);
      // console.log('数据转化',this.tableData7);
    },
    //计算位置的方法
    getSpanArr(data) {
      this.spanArr = [];
      this.pos = [];
      // console.log('处理合并的基础数据',data)
      // 多个字段组合计算合并
      this.shopType.forEach(item=>{
        let field = item.field
        let basespan = []
        let basepos = ''
        // 判断当前元素与上一个元素是否相同
          for (var i = 0; i < data.length; i++) {
            if (i === 0) {
              basespan.push(1);
              basepos = 0;
            } else {
              // let field = "pra0"
              // console.log('计算合并',field,eval('data[i].'+field),eval('data[i - 1].'+field))
              if (eval('data[i].'+field)  === eval('data[i - 1].'+field)) {
                basespan[basepos] += 1;
                basespan.push(0);
              }else {
                basespan.push(1);
                basepos = i;
              }
              
            }
          }
          // console.log('meiciyi',basespan)
         
          Vue.set(this.spanArr,field,basespan)
          Vue.set(this.pos,field,basepos)
          
      })
      // console.log('合并数据计算完毕',this.spanArr,this.pos)
      

      // for (var i = 0; i < data.length; i++) {
      //   if (i === 0) {
      //     this.spanArr1.push(1);
      //     this.pos1 = 0;
      //   } else {
      //     //如果笛卡尔积一直递增下去的话 这是一个很蠢的方法 由于我的要求层数是已知的 这里偷懒了 不然应该用for循环
      //     if (data[i].cailiao === data[i - 1].cailiao) {
      //       this.spanArr1[this.pos1] += 1;
      //       this.spanArr1.push(0);
      //     } else {
      //       this.spanArr1.push(1);
      //       this.pos1 = i;
      //     }
      //   }
      // }
      console.log(this.spanArr);
    },
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
  
  // 合并行数
  objectSpanMethod1({ row, column, rowIndex, columnIndex }) {
    // columnIndex === 0 找到第一列，实现合并随机出现的行数
    // console.log('合并行数',row,columnIndex,this.spanArr)
    let columns = Object.keys(row)
    console.log('那一列',columnIndex,columns)
    
    // if (columnIndex === 0) {
    //   if (rowIndex % 2 === 0) {
    //     return {
    //       rowspan: 2,
    //       colspan: 1
    //     };
    //   } else {
    //     return {
    //       rowspan: 0,
    //       colspan: 0
    //     };
    //   }
    // }

    let ll = {
      'rowspan':1,
      'colspan':1
    }
    columns.forEach((item,index)=>{
      if(columnIndex === index){
        console.log('第几列',columnIndex)
        // console.log('rowspanrowspan',item,this.spanArr[item][rowIndex],this.spanArr[item])
        const _row = this.spanArr[item][rowIndex];
        const _col = _row > 0 ? 1 : 0;
        console.log({
          rowspan: _row,
          colspan: _col
        })
        Vue.set(ll,'rowspan',_row)
        Vue.set(ll,'colspan',_col)
        // return {
        //   rowspan: _row,
        //   colspan: _col
        // };
      }
     
    })

    return ll;
    
    // if (columnIndex === 0) {
    //   const _row = this.spanArr[rowIndex];
    //   const _col = _row > 0 ? 1 : 0;
    //   return {
    //     rowspan: _row,
    //     colspan: _col
    //   };
    //   // columnIndex === 1 找到第二列，合并他的列数
    // } else if (columnIndex === 1) {
    //   const _row = this.spanArr1[rowIndex];
    //   const _col = _row > 0 ? 1 : 0;
    //   return {
    //     rowspan: _row,
    //     colspan: _col
    //   };
    // }
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
  onSubmit() {
      console.log('t56u676')
  },
  typeselect() {
      let that = this
      that.typemark = that.type == '2' ? '￥' : '%';
      console.log(that.type)

  },
  paramsTo(specs){
    let that = this
    let shopType = [];
    let  keys = Object.keys(specs)
    let values = Object.values(specs)
    
    keys.forEach((items,index) => {
      let spc = {};
      let typeNames = []
      Vue.set(spc,'name',items)
      Vue.set(spc,'field',that.filedsprefix+index)
      
      values[index].forEach((sp,k)=>{
        typeNames.push({
          'type':sp.name,
          'img':"",
        })
      
      })
      Vue.set(spc,'typeNames',typeNames)
      shopType.push(spc)
    });
    console.log('比较结构差异',shopType,that.shopType)
    // shopType: [
    //   {
    //     name: "颜色",
    //     typeNames: [
    //       { type: "红色", img: "" },
    //       { type: "白色", img: "" },
    //       { type: "蓝色", img: "" },
    //       { type: "粉色", img: "" }
    //     ]
    //   },
    //   {
    //     name: "材料",
    //     typeNames: [
    //       { type: "棉花", img: "" },
    //       { type: "纱布", img: "" },
    //       { type: "蚕丝", img: "" },
    //       { type: "麻布", img: "" }
    //     ]
    //   },
    //   {
    //     name: "尺码",
    //     typeNames: [
    //       { type: "L", img: "" },
    //       { type: "XL", img: "" },
    //       { type: "XXL", img: "" },
    //       { type: "XXX", img: "" }
    //     ]
    //   }
    // ],
    
    that.shopType = shopType;
  }

  }
})
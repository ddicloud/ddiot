/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-06 15:06:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-28 13:03:40
 */
// import VueResource from '../node_modules/vue-resource/dist/vue-resource.js'

// import {im} from 'common/importJs.js'
    // 以form data 方式进行post请求
  
new Vue({
    el: '#hub-goods-form',
    data: function () {
        return {
          oneOptions:0,
          twoOptions:0,
          threeOptions:0,
          valmodel:{
            member_price:'',
            prices:[],            
            distributor:[],
            member_price:'',
            goods_id:'',            
            type:1,  
            baseprice:[]          
          },
          levelsa:'',
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
            levelsfx:[],
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
            HubGoodsform:{},
            goods_id:0,
           
            attribute: {

            },
            goodsSpecs:[],
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
    },
    methods: {
      init(){
        let that = this;
        that.$http.post('attribute', {a:1}).then((response) => {
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
      chageDisInput(e,index,levelnum,dislevel){
        let that = this
        Vue.set(that.valmodel.distributor,index+'_'+levelnum+'_'+dislevel,e);
        console.log('输入改变',that.valmodel.distributor)
      
        // this.valmodel.distributor[index+'_'+levelnum+'_'+dislevel] = e;
        this.$forceUpdate() 

      },
      chageInput(e){
        // let row 
        // let level
        // let num
        console.log('输入了内容',e)
        this.$forceUpdate() 
      },
      selectGoods() {
            let that = this
            that.init();

            console.log(that)
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
                  console.log(that.goodslist,that.prices,that.levels,that.goodslist)
                  that.visible = true

                  this.tableData7 = [];
                  
                  this.newData = [];
                }
            }, (response) => {
                //响应错误回调
                console.log('错误了',response)
            });
    },
    handleEdit(index, row) {
      let that = this
      Vue.set(that.valmodel,'goods_id',row.goods_id);
      Vue.set(that.valmodel,'goods_price',row.goods_price);
      Vue.set(that.valmodel,'goods_name',row.goods_name);
      
      that.HubGoods = row
      console.log('当前商品',row)
      that.goods = row
      //  多规格商品 
      if(row.spec_type==1){
        that.specVal = Object.values(row.specs.specVal)
        that.specList = that.global.objToar(row.specs.list)
      
        that.paramsTo(row.specs.list)
         
      } 

      that.visible = false
      that.processing()
      that.$forceUpdate()
  },
  //返回所属规格名字
  retName(index) {
    
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
  renderStock(row){
    
    let keys = Object.values(row.row).join('_');
    // console.log('行关联数据',row,row.$index,keys,this.goods.specs.specVal[keys].goods_spec_id)
    let goods_spec_id = this.goods.specs.specVal[keys].goods_spec_id;
    this.goodsSpecs[row.$index] = goods_spec_id
    
    // Vue.set(this.goodsSpecs,row.$index,goods_spec_id)
    
    let levelsfx = []
    // this.levels.forEach((item,index)=>{
    //      levelsf
    // })
     return this.goods.specs.specVal[keys].stock_num
  },
  renderPrice(row){
    let keys =  Object.values(row.row).join('_');
    
     return this.goods.specs.specVal[keys].goods_price
     
    
  },
  //添加小的规格
  create(index) {
    
      if (this.shopType[index].input) {
        this.shopType[index].typeNames.push({
          type: this.shopType[index].input,
          img: ""
        });
      }
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
      
      this.newList = this.global.descartes(this.newData);
      
      console.log('计算完成后0',this.newData,this.newList)
      if(this.newData.length>1){
        for (let index = 0; index < this.newList.length; index++) {
          console.log(index)
          let par = {} 
          this.newList[index].forEach((item,idex)=>{
            // 形成字段
            // that.fileds.push()
            Vue.set(par,this.filedsprefix+idex,this.newList[index][idex])          
          })
          console.log('parparparpar',par)
          this.tableData7.push(par);
        }
      }else{
        
        
        let k = this.filedsprefix+'0'
        
        this.newList.forEach((item,idex)=>{
          console.log('lllll',item,idex)
          let par = {} 
          
          // 形成字段
          // that.fileds.push()
          Vue.set(par,k,item)     
          // console.log('010101',par)
          this.tableData7.push(par);

        })
      }
     

      this.getSpanArr(this.tableData7);
      console.log('数据转化',this.tableData7);
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
    let ll = {
      'rowspan':1,
      'colspan':1
    }
    columns.forEach((item,index)=>{
      if(columnIndex === index && this.spanArr[item]){
        console.log('第几列',columnIndex,this.spanArr,item,index)
        // console.log('rowspanrowspan',item,this.spanArr[item][rowIndex],this.spanArr[item])
        const _row = this.spanArr[item][rowIndex];
        const _col = _row > 0 ? 1 : 0;
        console.log({
          rowspan: _row,
          colspan: _col
        })
        Vue.set(ll,'rowspan',_row)
        Vue.set(ll,'colspan',_col)
      }
     
    })

    return ll;
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
  // 初始化所有分销参数
  chageLevelInput(event,levelnum){
    let that = this
    console.log(event,levelnum,that.tableData7,that.levels)
    console.log(levelnum,'tableData7',that.tableData7)
    console.log(levelnum,'levels',that.levels)
    console.log(levelnum,'event',event)
    that.levels.forEach((item,indexs)=>{
      if(that.tableData7.length>0){
        // 多规格
        that.tableData7.forEach((data,index)=>{
            console.log(index+'_'+indexs+'_'+levelnum);
            let col = indexs+1
            that.$set(that.valmodel.distributor,index+'_'+col+'_'+levelnum,event);
            that.$forceUpdate();
        })  
      }else{
        // 单规格
        let col = indexs+1
        that.$set(that.valmodel.distributor,indexs+'_'+col+'_'+levelnum,event);
        that.$forceUpdate();
      }
    })
    // that.$set(that.valmodel.distributor,'0_4_1',99);

    console.log('动态改变后',that.valmodel.distributor)
  },
  onSubmit(event) {
    let that = this
    console.log('价格与分佣',that.valmodel)
    console.log('基础数据',that.valmodel.distributor)
    let distributor = Object.assign({},that.valmodel.distributor);
    let prices = Object.assign({},that.valmodel.prices);
    let baseprice = Object.assign({},that.valmodel.baseprice);
    
    console.log({
          'goodsSpecs':JSON.stringify(this.goodsSpecs),
          'disInfo':JSON.stringify(distributor),
          'goods_id':that.HubGoods.goods_id,
          'member_price':that.valmodel.member_price,
          'type': that.type,
          'prices':JSON.stringify(prices)
    });
      that.$http.post('create', {
          'baseprice':JSON.stringify(baseprice),
          'goodsSpecs':JSON.stringify(this.goodsSpecs),
          'disInfo':JSON.stringify(distributor),
          'goods_id':that.HubGoods.goods_id,
          'member_price':that.valmodel.member_price,
          'type': that.type,
          'prices':JSON.stringify(prices)
      }).then((response) => {
        console.log('response',response)
        // return false;
        console.log(response.data)

        //响应成功回调
        if (response.data.code == 200) {  
          that.$message({
            message: response.data.message,
            type: 'success'
          });
          window.location.href = "index";
        }else{
          that.$message.error(response.data.message);
        }
      }, (response) => {
          //响应错误回调
          console.log('错误了',response)
      });
  },
  typeselect(event) {
      let that = this
      console.log(event)
      that.type = event

      that.typemark = event == 2 ? '￥' : '%';
      console.log(that.type,that.typemark)
      that.$forceUpdate()
  },
  paramsTo(specs){
    let that = this
    let shopType = [];
    let  keys = Object.keys(specs)
    let values = Object.values(specs)
    console.log('序列值',keys,specs);
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
    
    that.shopType = shopType;
  }

  }
})
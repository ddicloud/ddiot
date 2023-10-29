/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-06 15:06:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-04 23:48:17
 */
// import VueResource from '../node_modules/vue-resource/dist/vue-resource.js'

// import {im} from 'common/importJs.js'

// 以form data 方式进行post请求
new Vue({
    el: '#location-goods-create',
    data: function () {
        return {
          visible:false,
          good_ids:[],
          LocationGoods:{},
          adv_id:'',
          selectGoodsList:[],
          goods: {

          },
          advlist:[],
          goods_id:0,
          goodslist: [],
          keywords: '',
          storeName:'',
          page: 1,
          pageSize:10,
          total:0,
          menu: '我们真的不一样',
          
        }
    },
    created: function () {
        let that = this;
        that.$http.get('advlist', {}).then((response) => {
          console.log('response',response)
          // return false;
            //响应成功回调
            if (response.data.code == 200) {  
                that.advlist = response.data.data.list
                console.log('初始数据',that.advlist)
            }
        }, (response) => {
            //响应错误回调
            console.log('错误了',response)
        });
        // let attribute = _attribute;
        // that.attribute = attribute
        // that.selectGoods();
        console.log('全局设置是否可以',window.sysinfo,that.advlist)
        console.log('a is: ' + this.HubGoods)
    },
    methods: {
      init(){
        let that = this;
     
        
      },
      chageInput(e){
        console.log(e)
        this.$forceUpdate() 
      },
      handleSelectionChange(val) {
        console.log(val)
        if(val.length>0){
          let goods = []
          let good_ids=[] 
          val.forEach((item,index)=>{
              goods.push(item)
              good_ids.push(item.goods_id)
          })
          
          this.selectGoodsList = this.selectGoodsList.concat(goods)
          
          this.good_ids = good_ids;
        }
       
      },
      pageChange(page){
        let that = this
        that.page = page
        that.selectAdv()
      },
      selectAdv(){
          let that = this
          
          that.$http.post('goodslist', {
                  keywords: that.keywords,
                  page: that.page,
                  type:1,
                  adv_id: that.adv_id,
                  pageSize:that.pageSize
          }).then((response) => {
            this.good_ids ='';

            console.log('response',response)
            // return false;
              //响应成功回调
              if (response.data.code == 200) {  
                that.total      = response.data.data.count
                
                that.selectGoodsList= response.data.data.list
                
              }
          }, (response) => {
              //响应错误回调
              console.log('错误了',response)
          });
      },
      selectGoods() {
            let that = this
            that.init();
            console.log(that.adv_id)
            if(!that.adv_id){
              this.$message.error('请选择广告位');
              return false;              
            }

          
            //Lambda写法
            that.$http.post('goodslist', {
                    keywords: that.keywords,
                    storeName: that.storeName,
                    type:0,
                    page: 1,
                    pageSize:15,
                    adv_id: that.adv_id,
            }).then((response) => {
              console.log('response',response)
              // return false;
                //响应成功回调
                if (response.data.code == 200) {  
                  
                  
                  that.goodslist  = response.data.data.list 
                  
                  that.levels = response.data.data.levels
                  console.log(that.goodslist,that.prices,that.levels,that.goodslist)
                  that.visible = true

                }
            }, (response) => {
                //响应错误回调
                console.log('错误了',response)
            });
    },
    deleteRow(row){
        let that = this
        
        that.$http.post('deletegoods', {
                    'adv_id': that.adv_id,
                    'goods_id': row.goods_id
        }).then((response) => {
          console.log('response',response)
            //响应成功回调
            if (response.data.code == 200) {  
                that.selectAdv()
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
      that.$forceUpdate()
  },
  onSubmit(event) {
    let that = this
    console.log(that.valmodel)
      console.log('t56u676',event)
      that.$http.post('goodslocation', {
        'adv_id': that.adv_id,
        'good_ids': that.good_ids,
      }).then((response) => {
        console.log('response',response)
        // return false;
          //响应成功回调
          if (response.data.code == 200) {  
            this.$message({
              message: '商品广告添加成功',
              type: 'success'
            });
          }
      }, (response) => {
          //响应错误回调
          console.log('错误了',response)
      });

  },
  typeselect() {
      let that = this
      that.typemark = that.type == '2' ? '￥' : '%';
      console.log(that.type,that.typemark)
      that.$forceUpdate()
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
/*
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-07 11:28:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-06-24 00:16:40
 */

let objToar=function (obj) {
        if(obj=='' || obj==undefined){
            return false;
        }
        let  keys = Object.keys(obj)
        let  values = Object.values(obj)
        let arr = []
        values.forEach((item,index)=>{
            Vue.set(arr,keys[index],item)
        })
        return arr;
  }

  
let descartes = function (array) {
    if( array.length < 2 ) return array[0] || [];
    return [].reduce.call(array, function(col, set) {
        var res = [];
        col.forEach(function(c) {
            set.forEach(function(s) {
                var t = [].concat( Array.isArray(c) ? c : [c] );
                t.push(s);
                res.push(t);
        })});
        return res;
    });
}

let getUrlParam =  function (name) {
    let nameStr = encodeURIComponent(name);
    var reg = new RegExp("(^|&)" + nameStr + "=([^&]*)(&|$)"); // 构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg); // 匹配目标参数
    if (r != null) return unescape(r[2]);
    return null; // 返回参数值
}


let  numFilter = function(value) {
    // 截取当前数据到小数点后两位
    let realVal = parseFloat(value).toFixed(2)
    return realVal
}

let formatJson = function(filterVal, jsonData) {
    return jsonData.map(v => filterVal.map(j => {
      if (j === 'timestamp') {
        return parseTime(v[j])
      } else {
        return v[j]
      }
    }))
}

let  getStore = function(name) {
    if (typeof (Storage) !== "undefined") {
      return localStorage.getItem(name);
    } else {
      window.alert('Please use a modern browser to properly view this template!');
    }
}

 
export default {
    objToar,
    numFilter,
    getUrlParam,
    descartes,
    formatJson,
    getStore
}

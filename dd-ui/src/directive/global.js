/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-02 13:02:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-25 19:29:14
 */
import Vue from 'vue'

/* 常用正则 */
// eslint-disable-next-line no-unused-vars
const regExps = {
  email: /^[0-9a-zA-Z_]+@[0-9a-zA-Z_]+[\.]{1}[0-9a-zA-Z]+[\.]?[0-9a-zA-Z]+$/, // 邮箱
  mobile: /^(?:1\d{2})-?\d{5}(\d{3}|\*{3})$/, // 手机号码
  qq: /^[1-9][0-9]{4,9}$/, // QQ
  befitName: /^[a-z0-9A-Z\u4e00-\u9fa5]+$/, // 合适的用户名，中文,字母,数字
  befitPwd: /^[a-z0-9A-Z_]+$/, // 合适的密码，字母,数字,下划线
  allNumber: /^[0-9]+.?[0-9]$/ // 全部为数字
}

/* 获取元素自定义属性值-当前事件元素 */
const getData = function(el, key) {
  if (key) {
    return el.currentTarget.dataset[key]
  } else {
    return el.currentTarget.dataset
  }
}

const pushdArray = function(arr, index, value) {
  arr[index].push(value)
  return arr
}

// 校验微信环境
const isWeixin = function() {
  const userAgent = navigator.userAgent
  return userAgent.toLowerCase().indexOf('micromessenger') !== -1
}

// 判断类型集合
const checkStr = function(str, type) {
  switch (type) {
    case 'phone': // 手机号码
      return /^1[3|4|5|6|7|8|9][0-9]{9}$/.test(str)
    case 'tel': // 座机
      return /^(0\d{2,3}-\d{7,8})(-\d{1,4})?$/.test(str)
    case 'card': // 身份证
      return /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(str)
    case 'pwd': // 密码以字母开头，长度在6~18之间，只能包含字母、数字和下划线
      return /^[a-zA-Z]\w{5,17}$/.test(str)
    case 'postal': // 邮政编码
      return /[1-9]\d{5}(?!\d)/.test(str)
    case 'QQ': // QQ号
      return /^[1-9][0-9]{4,9}$/.test(str)
    case 'email': // 邮箱
      return /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/.test(str)
    case 'money': // 金额(小数点2位)
      return /^\d*(?:\.\d{0,2})?$/.test(str)
    case 'URL': // 网址
      return /(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])?/.test(str)
    case 'IP': // IP
      return /((?:(?:25[0-5]|2[0-4]\\d|[01]?\\d?\\d)\\.){3}(?:25[0-5]|2[0-4]\\d|[01]?\\d?\\d))/.test(str)
    case 'date': // 日期时间
      return /^(\d{4})\-(\d{2})\-(\d{2}) (\d{2})(?:\:\d{2}|:(\d{2}):(\d{2}))$/.test(str) || /^(\d{4})\-(\d{2})\-(\d{2})$/
        .test(str)
    case 'number': // 数字
      return /^[0-9]$/.test(str)
    case 'english': // 英文
      return /^[a-zA-Z]+$/.test(str)
    case 'chinese': // 中文
      return /^[\\u4E00-\\u9FA5]+$/.test(str)
    case 'lower': // 小写
      return /^[a-z]+$/.test(str)
    case 'upper': // 大写
      return /^[A-Z]+$/.test(str)
    case 'HTML': // HTML标记
      return /<("[^"]*"|'[^']*'|[^'">])*>/.test(str)
    default:
      return true
  }
}

// 格式化时间-小于10补0
const formatDigit = function(n) {
  return n.toString().replace(/^(\d)$/, '0$1')
}
// 格式化时间，通用
const formatDate = function(timestamp, formats) {
  /* formats格式包括:
	    1. Y-M-D
	    2. Y-M-D h:m:s
	    3. Y年M月D日
	    4. Y年M月D日 h时m分
	    5. Y年M月D日 h时m分s秒
	    示例：console.log(formatDate(1500305226034, 'Y年M月D日 h:m:s')) ==> 2017年07月17日 23:27:06
	*/
  formats = formats || 'Y-M-D'
  var myDate = ''
  if (timestamp) {
    if (typeof (timestamp) !== 'string') {
      myDate = timestamp
    } else {
      myDate = new Date(timestamp)
    }
  } else {
    myDate = new Date()
  }

  var year = myDate.getFullYear()
  var month = formatDigit(myDate.getMonth() + 1)
  var day = formatDigit(myDate.getDate())
  var hour = formatDigit(myDate.getHours())
  var minute = formatDigit(myDate.getMinutes())
  var second = formatDigit(myDate.getSeconds())
  return formats.replace(/Y|M|D|h|m|s/g, (matches) => {
    return {
      Y: year,
      M: month,
      D: day,
      h: hour,
      m: minute,
      s: second
    }[matches]
  })
}

const filter = function(str) {
  str += ''
  str = str.replace(/&/g, '%26')
  str = str.replace(/\=/g, '%3D')
  return str
}

const formateObjToParamStr = function(paramObj) {
  const sdata = []
  for (const attr in paramObj) {
    sdata.push(`${attr}=${filter(paramObj[attr])}`)
  }
  return sdata.join('&')
}

// 验证邮箱
const isEmail = function(s) {
  return /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((.[a-zA-Z0-9_-]{2,3}){1,2})$/.test(s)
}
// 验证手机号码
const isMobile = function(s) {
  return /^1[0-9]{10}$/.test(s)
}
// 验证电话号码
const isPhone = function(s) {
  return /^([0-9]{3,4}-)?[0-9]{7,8}$/.test(s)
}
// 验证是否url地址
const isURL = function(s) {
  return /^http[s]?:\/\/.*/.test(s)
}
// 验证是否字符串
const isString = function(o) {
  return Object.prototype.toString.call(o).slice(8, -1) === 'String'
}
// 验证是否是否数字
const isNumber = function(o) {
  return Object.prototype.toString.call(o).slice(8, -1) === 'Number'
}
// 验证是否是Boolean
const isBoolean = function(o) {
  return Object.prototype.toString.call(o).slice(8, -1) === 'Boolean'
}
// 验证是否是函数
const isFunction = function(o) {
  return Object.prototype.toString.call(o).slice(8, -1) === 'Function'
}
// 是否为null
const isNull = function(o) {
  return Object.prototype.toString.call(o).slice(8, -1) === 'Null'
}
// 是否undefined
const isUndefined = function(o) {
  return Object.prototype.toString.call(o).slice(8, -1) === 'Undefined' || Object.prototype.toString.call(o).slice(8, -1) === 'undefined'
}

const isEmpty = function(value) {
  return (
    value === null || value === undefined ||
        (typeof value === 'object' && Object.keys(value).length === 0) ||
        (typeof value === 'string' && value.trim().length === 0)
  )
}

// 是否对象
const isObj = function(o) {
  return Object.prototype.toString.call(o).slice(8, -1) === 'Object'
}
// 是否数组
const isArray = function(o) {
  return Object.prototype.toString.call(o).slice(8, -1) === 'Array'
}
// 是否时间对象
const isDate = function(o) {
  return Object.prototype.toString.call(o).slice(8, -1) === 'Date'
}
// 是否正则
const isRegExp = function(o) {
  return Object.prototype.toString.call(o).slice(8, -1) === 'RegExp'
}
// 是否错误对象
const isError = function(o) {
  return Object.prototype.toString.call(o).slice(8, -1) === 'Error'
}
// 是否Symbol函数
const isSymbol = function(o) {
  return Object.prototype.toString.call(o).slice(8, -1) === 'Symbol'
}
// 是否Promise对象
const isPromise = function(o) {
  return Object.prototype.toString.call(o).slice(8, -1) === 'Promise'
}
// 是否Set对象
const isSet = function(o) {
  return Object.prototype.toString.call(o).slice(8, -1) === 'Set'
}
// 判断数据是不是引用类型的数据
const isObject = function(value) {
  const type = typeof value
  return value !== null && (type === 'object' || type === 'function')
}

// 字符串超出多少字显示省略号
const strOut = function(str, len = 0, type) {
  type = type || 'star'
  var restr = ''
  if (str) {
    if (str.length >= len) {
      restr = str.substring(0, len) + (type === 'star' ? '***' : '...')
    } else {
      restr = str
    }
  }
  return restr
}
// 浮点数加法运算--解决精度丢失（传入Number，返回Number）
const FloatAdd = function(data1, data2) { // 加法
  let r1, r2
  // 获取每个参数的小数的位数
  try { r1 = data1.toString().split('.')[1].length } catch (e) { r1 = 0 }
  try { r2 = data2.toString().split('.')[1].length } catch (e) { r2 = 0 }
  // 计算底数为10以最大小数位数为次幂的值
  const m = Math.pow(10, Math.max(r1, r2))
  // 把所有参数转为整数后相加再除以次幂的值
  return (data1 * m + data2 * m) / m
}

// 浮点数乘法运算--解决精度丢失（传入Number，返回Number）
const FloatMul = function(data1, data2) { // 减法
  let r1, r2
  // 获取每个参数的小数的位数
  try { r1 = data1.toString().split('.')[1].length } catch (e) { r1 = 0 }
  try { r2 = data2.toString().split('.')[1].length } catch (e) { r2 = 0 }
  // 计算底数为10以最大小数位数为次幂的值
  const m = Math.pow(10, Math.max(r1, r2))
  // 精度长度以最大小数位数为长度
  const n = (r1 >= r2) ? r1 : r2
  return ((data1 * m - data2 * m) / m).toFixed(n)
}

// 随机数时间戳 （返回数字符串）
const uniqueId = function() {
  var a = Math.random
  var b = parseInt
  return Number(new Date()).toString() + b(10 * a()) + b(10 * a()) + b(10 * a())
}

// 数组随机洗牌算法
const shuffle = function(arr) {
  var result = []
  var random
  while (arr.length > 0) {
    random = Math.floor(Math.random() * arr.length)
    result.push(arr[random])
    arr.splice(random, 1)
  }
  return result
}
// 严格的身份证号码校验
const isCardID = function(sId) {
  if (!/(^\d{15}$)|(^\d{17}(\d|X|x)$)/.test(sId)) {
    console.log('你输入的身份证长度或格式错误')
    return false
  }
  // 身份证城市
  var aCity = {
    11: '北京',
    12: '天津',
    13: '河北',
    14: '山西',
    15: '内蒙古',
    21: '辽宁',
    22: '吉林',
    23: '黑龙江',
    31: '上海',
    32: '江苏',
    33: '浙江',
    34: '安徽',
    35: '福建',
    36: '江西',
    37: '山东',
    41: '河南',
    42: '湖北',
    43: '湖南',
    44: '广东',
    45: '广西',
    46: '海南',
    50: '重庆',
    51: '四川',
    52: '贵州',
    53: '云南',
    54: '西藏',
    61: '陕西',
    62: '甘肃',
    63: '青海',
    64: '宁夏',
    65: '新疆',
    71: '台湾',
    81: '香港',
    82: '澳门',
    91: '国外'
  }
  if (!aCity[parseInt(sId.substr(0, 2))]) {
    console.log('你的身份证地区非法')
    return false
  }

  // 出生日期验证
  var sBirthday = (sId.substr(6, 4) + '-' + Number(sId.substr(10, 2)) + '-' + Number(sId.substr(12, 2))).replace(/-/g,
    '/')
  var d = new Date(sBirthday)
  if (sBirthday !== (d.getFullYear() + '/' + (d.getMonth() + 1) + '/' + d.getDate())) {
    console.log('身份证上的出生日期非法')
    return false
  }

  // 身份证号码校验
  var sum = 0
  var weights = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2]
  var codes = '10X98765432'
  for (var i = 0; i < sId.length - 1; i++) {
    sum += sId[i] * weights[i]
  }
  var last = codes[sum % 11] // 计算出来的最后一位身份证号码
  if (sId[sId.length - 1] !== last) {
    console.log('你输入的身份证号非法')
    return false
  }

  return true
}
// 随机整数范围
const random = function(min, max) {
  if (arguments.length === 2) {
    return Math.floor(min + Math.random() * ((max + 1) - min))
  } else {
    return null
  }
}
// 将阿拉伯数字翻译成中文的大写数字
const numberToChinese = function(num) {
  var AA = ['零', '一', '二', '三', '四', '五', '六', '七', '八', '九', '十']
  var BB = ['', '十', '百', '仟', '萬', '億', '点', '']
  var a = ('' + num).replace(/(^0*)/g, '').split('.')
  var k = 0
  var re = ''
  for (var i = a[0].length - 1; i >= 0; i--) {
    switch (k) {
      case 0:
        re = BB[7] + re
        break
      case 4:
        if (!new RegExp('0{4}//d{' + (a[0].length - i - 1) + '}$')
          .test(a[0])) { re = BB[4] + re }
        break
      case 8:
        re = BB[5] + re
        BB[7] = BB[5]
        k = 0
        break
    }
    if (k % 4 === 2 && a[0].charAt(i + 2) !== 0 && a[0].charAt(i + 1) === 0) { re = AA[0] + re }
    if (a[0].charAt(i) !== 0) { re = AA[a[0].charAt(i)] + BB[k % 4] + re }
    k++
  }
  // 加上小数部分(如果有小数部分)
  if (a.length > 1) {
    re += BB[6]
    // eslint-disable-next-line no-redeclare
    for (var i = 0; i < a[1].length; i++) { re += AA[a[1].charAt(i)] }
  }
  if (re === '一十') { re = '十' }
  if (re.match(/^一/) && re.length === 3) { re = re.replace('一', '') }
  return re
}
// 将数字转换为大写金额
const changeToChinese = function(Num) {
  // 判断如果传递进来的不是字符的话转换为字符
  if (typeof Num === 'number') {
    // eslint-disable-next-line no-new-wrappers
    Num = new String(Num)
  }
  Num = Num.replace(/,/g, '') // 替换tomoney()中的“,”
  Num = Num.replace(/ /g, '') // 替换tomoney()中的空格
  Num = Num.replace(/￥/g, '') // 替换掉可能出现的￥字符
  if (isNaN(Num)) { // 验证输入的字符是否为数字
    // alert("请检查小写金额是否正确");
    return ''
  }
  // 字符处理完毕后开始转换，采用前后两部分分别转换
  var part = String(Num).split('.')
  var newchar = ''
  // 小数点前进行转化
  for (var i = part[0].length - 1; i >= 0; i--) {
    if (part[0].length > 10) {
      return ''
      // 若数量超过拾亿单位，提示
    }
    var tmpnewchar = ''
    var perchar = part[0].charAt(i)
    switch (perchar) {
      case '0':
        tmpnewchar = '零' + tmpnewchar
        break
      case '1':
        tmpnewchar = '壹' + tmpnewchar
        break
      case '2':
        tmpnewchar = '贰' + tmpnewchar
        break
      case '3':
        tmpnewchar = '叁' + tmpnewchar
        break
      case '4':
        tmpnewchar = '肆' + tmpnewchar
        break
      case '5':
        tmpnewchar = '伍' + tmpnewchar
        break
      case '6':
        tmpnewchar = '陆' + tmpnewchar
        break
      case '7':
        tmpnewchar = '柒' + tmpnewchar
        break
      case '8':
        tmpnewchar = '捌' + tmpnewchar
        break
      case '9':
        tmpnewchar = '玖' + tmpnewchar
        break
    }
    switch (part[0].length - i - 1) {
      case 0:
        tmpnewchar = tmpnewchar + '元'
        break
      case 1:
        if (perchar !== 0) tmpnewchar = tmpnewchar + '拾'
        break
      case 2:
        if (perchar !== 0) tmpnewchar = tmpnewchar + '佰'
        break
      case 3:
        if (perchar !== 0) tmpnewchar = tmpnewchar + '仟'
        break
      case 4:
        tmpnewchar = tmpnewchar + '万'
        break
      case 5:
        if (perchar !== 0) tmpnewchar = tmpnewchar + '拾'
        break
      case 6:
        if (perchar !== 0) tmpnewchar = tmpnewchar + '佰'
        break
      case 7:
        if (perchar !== 0) tmpnewchar = tmpnewchar + '仟'
        break
      case 8:
        tmpnewchar = tmpnewchar + '亿'
        break
      case 9:
        tmpnewchar = tmpnewchar + '拾'
        break
    }
    const newchar = tmpnewchar + newchar
  }
  // 小数点之后进行转化
  if (Num.indexOf('.') !== -1) {
    if (part[1].length > 2) {
      // alert("小数点之后只能保留两位,系统将自动截断");
      part[1] = part[1].substr(0, 2)
    }
    for (i = 0; i < part[1].length; i++) {
      tmpnewchar = ''
      perchar = part[1].charAt(i)
      switch (perchar) {
        case '0':
          tmpnewchar = '零' + tmpnewchar
          break
        case '1':
          tmpnewchar = '壹' + tmpnewchar
          break
        case '2':
          tmpnewchar = '贰' + tmpnewchar
          break
        case '3':
          tmpnewchar = '叁' + tmpnewchar
          break
        case '4':
          tmpnewchar = '肆' + tmpnewchar
          break
        case '5':
          tmpnewchar = '伍' + tmpnewchar
          break
        case '6':
          tmpnewchar = '陆' + tmpnewchar
          break
        case '7':
          tmpnewchar = '柒' + tmpnewchar
          break
        case '8':
          tmpnewchar = '捌' + tmpnewchar
          break
        case '9':
          tmpnewchar = '玖' + tmpnewchar
          break
      }
      if (i === 0) tmpnewchar = tmpnewchar + '角'
      if (i === 1) tmpnewchar = tmpnewchar + '分'
      newchar = newchar + tmpnewchar
    }
  }
  // 替换所有无用汉字
  while (newchar.search('零零') !== -1) { newchar = newchar.replace('零零', '零') }
  newchar = newchar.replace('零亿', '亿')
  newchar = newchar.replace('亿万', '亿')
  newchar = newchar.replace('零万', '万')
  newchar = newchar.replace('零元', '元')
  newchar = newchar.replace('零角', '')
  newchar = newchar.replace('零分', '')
  if (newchar.charAt(newchar.length - 1) === '元') {
    newchar = newchar + '整'
  }
  return newchar
}
// 判断一个元素是否在数组中
const arrContains = function(arr, val) {
  return arr.indexOf(val) !== -1
}
// 数组去重
const unique = function(arr) {
  // eslint-disable-next-line no-prototype-builtins
  if (Array.hasOwnProperty('from')) {
    return Array.from(new Set(arr))
  } else {
    var n = {}
    var r = []
    for (var i = 0; i < arr.length; i++) {
      if (!n[arr[i]]) {
        n[arr[i]] = true
        r.push(arr[i])
      }
    }
    return r
  }
}

// 数组删除其中一个元素
const arrRemove = function(arr, ele) {
  var index = arr.indexOf(ele)
  if (index > -1) {
    arr.splice(index, 1)
  }
  return arr
}

// 求数组中的最大值
const arrMax = function(arr) {
  return Math.max.apply(null, arr)
}
// 求数组中的最小值
const arrMin = function(arr) {
  return Math.min.apply(null, arr)
}
// 数组中的值求和
const arrSum = function(arr) {
  return arr.reduce((pre, cur) => {
    return pre + cur
  })
}
// 去除空格,type: 1-所有空格 2-前后空格 3-前空格 4-后空格
const strTrim = function(str, type) {
  type = type || 2
  switch (type) {
    case 1:
      return str.replace(/\s+/g, '')
    case 2:
      return str.replace(/(^\s*)|(\s*$)/g, '')
    case 3:
      return str.replace(/(^\s*)/g, '')
    case 4:
      return str.replace(/(\s*$)/g, '')
    default:
      return str
  }
}
// 字符转换，type: 1:首字母大写 2：首字母小写 3：大小写转换 4：全部大写 5：全部小写
const changeCase = function(str, type) {
  type = type || 4
  switch (type) {
    case 1:
      return str.replace(/\b\w+\b/g, (word) => {
        return word.substring(0, 1).toUpperCase() + word.substring(1).toLowerCase()
      })
    case 2:
      return str.replace(/\b\w+\b/g, (word) => {
        return word.substring(0, 1).toLowerCase() + word.substring(1).toUpperCase()
      })
    case 3:
      return str.split('').map((word) => {
        if (/[a-z]/.test(word)) {
          return word.toUpperCase()
        } else {
          return word.toLowerCase()
        }
      }).join('')
    case 4:
      return str.toUpperCase()
    case 5:
      return str.toLowerCase()
    default:
      return str
  }
}

const objToar = function(obj) {
  if (obj === '' || obj === undefined) {
    return false
  }
  const keys = Object.keys(obj)
  const values = Object.values(obj)
  const arr = []
  values.forEach((item, index) => {
    Vue.set(arr, keys[index], item)
  })
  return arr
}

// 检测密码强度 等级1-5
const checkPwd = function(str) {
  var Lv = 1
  if (str.length < 6) {
    return Lv
  }
  if (/[0-9]/.test(str)) {
    Lv++
  }
  if (/[a-z]/.test(str)) {
    Lv++
  }
  if (/[A-Z]/.test(str)) {
    Lv++
  }
  if (/[\.|-|_]/.test(str)) {
    Lv++
  }
  return Lv
}
// 在字符串中插入新字符串
const insertStr = function(soure, index, newStr) {
  var str = soure.slice(0, index) + newStr + soure.slice(index)
  return str
}
// 16进制颜色值转RGBA字符串
const colorToRGB = function(val, opa) {
  var pattern = /^(#?)[a-fA-F0-9]{6}$/ // 16进制颜色值校验规则
  var isOpa = typeof opa === 'number' // 判断是否有设置不透明度

  if (!pattern.test(val)) { // 如果值不符合规则返回空字符
    return ''
  }

  var v = val.replace(/#/, '') // 如果有#号先去除#号
  var rgbArr = []
  var rgbStr = ''

  for (var i = 0; i < 3; i++) {
    var item = v.substring(i * 2, i * 2 + 2)
    var num = parseInt(item, 16)
    rgbArr.push(num)
  }

  rgbStr = rgbArr.join()
  rgbStr = 'rgb' + (isOpa ? 'a' : '') + '(' + rgbStr + (isOpa ? ',' + opa : '') + ')'
  return rgbStr
}

/**
* 坐标转换，百度地图坐标转换成腾讯地图坐标
* lng 腾讯经度（pointy）
* lat 腾讯纬度（pointx）
* 经度>纬度
*/
const bMapToQQMap = function(lng, lat) {
  if (lng === null || lng === '' || lat === null || lat === '') { return [lng, lat] }

  var x_pi = 3.14159265358979324
  var x = parseFloat(lng) - 0.0065
  var y = parseFloat(lat) - 0.006
  var z = Math.sqrt(x * x + y * y) - 0.00002 * Math.sin(y * x_pi)
  var theta = Math.atan2(y, x) - 0.000003 * Math.cos(x * x_pi)
  lng = (z * Math.cos(theta)).toFixed(7)
  lat = (z * Math.sin(theta)).toFixed(7)

  return [lng, lat]
}

/**
* 坐标转换，腾讯地图转换成百度地图坐标
* lng 腾讯经度（pointy）
* lat 腾讯纬度（pointx）
* 经度>纬度
*/
const qqMapToBMap = function(lng, lat) {
  if (lng === null || lng === '' || lat === null || lat === '') { return [lng, lat] }

  var x_pi = 3.14159265358979324
  var x = parseFloat(lng)
  var y = parseFloat(lat)
  var z = Math.sqrt(x * x + y * y) + 0.00002 * Math.sin(y * x_pi)
  var theta = Math.atan2(y, x) + 0.000003 * Math.cos(x * x_pi)
  lng = (z * Math.cos(theta) + 0.0065).toFixed(5)
  lat = (z * Math.sin(theta) + 0.006).toFixed(5)
  return [lng, lat]
}

export default {
  // 16进制颜色值转RGBA字符串
  colorToRGB,
  // 在字符串中插入新字符串
  insertStr,
  // 检测密码强度 等级1-5
  checkPwd,
  // 字符转换，type: 1:首字母大写 2：首字母小写 3：大小写转换 4：全部大写 5：全部小写
  changeCase,
  // 去除空格,type: 1-所有空格 2-前后空格 3-前空格 4-后空格
  strTrim,
  // 数组中的值求和
  arrSum,
  // 求数组中的最小值
  arrMin,
  // 求数组中的最大值
  arrMax,

  // 数组删除其中一个元素
  arrRemove,
  // 数组去重
  unique,
  // 判断一个元素是否在数组中
  arrContains,
  // 将阿拉伯数字翻译成中文的大写数字
  numberToChinese,
  // 随机整数范围
  changeToChinese,
  random,
  // 严格的身份证号码校验
  isCardID,
  // 数组随机洗牌算法
  shuffle,
  // 随机数时间戳 （返回数字符串）
  uniqueId,
  // 浮点数乘法运算--解决精度丢失（传入Number，返回Number）
  FloatMul,
  // 浮点数加法运算--解决精度丢失（传入Number，返回Number）
  FloatAdd,
  // 字符串超出多少字显示省略号
  strOut,
  // 判断数据是不是引用类型的数据
  isObject,
  // 是否Set对象
  isSet,
  // 是否Promise对象
  isPromise,
  // 是否Symbol函数
  isSymbol,
  isError,
  pushdArray,
  // 是否正则
  isRegExp,
  // 是否时间对象
  isDate,
  // 是否数组
  isArray,
  // 是否对象
  isObj,
  // 是否undefined
  isUndefined,
  // 是否为null
  isNull,
  // 验证是否是函数
  isFunction,
  // 验证是否是Boolean
  isBoolean,
  // 验证是否是否数字
  isNumber,
  // 验证是否字符串
  isString,
  // 验证是否url地址
  isURL,
  // 验证电话号码
  isPhone,
  // 验证手机号码
  isMobile,
  // 验证邮箱
  isEmail,
  // 格式化时间，通用
  formatDate,
  // 格式化时间-小于10补0
  formatDigit,
  // 判断类型集合
  checkStr,
  // 校验微信环境
  isWeixin,
  /* 获取元素自定义属性值-当前事件元素 */
  getData,
  // 对象转数组
  objToar,
  isEmpty,
  bMapToQQMap,
  qqMapToBMap,
  formateObjToParamStr
}

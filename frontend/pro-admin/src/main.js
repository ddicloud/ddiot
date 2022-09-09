/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-10-30 10:40:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-05 17:04:19
 */
import Vue from 'vue'
import Cookies from 'js-cookie'
import 'normalize.css/normalize.css' // a modern alternative to CSS resets
import 'element-ui/lib/theme-chalk/display.css'
import Element from 'element-ui'
// import VueClipboard from 'vue-clipboard'
import './styles/element-variables.scss'
// import enLang from 'element-ui/lib/locale/lang/en' // 如果使用中文语言包请默认支持，无需额外引入，请删除该依赖
import vueQr from 'vue-qr'
// import '@/utils/el-form.js'
import '@/styles/index.scss' // global css
import App from './App'
import store from './store'
import router from './router'
import { config } from '@/utils/publicUtil'
import './icons' // icon
import './permission' // permission control
import './utils/error-log' // error log
import * as filters from './filters' // global filters
// 引入 axios
import axios from 'axios'
// 页面tab切换按钮
import FireTableMenu from '@/components/FireTableMenu/index.vue'
// 表单头部公共按钮
import FireOperMenu from '@/components/FireOperMenu/index.vue'
// 多规格表单类型
import FireTable from '@/components/FireTable/index.vue'

import iGlobal from '@/directive/global.js' // 引入 global.js
import FireDataTable from '@/components/FireDataTable/index.vue'
import VueClipboard from 'vue-clipboard2'
import echarts from 'echarts'

import Avue from '@smallwei/avue'
import '@smallwei/avue/lib/index.css'
import { dependencies, devDependencies } from '../package.json'
import moment from 'moment'
Vue.prototype.$moment = moment

Vue.prototype.$dependencies = dependencies
Vue.prototype.$devDependencies = devDependencies
// if (!Vue && typeof window !== 'undefined' && window.Vue) {
//   install(window.Vue)
// }

// 初始化表单全局配置
import '@/utils/el-form.js'
Vue.prototype.iGlobal = iGlobal
Vue.prototype.apiUrl = config.apiUrl
Vue.prototype.$http = axios
Vue.config.productionTip = false
Vue.prototype.$echarts = echarts

/**
 * If you don't want to use mock-server
 * you want to use MockJs for mock api
 * you can execute: mockXHR()
 *
 * Currently MockJs will be used in the production environment,
 * please remove it before going online ! ! !
 */
if (process.env.NODE_ENV === 'production') {
  const {
    mockXHR
  } = require('../mock')
  mockXHR()
}
Vue.component('FireDataTable', FireDataTable)
Vue.component('fire-tab-menu', FireTableMenu)
Vue.component('fire-oper-menu', FireOperMenu)
Vue.component('fire-table', FireTable)
Vue.component('fireQr', vueQr)
Vue.use(VueClipboard)
Vue.use(Avue)
// Vue.component('el-filter', ElFilter)

// Vue.use(VueClipboard)
Vue.use(Element, {
  size: Cookies.get('size') || 'medium' // set element-ui default size
  // locale: enLang // 如果使用中文，无需设置，请删除
})
// register global utility filters
Object.keys(filters).forEach(key => {
  Vue.filter(key, filters[key])
})
Vue.config.productionTip = false
new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})

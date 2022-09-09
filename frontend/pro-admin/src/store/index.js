/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-10-27 09:56:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-05 18:20:21
 */
import Vue from 'vue'
import Vuex from 'vuex'
import getters from './getters'
import createPersistedState from 'vuex-persistedstate'
import SecureLS from 'secure-ls'
Vue.use(Vuex)

var ls = new SecureLS({
  encodingType: 'aes',
  isCompression: false,
  encryptionSecret: 'old-beauty'
})
// https://webpack.js.org/guides/dependency-management/#requirecontext
const modulesFiles = require.context('./modules', true, /\.js$/)

// you do not need `import app from './modules/app'`
// it will auto require all vuex module from modules file
const modules = modulesFiles.keys().reduce((modules, modulePath) => {
  // set './app.js' => 'app'
  const moduleName = modulePath.replace(/^\.\/(.*)\.\w+$/, '$1')
  const value = modulesFiles(modulePath)
  modules[moduleName] = value.default
  return modules
}, {})

const store = new Vuex.Store({
  modules,
  getters,
  // 配置保存所有state到localStorage中
  plugins: [
    createPersistedState({
      // storage: window.sessionStorage,
      key: 'sessionStorage',
      reducer(val) {
        return {
          elForm: val.elForm,
          app: val.app,
          user: val.user,
          settings: val.settings,
          pluginsMenu: val.permission.pluginsMenu
        }
      },
      storage: {
        getItem: key => ls.get(key),
        setItem: (key, value) => ls.set(key, value),
        removeItem: key => ls.remove(key)
      }
    })
  ]
})

export default store


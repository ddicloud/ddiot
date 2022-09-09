/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-11-29 23:22:59
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-15 19:20:55
 */
// var publicUtil = require('./utils/publicUtil.js')
// import { config } from './utils/publicUtil'
// const Config = publicUtil.config
var Config = require('./config/config.js')

module.exports = {
  title: Config.siteName,
  /**
   * @type {boolean} true | false
   * @description Whether show the settings right-panel
   */
  showSettings: true,

  /**
   * @type {boolean} true | false
   * @description Whether need tagsView
   */
  tagsView: true,

  /**
   * @type {boolean} true | false
   * @description Whether fix the header
   */
  fixedHeader: false,

  /**
   * @type {boolean} true | false
   * @description Whether show the logo in sidebar
   */
  sidebarLogo: true,

  /**
   * @type {string | array} 'production' | ['production', 'development']
   * @description Need show err logs component.
   * The default is only used in the production env
   * If you want to also use it in dev, you can pass ['production', 'development']
   */
  errorLog: 'production',
  menuType: Config.menuType || 'system',
  Layout: Config.Layout || 'subfield'
}

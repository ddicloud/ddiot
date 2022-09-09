/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-10-30 10:40:26
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-05 18:15:22
 */
const getters = {
  sidebar: state => state.app.sidebar,
  size: state => state.app.size,
  elForm: state => state.elForm,
  device: state => state.app.device,
  visitedViews: state => state.tagsView.visitedViews,
  cachedViews: state => state.tagsView.cachedViews,
  accessToken: state => state.user.access_token,
  userInfo: state => state.user,
  webSite: state => state.user.webSite,
  blocId: state => state.app.blocId,
  storeId: state => state.app.storeId,
  storeName: state => state.app.storeName,
  avatar: state => state.user.avatar,
  username: state => state.user.name,
  addons: state => state.user.addons,
  introduction: state => state.user.introduction,
  roles: state => state.user.roles,
  permission_routes: state => state.permission.routes,
  errorLogs: state => state.errorLog.logs,
  moduleAll: state => state.permission.moduleAll,
  menutop: state => state.permission.menutop,
  LeftMenu: state => state.permission.LeftMenu,
  pluginsMenu: state => state.permission.pluginsMenu,
  subLeftIsActive: state => state.permission.subLeftIsActive,
  menuType: state => state.settings.menuType,
  plugins: state => state.settings.plugins,
  Layout: state => state.settings.Layout,
  baseUrl: state => state.settings.baseUrl,
  siteUrl: state => state.settings.siteUrl,
  uploadUrl: state => state.settings.uploadUrl,
  uploadConf: state => state.settings.uploadConf
}
export default getters

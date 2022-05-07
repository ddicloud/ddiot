/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-10-30 10:40:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-15 14:27:16
 */

const config = {
  siteName: '店滴云',
  // 站点基础地址 末尾不带斜杠
  // siteUrl: 'https://dev.hopesfire.com',
  siteUrl: process.env.NODE_ENV !== 'production'
    ? 'https://dev.hopesfire.com'
    : 'https://dev.hopesfire.com',
  // 百度地址key
  bmapAk: 'sY7GGnljSvLzM44mEwVtGozS',
  // unit 单商户模式，units多商户模式
  modeType: 'units',
  // 集团ID
  bloc_id: 28,
  // 商户id
  store_id: 77,
  // 默认模块
  menuType: 'system',
  // 默认布局
  Layout: 'subfield'
}

module.exports = config

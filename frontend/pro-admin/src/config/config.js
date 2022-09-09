/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-10-30 10:40:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-18 15:57:45
 */

const config = {
  siteName: '店滴云-让经营场所，更智能',
  // 站点基础地址 末尾不带斜杠
  // siteUrl: 'https://dev.hopesfire.com',
  siteUrl: process.env.NODE_ENV !== 'production'
    // ? 'http://www.wayfiretech.com'
    // : 'https://www.wayfiretech.com',
    ? 'https://www.dandicloud.cn'
    : 'https://www.dandicloud.cn',
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

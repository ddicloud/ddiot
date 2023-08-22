/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-11-08 09:02:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-12 09:47:08
 */

const config = {
  siteName: '店滴云-让经营场所，更智能',
  // 站点基础地址 末尾不带斜杠
  // siteUrl: 'https://dev.hopesfire.com',
  siteUrl: process.env.NODE_ENV !== 'production'
    ? 'https://www.ddiot.com'
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
  Layout: 'subfield',
  serviceMenu: [{
    'id': 'serviceMenu',
    'hidden': true,
    'parent': 0,
    'name': 'service-subscription',
    'type': 'service',
    'meta': {
      'parent_menu_id': 0,
      'title': ' 服务',
      'icon': 'el-dd-appstoreadd',
      'affix': false,
      'parent': 1575
    },
    'path': '/default/service/index.vue',
    'children': [{
      'id': 1576,
      'hidden': false,
      'parent': 1575,
      'order': 2,
      'name': 'service-subscription',
      'level_type': 4,
      'type': 'service',
      'meta': {
        'parent_menu_id': 0,
        'title': '服务订购',
        'icon': '',
        'affix': false,
        'parent': 'serviceMenu'
      },
      'path': '/default/service/subscription.vue',
      'children': [],
      'icon': ''
    },
    {
      'id': 1582,
      'hidden': false,
      'parent': 1575,
      'order': 1,
      'name': 'invoice-index',
      'level_type': 4,
      'type': 'service',
      'meta': {
        'parent_menu_id': 0,
        'title': '发票管理',
        'icon': '',
        'affix': false,
        'parent': 'serviceMenu'
      },
      'path': '/default/invoice/index.vue',
      'children': [],
      'icon': ''
    },
    {
      'id': 1579,
      'hidden': false,
      'parent': 'serviceMenu',
      'order': 0,
      'name': 'service-register',
      'level_type': 4,
      'type': 'service',
      'meta': {
        'parent_menu_id': 0,
        'title': '订购记录',
        'icon': '',
        'affix': false,
        'parent': 'serviceMenu'
      },
      'path': '/default/service/register.vue',
      'children': [],
      'icon': ''
    }
    ]
  }]
}

module.exports = config

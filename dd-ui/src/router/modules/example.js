/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-10-30 10:40:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-01 10:32:37
 */
/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/layout'
// import LayoutMain from '@/views/main'
import diandiAdmin from 'diandi-admin'
const LayoutMain = diandiAdmin['main-index']

const example = {
  path: '/example',
  component: Layout,
  redirect: '/example/index',
  children: [{
    path: '/example/index',
    component: diandiAdmin['ExampleIndex'],
    name: 'example-index',
    meta: {
      title: '开发示例首页',
      icon: 'guide',
      noCache: true
    }
  },
  {
    path: '/example/guide',
    component: LayoutMain,
    redirect: '/example/guide/index',
    children: [{
      path: '/example/guide/index',
      component: diandiAdmin['ExampleGuideIndex'],
      name: 'example-guide-index',
      meta: {
        title: '示例Guide',
        icon: 'guide',
        noCache: true
      }
    }]
  },
  {
    path: '/example/permission',
    component: LayoutMain,
    redirect: '/example/permission/page',
    alwaysShow: true, // will always show the root menu
    name: 'Permission',
    meta: {
      title: 'Permission',
      icon: 'lock',
      roles: ['admin', 'editor'] // you can set roles in root nav
    },
    children: [{
      path: 'page',
      component: diandiAdmin['ExamplePermissionPage'],
      name: 'PagePermission',
      meta: {
        title: 'Page Permission',
        roles: ['admin'] // or you can only set roles in sub nav
      }
    },
    {
      path: 'directive',
      component: diandiAdmin['ExamplePermissionDirective'],
      name: 'DirectivePermission',
      meta: {
        title: 'Directive Permission'
        // if do not set roles, means: this page does not require permission
      }
    },
    {
      path: 'role',
      component: diandiAdmin['ExamplePermissionRole'],
      name: 'RolePermission',
      meta: {
        title: 'Role Permission',
        roles: ['admin']
      }
    }
    ]
  },

  {
    path: '/example/icons',
    component: LayoutMain,
    redirect: '/example/icons/index',
    children: [{
      path: 'index',
      component: diandiAdmin['ExampleIconsIndex'],
      name: 'Icons',
      meta: {
        title: 'Icons',
        icon: 'icon',
        noCache: true
      }
    }]
  },
  {
    path: '/example/base-page',
    component: LayoutMain,
    redirect: '/example/base-page/index',
    name: 'Example',
    meta: {
      title: 'Example',
      icon: 'el-icon-s-help'
    },
    children: [{
      path: 'index',
      component: diandiAdmin['BasePageIndex'],
      name: 'base-page-index',
      meta: {
        title: '开发示例',
        icon: 'edit'
      }
    }, {
      path: 'create',
      component: diandiAdmin['BasePageCreate'],
      name: 'CreateArticle',
      meta: {
        title: 'Create Article',
        icon: 'edit'
      }
    },
    {
      path: 'edit/:id(\\d+)',
      component: diandiAdmin['BasePageEdit'],
      name: 'EditArticle',
      meta: {
        title: 'Edit Article',
        noCache: true,
        activeMenu: '/example/base-page/list'
      },
      hidden: true
    },
    {
      path: 'list',
      component: diandiAdmin['BasePageList'],
      name: 'ArticleList',
      meta: {
        title: 'Article List',
        icon: 'list'
      }
    }
    ]
  },
  {
    path: '/example/tab',
    component: LayoutMain,
    redirect: '/example/tab/index',
    children: [{
      path: 'index',
      component: diandiAdmin['ExampleTabIndex'],
      name: 'Tab',
      meta: {
        title: 'Tab',
        icon: 'tab'
      }
    }]
  }
  ]

}

export default example

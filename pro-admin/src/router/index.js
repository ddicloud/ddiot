/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-10-27 09:56:28
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-16 09:28:57
 */
import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

/* Layout */
import Layout from '@/layout'
import diandiAdmin from 'diandi-admin'

/* Router Modules */
import componentsRouter from './modules/components'
import chartsRouter from './modules/charts'
// import tableRouter from './modules/table'
import formRouter from './modules/form'
import example from './modules/example'
// import centerHonorayEdit from './diandi_honorary/center_honoray/center_honoray_edit'

/**
  * Note: sub-menu only appear when route children.length >= 1
  * Detail see: https://panjiachen.github.io/vue-element-admin-site/guide/essentials/router-and-nav.html
  *
  * hidden: true                   if set true, item will not show in the sidebar(default is false)
  * alwaysShow: true               if set true, will always show the root menu
  *                                if not set alwaysShow, when item has more than one children route,
  *                                it will becomes nested mode, otherwise not show the root menu
  * redirect: noRedirect           if set noRedirect will no redirect in the breadcrumb
  * name:'router-name'             the name is used by <keep-alive> (must set!!!)
  * meta : {
     roles: ['admin','editor']    control the page roles (you can set multiple roles)
     title: 'title'               the name show in sidebar and breadcrumb (recommend set)
     icon: 'svg-name'/'el-icon-x' the icon show in the sidebar
     noCache: true                if set true, the page will no be cached(default is false)
     affix: true                  if set true, the tag will affix in the tags-view
     breadcrumb: false            if set false, the item will hidden in breadcrumb(default is true)
     activeMenu: '/example/list'  if set path, the sidebar will highlight the path you set
   }
  */

/**
 * constantRoutes
 * a base page that does not have permission requirements
 * all roles can be accessed
 */
export const constantRoutes = [
  {
    path: '/redirect',
    component: Layout,
    hidden: true,
    children: [
      {
        path: '/redirect/:path(.*)',
        component: diandiAdmin['redirect-index']
      }
    ]
  },
  {
    path: '/login',
    component: diandiAdmin['login-index'],
    hidden: true
  },
  {
    path: '/forget',
    component: diandiAdmin['login-forget'],
    hidden: true
  },
  {
    path: '/register',
    component: diandiAdmin['login-register'],
    hidden: true
  },
  {
    path: '/auth-redirect',
    component: diandiAdmin['login-auth-redirect'],
    hidden: true
  },
  {
    path: '/401',
    component: diandiAdmin['error-page/401'],
    hidden: true
  },
  // {
  //   path: '/',
  //   component: Layout,
  //   redirect: '/dashboard',
  //   children: [
  //     {
  //       path: 'dashboard',
  //       component: diandiAdmin['dashboard'],
  //       name: '首页',
  //       meta: {
  //         title: '首页',
  //         icon: 'dashboard',
  //         affix: true
  //       }
  //     }
  //   ]
  // },
  {
    path: '/profile',
    component: Layout,
    redirect: '/profile/index',
    hidden: true,
    children: [
      {
        path: 'index',
        component: () => diandiAdmin['profile-index'],
        name: 'Profile',
        meta: {
          title: '我的资料',
          icon: 'user',
          noCache: true
        }
      }
    ]
  },
  {
    path: '/diandi',
    component: Layout,
    redirect: '/diandi/index',
    hidden: true,
    children: [
      {
        path: 'index',
        component: diandiAdmin['user-management'],
        name: 'diandi',
        meta: {
          title: '组件测试地址',
          icon: 'user',
          noCache: true
        }
      }
    ]
  }
]
// 404 page must be placed at the end !!!
// {
//   path: '*',
//   redirect: '/404',
//   hidden: true
// }

/**
 * asyncRoutes
 * the routes that need to be dynamically loaded based on user roles
 */
export const asyncRoutes = [
  /** when your routing map is too long, you can split it into small modules **/
  componentsRouter,
  chartsRouter,
  // tableRouter,
  formRouter,
  example,
  // centerHonorayEdit,
  {
    path: '/error',
    component: Layout,
    redirect: 'noRedirect',
    name: 'ErrorPages',
    meta: {
      title: 'Error Pages',
      icon: '404'
    },
    children: [
      {
        path: '401',
        component: diandiAdmin['error-page-401'],
        name: 'Page401',
        meta: {
          title: '401',
          noCache: true
        }
      },
      {
        path: '404',
        component: diandiAdmin['error-page-404'],
        name: 'Page404',
        meta: {
          title: '404',
          noCache: true
        }
      }
    ]
  },

  {
    path: '/error-log',
    component: Layout,
    children: [
      {
        path: 'log',
        component: diandiAdmin['error-page-index'],
        name: 'ErrorLog',
        meta: {
          title: 'Error Log',
          icon: 'bug'
        }
      }
    ]
  },

  {
    path: '/example/excel',
    component: Layout,
    redirect: '/example/excel/export-excel',
    name: 'Excel',
    meta: {
      title: 'Excel',
      icon: 'excel'
    },
    children: [
      {
        path: 'export-excel',
        component: diandiAdmin['ExcelExportExcel'],
        name: 'ExportExcel',
        meta: {
          title: 'Export Excel'
        }
      },
      {
        path: 'export-selected-excel',
        component: diandiAdmin['ExcelSelectExcel'],
        name: 'SelectExcel',
        meta: {
          title: 'Export Selected'
        }
      },
      {
        path: 'export-merge-header',
        component: diandiAdmin['ExcelMergeHeader'],
        name: 'MergeHeader',
        meta: {
          title: 'Merge Header'
        }
      },
      {
        path: 'upload-excel',
        component: diandiAdmin['ExcelUploadExcel'],
        name: 'UploadExcel',
        meta: {
          title: 'Upload Excel'
        }
      }
    ]
  },

  {
    path: '/example/zip',
    component: Layout,
    redirect: '/example/zip/download',
    alwaysShow: true,
    name: 'Zip',
    meta: {
      title: 'Zip',
      icon: 'zip'
    },
    children: [
      {
        path: 'download',
        component: diandiAdmin['ExampleZipIndex'],
        name: 'ExportZip',
        meta: {
          title: 'Export Zip'
        }
      }
    ]
  },
  {
    path: '/example/pdf',
    component: Layout,
    redirect: '/example/pdf/index',
    children: [
      {
        path: 'index',
        component: diandiAdmin['ExamplePdfIndex'],
        name: 'PDF',
        meta: {
          title: 'PDF',
          icon: 'pdf'
        }
      }
    ]
  },
  {
    path: '/example/pdf/download',
    component: diandiAdmin['ExamplePdfDownload'],
    hidden: true
  },

  {
    path: '/example/theme',
    component: Layout,
    redirect: '/example/theme/index',
    children: [
      {
        path: 'index',
        component: diandiAdmin['ExampleThemeIndex'],
        name: 'Theme',
        meta: {
          title: 'Theme',
          icon: 'theme'
        }
      }
    ]
  },

  {
    path: '/example/clipboard',
    component: Layout,
    redirect: '/example/clipboard/index',
    children: [
      {
        path: 'index',
        component: diandiAdmin['ClipboardIndex'],
        name: 'ClipboardDemo',
        meta: {
          title: 'Clipboard',
          icon: 'clipboard'
        }
      }
    ]
  }
  // {
  //   path: '/centerHonorayEdit',
  //   component: Layout,
  //   redirect: '/diandi_honorary/center_honoray/center_honoray_edit',
  //   children: [{
  //     path: 'centerHonorayEdit',
  //     component: () => import('@/views/diandi_honorary/center_honoray/center_honoray_edit'),
  //     name: 'CenterHonoray',
  //     meta: {
  //       title: 'CenterHonoray',
  //       icon: 'centerHonoray'
  //     }
  //   }]
  // }
  // 404 page must be placed at the end !!!
  //  {
  //    path: '*',
  //    redirect: '/404',
  //    hidden: true
  //  }
]

const createRouter = () =>
  new Router({
    mode: 'hash', // require service support
    base: '/honor-admin-fe',
    scrollBehavior: () => ({
      y: 0
    }),
    routes: asyncRoutes.concat(constantRoutes)
    //  routes: constantRoutes
  })

const router = createRouter()

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
  const newRouter = createRouter()
  router.matcher = newRouter.matcher // reset router
}

export default router

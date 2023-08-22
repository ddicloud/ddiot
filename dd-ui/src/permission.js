/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-10-30 10:40:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-07 18:17:54
 */
import router from './router'
import store from './store'
import Cookies from 'js-cookie'
// import {
//   Message
// } from 'element-ui'
import NProgress from 'nprogress' // progress bar
import 'nprogress/nprogress.css' // progress bar style
import {
  getToken
} from '@/utils/auth' // get token from cookie
import getPageTitle from '@/utils/get-page-title'
import { getsignup } from 'diandi-admin/lib/api/admin/user.js'
NProgress.configure({
  showSpinner: false
}) // NProgress Configuration

const whiteList = ['/login', '/auth-redirect', '/register', '/forget', '/qcord'] // no redirect whitelist

router.beforeEach(async(to, from, next) => {
  // start progress bar
  NProgress.start()

  // set page title
  document.title = getPageTitle(to.meta.title)

  // determine whether the user has logged in
  const hasToken = getToken()

  if (hasToken) {
    if (to.path === '/login') {
      // if is logged in, redirect to the home page
      next({
        path: '/'
      })
      NProgress.done() // hack: https://github.com/PanJiaChen/vue-element-admin/pull/2939
    } else {
      // determine whether the user has obtained his permission roles through getInfo
      const permission_routes = store.getters.permission_routes && store.getters.permission_routes
        .length > 0 && store.getters.LeftMenu.length > 0
      // console.log('权限初始化校验',store.getters.LeftMenu)
      const is_roles = Cookies.get('is_roles')
      if (is_roles && permission_routes) {
        next()
      } else {
        try {
          // get user info
          // note: roles must be a object array! such as: ['admin'] or ,['developer','editor']
          const {
            access_token, roles
          } = await store.dispatch('user/getInfo')
          // 动态生成路由
          store.dispatch('user/setRoles', roles)
          // generate accessible routes map based on roles
          const accessRoutes = await store.dispatch('permission/getMenus', access_token)
          // dynamically add accessible routes
          router.addRoutes(accessRoutes)
          // hack method to ensure that addRoutes is complete
          // set the replace: true, so the navigation will not leave a history record
          next({
            ...to,
            replace: true
          })
        } catch (error) {
          // remove token and go to login page to re-login
          await store.dispatch('user/resetToken')
          // Message.error(error.message || 'Has Error')
          next(`/login?redirect=${to.path}`)
          NProgress.done()
        }
      }
    }
  } else {
    /* has no token*/

    if (whiteList.indexOf(to.path) !== -1) {
      // in the free login whitelist, go directly
      next()
    } else {
      const code = to.query.code ?? 0
      if (code) {
        // 使用code获取用户信息
        const data = {
          code: code
        }
        getsignup(data).then(async(response) => {
          if (response.code === 200) {
            store.dispatch('user/set_token', response.data.access_token)
            const { access_token, roles } = response.data
            // 动态生成路由
            store.dispatch('user/setRoles', roles)
            // generate accessible routes map based on roles
            const accessRoutes = await store.dispatch('permission/getMenus', access_token)
            console.log('accessRoutes', JSON.stringify(accessRoutes))
            // dynamically add accessible routes
            router.addRoutes(accessRoutes)

            next(`/system-store-index?redirect=${to.path}`)
          }
        })
      } else {
        next(`/login?redirect=${to.path}`)
      }

      // 使用用户信息请求后台查看是否存在

      // 存在就直接登录

      // 不存在就去绑定账户

      // other pages that do not have permission to access are redirected to the login page.
      // next(`/login?redirect=${to.path}`)
      NProgress.done()
    }
  }
})

router.afterEach(() => {
  // finish progress bar
  NProgress.done()
})

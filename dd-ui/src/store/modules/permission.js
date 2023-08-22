/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-10-30 10:40:26
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-01-13 12:33:51
 */
import {
  asyncRoutes,
  constantRoutes
} from '@/router'

import {
  getMenus,
  getMenuRoutes
} from 'diandi-admin/lib/api/system/system'
import Cookies from 'js-cookie'

/**
 * Use meta.role to determine if the current user has permission
 * @param roles
 * @param route
 */
function hasPermission(roles, route) {
  if (route.meta && route.meta.roles) {
    return roles.some(role => route.meta.roles.includes(role))
  } else {
    return true
  }
}

/**
 * Filter asynchronous routing tables by recursion
 * @param routes asyncRoutes
 * @param roles
 */
export function filterAsyncRoutes(routes, roles) {
  const res = []

  routes.forEach(route => {
    const tmp = {
      ...route
    }
    if (hasPermission(roles, tmp)) {
      if (tmp.children) {
        tmp.children = filterAsyncRoutes(tmp.children, roles)
      }
      res.push(tmp)
    }
  })

  return res
}

const state = {
  routes: [],
  addRoutes: [],
  moduleAll: [],
  menutop: [],
  menuType: 'system',
  Layout: 'top',
  pluginsMenu: [],
  LeftMenu: [],
  subLeftIsActive: 0
}

const mutations = {
  SET_ROUTES: (state, routes) => {
    state.addRoutes = routes
    state.routes = constantRoutes.concat(routes)
  },
  SET_ROLES: (state, roles) => {
    state.roles = roles
  },
  SET_MODULE: (state, moduleAll) => {
    state.moduleAll = moduleAll
  },
  SET_MENUTOP: (state, menutop) => {
    state.menutop = menutop
  },
  SET_MENUTYPE: (state, menuType) => {
    state.menuType = menuType
  },
  SET_LAYOUT: (state, Layout) => {
    state.Layout = Layout
  },
  SET_LEFTMENU: (state, LeftMenu) => {
    state.LeftMenu = LeftMenu
  },
  SET_PLUGINSMENU: (state, menus) => {
    state.pluginsMenu = menus
  },
  SET_LEFTACTIVE: (state, subLeftIsActive) => {
    state.subLeftIsActive = subLeftIsActive
  }
}
console.log('state', state)
const actions = {
  generateRoutes({
    commit
  }, roles) {
    return new Promise(resolve => {
      let accessedRoutes

      if (roles.includes('admin')) {
        accessedRoutes = asyncRoutes || []
      } else {
        accessedRoutes = filterAsyncRoutes(asyncRoutes, roles)
      }
      commit('SET_ROUTES', accessedRoutes)
      resolve(accessedRoutes)
    })
  },
  getMenus({
    commit
  }, access_token) {
    return new Promise((resolve, reject) => {
      getMenus(access_token).then(response => {
        const {
          left,
          top,
          Roles,
          moduleAll
        } = response.data
        console.log('初始化菜单 getMenus left', JSON.stringify(left))
        commit('SET_MENUTOP', top)
        commit('SET_MODULE', moduleAll)
        commit('SET_ROLES', Roles)

        const Routes = getMenuRoutes(left)
        console.log('初始化菜单 getMenuRoutes', JSON.stringify(left))

        // const LeftMenu = initLeftMenus(left)
        const LeftMenu = left
        console.log('初始化菜单 LeftMenu', JSON.stringify(left))

        commit('SET_LEFTMENU', LeftMenu)
        Cookies.set('is_roles', 1)
        // console.log('Routes0', left)
        Routes.push({ path: '*', redirect: '/404', hidden: true })
        // console.log('LeftMenu',Routes)
        commit('SET_ROUTES', Routes)
        resolve(Routes)
      }).catch(error => {
        reject(error)
      })
    })
  },
  setLeftMent({
    commit
  }, menus) {
    commit('SET_LEFTMENU', menus)
  },
  setPluginsMent({
    commit
  }, menus) {
    commit('SET_PLUGINSMENU', menus)
  },
  setMenuType({
    commit
  }, menuType) {
    commit('SET_MENUTYPE', menuType)
  },
  setLayout({
    commit
  }, Layout) {
    commit('SET_LAYOUT', Layout)
  },
  setActive({
    commit
  }, active) {
    commit('SET_LEFTACTIVE', active)
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}

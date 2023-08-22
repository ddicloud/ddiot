/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-10-30 10:40:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-01-22 02:12:22
 */
import Cookies from 'js-cookie'
import store from '@/store'

const TokenKey = 'access-token'

export function getToken() {
  return Cookies.get(TokenKey)
}

export function setToken(token) {
  store.dispatch('elForm/changeHEaders', {
    key: TokenKey,
    value: token
  })
  return Cookies.set(TokenKey, token)
}

export function removeToken() {
  Cookies.remove('is_roles')
  return Cookies.remove(TokenKey)
}

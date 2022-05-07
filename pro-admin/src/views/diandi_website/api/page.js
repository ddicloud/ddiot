/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-19 10:08:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-21 11:01:09
 */
import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/diandi_website/page/index',
    method: 'get',
    params: query
  })
}

export function getView(id) {
  return request({
    url: `/diandi_website/page/view/${id}`,
    method: 'get'
  })
}

export function createItem(data) {
  return request({
    url: '/diandi_website/page/create',
    method: 'post',
    data
  })
}

export function updateItem(data) {
  return request({
    url: `/diandi_website/page/update/${data.id}`,
    method: 'PUT',
    data
  })
}

export function deleteItem(id) {
  return request({
    url: `/diandi_website/page/delete/${id}`,
    method: 'DELETE'
  })
}

export function fetchView(id) {
  return request({
    url: `/diandi_website/page/view/${id}`,
    method: 'get'
  })
}

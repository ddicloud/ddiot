/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-02-11 11:12:33
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-11 12:29:10
 */
import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/diandi_website/article/index',
    method: 'get',
    params: query
  })
}

export function getView(id) {
  return request({
    url: `/diandi_website/article/view/${id}`,
    method: 'get'
  })
}

export function createItem(data) {
  return request({
    url: '/diandi_website/article/create',
    method: 'post',
    data
  })
}

export function updateItem(data) {
  return request({
    url: `/diandi_website/article/update/${data.id}`,
    method: 'PUT',
    data
  })
}

export function deleteItem(id) {
  return request({
    url: `/diandi_website/article/delete/${id}`,
    method: 'DELETE'
  })
}

export function fetchView(id) {
  return request({
    url: `/diandi_website/article/view/${id}`,
    method: 'get'
  })
}

export function fetchCate(data) {
  return request({
    url: '/diandi_website/article/cate',
    method: 'post',
    data
  })
}

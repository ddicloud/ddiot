/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-19 10:08:14
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-20 20:09:47
 */
import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/diandi_website/slide/index',
    method: 'get',
    params: query
  })
}

export function getView(id) {
  return request({
    url: `/diandi_website/slide/view/${id}`,
    method: 'get'
  })
}

export function createItem(data) {
  return request({
    url: '/diandi_website/slide/create',
    method: 'post',
    data
  })
}

export function updateItem(data) {
  return request({
    url: `/diandi_website/slide/update/${data.id}`,
    method: 'PUT',
    data
  })
}

export function deleteItem(id) {
  return request({
    url: `/diandi_website/slide/delete/${id}`,
    method: 'DELETE'
  })
}

export function fetchView(id) {
  return request({
    url: `/diandi_website/slide/view/${id}`,
    method: 'get'
  })
}

export function getpagelist(data) {
  return request({
    url: '/diandi_website/article/pagelist',
    method: 'get',
    data
  })
}

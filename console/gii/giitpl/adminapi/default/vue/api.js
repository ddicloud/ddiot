
import request from '@/utils/request'
import {path} from "./init";


export function initList(data) {
    return request({
        url: path.api + '/index',
        method: 'get',
        params: data
    })
}

export function getView(id) {
    return request({
        url: path.api + `/${id}`,
        method: 'get'
    })
}

export function itemCreate(data) {
    return request({
        url: path.api + '/create',
        method: 'post',
        data: data
    })
}

export function itemUpdate(id, data) {
    return request({
        url: path.api + `/update/${id}`,
        method: 'put',
        data: data
    })
}

export function itemDelete(id) {
    return request({
        url: `/diandi_hotel/advertise/ad/delete/${id}`,
        method: 'delete'
    })
}

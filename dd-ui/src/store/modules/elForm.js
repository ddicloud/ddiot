/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-10-30 10:40:26
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-01-22 13:06:51
 */
import {
  getToken
} from '@/utils/auth'

import {
  bloc_id,
  store_id,
  siteUrl,
  bmapAk
} from '@/config/config'

// 图片上传地址
const uploaImage = siteUrl + '/admin/file/upload/images'
// 文件上传地址
const uploadFile = siteUrl + '/admin/file/upload/file'
// 资源预览默认地址
const attachmentUrl = siteUrl + '/attachment'
// 分配合并上传地址
const uploadMerge = siteUrl + '/admin/file/upload/merge'
// 百度编辑器配置地址
const ueditorServerUrl = siteUrl + '/admin/system/settings/ueditor'

const state = {
  headers: {
    'access-token': getToken(),
    'bloc-id': bloc_id,
    'store-id': store_id
  },
  fileSize: 10,
  chunkSize: 2, // 分片尺寸（M）
  action: uploaImage, // 图片上传地址,
  uploadFile: uploadFile, // 文件上传地址,
  uploadMerge: uploadMerge, // 分配合并地址,
  attachmentUrl: attachmentUrl, // 资源访问路径（主要考虑云上传问题）
  ueditorServerUrl: ueditorServerUrl, // 百度编辑器服务配置请求
  bmapAk: bmapAk, // 百度地图key
  data: {}// 上传基础参数
}

const mutations = {
  CHANGE_SETTING: (state, {
    key,
    value
  }) => {
    // eslint-disable-next-line no-prototype-builtins
    if (state.hasOwnProperty(key)) {
      state[key] = value
    }
  },
  CHANGE_HEADERS: (state, {
    key,
    value
  }) => {
    // eslint-disable-next-line no-prototype-builtins
    if (state.headers.hasOwnProperty(key)) {
      state.headers[key] = value
    }
  }
}

const actions = {
  changeSetting({
    commit
  }, data) {
    console.log(data)
    commit('CHANGE_SETTING', data)
  },
  changeHEaders({
    commit
  }, data) {
    commit('CHANGE_HEADERS', {
      key: data.key,
      value: data.value
    })
  },
  changeSettingAll({
    commit
  }, data) {
    const keys = Object.keys(data)
    const values = Object.values(data)
    values.forEach((val, index) => {
      commit('CHANGE_SETTING', {
        key: keys[index],
        value: val
      })
    })
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}

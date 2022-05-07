/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-11-14 11:37:10
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-01-26 23:58:15
 */
import Vue from 'vue'
import store from '@/store'

// 表单检索
import ElFilter from 'diandi-ele-form-filter'
// 引入 diandi-ele-form
import EleForm from 'diandi-ele-form/lib'
// 图片上传
import EleFormImageUploader from 'diandi-ele-form-image-uploader'
// 文件上传
import EleFormUploadFile from 'diandi-ele-form-upload-file'
// 视频上传
import EleFormVideoUploader from 'diandi-ele-form-video-uploader'
// 树形下拉选择
import EleFormTreeSelect from 'diandi-ele-form-tree-select'
// 动态表单
import EleFormDynamic from 'diandi-ele-form-dynamic/dist/diandi-ele-form-dynamic.umd.min.js'
// 百度地图
import EleFormBmap from 'diandi-ele-form-bmap'
// 百度编辑器
import VueUeditorWrap from 'diandi-ueditor'
// 富文本编辑器
// import EleFormQuillEditor from 'diandi-ele-form-quill-editor'
// 图标选择器
import FireIcon from '@/components/FireIcon/index.vue'
// 注册 image-uploader 组件
Vue.component('image-uploader', EleFormImageUploader)
// 注册 upload-file 组件
Vue.component('upload-file', EleFormUploadFile)
// 注册 video-uploader 组件
Vue.component('video-uploader', EleFormVideoUploader)
// 注册 tree-select 组件
Vue.component('tree-select', EleFormTreeSelect)
// 注册 dynamic 组件
Vue.component('dynamic', EleFormDynamic)
// 注册 bmap 组件
Vue.component('bmap', EleFormBmap)
Vue.component('FireIcon', FireIcon)
Vue.component('fire-editor', VueUeditorWrap)
Vue.use(ElFilter)

const config = {
  fileSize: store.getters.elForm.fileSize,
  chunkSize: store.getters.elForm.chunkSize, // 分片尺寸（M）
  action: store.getters.elForm.action, // 图片上传地址,
  uploadFile: store.getters.elForm.uploadFile, // 文件上传地址,
  uploadMerge: store.getters.elForm.uploadMerge, // 分配合并地址,
  attachmentUrl: store.getters.elForm.attachmentUrl,
  ueditorServerUrl: store.getters.elForm.ueditorServerUrl,
  // 只配置键值，且这些存储到Cookie中
  headers: store.getters.elForm.headers,
  // headers: {
  //   'access-token': store.getters.accessToken,
  //   'bloc-id': store.getters.blocId,
  //   'store-id': store.getters.storeId
  // },
  data: {

  }
}

store.dispatch('elForm/changeSettingAll', config)
// 在引入 EleForm 时，可以传入一个全局配置对象(可选), 例如:
Vue.use(EleForm, {
  // 所有和上传相关(上传图片, 上传视频, 富文本中图片上传)
  upload: config,
  // 可以在这里设置全局的 image-uploader 属性
  'image-uploader': {
    action: store.getters.elForm.action, // 上传地址
    responseFn(response, file, fileList) {
      // 返回一个预览地址，一个相对地址
      return response.attachment
    }
  },
  // 专门设置全局的 upload-file 属性
  'upload-file': {
    action: store.getters.elForm.uploadFile, // 上传地址
    // action: 'https://jsonplaceholder.typicode.com/posts' // 上传地址
    // 上传后对响应处理, 拼接为一个图片的地址
    responseFn(response, file, fileList) {
      return {
        name: file.name,
        attachment: response.data.attachment,
        url: response.data.url,
        size: file.size
      }
    }
  },
  // 可以在这里设置全局的 video-uploader 属性
  'video-uploader': {
    action: store.getters.elForm.uploadFile, // 上传地址
    // action: 'https://jsonplaceholder.typicode.com/posts' // 上传地址
    responseFn(response, file, fileList) {
      console.log('video up', response)
      return response.data.attachment
    }
  },
  // 属性参考: https://vue-treeselect.js.org/
  'tree-select': {
    clearable: true // 所有的 tree-select 都会有 clearable = true的属性值
  },
  // 可以为编辑器配置全局属性, 每个实例都共享这个属性
  'bmap': {
    // 比如设置 ak 后, 所有的 bmap 编辑器上传图片都会采用这个属性值
    ak: store.getters.elForm.bmapAk
  },
  dynamic: {
    delimiter: '/' // 所有的 dynamic 都会有 delimiter = '/' 的属性值
  },
  // number类型
  number: {
    min: 0 // 所有 number 类型, 最小值为 0
  },
  // 可以为编辑器配置全局属性, 每个实例都共享这个属性
  'fire-editor': {
    // 比如设置上传 action 后, 所有的 quill-editor 编辑器上传图片都会采用这个属性
    action: store.getters.elForm.action,
    attrs: {
      serverUrl: store.getters.elForm.ueditorServerUrl
    }
  }
})

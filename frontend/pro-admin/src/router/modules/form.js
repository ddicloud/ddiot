/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-10-27 09:56:28
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-25 18:48:42
 */
/** When your routing table is too long, you can split it into small modules **/

import Layout from '@/layout'
import diandiAdmin from 'diandi-admin'

const formRouter = {
  path: '/example/form',
  component: Layout,
  redirect: '/example/form/index',
  name: 'example-form',
  meta: {
    title: 'Table',
    icon: 'table'
  },
  children: [
    {
      path: 'index',
      component: diandiAdmin['FormIndex'],
      name: 'example-form-index',
      meta: { title: '基础表单' }
    },
    {
      path: 'media',
      component: diandiAdmin['FormMedia'],
      name: 'example-form-media',
      meta: { title: '多媒体上传' }
    },
    {
      path: 'verification',
      component: diandiAdmin['FormVerification'],
      name: 'example-form-verification',
      meta: { title: '表单验证' }
    }

  ]
}
export default formRouter

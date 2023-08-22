/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-10-27 09:56:28
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-10-30 14:41:30
 */
/** When your routing table is too long, you can split it into small modules **/

import Layout from '@/layout'

const tableRouter = {
  path: '/example/table',
  component: Layout,
  redirect: '/example/table/complex-table',
  name: 'Table',
  meta: {
    title: 'Table',
    icon: 'table'
  },
  children: [
    {
      path: 'dynamic-table',
      component: () => import('@/views/example/table/dynamic-table/index'),
      name: 'DynamicTable',
      meta: { title: 'Dynamic Table' }
    },
    {
      path: 'drag-table',
      component: () => import('@/views/example/table/drag-table'),
      name: 'DragTable',
      meta: { title: 'Drag Table' }
    },
    {
      path: 'inline-edit-table',
      component: () => import('@/views/example/table/inline-edit-table'),
      name: 'InlineEditTable',
      meta: { title: 'Inline Edit' }
    },
    {
      path: 'complex-table',
      component: () => import('@/views/example/table/complex-table'),
      name: 'ComplexTable',
      meta: { title: 'Complex Table' }
    },
    {
      path: 'table-list/index',
      component: () => import('@/views/example/table/table-list/index'),
      name: 'base-page-index',
      meta: {
        title: '店滴列表组件',
        icon: 'edit'
      }
    }, {
      path: 'table-list/view',
      component: () => import('@/views/example/table/table-list/view'),
      name: 'base-page-view',
      meta: {
        title: '详情',
        icon: 'edit'
      }
    }
  ]
}
export default tableRouter

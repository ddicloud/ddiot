/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-10-30 10:40:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-25 18:44:58
 */
/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/layout'

import diandiAdmin from 'diandi-admin'

const chartsRouter = {
  path: '/example/charts',
  component: Layout,
  redirect: 'noRedirect',
  name: 'Charts',
  type: 'system',
  meta: {
    title: 'Charts',
    icon: 'chart'
  },
  children: [
    {
      path: 'keyboard',
      component: diandiAdmin['ChartsKeyboard'],
      name: 'KeyboardChart',
      meta: { title: 'Keyboard Chart', noCache: true }
    },
    {
      path: 'line',
      component: diandiAdmin['ChartsLine'],
      name: 'LineChart',
      meta: { title: 'Line Chart', noCache: true }
    },
    {
      path: 'mix-chart',
      component: diandiAdmin['ChartsMixChart'],
      name: 'MixChart',
      meta: { title: 'Mix Chart', noCache: true }
    }
  ]
}

export default chartsRouter

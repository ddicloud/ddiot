/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-11-05 21:09:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-22 15:50:30
 */
import Layout from '@/layout'

import ServiceSubscription from '@/views/default/service/subscription.vue'
import ServiceInvoiceIndex from '@/views/default/invoice/index.vue'
import ServiceBuy from '@/views/default/service/buy.vue'
import ServiceSuccess from '@/views/default/service/success.vue'
import ServiceRegister from '@/views/default/service/register.vue'
import ServiceDetail from '@/views/default/service/details.vue'
import SystemStoreIndex from '@/views/default/store/index'
import SystemAddstoreIndex from '@/views/default/store/addstore'

const service = [

  {
    path: '/default/service/subscription.vue',
    component: Layout,
    redirect: '/default/service/subscription.vue',
    name: 'service-subscription',
    // meta: {
    //   title: '服务订购',
    //   icon: 'table'
    // },
    children: [
      {
        path: '/default/service/subscription.vue',
        name: 'service-subscription',
        component: ServiceSubscription,
        // meta: {
        //   affix: false,
        //   title: '服务订购'
        // },
        hidden: false
      },
      {
        path: '/default/service/buy.vue',
        component: ServiceBuy,
        name: 'service-buy',
        hidden: true
      },
      {
        path: '/default/service/register.vue',
        name: 'service-register',
        component: ServiceRegister,
        hidden: true
      },
      {
        path: '/default/service/details.vue',
        name: 'service-details',
        component: ServiceDetail,
        hidden: true
      },
      {
        path: '/default/service/success.vue',
        name: 'service-success',
        component: ServiceSuccess,
        hidden: true
      }]
  }, {
    path: '/default/invoice/index.vue',
    component: Layout,
    redirect: '/default/invoice/index.vue',
    name: 'invoice-index',
    meta: {
      title: '发票管理',
      icon: 'table'
    },
    children: [{
      path: '/default/invoice/index.vue',
      component: ServiceInvoiceIndex,
      hidden: false
    }]
  }, {
    path: '/system/store/index',
    component: SystemStoreIndex,
    redirect: '/system/store/index',
    // name: 'system-store-index',
    meta: {
      title: '店铺管理',
      icon: '店铺管理'
    },
    children: [
      {
        name: 'system-store-index',
        path: '/system-store-index',
        component: SystemStoreIndex,
        hidden: true
      }
    ]
  },
  {
    path: '/system-store-addstore',
    component: SystemAddstoreIndex,
    name: 'system-store-addstore',
    meta: {
      title: '创建店铺',
      icon: '创建店铺'
    },
    hidden: true
  }]

export default service

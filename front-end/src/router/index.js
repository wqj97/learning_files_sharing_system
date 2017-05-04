import Vue from 'vue'
import Router from 'vue-router'

const asyncImport = (component) =>
    resolve => {
     require.ensure([], (require) => {
       resolve(require(`../views/${component}`))
     }, 'noneIndex')
   }
Vue.use(Router)
const router = new Router({
  routes: [
    {
      path: '/',
      name: 'index',
      component: require('v/index')
    },
    {
      path: '/download',
      component: asyncImport('download')
    },
    {
      path: '/history',
      component: asyncImport('history')
    },
    {
      path: '/schoolList',
      component: asyncImport('schoolList')
    },
    {
      path: '/search',
      component: asyncImport('search')
    },
    {
      path: '/upload',
      component: asyncImport('upload')
    },
    {
      path: '/mine',
      component: asyncImport('mine')
    },
    {
      path: '/buy',
      component: asyncImport('buy')
    },
    {
      path: '/netWorkError',
      component: asyncImport('netWorkError')
    },
    {
      path: '/tempPay',
      component: asyncImport('tempPay')
    }

  ]
})
export default router

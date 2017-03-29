import Vue from 'vue'
import Router from 'vue-router'

const asyncRequire = viewName => resolve => require([`../views/${viewName}`], resolve)
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
    }

  ]
})
export default router

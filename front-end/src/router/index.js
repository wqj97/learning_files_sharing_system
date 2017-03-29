import Vue from 'vue'
import Router from 'vue-router'

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
      component: require('v/download')
    },
    {
      path: '/history',
      component: require('v/history')
    },
    {
      path: '/schoolList',
      component: require('v/schoolList')
    },
    {
      path: '/search',
      component: require('v/search')
    },
    {
      path: '/upload',
      component: require('v/upload')
    },
    {
      path: '/mine',
      component: require('v/mine')
    },
    {
      path: '/buy',
      component: require('v/buy')
    }

  ]
})
export default router

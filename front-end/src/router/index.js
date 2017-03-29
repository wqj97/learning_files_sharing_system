import Vue from 'vue'
import Router from 'vue-router'

const asyncRequire = viewName => resolve => require([`../views/${viewName}`], resolve)
/**
 * 异步加载模块, 如果一些很少访问的views
 * 用 asyncRequire('XXX')就好
 * asyncRequire会自动加载views目录下指定的文件
 */
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

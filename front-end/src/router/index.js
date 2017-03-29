import Vue from 'vue'
import Router from 'vue-router'
<<<<<<< HEAD

const asyncRequire = viewName => resolve => require([`../views/${viewName}`], resolve)
/**
 * 异步加载模块, 如果一些很少访问的views
 * 用 asyncRequire('XXX')就好
 * asyncRequire会自动加载views目录下指定的文件
 */
=======
const download = resolve => {
  require.ensure([], (require) => {
    resolve(require('v/download'))
  })
}
const asyncImport = (component) =>
   resolve => {
    require.ensure([], (require) => {
      // TODO: BUG: alias doesn't work
      resolve(require(`../views/${component}`))
    }, 'noneIndex')
  }
// import {asyncImport} from "@/utils"
>>>>>>> lazy loading router
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

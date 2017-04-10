// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import FastClick from 'fastclick'
import VueRouter from 'vue-router'
import App from './App'
import router from './router'
import store from './store'
import VueResource from 'vue-resource'
import  { ToastPlugin } from 'vux'
Vue.use(ToastPlugin)


Vue.use(VueResource)
router.beforeEach(function (to, from, next) {
  store.commit('updateLoadingStatus', {isLoading: true})
  next()
})

router.afterEach(function (to) {
  store.commit('updateLoadingStatus', {isLoading: false})
})

router.beforeEach((to, from, next) => {
  // if(!localStorage.schoolName && to.path !== '/schoolList') {
  //   next({ path: '/schoolList', query: { redirect: true } })
  // }
  next()
})

// FastClick.attach(document.body)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  router,
  render: h => h(App),
  store
}).$mount('#app-box')

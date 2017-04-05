import Vuex from 'vuex'
import Vue from 'vue'
Vue.use(Vuex)
export default new Vuex.Store({
    state: {
    isLoading: false,
    isError: false,
    user: {
      // {
      // "U_name":"万千钧",
      // "U_school":"南开大学",
      // "U_credit":24,"U_head":"http:\/\/wx.qlogo.cn\/mmopen\/Q3auHgzwzM4CjVpt8a7mBeuY9NaviaLeibuaBt7TbegCmwI1Jibp2v0Dqvlaslgb2nauzDpXl1p5Bw4PAAYtOvXG2c0vZcicZWu80zKM1P5vTOM\/0",
      // "level":3}
    }
  },
  mutations: {
    updateLoadingStatus(state, payload) {
      state.isLoading = payload.isLoading
    },
    updateError(state, payload) {
      state.isError = payload.isError
    },
    updateUser(state, payload) {
      state.user = payload.user
    }
  },
  actions: {
    initUserInfo({state, commit}) {
      // debugger
      if (state.user.U_name) return
      Vue.http.get('/user').then(res => {
        commit('updateUser', {user:res.body})
      }, err => {
        commit('updateError', {isError: true})
      })
    }
  }
})

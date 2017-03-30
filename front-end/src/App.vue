<template>
  <div id="app">
    <loading v-model="isLoading"></loading>
    <transition name="fade">
      <router-view></router-view>
    </transition>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import {Loading} from 'vux'
export default {
  name: 'app',
  components:{
    Loading
  },
  computed: {
    ...mapState({
      isLoading: state => state.isLoading
    })
  }
}
</script>
<style lang="scss">
@import './style/animate.scss'
</style>
<style lang="less">
@import '~vux/src/styles/reset.less';

body {
  background-color: #fbf9fe;
}
</style>


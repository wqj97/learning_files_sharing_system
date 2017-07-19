<template>
  <div :class="{'searchBar': true,'searchBar-shadow' : this.shadow}">
    <div class="left">
      <span class="vertical_center" v-if="type">{{title}}</span>
      <img class="img" v-else src="../assets/search.png">
    </div>
    <div class="right">
      <form action="" @submit.prevent="empty">
      <input  v-on:keyup.13="$emit('submit', $event.target.value)" :value="value" type="search" @input="$emit('input', $event.target.value)" :placeholder="placeholder" autofocus>
      <button id="search" @click="$emit('submit', $event.target.value)">搜索</button>
      </form>
    </div>
  </div>
</template>

<script>
import {getCategroyListById} from '../utils'
export default {
  name: 'searchBar',
  props: {
    value: {
      type: String
    },
    type: {
      type:Number
    },
    shadow:{
      type: Boolean
    }
  },
  computed: {
    placeholder() {
      // return '搜索' + !this.type ? this.type : '...'   // why can't
      const lastpart = !this.type == undefined ? this.type : '...'
      return '搜索' + lastpart
    },
    title () {
      return getCategroyListById(this.type)
    }
  },
  methods: {
    empty() {
    }
  },

  data () {
    return {

    }
  }
}
</script>


<style lang="scss" scoped>
  @import '../style/base.scss';
  #search{
  position: absolute;
  top:-4px;
  right: 0vw;
  padding: 7px;
  font-size: 17px;
  background-color: #2ECAFF;
  border:none;
  color: #fff;
  border-radius: 20%;
  }
.searchBar{
  background-color: #fff;
  width: 100%;
  display: flex;
  padding: 13px 18px;
  box-sizing: border-box;
}
.searchBar-shadow{
  box-shadow: 0 2px 30px 0 rgba(0, 0, 0, .22);
}
.left{
  width: 55px;
  vertical-align: middle;
  color: #455D7A;
  font-size: 9px;
  display: flex;
  text-align: center;
  flex-direction: column;
  justify-content: center;
  align-items: flex-start;
  margin-right: 4px;
  white-space: nowrap;
  overflow: hidden;
}
.img{
  width: 20px;
  height: 20px;
  vertical-align: middle;
}
.right {
  position: relative;
  width: 100%;
  input{
    width: 100%;
    vertical-align: middle;
    color:#9E9E9E;
    font-size: 14px;
    appearance: none;
    border: none;
    width:100%;
    &:focus{
      outline: none;
    }
    &::placeholder{
      color:#9E9E9E;
    }
  }

}
</style>

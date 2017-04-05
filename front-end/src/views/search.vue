<template>
  <div>

  <searchBar v-if="passIn" :type="type[0]"  @submit="submit" shadow v-model="search"></searchBar>
  <searchBar v-else  shadow v-model="search" @submit="submit"></searchBar>
    <main class="container">
    <fileList v-if="passIn"></fileList>
    <categoryList v-else v-model="type" checkBox></categoryList>
  </main>
  </div>
</template>

<script>
import {searchBar, fileList, categoryList} from '@/components'
export default {
  name: 'search',
  components: {
    searchBar, fileList, categoryList
  },
  mounted () {
  	console.log(this.$route)
    if(this.$route.query.type) {
      this.type.push(this.$route.query.type)
      this.passIn = true
  }
},
methods: {
  submit() {
    if (this.type.length === 0) {
      this.$vux.toast.show({
      text: '至少选中一个分类',
      type: 'warn'
    })
    return
    }
    this.$http.get(`/search?name=${this.search}&page=1&type=${this.type}`).then(res => {
      console.log(res)
    }, res => {
      this.$vux.toast.show({
      text: '网络错误',
      type: 'warn'
    })
    })
  }
},
  data () {
    return {
      search: '',
      passIn: false,
      type:[]
    }
  }
}
</script>

<style lang="scss" scoped>
.container{
  margin-top: 20px;
}

</style>

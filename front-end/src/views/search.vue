<template>
  <div>

  <searchBar v-if="passIn" :type="type[0]"  shadow v-model="search"></searchBar>
  <searchBar v-else  shadow v-model="search"></searchBar>
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

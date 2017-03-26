<template>
  <div>
  <searchBar :type="type"  shadow v-model="search"></searchBar>
    {{search}}
    <main class="container">
    <fileList v-if="type"></fileList>
    <categoryList v-else checkBox></categoryList>
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
    this.type = this.$route.query.type
  },
  data () {
    return {
      search: '',
      type:''
    }
  }
}
</script>

<style lang="scss" scoped>
.container{
  margin-top: 20px;
}

</style>

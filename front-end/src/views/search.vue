<template>
  <div>
    <searchBar shadow
               v-model="search"
               @submit="submit"></searchBar>
    <main class="container">
      <fileList isScroll
                :list="searchResult"
                v-if="isSearch"></fileList>
      <categoryList v-model="type"
                    checkBox></categoryList>
    </main>
  </div>
</template>

<script>
import { searchBar, fileList, categoryList } from '@/components'
export default {
  name: 'search',
  components: {
    searchBar, fileList, categoryList
  },
  created() {
    let id = this.$route.query.type
    if (id) {
      this.type.push(Number(id))
      this.passIn = true
    } else {
      this.type.push(0)
    }
  },
  methods: {
    submit() {
      this.isSearch = true
      this.$http.get(`/search?name=${this.search}&page=0&type=${JSON.stringify(this.type)}`).then(res => {
        this.searchResult = res.body
      }, res => {
        this.$vux.toast.show({
          text: '网络错误',
          type: 'warn'
        })
      })
    }
  },
  data() {
    return {
      search: '',
      searchResult: '',
      isSearch: false,
      passIn: false,
      type: []
    }
  }
}
</script>

<style lang="scss" scoped>
.container {
  margin-top: 20px;
}
</style>

<template>
  <div>
    <searchBar v-if="passIn"
               @submit="submit"
               shadow
               v-model="search"></searchBar>
    <main class="container">
      <fileList isScroll
                  :list="searchResult"
                  v-if="isSearch"></fileList>
      <categoryList v-if="passIn"
                    v-model="type"
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
  mounted() {
    if (this.$route.query.type) {
      const arr = []
      arr.push(this.$route.query.type)
      this.type = arr
      this.passIn = true
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
      type: [0]
    }
  }
}
</script>

<style lang="scss" scoped>
.container {
  margin-top: 20px;
}
</style>

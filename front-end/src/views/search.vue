<template>
  <div>
    <scrollBanner>资料说明：部分资料来源于网络，无法联系上作者。若作者认为侵权，我方将尽快从平台移除。</scrollBanner>
    <searchBar v-if="passIn" shadow :type="type[0]" v-model="search" @submit="submit"></searchBar>
    <searchBar v-else shadow v-model="search" @submit="submit"></searchBar>
    <main class="container">
      <fileList isScroll :list="searchResult" v-if="isSearch || passIn" @refresh="loadMore" ref="scroll"></fileList>
      <categoryList v-show="!passIn && !isSearch" v-model="type" checkBox></categoryList>
    </main>
  </div>
</template>

<script>
import { searchBar, fileList, categoryList, scrollBanner } from '@/components'
export default {
  name: 'search',
  components: {
    searchBar, fileList, categoryList, scrollBanner
  },
  created() {
    let id = this.$route.query.type
    let searchData = this.$route.query.search
    // debugger
    if (id) {
      this.type = []
      this.type.push(Number(id))
      this.passIn = true
      if (searchData == undefined || searchData === '') {
        this.searchData()
      } else {
        this.search = searchData
        this.submit()
      }
    } else {
      this.type.push(0)
      this.search = searchData
        this.submit()
    }
  },
  methods: {
    loadMore() {
      this.searchData()
    },
    submit() {
      this.page = 0
      this.isSearch = true         // 显示list组件
      this.searchResult = []
      this.$nextTick(function () {
        this.$refs.scroll.resetState()
      })
      this.searchData()
      this.$router.replace({ path: this.$route.fullPath, query: { search: this.search } })
    },
    searchData() {
      this.$store.commit('updateLoadingStatus', { isLoading: true })
      this.$http.get(`/search?name=${this.search}&page=${this.page}&type=${JSON.stringify(this.type)}`).then(res => {
        this.$store.commit('updateLoadingStatus', { isLoading: false })
        if (res.body.length === 0) {
          this.$refs.scroll.noMoreData()
          return
        }
        this.searchResult = this.searchResult.concat(res.body)
        this.$refs.scroll.done()
      }, res => {
        this.$vux.toast.show({
          text: '网络错误',
          type: 'warn'
        })
      })
      this.page++
    }
  },
  data() {
    return {
      search: '',
      searchResult: [],
      isSearch: false,
      passIn: false,
      type: [],
      page: 0
    }
  }
}
</script>

<style lang="scss" scoped>
.container {
  margin-top: 20px;
}
</style>

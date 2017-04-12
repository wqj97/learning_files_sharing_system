<template>
  <div>
    <div class="list-container">
      <refresh
      ref="fresh"
      @refresh="getPage">
    <div  class="item" v-for="item in list" @click = "click(item)">
    {{item['name']? item['name']: item['Id']}}
    </div>
     </refresh>
  </div>
  </div>
</template>

<script>
import { refresh } from '../components'
export default {
  name: 'history',
  components: {
    refresh
  },
  mounted() {
    this.type = this.$route.query.type
    this.getPage()
  },
  methods: {
    click(item) {
     if(item['F_Id']) {
       this.$router.push(`/download?id=${item['F_Id']}`)
       } else {
         window.location.href=item['N_url']
       }
    },
    getPage () {
       this.$store.commit('updateLoadingStatus', {isLoading: true})
    this.$http.get(`/user/lists/${this.type}?page=${this.page}`).then(res => {
      console.log(this)
      if (res.body.length === 0) {this.$refs.fresh.noMore()}
      this.$refs.fresh.done()
      this.list =this.list.concat(res.body)
      this.page++
      this.$store.commit('updateLoadingStatus', {isLoading: false})
    })
    }
  },
  data() {
    return {
      type: '',
      list : [],
      page: 0
    }
  }
}
</script>

<style  lang="scss" scoped>
  @import "../style/base";
  .item{
    color: $baseFontColor;
    text-align: center;
    padding: 25px 0;
    border-bottom: 1px solid #EEEEEE;
  }
</style>

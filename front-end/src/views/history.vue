<template>
  <div>
    <div class="list-container"v-if="list.length!=0">
    <div  class="item" v-for="item in list" @click = "$router.push(`/download?id=${item['F_Id']}`)">
    {{item['F_name']}}
    </div>
  </div>
  <div class="item" v-else>
      没有更多内容
    </div>
  </div>
</template>

<script>
export default {
  name: 'history',
  mounted() {
    this.type = this.$route.query.type
     this.$store.commit('updateLoadingStatus', {isLoading: true})
    this.$http.get(`/user/lists/${this.type}`).then(res => {
      this.list = res.body
      this.$store.commit('updateLoadingStatus', {isLoading: false})
    })

  },
  data() {
    return {
      type: '',
      list : []
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

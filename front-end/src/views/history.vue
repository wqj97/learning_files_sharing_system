<template>
  <div>
    <div class="list-container"v-if="list.length!=0">
    <div  class="item" v-for="item in list" @click = "$router.push(item.url)">
    {{item.title}}
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
  data() {
    return {
      list : [{
        title: '123',
        url:'123'
      }]
    }
  }
}
</script>

<style  lang="scss" scoped>
  @import "../style/base";
  .item{
    color: $baseFontColor;
    text-align: center;
    padding: 38px 0;
    border-bottom: 1px solid #EEEEEE;
  }
</style>

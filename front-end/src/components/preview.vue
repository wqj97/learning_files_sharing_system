<template>
  <div>
  <div id="empty" v-if="arr.length === 0">该资料目前不支持预览, 请下载后查看</div>
  <img class="preview" v-for="i in arr" :src="i">
  </div>
</template>

<script>
export default {
  name: 'preview',
  props: {
    url: {
      require: true
    }
  },
  computed: {
    arr () {
      if (this.url[0] !== '[') return []
      return JSON.parse(this.url)
    }
  },
  data () {
    return {

    }
  }
}
</script>


<style lang="scss" scoped>
@import "../style/base";
.preview{
  width: 100%;
  height: auto;
}
#empty{
  padding-top: 50px;
  text-align: center;
  color: $baseFontColor;
  font-size: 18px;
}
</style>

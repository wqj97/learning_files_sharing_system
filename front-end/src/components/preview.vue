<template>
  <div>
  <div class="slogan" v-if="arr.length === 0">该资料目前不支持预览, 请下载后查看</div>
  <img class="preview" v-for="i in arr" :src="i">
  <div class="slogan bottom" v-show="arr.length !== 0 && arr.length < 5">更多内容,请下载后查看</div>
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
.slogan{
  padding: 9vh 0px;
  text-align: center;
  color: $baseFontColor;
  font-size: 18px;
}
.bottom {
  padding-top: 4vh;
}
</style>

<template>

  <div id="refresh">
  <span v-show="refreshFlag">加载中...</span>
  <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'pullRefresh',
  props: {
    distance: {
      type: Number,
      default: 40
    }
  },
  methods: {
    done() {
      this.refreshFlag = false
    },
    noMore() {
      this.noMoreData = true
    }
  },
  mounted() {
    let $refresh = document.getElementById('refresh')
    window.document.addEventListener('touchmove', e => {
      if (this.refreshFlag || this.noMoreData) return
      if ($refresh.getBoundingClientRect().bottom - this.distance < window.innerHeight) {
        this.refreshFlag = true
        this.$emit('refresh')
      }
      // setTimeout(() => {
      //   this.refreshFlag = false
      // }, 1000);
      // console.log(window.innerHeight)
      // console.log($refresh.getBoundingClientRect().bottom)
    })
  },
  data () {
    return {
      refreshFlag: false,
      noMoreData: false
    }
  }
}
</script>


<style lang="scss" scoped>

</style>

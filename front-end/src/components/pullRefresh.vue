<template>

  <div id="refresh">
  <slot></slot>
  <div class="footer">
    <span v-show="refreshFlag">加载中...</span>
  <span v-show="noMoreData">没有更多数据</span>
  </div>
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
      this.refreshFlag = false
    },
    resetState() {
      this.noMoreData = false
      this.refreshFlag = false
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
.footer{
  text-align: center;
  padding-top: 10px;
  color: #455D7A;
}
</style>

<template>
  <div id="refresh">
    <slot></slot>
    <div class="footer">
      <span v-show="refreshFlag">加载中...</span>
      <span v-show="noMoreData">{{slogan}}</span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'pullRefresh',
  props: {
    distance: {
      type: Number,
      default: 40,
      require: false
    },
    tip: {
      type: String,
      default: undefined,
      require: false
    }
  },
  methods: {
    done() {
      this.refreshFlag = false
      this.$emit('done')
    },
    noMore() {
      this.noMoreData = true
      this.refreshFlag = false
      this.$emit('no More data')
    },
    resetState() {
      this.noMoreData = false
      this.refreshFlag = false
      this.$emit('state reset')
    },
    onScroll() {
      if (this.refreshFlag || this.noMoreData) return
      let height = this.$refresh.getBoundingClientRect().bottom
      if (height === 0) {
        this.$refresh = document.getElementById('refresh')
        height = this.$refresh.getBoundingClientRect().bottom
      }
      if (height - this.distance < window.innerHeight) {
        this.refreshFlag = true
        this.$emit('refresh')
      }
    }
  },
  mounted() {
    console.log('init')
    this.$refresh = document.getElementById('refresh')
    window.document.addEventListener('touchmove', this.onScroll)
    window.document.addEventListener('scroll', this.onScroll)
  },
  computed: {
    slogan() {
      return this.tip !== undefined ? this.tip : this.defaultTip
    }
  },
  data() {
    return {
      $refresh: '',
      defaultTip: '没有更多数据',
      refreshFlag: false,
      noMoreData: false
    }
  }
}
</script>


<style lang="scss" scoped>
.footer {
  text-align: center;
  padding-top: 10px;
  color: #455D7A;
}
</style>

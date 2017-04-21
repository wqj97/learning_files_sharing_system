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
  computed: {
    slogan() {
      return this.tip !== undefined ? this.tip : this.defaultTip
    }
  },
  data () {
    return {
      defaultTip: '没有更多数据',
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

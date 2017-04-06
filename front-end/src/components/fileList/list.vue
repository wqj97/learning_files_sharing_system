<template>
  <div>
    <Scroller :use-pullup="isScroll"
              :pullup-config="pullupConfig"
              lock-x
              ref="scroller"
              @on-pullup-loading="refresh">
      <div>
        <item v-for="(i, index) in list" type="DOC"
              :title="i['F_name']"
              :comments="i['comment_count']"
              :times="i['F_download_count']"
              :views="i['F_view_count']"
              :likes="i['collect_record']"
              :key="index"
             :id="i['F_Id']"></item>
      </div>
    </Scroller>
  </div>
</template>

<script>
import item from './item'
import { Scroller } from 'vux'
export default {
  components: {
    item,
    Scroller
  },
  props: {
    // TODO: 不知道数据的命名规则
    list: {
      type: Array
    },
    isScroll: {
      type: Boolean,
      default: false
    }
  },
  name: 'fileList',
  methods: {
    refresh() {
      console.log('???')

      setTimeout(() => {
        this.endRefresh()
      },500)
    },
    endRefresh() {
      console.log('in')

      this.$refs.scroller.donePullup()
    }
  },
  data() {
    return {
      status: 'default',
      pullupConfig: {
        content: '下拉刷新',
        pullUpHeight: 60,
        height: 40,
        autoRefresh: false,
        downContent: '刷新',
        upContent: '??',
        loadingContent: '刷新中...'
      }
    }
  }
}
</script>

<style lang="scss" >
.xs-plugin-pullup-undefined {
  padding-top: 5px;
  position: static !important;
  color: #888686;
}
</style>

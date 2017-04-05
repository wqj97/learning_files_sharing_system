<template>
  <div>
    <Scroller :use-pullup="isScroll" :pullup-config="pullupConfig" lock-x
    v-model="status">
      <div>
        <item type="DOC"
              title="2017年高数期末考试试卷"
              :comments="15"
              :times="203"
              :views="305"
              :likes="30"></item>
        <item type="DOC"
              title="2017年高数期末考试试卷"
              :comments="15"
              :times="203"
              :views="305"
              :likes="30"></item>
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
      default:false
    }
  },
  name: 'fileList',
  data() {
    return {
      status:'default',
      pullupConfig: {
  content: '下拉刷新',
  pullUpHeight: 60,
  height: 40,
  autoRefresh: false,
  downContent: '松开刷新',
  upContent: '松开刷新',
  loadingContent: '刷新中...'
}
    }
  }
}
</script>

<style lang="scss" >
.xs-plugin-pullup-undefined{
  padding-top:5px;
  position:static !important;
  color:#888686;
}
</style>

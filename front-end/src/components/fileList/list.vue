<template>
  <div>
      <item type="DOC" title="2017年高数期末考试试卷" :comments="15" :times="203" :views="305" :likes="30"></item>
  </div>
</template>

<script>
import item from './item'
export default {
  components: {
    item
  },
  props: {
    // TODO: 不知道数据的命名规则
    list: {
      type: Object
    }
  },
  name: 'fileList',
  data () {
    return {

    }
  }
}
</script>


<style lang="scss" scoped>

</style>

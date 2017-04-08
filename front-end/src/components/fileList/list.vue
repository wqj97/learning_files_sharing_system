<template>
  <div>
    <Refresh ref="fresh" @refresh="$emit('refresh')">
        <item v-for="(i, index) in list" type="DOC"
              :title="i['F_name']"
              :comments="i['comment_count']"
              :times="i['F_download_count']"
              :views="i['F_view_count']"
              :likes="i['collect_record']"
              :key="index"
              :type="i['F_ext']"
             :id="i['F_Id']"
             ></item>
    </Refresh>
  </div>
</template>
<script>
import item from './item'
import Refresh from '../pullRefresh'
export default {
  components: {
    item,
    Refresh
  },
  props: {
    list: {
      type: Array
    },
    isScroll: {
      type: Boolean,
      default: false
    }
  },
  name: 'fileList',
  mounted() {
    console.log('file list init')
    if (!this.isScroll) {
      this.noMoreData()
    }
  },
  methods: {
    noMoreData () {
      this.$refs.fresh.noMore()
    },
    done () {
      this.$refs.fresh.done()
    },
    resetState() {
      this.$nextTick(() => {
        this.$refs.fresh.resetState()
      })
    }
  },
  data() {
    return {
    }
  }
}
</script>

<style lang="scss" >

</style>

<template>
  <div>
    <refresh @refresh="$emit('refresh')" ref="fresh">
      <item v-for="(item, index) in list"
          :avatarUrl="item['U_head']"
          :date="item['C_join_time']"
          :content="item['C_content']"
          key="index"
          :name="item['U_name']"></item>
    </refresh>
  </div>
</template>

<script>
import item from './item'
import refresh from '../pullRefresh'
export default {
  name: '',
  components: {
    item,
    refresh
  },
  props: {
    list: {
      type: Array
    }
  },
  data() {
    return {
    }
  },
  methods: {
    noMoreData () {
      this.$refs.fresh.noMore()
    },
    done () {
      this.$refs.fresh.done()
    }
  }
}
</script>


<style lang="scss" scoped>

</style>

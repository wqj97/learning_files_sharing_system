<template>
  <div>
    <item v-for="(item, index) in list"
          :avatarUrl="item['U_head']"
          :date="item['C_join_time']"
          :content="item['C_content']"
          key="index"
          :name="item['U_name']"></item>
  </div>
</template>

<script>
import item from './item'
export default {
  name: '',
  components: {
    item
  },
  props: {
    list: {
      type: Array
    }
  },
  data() {
    return {

    }
  }
}
</script>


<style lang="scss" scoped>

</style>

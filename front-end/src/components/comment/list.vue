<template>
  <div>
    <!--TODO  名字, 头像-->
    <item v-for="(item, index) in list"
          avatarUrl="/static/img/defaultHead.jpg"
          :date="item['C_join_time']"
          key="index"
          :content="item['C_content']"
          name="meta"></item>
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

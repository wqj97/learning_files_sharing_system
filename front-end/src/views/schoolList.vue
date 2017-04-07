<template>
  <div>
    <Group title="学校列表">
      <span v-for="item in list" @click="click(item)">
        <Cell
            :title="item.name"
            is-link
            :key="item.id"
            ></Cell>
      </span>
    </Group>
  </div>
</template>

<script>
import { Group, Cell } from 'vux'
import {mapActions} from 'vuex'
export default {
  name: 'schoolLoaction',
  components: {
    Cell,
    Group
  },
  data() {
    return {
      list: []
    }
  },
  methods: {
    click(school) {
      this.$store.dispatch('updateUserSchool', school)
      this.$router.push('/')
    }
  },
  mounted() {
    if (this.$route.query.redirect) {
    this.$vux.toast.show({
      text: '请先选择学校',
      time: 3000,
      type: 'text',
      position:'middle'
    })
    }
    this.$http.get('/user/school/list').then(res => {
      this.list = res.body
    })
  }
}
</script>

<style scoped>

</style>

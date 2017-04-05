<template>
  <div>
<Group>
  <Cell v-for="item in list" :title="item.name" is-link @click="click(item)"></Cell>
</Group>
  </div>
</template>

<script>
import {Group, Cell} from 'vux'
export default {
  name: 'schoolLoaction',
  components: {
    Cell,
    Group
  },
  data () {
    return {
      list: []
    }
  },
  methods: {
    click (school) {
      localStorage.schoolName = school.name
      localStorage.schoolId = school.id
    }
  },
  mounted () {
    this.$http.get('/user/school/list').then( res => {
      this.list = res.body
    })
  }
}
</script>

<style scoped>

</style>

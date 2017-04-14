<template>
  <div>
    <Group v-show="state!== 0" gutter="0" >
     <span @click="state=0">
        <Cell
      title="已选地区" :value="city" ></Cell>
     </span>
    </Group>
    <Search :autoFixed="false"
            @on-submit="onSearch"
            @on-cancel="onSearch('')"
            @on-change="onSearch"
            v-model="searchValue"></Search>
    <Group gutter="0">
      <span v-for="(item, index) in searchResult"
            @click="click(item)">
              <Cell
                  :title="item.title"
                  is-link
                  :key="index"
                  ></Cell>
            </span>
    </Group>
  </div>
</template>

<script>
import { Group, Cell, Search } from 'vux'
import { mapActions } from 'vuex'
// 把数据变为cellList接受的数据
let dataAdapter = data => {
  if (data[0]['S_name']) {
    return data.map(i => {
      return {
        title: i['S_name'],
        Id: i['S_Id']
      }
    })
  } else {
    return data.map(i => {
      return { title: i['S_city'] }
    })
  }
}
export default {
  name: 'schoolLoaction',
  components: {
    Cell,
    Group,
    Search
  },
  data() {
    return {
      list: [],
      searchValue: '',
      searchResult: [],
      state: 0,    // 0 选择地区 1 选择学校
      city: ''
    }
  },
  methods: {
    click(item) {
      if (this.state === 0) {
        this.$store.commit('updateLoadingStatus', { isLoading: true })
        this.$http.get(`/user/school?city=${item['title']}`).then(res => {
          this.list = dataAdapter(res.body)
          this.searchResult = this.list
          this.city = item['title']
          this.$store.commit('updateLoadingStatus', { isLoading: false })
        })
        this.state = 1
        return
      }
      if (this.state === 1) {
        this.$store.dispatch('updateUserSchool', item)
        this.$router.push('/')
        return
      }
    },
    onSearch(val) {
      if (val === '') {
        this.searchResult = this.list
      }
      let value = val !== undefined ? val : this.searchValue
      if (value === '') {
        this.searchResult = this.list
        return
      }
      let tempArr = []
      this.searchResult = this.list.forEach(i => {
        if (~i['title'].indexOf(value)) tempArr.unshift(i)
      })
      this.searchResult = tempArr
    },
    getCityList(){
    this.$store.commit('updateLoadingStatus', { isLoading: true })
    this.$http.get('/user/school/city').then(res => {
      this.list = dataAdapter(res.body)
      this.searchResult = this.list
      this.$store.commit('updateLoadingStatus', { isLoading: false })
    })
    }
  },
  mounted() {
    if (this.$route.query.redirect) {
      this.$vux.toast.show({
        text: '请先选择学校',
        time: 3000,
        type: 'text',
        position: 'middle'
      })
    }

    this.getCityList()
  },
  watch: {
    state (val) {
      if(val === 0) {
        this.getCityList()
      }
    }
  }
}
</script>

<style scoped>

</style>

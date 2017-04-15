<template>
  <div>
    <Group v-show="!isSearch&&state !== 2" gutter="0" >
     <span @click="back(2)">
        <Cell
      title="已选省市" :value="province" ></Cell>
     </span>
    </Group>
    <Group v-show="!isSearch&&state === 1" gutter="0" >
     <span @click="back(0)">
        <Cell
      title="已选地区" :value="city" ></Cell>
     </span>
    </Group>
    <Search placeholder="直接搜索学校"
            :results="searchResult"
            @on-focus	="isSearch = true"
            @on-submit="onSearch"
            @on-cancel="isSearch = false"
            @on-change="onSearch"
            v-model="searchValue"></Search>
    <Group v-show="!isSearch" gutter="0">
      <span v-for="(item, index) in list"
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
  if (data.length === 0) return []
  if (data[0]['S_name']) {
    return data.map(i => {
      return {
        title: i['S_name'],
        Id: i['S_Id']
      }
    })
  }
  if (data[0]['S_city']) {
    return data.map(i => {
      return { title: i['S_city'] }
    })
  }
  if (data[0]['S_province']) {
    return data.map(i => {
      return { title: i['S_province'] }
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
      state: 2,    // 0 选择地区 1 选择学校   2 选择省市
      city: '',
      province: '',
      isSearch:false
    }
  },
  methods: {
    back(state) {
      switch (state) {
        case 2:
          this.getList('province_list')
          break;
        case 0:
          this.getList()
        default:
          break;
      }
      this.state = state
      return
    },
    click(item) {
      // 省市
      if (this.state === 2) {
        this.province = item['title']
         this.$store.commit('updateLoadingStatus', { isLoading: true })
        this.$http.get(`user/school/province?keyword=${item['title']}`).then(res => {
          this.list = dataAdapter(res.body)
          this.$store.commit('updateLoadingStatus', { isLoading: false })
        })
        this.state = 0
        return
      }
      // 选择地区
      if (this.state === 0) {
        this.city = item['title']
        this.$store.commit('updateLoadingStatus', { isLoading: true })
        this.$http.get(`/user/school?keyword=${item['title']}`).then(res => {
          this.list = dataAdapter(res.body)
          this.$store.commit('updateLoadingStatus', { isLoading: false })
        })
        this.state = 1
        return
      }
      //选择学校
      if (this.state === 1) {
        this.$store.dispatch('updateUserSchool', item)
        this.$router.push('/')
        return
      }
    },
    onSearch(val) {
      this.isSearch = true
      let value = val !== undefined ? val : this.searchValue
      if (value.length <=1) return
      this.$http.get(`/user/school?keyword=${value}`).then (res => {
        this.searchResult = dataAdapter(res.body)
      })
    },
    getList(type = 'city'){
      // city province_list
    this.$store.commit('updateLoadingStatus', { isLoading: true })
    this.$http.get(`/user/school/${type}`).then(res => {
      this.list = dataAdapter(res.body)
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
    this.getList('province_list')
  },
  watch: {
  }
}
</script>

<style scoped>

</style>

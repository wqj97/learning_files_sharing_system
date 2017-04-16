<template>
  <div class="item_container">
  <div v-for="item in renderList" class="item" @click="click(item)">
     <div class="imgWarp">
        <img class="img" :src="item.image">
     </div>
      {{item.title}}
  <div class="checkbox" v-show="checkBox">
    <img v-if="item.checked" src="../assets/checked.svg"  alt="checked">
    <img v-else src="../assets/unChecked.svg" alt="unchecked">
  </div>
  </div>
  </div>
</template>
<script>
import {ids, titleList, assetsPath} from '../utils'
// const imgPath = process.env.NODE_ENV === 'development' ?  '/static/img/category/' : '/home/static/img/category/'
const defaultList = titleList.map((item, index) => {
  return {
    title: item,
    image: `${assetsPath}img/category/${index + 1}.svg`,
    id: ids[index],
    checked: false
  }
})
export default {
  props: {
    value: {
      type: Array
    },
    checkBox: {
      default: false,
      type: Boolean
    }
  },
  mounted() {
    if(!this.value)  return
    this.renderList.forEach(item => {
      item.checked = false
    })
    this.value.forEach(id => {
      if (id === 0) return
      let index = ids.indexOf(id)
      console.log('index:' + index)
      if (index === -1) throw "传入的type数据有误"
      this.renderList[index].checked = true
    })
  },
  methods: {
    click(item) {
      this.$emit('click', item)
      if (!this.checkBox) return
      this.toggleCheck(item)
      this.$emit('input', this.transformArr())
    },
    transformArr() {
      let tempArr = []
      this.renderList.forEach(item => {
        if (item.checked)  tempArr.push(item.id)
      })
      if (tempArr.length === 0) tempArr.push(0)
      return tempArr
    },
    toggleCheck(item) {
      const index = this.renderList.indexOf(item)
      const it  = this.renderList[index]
      it.checked = !it.checked
      this.$set(this.renderList, index, item)
    }
  },
  data () {
    return {
      select: [],
      renderList : this.list ? this.list : defaultList
    }
  }
}
</script>

<style lang="scss" scoped>
.item_container{
  display: flex;
  flex-wrap: wrap;
}
.item{
  position: relative;
  box-sizing: border-box;
  width: 50%;
  padding: 14px 0;
  padding-left: 45px;
  text-align: left;
  background-color: #fff;
  border: 1px solid #EEEEEE;
  color: #455D7A;
  .imgWarp{
    display: inline-block;
    width: 42px;
    height:40px;
    margin-right: 7px;
  }
.img{
  vertical-align: middle;
  width: 100%;
  max-height:100%;
}
}
.checkbox{
  position: absolute;
  right: 7px;
  bottom: 0px;
}
</style>

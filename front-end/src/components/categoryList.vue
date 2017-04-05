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
const ids =        [2        ,4        ,8      ,16    ,32       ,64      ,128    ]
const titleList = ['科目习题', '科目精华', '英语', '考研', '资格考试', '工具书', '其他']
const imgPath = '/static/img/category/'
const defaultList = titleList.map((item, index) => {
  return {
    title: item,
    image: `${imgPath}${index + 1}.png`,
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
  methods: {
    click(item) {
      this.$emit('click', item)
      if (!this.checkBox) return
      const index = this.select.indexOf(item)
      if(index === -1) {
        // 没有被选中
        this.select.push(item)
      } else {
        // 被选中
        this.select.splice(index, 1)
      }
      this.toggleCheck(item)
      this.$emit('input', this.transformArr(this.select))
    },
    transformArr(arr) {
      if (!arr) return []
      return arr.map(index => index.id)
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

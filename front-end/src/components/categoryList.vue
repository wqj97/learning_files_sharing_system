<template>
  <div class="item_container">
  <div v-for="item in renderList" class="item" @click="$emit('click', item)">
     <div class="imgWarp">
        <img class="img" :src="item.image">
     </div>
      {{item.title}}
  <div class="checkbox" v-show="checkBox">
    <img src="../assets/checked.svg"  alt="checked">
    <img src="../assets/unChecked.svg" alt="unchecked">
  </div>
  </div>
  </div>
</template>

<script>
const titleList = ['科目习题', '科目精华', '英语', '考研', '资格考试', '工具书', '其他']
const imgPath = '/static/img/category/'
const defaultList = titleList.map((item, index) => {
  return {
    title: item,
    image: `${imgPath}${index + 1}.png`
  }
})
export default {
  props: {
    checkBox: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
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

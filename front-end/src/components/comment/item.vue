<template>
  <div class="wrapper">
    <div class="left">
      <img :src="avatarUrl" class="img">
    </div>
    <div class="right">
      <div class="name subContent">
        {{name}}
      </div>
      <div class="content">{{content}}</div>
      <div class="date subContent">{{date}}</div>
    </div>
  </div>
</template>

<script>
export default {
  name: '',
  props: {
    avatarUrl: String,
    date: String,
    content: String,
    name: String
  },
  data () {
    return {

    }
  }
}
</script>


<style lang="scss" scoped>
.wrapper{
  background-color: #fff;
  padding: 10px 0;
  border-bottom: 1px solid #EEEEEE;
  display: flex;
}
.left{
  box-sizing: border-box;
  width: 91px;
  padding:10px;
  .img{
    width:47px;
    height: 47px;
    border-radius: 100%;
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, .22);
  }
}
.right{
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  .subContent{
    font-size: 10px;
    color: #C9C9C9;
  }
  .content{
    margin: 14px auto;
    margin-bottom: 18px;
    font-size: 14px;
    color: #455D7A;
  }
}
</style>

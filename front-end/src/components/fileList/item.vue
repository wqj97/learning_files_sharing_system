<template>
  <div class="file-list-item"  @click="$router.push(`/download?id=${id}`)">
    <div class="left">{{formatType}}</div>
    <div class="right">
      <div class="top">{{title}}</div>
      <div class="bottom">
        <div class="item"><img src="../../assets/comment.png">{{comments}}</div>
        <div class="item"><img src="../../assets/download.png">{{times}}</div>

        <div class="item"><img src="../../assets/eye.png">{{views}}</div>
        <div class="item"><img src="../../assets/heart.png">{{likes}}</div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: '',
  props: {
    type: {
      type: String,
      default: "未知"
    },
    title: {
      type: String,
      require: true
    },
    comments: {
      type: Number
    },
    times: {
      type: Number
    },
    views: {
      type: Number
    },
    likes: {
      type: Number
    },
    id: {
      type: Number
    }
  },
  computed: {
    formatType () {
      return this.type.toUpperCase()
  }
  }
}
</script>


<style lang="scss" scoped>
$radius: 5px;
.file-list-item {
  margin: 15px 9px;
  background: #FFFFFF;
  border-radius: $radius;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .29);
  display: flex;
  .left {
    overflow: hidden;
    z-index: 0;
    border-top-left-radius: $radius;
    border-bottom-left-radius: $radius;
    background-image: linear-gradient(0deg, #2ECAFF 0%, #00B9F8 100%);
    // height: 100%;
    width: 88px;

    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFF;
    font-size: 22px;
    overflow: hidden;
  }
  .right{
    box-sizing: border-box;
    width:100%;
    padding: 8px 26px;
    font-size: 14px;
  .top{
    color: #455D7A;
    overflow: hidden;
    text-align: center;
    margin-bottom: 18px;
  }
  .bottom{
    color: #9E9E9E;
    display: flex;
    justify-content: space-around;
    img{
      width: 15px;
      height: 15px;
      vertical-align: middle;
    }
  }
  }

}
</style>

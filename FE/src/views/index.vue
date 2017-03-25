<template>
  <div>
   <header id="header">
      <div id="basic_info" class="text_shdow">
      <div class="">
        <img class="avatar_photo vertical_center" src="../assets/defaultHead.jpg">
      Lv.3
      </div>
      <div class="right ">
        <img class="img vertical_center" src="../assets/location.png">
          天津工业大学
      </div>
    </div>
    <h3 class="title text_shdow">这里有你想要的所有</h3>
    <div id="search">
      <img src="../assets/search.png" class="img vertical_center" alt="">
      <span >搜索...</span>
    </div>
    <div class="upload text_shdow">
      <img class="img vertical_center" src="../assets/upload.png">
      <span>上传文件</span>
    </div>
   </header>
   <section class="slide_show">

   </section>
  </div>
</template>

<script>
export default {
  name: '',
}
</script>

<style lang="scss" scoped>
@import '../style/base';
#basic_info{
  padding: 0 28px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  .avatar_photo{
    width:28px;
    height: 28px;
    border-radius: 100%;
  }
  .right{
    .img {
      width:10px;
      height: 16px;
    }
  }
}

#header{
  text-align: center;
  color: white;
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  height: 205px;
  background-image: linear-gradient(-180deg, #00B9F8 0%, #2ECAFF 100%);
  .title{
    /* 这有你想要的所有: */
font-weight: 100;
font-size: 20px;
color: #FFFFFF;
letter-spacing: -0.49px;
  }
  .upload{
    padding: 8px;
    .img{
      width: 15px;
      height: 15px;
    }
  }
}
#search {
  box-sizing: content-box;
  text-align: left;
  margin: 0 28px;
  // line-height: 48px;
  padding: 12px 17px;
  color: #9E9E9E;
  line-height:22px;
  .img{
    padding-right: 5px;
    width: 21px;
    height: 21px;
  }
background: #FFFFFF;
box-shadow: 0px 1px 4px 0px rgba(0,0,0,0.18);
border-radius: 25px;
}
.slide_show{
  height:100px;
}
</style>

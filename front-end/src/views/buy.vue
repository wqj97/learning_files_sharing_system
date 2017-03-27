<template>
  <div>
    <!--水平方向上有滚动条-->
    <div class="item">
      <div class="main">
        <div class="level">Lv.1</div>
        <div class="price">￥5</div>
      </div>
      <div class="slogan">可享受部分资料</div>
        <div class="line"></div>
    </div>
    <div class="item lv2">
      <div class="main">
        <div class="level">Lv.2</div>
        <div class="price">￥10</div>
      </div>
      <div class="slogan">可享受大部分资料</div>
        <div class="line"></div>
    </div>
    <div class="item lv3">
      <div class="main">
        <div class="level">Lv.3</div>
        <div class="price">￥30</div>
      </div>
      <div class="slogan">可享受全部资料</div>
        <div class="line"></div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'buy',
  data () {
    return {

    }
  }
}
</script>


<style lang="scss" scoped>
.item{
background-image: linear-gradient(45deg, #2ECAFF 0%, #00B9F8 100%);
box-shadow: 0px 8px 17px 0px rgba(0,185,248,0.42);
border-radius: 15px;
margin:50px 18px;
color:#FFF;
text-align: center;
  .main{
    font-size: 36px;
    font-weight: 300;
    display: flex;
    justify-content: space-between;
    padding: 35px 51px;
    padding-bottom: 5px;
  }
  .slogan{
    font-weight: 200;
    font-size: 14px;
    border-bottom: 1px solid #fff;
  }
  .line{
    opacity: 0;
    width:100%;
    height:1px;
    margin: 33px;
  }
}
.lv2{
/* Rectangle 9: */
background-image: linear-gradient(45deg, #FAD961 0%, #F77A26 86%, #F76B1C 100%);
box-shadow: 0px 8px 17px 0px rgba(245,165,35,0.36);
border-radius: 15px;
}
.lv3{
/* Rectangle 9: */
background-image: linear-gradient(-134deg, #3023AE 0%, #E82E7F 100%);
box-shadow: 0px 8px 17px 0px rgba(143,18,254,0.49);
border-radius: 15px;
}
</style>

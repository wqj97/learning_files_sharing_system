<template>
  <div>
    <div class="top">
      <div class="top">
        <fileIcon type="pdf"
                  size="small"></fileIcon>
                  <div class="right">
                    <h2>2017年高数期末考试试卷</h2>
                  <span>下载等级: Lv.3</span>
                  </div>
      </div>
      <div class="middle">
      <div class="item">
        <img src="../assets/download.png">

      </div>
        <div class="item">
        <img src="../assets/eye.png" >
      </div>
        <div class="item">
        <img src="../assets/humbuger.png" >
      </div>
      </div>
      <div class="bottom">
        <div class="left">
          <div class="comment wrapper"><img src="../assets/commentColor.png"> 15</div>

          <div class="like wrapper">
            <img src="../assets/heartColor.png">
            30
          </div>
        </div>
        <div class="right">
        <button id="download-btn">下载</button>
        </div>
      </div>
    </div>
    <div class="tab">
      <div class="preview"></div>
      <div class="comments">
      <commentList></commentList>
      </div>
    </div>
  </div>
</template>

<script>
import { fileIcon, commentList } from '@/components/'
export default {
  name: 'download',
  components: {
    fileIcon,
    commentList
  }
}
</script>

<style lang="scss" scoped>
@import '../style/base.scss';
.top{
  background-color: #fff;
  color: #455D7A;
  width: 100%;
  margin-top:19px;
  padding-bottom: 18px;
  border-bottom: 1px solid #EEEEEE;
  .top{
    padding-bottom: 0px;
    border: none;
    display: flex;
    justify-content: space-around;
    .right{
      font-weight: 200;
      h2{font-weight: 300;
      font-size: 20px;}
      text-align: center;
    }
  }
}
.middle{
  display: flex;
  justify-content: space-around;
  margin: 18px 75px;
  margin-bottom: 28px;
  .item{
    img{
      vertical-align: middle;
      width: 20px;
      height: 20px;
    }
  }
}

$menuBarRadius: 4px;
.bottom{
  display: flex;
  justify-content: space-around;
  align-items: center;
  .left{
    box-sizing: border-box;
    display: flex;
    img{
      width: 16px;
      height: 15px;
    }
    .wrapper{
      padding: 17px 20px;
    }
    .comment{
      border: 1px solid $baseColor;
      border-top-left-radius: $menuBarRadius;
      border-bottom-left-radius: $menuBarRadius;
    }
    .like{
      border: 1px solid $redColor;
      border-top-right-radius: $menuBarRadius;
      border-bottom-right-radius: $menuBarRadius;
    }
  }
  #download-btn{
    /* Rectangle 3: */
background-image: linear-gradient(-180deg, #00B9F8 0%, #2ECAFF 100%);
border-radius: 100px;
font-size: 18px;
color: #FFFFFF;
letter-spacing: 0px;
padding: 10px 43px;
border:none;
  box-shadow: 0 2px 10px rgba(0, 185, 248, .6);
  }

}
</style>

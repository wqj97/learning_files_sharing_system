<template>
  <div>
   <header id="header">
      <div id="basic_info" class="text_shdow">
      <div class="">
        <img class="avatar_photo vertical_center" src="../assets/defaultHead.jpg">
      Lv.3
      </div>
      <div class="right">
        <img class="img vertical_center" src="../assets/location.png">
          天津工业大学
      </div>
    </div>
    <h3 class="title text_shdow">这里有你想要的所有</h3>
    <div id="search" @click="$router.push('/search')">
      <img src="../assets/search.png" class="img vertical_center">
      <span >搜索...</span>
    </div>
    <div class="upload text_shdow" @click="$router.push('/upload')">
      <img class="img vertical_center" src="../assets/upload.png">
      <span>上传文件</span>
    </div>
   </header>
   <section class="slide_show">
    <swiper  :list="imgList" auto style="width:100%;margin:0 auto; height:100%" dots-class="custom-bottom" dots-position="center"></swiper>
   </section>
   <section class="list">
     <Tab v-model="tabIndex" :active-color="mainColor" :bar-active-color="mainColor" :line-width="2" defaultColor="#00B9F8">
      <tab-item :selected="item === currentTab" v-for="(item, index) in tabList" :key="index" >{{item}}</tab-item>
     </Tab>
     <!--<swiper v-model="tabIndex" >
        <swiper-item>
         <categoryList></categoryList>
        </swiper-item>
         <swiper-item>
         <categoryList></categoryList>
        </swiper-item>
      </swiper>-->
<categoryList v-show="tabIndex === 0" @click="categoryListClick"></categoryList>
  <fileList v-show="tabIndex !== 0"></fileList>
   </section>
  </div>
</template>
<script>
import { Swiper, Tab, TabItem, SwiperItem} from 'vux'
import {categoryList, fileList} from '../components/'


const imgList = [
  'http://placeholder.qiniudn.com/100x100/FF3B3B/ffffff',
  'http://placeholder.qiniudn.com/800x100/FFEF7D/ffffff',
  'http://placeholder.qiniudn.com/800x100/8AEEB1/ffffff'
]
const demoList = imgList.map((one, index) => ({
  url: 'javascript:',
  img: one
}))

const tabList = ['全部分类', '本校热门']
export default {
  name: '',
  components: {
    Swiper,
    Tab,
    TabItem,
    categoryList,
    SwiperItem,
    fileList
  },
  data () {
    return {
      tabIndex: 0,
      currentTab:tabList[0],
      mainColor: "#F8421E",
      imgList: demoList,
      tabList: tabList
    }
  },
  methods: {
    categoryListClick(val) {
    	this.$router.push({path: '/search', query: { type: val.title }})
    }
  }
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

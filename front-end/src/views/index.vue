<template>
  <div>
    <header id="header">
      <div id="basic_info"
           class="text_shdow">
        <div class="left"
             @click="$router.push('/mine')">
          <img class="avatar_photo vertical_center"
               :src="user['U_head']"> Lv.{{user.level}}
        </div>
        <div class="right"
             @click="$router.push('/schoolList')">
          <img class="img vertical_center"
               src="../assets/location.png">
          <span style="font-size:12px;">{{user['U_school']}}</span>
        </div>
      </div>
      <h3 class="title text_shdow">这里有你想要的所有</h3>
      <div id="search"
           @click="$router.push('/search')">
        <img src="../assets/search.png"
             class="img vertical_center">
        <span>搜索...</span>
      </div>
      <div class="upload text_shdow"
           @click="$router.push('/upload')">
        <img class="img vertical_center"
             src="../assets/upload.png">
        <span>上传文件</span>
      </div>
    </header>
    <section class="slide_show">
      <swiper loop
              :list="imgList"
              auto
              :show-desc-mask="false"
              style="width:100%;margin:0 auto; height:100px;"
              :aspect-ratio="100/375"
              dots-class="custom-bottom"
              dots-position="center"></swiper>
    </section>
    <section class="list">
      <Tab v-model="tabIndex"
           :active-color="mainColor"
           :bar-active-color="mainColor"
           :line-width="2"
           defaultColor="#00B9F8">
        <tab-item :selected="item === currentTab"
                  v-for="(item, index) in tabList"
                  :key="index">{{item}}</tab-item>
      </Tab>
      <transition name="fade">
        <categoryList v-if="tabIndex === 0"
                      @click="categoryListClick"></categoryList>
        <fileList :list="topFileList"
                  v-else="tabIndex !== 0"></fileList>
      </transition>
    </section>
  </div>
</template>
<script>
import { Swiper, Tab, TabItem, SwiperItem } from 'vux'
import { categoryList, fileList } from '../components/'
import { mapState } from 'vuex'
if (process.env.NODE_ENV === 'development') require('vconsole')
const defaultImageList = [{
        img: 'http://placeholder.qiniudn.com/200x750/FF3B3B/ffffff',
        url: 'http://www.baidu.com'
      },{
        img: 'http://placeholder.qiniudn.com/100x375/FF3B3B/ffffff',
        url: 'http://www.baidu.com'
      },{
         img: 'http://placeholder.qiniudn.com/300x1125/FF3B3B/ffffff',
        url: 'http://www.baidu.com'
      }
      ]

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
  mounted() {
    this.$store.dispatch('initUserInfo')
    this.$http.get('/index/home').then(data => {
      const body = data.body
      if (body.banner) {

      this.imgList = body.banner.map(i => {
        return {
          img: i.image,
          url: i.url
        }
      })
      } else {
        this.imgList = defaultImageList
      }
      this.topFileList = body['top_file']
    })
  },
  data() {
    return {
      tabIndex: 0,
      currentTab: tabList[0],
      mainColor: "#F8421E",
      imgList: [],
      tabList: tabList,
      topFileList: []
      // university: localStorage.schoolName
    }
  },
  methods: {
    categoryListClick(val) {
      this.$router.push({ path: '/search', query: { type: val.id } })
    }
  },
  computed: {
    ...mapState({
      user: state => state.user
    })
  }
}
</script>

<style lang="scss" scoped>
@import '../style/base';
@import '../style/animate';
#basic_info {
  padding: 0 28px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  .avatar_photo {
box-shadow: 0px 2px 7px 0px rgba(0,0,0,0.24);
    width: 28px;
    height: 28px;
    border-radius: 100%;
  }
  .right {
    .img {
      width: 10px;
      height: 16px;
    }
  }
}

#header {
  text-align: center;
  color: white;
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  height: 205px;
  background-image: linear-gradient(-180deg, #00B9F8 0%, #2ECAFF 100%);
  .title {
    /* 这有你想要的所有: */
    font-weight: 300;
    font-size: 20px;
    color: #FFFFFF;
    letter-spacing: -0.49px;
  }
  .upload {
    padding: 8px;
    .img {
      width: 15px;
      height: 15px;
    }
  }
}

#search {
  box-sizing: content-box;
  text-align: left;
  margin: 0 28px; // line-height: 48px;
  padding: 12px 17px;
  color: #9E9E9E;
  line-height: 22px;
  .img {
    padding-right: 5px;
    width: 21px;
    height: 21px;
  }
  background: #FFFFFF;
  box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.18);
  border-radius: 25px;
}

.slide_show {
  // height: 100px;
}
</style>

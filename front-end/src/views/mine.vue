<template lang='html'>
  <div class='Mine'>
    <div class="Mine-bg">
      <img src="../assets/Mine-bg.jpg">
    </div>
    <div class="Mine-info">
      <div class="head">
        <img :src="user['U_head']" alt="">
      </div>
      <div class="name">
      {{user['U_name']}}
      </div>
      <div class="num">
        {{user['U_school']}}
      </div>
    </div>
    <div class="record">
      <div class="doing" @click="levelClicked">
        <div class="number">
          {{user['level']}}
        </div>
        <div class="des">
          等级
        </div>
      </div>
      <div class="did" @click="scoreClicked">
        <div class="number">
          {{user['U_credit']}}
        </div>
        <div class="des">
          积分
        </div>
      </div>
    </div>
    <div class="Mine-menu">
      <div @click="$router.push('/history?type=download')">
          <img src="../assets/mine/download.svg">
          下载记录
      </div>
      <div @click="$router.push('/history?type=collect')">
        <img src="../assets/mine/heart.svg">
        收藏
      </div>
    </div>
        <div class="Mine-menu">
      <div @click="$router.push('/history?type=share')">

          <img src="../assets/mine/share.svg">
          分享记录
      </div>
      <div @click="$router.push('/history?type=notice')">
        <img src="../assets/mine/letter.svg">
        系统通知
      </div>
    </div>
      <div class="bottom_btn" id="buy" @click="$router.push('/tempPay')">
        成为赞助者
      </div>

  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  name: 'mine',
  mounted() {
    this.$store.dispatch('initUserInfo')
  },
  methods: {
levelClicked () {
this.redirect('https://mp.weixin.qq.com/s?__biz=MzIxNDYyOTU2OA==&mid=100000633&idx=1&sn=57ae7d369ec5686657ed531ddb405947&chksm=17a5eed620d267c026343853df1a5c2d37cd32800cced996dfbc55ad90aa3ec28bda7a3fb287&key=c2525146f07f2fe81868bdb0a0a244c6054394c58dc99a12ab4b595032cbb0ab36517ce18c74c949183bf97c0a89f76a093ceb1778c6f862592ce9b2115a03d1a00e86f93063538182ca3cc644bc091a&ascene=0&uin=MzI5OTA4ODU%3D&devicetype=iMac+MacBookAir7%2C2+OSX+OSX+10.12.3+build(16D32)&version=12020010&nettype=WIFI&fontScale=100&pass_ticket=hIVJi1Sk8IEWqIiDe6YsmJpJnj5E1VdP2l9nQJLcPrM%3D')
},scoreClicked () {
this.redirect('https://mp.weixin.qq.com/s?__biz=MzIxNDYyOTU2OA==&mid=100000632&idx=1&sn=4786efa8a08a99c332efeb131fc8c586&chksm=17a5eed720d267c105f4fa050cbede03c0e8b32092121daee3d39ba623dc5df3db3ecb9e8349&key=019f1c355eb8650ad14cd61163a70ddea9dcfb4b28ce6e1b655054fc42ed006b79e0fd8d02501f05af385c6342b94e9066cdeadfad55be931736038c1ebe385bf7f1aa9048d96bc224111505f622926e&ascene=0&uin=MzI5OTA4ODU%3D&devicetype=iMac+MacBookAir7%2C2+OSX+OSX+10.12.3+build(16D32)&version=12020010&nettype=WIFI&fontScale=100&pass_ticket=hIVJi1Sk8IEWqIiDe6YsmJpJnj5E1VdP2l9nQJLcPrM%3D')
},
redirect(url) {
  window.location.href=url
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
.bottom_btn {
  position: fixed;
  width: 100%;
  bottom: 0;
  height: 8vh;
  line-height: 8vh;
  text-align: center;
  color: #FFF;
  font-size: 18px;
  font-weight: 200;
   background-image: linear-gradient(-180deg, #00B9F8 0%, #2ECAFF 100%);
}

.Mine {
  margin-bottom: 8vh;
  .Mine-bg {
    height: 200px;
    overflow: hidden;
    img {
      width: 100%;
    }
  }
  .Mine-info {
    margin-top: -70px;
    text-align: center;
    font-size: 14px;
    color: #455D7A;
    .head {
      display: inline-block;
      img {
        box-sizing: content-box;
        width: 140px;
        clip-path: polygon(75% 5%, 100% 50%, 75% 95%, 25% 95%, 0 50%, 25% 5%);
      }
    }
  }
  .record {
    position: relative;
    z-index: 99;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 90px;
    margin-top: 15px;
    .doing {
      border-right: 1px solid #e0e0e0;
    }
    .number {
      font-size: 27px;
      color: #233142;
    }
    .des {
      font-size: 12px;
      color: #455D7A;
    }
    &>div {
      width: 50%;
      text-align: center;
    }
  }
  .Mine-menu {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 90px;
    color: #455D7A;
    border-bottom: 1px solid #e0e0e0;
    .cost {
      border-right: 1px solid #e0e0e0;
    }
    &>div {
      width: 50%;
      text-align: center;
    }
    img {
      display: block;
      margin: 0 auto 5px;
    }
  }
}
</style>

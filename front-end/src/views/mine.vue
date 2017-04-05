<template lang='html'>
  <div class='Mine'>
    <div class="Mine-bg">
      <img src="../assets/Mine-bg.jpg">
    </div>
    <div class="Mine-info">
      <div class="head">
        <img src="../assets/defaultHead.jpg" alt="">
      </div>
      <div class="name">
      {{user['U_name']}}
      </div>
      <div class="num">
        {{user['U_school']}}
      </div>
    </div>
    <div class="record">
      <div class="doing">
        <div class="number">
          {{user['level']}}
        </div>
        <div class="des">
          等级
        </div>
      </div>
      <div class="did">
        <div class="number">
          {{user['U_credit']}}
        </div>
        <div class="des">
          积分
        </div>
      </div>
    </div>
    <div class="Mine-menu">
      <div>
          <img src="../assets/mine/download.svg">
          下载记录
      </div>
      <div>
        <img src="../assets/mine/heart.svg">
        收藏
      </div>
    </div>
        <div class="Mine-menu">
      <div>

          <img src="../assets/mine/share.svg">
          分享记录
      </div>
      <div>
        <img src="../assets/mine/letter.svg">
        系统通知
      </div>
    </div>
      <div id="buy" @click="$router.push('/buy')">
        立即升级
      </div>

  </div>
</template>

<script>
import { mapState } from 'vuex'
  export default {
    name:'mine',
    mounted () {
  this.$store.dispatch('initUserInfo')
    },
    computed: {
    ...mapState({
        user: state => state.user
      })
    }
  }
</script>

<style lang="scss" scoped>
#buy{
position: fixed;
width:100%;
bottom: 0;
height: 8vh;
line-height: 8vh;
text-align: center;
color:#FFF;
font-size: 18px;
font-weight: 200;

background-image: linear-gradient(-90deg, #EF5F3E 0%, #EB3369 100%);
}
  .Mine {
    .Mine-bg {
      height:200px;
      overflow: hidden;
      img {
        width:100%;
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
      & > div {
        width: 50%;
        text-align: center;
      }
    }
    .Mine-menu {
      display: flex;
      justify-content: center;
      align-items: center;
      height:90px;
      color: #455D7A;
      border-bottom: 1px solid #e0e0e0;
      .cost{
        border-right: 1px solid #e0e0e0;
      }
      & > div {
        width: 50%;
        text-align: center;
      }
      img{
        display: block;
        margin:0 auto 5px;
      }
    }
  }
</style>

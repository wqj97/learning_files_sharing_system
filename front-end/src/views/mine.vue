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
        万千钧
      </div>
      <div class="num">
        1511650919
      </div>
    </div>
    <div class="record">
      <div class="doing">
        <div class="number">
          1
        </div>
        <div class="des">
          正在进行
        </div>
      </div>
      <div class="did">
        <div class="number">
          3
        </div>
        <div class="des">
          完成课程
        </div>
      </div>
    </div>
    <div class="Mine-menu">
      <div class="cost">
      
          <img src="../assets/wallet.svg">
          消费记录
      </div>
      <div class="share">
        <img src="../assets/share.svg">
        分享享优惠
      </div>
    </div>
  </div>
</template>

<script>
  export default {}
</script>

<style lang="scss" scoped>
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

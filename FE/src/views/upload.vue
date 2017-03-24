<template lang='html'>
  <div class='goBind'>
    <transition :name="transitionName" mode="out-in">
      <div class="panel" v-if="steep === 1" key="steep1">
        <div class="title">
          绑定至善网
        </div>
        <div class="sub-title">
          至善网账号
        </div>
        <div class="inputer">
          <input type="text">
        </div>
        <div class="sub-title">
          至善网密码
        </div>
        <div class="inputer">
          <input type="text">
        </div>
        <div class="next-step" @click="steep = 2">
          下一步 →
        </div>
      </div>
      <div class="panel" v-else key="steep2">
        <div class="title">
          选择课程
        </div>
        <div class="list">
          <div class="list-cell">
            毛概
          </div>
        </div>
        <div class="pre-step" @click="steep = 1">
          ← 上一步
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
  export default {
    name: 'goBind',
    data () {
      return {
        steep: 1,
        transitionName: 'slide-left'
      }
    },
    watch: {
      steep (val) {
        this.transitionName = val === 1 ? 'slide-right' : 'slide-left'
      }
    }
  }
</script>


<style lang="scss" rel="stylesheet/scss" type="text/css">
  .goBind {
    height: 100vh;
    background-image: linear-gradient(-180deg, #233142 0%, #455D7A 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    .panel {
      font-weight: 200;
    background: #fff;
      width: 80% !important;
      height: 85% !important;
      padding: 0 30px;
      box-sizing: border-box;
      position: relative;
      transition: transform 1s cubic-bezier(.55, 0, .1, 1), opacity 1s cubic-bezier(.55, 0, .1, 1);
      .list{
        .list-cell{
          position: relative;
          &:after{
            content: '>';
            position: absolute;
            display: block;
            right:30px;
            top:0;
          }
          margin:0 -30px;
          &:first-child{
            border-top: 1px solid #e0e0e0;
          }
          text-align: center;
          flood-color: #455D7A;
          font-size:1rem;
          line-height: 40px;
          border-bottom:1px solid #e0e0e0;
        }
      }
      .title {
        font-weight: 400;
        font-size: 1.2rem;
        color: #455D7A;
        margin: 30px 0 50px 0;
        text-align: center;
      }
      .sub-title {
        font-size: 1rem;
        color: #455D7A;
        margin: 30px 0 12px;
      }
      .next-step {
        font-size: 1rem;
        color: #455D7A;
        position: absolute;
        bottom: 35px;
        right: 30px;
      }
      .pre-step{
        font-size: 1rem;
        color: #455D7A;
        position: absolute;
        bottom: 35px;
        left: 30px;
      }
      .inputer {
        input {
          -webkit-appearance: none;
          -moz-appearance: none;
          appearance: none;
          border: none;
          border-bottom: 1px solid #e0e0e0;
          width: 100%;
          height: 18px;
          outline: none;
          transition: .3s ease;
          color: #455D7A;
          &:focus {
            border-radius: 0;
            border-bottom-color: #233142;
          }
        }
      }
    }
  }
</style>

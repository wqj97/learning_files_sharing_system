<template>
  <div>
    <p class="solgan">感谢您的赞助和支持，爱优医将通过等级以表谢意。</p>
    <div class="item lv0">
      <div class="main">
        <div class="level">Lv.0</div>
        <div class="price">￥0</div>
      </div>
      <div class="slogan">可享受少部分资料</div>
    </div>
    <div class="item lv1" @click="pay(0)">
      <div class="main">
        <div class="level">Lv.1</div>
        <div class="price">￥{{prices["0"]}}</div>
      </div>
      <div class="slogan">可享受部分资料</div>
    </div>
    <div class="item lv2" @click="pay(1)">
      <div class="main">
        <div class="level">Lv.2</div>
        <div class="price">￥{{prices["1"]}}</div>

      </div>
      <div class="slogan">可享受大部分资料</div>
    </div>
    <div class="item lv3" @click="pay(2)">
      <div class="main">
        <div class="level">Lv.3</div>
        <div class="price">￥{{prices["2"]}}</div>
      </div>
      <div class="slogan">可享受全部资料</div>
    </div>
    <p class="solgan">若想提供更多赞助，请联系客服微信: aiyouyi123</p>
  </div>
</template>
<script>
import pingpp from 'pingpp-js'
export default {
  name: 'buy',
  mounted() {
    this.$store.commit('updateError', { isError: true })
    this.$store.commit('updateLoadingStatus', { isLoading: true })
    this.$http.get('/pay/price').then(res => {
      this.$store.commit('updateLoadingStatus', { isLoading: false })
      this.prices = JSON.parse(res.body)
    }, err => {
      this.$vux.toast.show({
        text: '失败, 未知错误',
        type: 'warn'
      })
    })
    let callBack
    if (/buy\?success/.test(this.$route.fullPath)) callBack = true
    if (/buy\?cancel/.test(this.$route.fullPath)) callBack = false
    if (callBack === undefined) return
    callBack ? this.paySecceed() : this.payCancel()
  },
  methods: {
    paySecceed() {
      let duration = 3000
      this.$vux.toast.show({
        type: 'success',
        time: duration,
        text: '付款成功!'
      })
     window.setTimeout(() => {
        this.$router.push('/mine')
     }, duration)
    },
    payCancel() {
this.$vux.toast.show({
        type: 'cancel',
        text: '支付取消'
      })
    },
    pay(index) {
      let price = Number(this.prices[index])
      console.log(price)
      this.$http.post('/pay', { amount: price*100 }).then(res => {
        let charge = res.body
        console.log(charge)
        ////ugly code///
        pingpp.createPayment(charge, function (result, err) {
          console.log(result)
          console.log(err.msg)
          console.log(err.extra)
          if (result == "success") {
            this.paySecceed()
            // 只有微信公众账号 wx_pub 支付成功的结果会在这里返回，其他的支付结果都会跳转到 extra 中对应的 URL。
          } else if (result == "fail") {
            alert('失败!')
            // charge 不正确或者微信公众账号支付失败时会在此处返回
          } else if (result == "cancel") {
           this.payCancel()
            // 微信公众账号支付取消支付
          }
        })
        ////////
 })
    }
  },
  data() {
    return {
      prices: {}
    }
  }
}
</script>


<style lang="scss" scoped>
.solgan {
  text-align: left;
  color: #294d79;
  margin: 20px 18px;
  font-size: 17px;
  white-space: normal;
  word-break: break-all;
}

.lv0 {
  margin-top: 20px !important;
}

.item {
  user-select: none;
  border-radius: 15px;
  margin: 50px 18px;
  color: #FFF;
  text-align: center;
  padding-bottom: 40px;
  .main {
    font-size: 36px;
    font-weight: 300;
    display: flex;
    justify-content: space-between;
    padding: 35px 51px;
    padding-bottom: 5px;
  }
  .slogan {
    font-weight: 200;
    font-size: 14px;
    border-bottom: 1px solid #fff;
  }
  .line {
    opacity: 0;
    width: 100%;
    height: 1px;
    margin: 33px;
  }
}

.lv0 {
  background-image: linear-gradient(45deg, #2ECAFF 0%, #00B9F8 100%);
  box-shadow: 0px 8px 17px 0px rgba(0, 185, 248, 0.42);
}

.lv1 {
  /* Rectangle 9: */
  background-image: linear-gradient(-135deg, rgba(231, 19, 66, 0.88) 0%, rgba(232, 20, 66, 0.43) 100%);
  box-shadow: 0px 8px 17px 0px rgba(227, 12, 12, 0.35);
}

.lv2 {
  /* Rectangle 9: */
  background-image: linear-gradient(45deg, #FAD961 0%, #F77A26 86%, #F76B1C 100%);
  box-shadow: 0px 8px 17px 0px rgba(245, 165, 35, 0.36);
}

.lv3 {
  /* Rectangle 9: */
  background-image: linear-gradient(-134deg, #3023AE 0%, #E82E7F 100%);
  box-shadow: 0px 8px 17px 0px rgba(143, 18, 254, 0.49);
}
</style>

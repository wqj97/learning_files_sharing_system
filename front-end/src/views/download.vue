<template>
  <div class="container">
    <x-dialog v-model="isShowNewComment" hide-on-blur>
      <div class="comment_title">新建评论</div>
      <x-textarea v-model="newCommentContent" placeholder="请输入你的评论" :max="40"></x-textarea>
      <x-button @click.native="submitComment">评论</x-button>
    </x-dialog>
    <div class="top">
      <div class="top">
        <fileIcon class="fileIcon" v-if="detail['F_ext']" :type="detail['F_ext']" size="small"></fileIcon>
        <div class="right">
          <h2>{{detail['F_name']}}</h2>
          <span>下载等级: Lv.{{detail['F_level']}}</span>
        </div>
      </div>
      <div class="middle">
        <div class="item">
          <img src="../assets/download.svg"> {{detail['F_download_count']}}
        </div>
        <div class="item">
          <img src="../assets/views.svg"> {{detail['F_view_count']}}
        </div>
        <div class="item">
          <img src="../assets/humbuger.svg"> {{type}}
        </div>
      </div>
      <div class="bottom">
        <div class="left">
          <div class="comment wrapper" @click="isShowCommentList = !isShowCommentList"><img src="../assets/commentColor.svg"> {{detail['comment_count']}}</div>
          <div class="like wrapper" @click="like">
            <img v-if="detail['liked']" src="../assets/heartColor.svg">
            <img v-else src="../assets/emptyHeart.svg"> {{detail['like_count']}}
          </div>
        </div>
        <div class="right">
          <button id="download-btn" :class="{'gray': !isEnoughToDownload}" @click="downloadClick">下载</button>
        </div>
      </div>
    </div>
    <div class="tab">
      <div class="preview" v-show="!isShowCommentList">
        <preview v-if="previewUrlArr" :url="previewUrlArr"></preview>
      </div>
      <div class="comments" v-show="isShowCommentList">
        <commentList :list="commentArr" @refresh="commentRefresh" ref="refresh"></commentList>
      </div>
      <div class="bottom_btn" @click="isShowNewComment = true">新建评论</div>
    </div>
  </div>
</template>

<script>
import { fileIcon, commentList, preview } from '@/components/'
import { getCategroyListById, isComputer } from '@/utils'
import { mapState } from 'vuex'
import { XDialog, XTextarea, XButton } from 'vux'
import Cookies from 'js-cookie'
let flag = 0
export default {
  name: 'download',
  components: {
    fileIcon,
    commentList,
    XDialog,
    XTextarea,
    XButton,
    preview
  },
  mounted() {
    if (this.$route.query.refresh !== 'true') {
      window.location.href = window.location.href + '&refresh=true'
      window.location.reload()
      return
    }
    window.scrollTo(0, 0)

    let id = this.$route.query.id
    if (!id) {
      this.$vux.toast.show({
        text: '无文件id!',
        type: 'warn'
      })
      this.$router.push('/')
    }

    this.id = id
    this.$store.commit('updateLoadingStatus', { isLoading: true })
    this.getComment()
    this.$http.get(`/file?file_id=${id}`).then(res => {
      this.detail = res.body
      this.$store.commit('updateLoadingStatus', { isLoading: false })
      if (isComputer() || process.env.NODE_ENV === 'development') return
      this.signWechat(res.body)
    }, err => {
      this.$store.commit('updateError', { isError: true })
    })
  },
  data() {
    return {
      id: '',
      isShowCommentList: false,
      isShowNewComment: false,
      newCommentContent: '',
      detail: {},
      commentArr: [],
      commentPage: 0,
      jsjdkReady: false
    }
  },
  methods: {
    signWechat(data) {
      console.log('sign jsjdk...')
      let fileShareInfo = {
        title: data['F_name'], // 分享标题
        link: `https://wx.97qingnian.com/user/oauth?url=${window.location.href}`, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
        desc: '你的好友给你分享文件啦!',
        imgUrl: '',                  // 分享图标
        success: () => {
          console.log('share ok')
          this.$http.post('/file/share', { 'file_id': this.detail['F_Id'] }).then(res => {
            this.$vux.toast.show({
              text: '分享成功!'
            })
          })
        },
        cancel: function () {
          console.log('用户取消')
        },
        trigger: function () {
          console.log('action trigger')
        }
      }


      console.log('fileShareInfo:' + JSON.stringify(fileShareInfo))
      this.$http.post('/jssdk/sign', { url: location.href.split('#')[0] }).then(res => {
        console.log('config:' + JSON.stringify(res.body))
        let config = JSON.parse(res.body[0])
        // config['debug'] = true
        console.log('config jsjsk...')
        wx.config(config)
        // this.$store.commit('updateLoadingStatus', { isLoading: true })
        window.setInterval(() => {
          if (!this.jsjdkReady) {
            console.log('come on!  a shit!')
            window.location.reload()
          }
        }, 5000)
      })
      wx.ready(() => {

        console.log('jsjdkConfig success, set hooks...')
        wx.onMenuShareTimeline(fileShareInfo)
        wx.onMenuShareAppMessage(fileShareInfo)
        wx.onMenuShareQQ(fileShareInfo)
        wx.onMenuShareQZone(fileShareInfo)
        console.log(wx.onMenuShareTimeline)
        this.$store.commit('updateLoadingStatus', { isLoading: false })
        this.jsjdkReady = true
      })
      wx.error((res) => {
        console.error('jsjdkConfig error' + JSON.stringify(res))
        flag++
        if (flag === 3) return
        window.setTimeout(() => {
          this.signWechat(data)
        }, 600)
      })
    },
    submitComment() {
      if (this.newCommentContent === '') {
        this.$vux.toast.show({
          text: '内容不能为空',
          type: 'warn'
        })
        return
      }
      this.$http.post(`/file/comment/new/`, { file_id: this.detail['F_Id'], content: this.newCommentContent }).then(res => {
        this.$vux.toast.show({
          text: '成功!'
        })
        this.commentPage = 0
        this.getComment()
        this.newCommentContent = ''
        this.isShowNewComment = false
      }, err => {
        this.$vux.toast.show({
          text: '失败, 未知错误',
          type: 'warn'
        })
      })
    },
    commentRefresh() {
      this.getComment()
    },
    getComment() {
      this.$http.get(`/file/comment/?file_id=${this.id}&page=${this.commentPage}`).then(res => {
        if (res.body.length === 0) this.noMoreData()
        this.commentArr = this.commentArr.concat(res.body)
        this.$refs.refresh.done()
      }, err => {
        this.$vux.toast.show({
          text: '失败, 未知错误',
          type: 'warn'
        })
      })
      this.commentPage++
    },
    noMoreData() {
      this.$refs.refresh.noMoreData()
    },
    downloadClick() {
      this.$http.get('/user/check').then(data => {
        if (!data.data) {
          window.location.href = 'https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzIxNDYyOTU2OA==&scene=124#wechat_redirect'
          return
        } else {
          if (this.user['U_school'] == '' || this.user['U_school'] === null || this.user['U_school'] === undefined) {
            this.$vux.toast.show({
              text: '没有绑定学校, 请先绑定学校~',
              type: 'warn'
            })
            setTimeout(() => {
              this.$router.push('/schoolList')
            }, 700);
            return
          }

          if (this.user.level < this.detail['F_level']) {
            this.$vux.toast.show({
              text: '权限不够哦~ 请去个人中心升级权限',
              type: 'warn'
            })
            setTimeout(() => {
              this.$router.push('/mine')
            }, 700);
            return
          }
          let openid = Cookies.get('Aiuyi_openid')
          if (openid == undefined) {
            console.error('fail to get openId')
          }
          window.location.href = `${window.location.origin}/file/download/?file_id=${this.detail['F_Id']}&openid=${openid}`
        }
      })
    },
    like() {
      this.$store.commit('updateLoadingStatus', { isLoading: true })
      this.$http.get(`/file/collect?file_id=${this.detail['F_Id']}`).then(res => {
        this.$store.commit('updateLoadingStatus', { isLoading: false })
        let isLiked = res.body['0'] === 'Collected'
        this.detail['liked'] = isLiked
        isLiked ? this.detail['like_count'] += 1 : this.detail['like_count'] -= 1
      }, err => {
        this.$vux.toast.show({
          text: '失败, 未知错误',
          type: 'warn'
        })
      })
    }
  },
  computed: {
    isEnoughToDownload() {
      if (this.user.level < this.detail['F_level']) {
        return false
      }
      return true
    },
    previewUrlArr() {
      return this.detail['F_transfer_url']
    },
    type() {
      return getCategroyListById(this.detail['F_type'])
    },
    ...mapState({
      user: state => state.user
    })
  }
}
</script>

<style lang="scss" scoped>
@import '../style/base.scss';
.container {
  padding-bottom: 8vh;
}

.top {
  background-color: #fff;
  color: #455D7A;
  width: 100%;
  padding-top: 19px;
  padding-bottom: 18px; // border-bottom: 1px solid #EEEEEE;
  .top {
    box-sizing: border-box;
    border: none;
    display: flex;
    justify-content: space-around;
    padding: 0 6px;
    .fileIcon {
      min-width: 60px;
    }
    .right {
      font-weight: 200;
      h2 {
        font-weight: 300;
        font-size: 20px;
      }
      text-align: center;
    }
  }
}

.middle {
  display: flex;
  justify-content: space-around;
  margin: 18px 40px;
  margin-bottom: 28px;
  .item {
    img {
      vertical-align: middle;
      width: 22px;
      height: 30px;
      margin-right: 10px;
    }
  }
}

$menuBarRadius: 4px;
.bottom {
  display: flex;
  justify-content: space-around;
  align-items: center;
  .left {
    box-sizing: border-box;
    display: flex;
    img {
      width: 16px;
      height: 15px;
    }
    .wrapper {
      padding: 17px 20px;
    }
    .comment {
      border: 1px solid $baseColor;
      border-top-left-radius: $menuBarRadius;
      border-bottom-left-radius: $menuBarRadius;
    }
    .like {
      border: 1px solid $redColor;
      border-left: none;
      border-top-right-radius: $menuBarRadius;
      border-bottom-right-radius: $menuBarRadius;
    }
  }
  #download-btn {
    /* Rectangle 3: */
    background-image: linear-gradient(-180deg, #00B9F8 0%, #2ECAFF 100%);
    border-radius: 100px;
    font-size: 18px;
    color: #FFFFFF;
    letter-spacing: 0px;
    padding: 10px 43px;
    border: none;
    box-shadow: 0 2px 10px rgba(0, 185, 248, .6);
    transition: filter .4s cubic-bezier(0, 0.57, 0.75, 0.46);
    transition-delay: .8s;
  }
}

.gray {
  filter: grayscale(100%);
}

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

.comment_title {
  padding: 10px;
}

.preview {
  z-index: -1;
  height: 500px;
}
</style>

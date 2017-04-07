<template>
  <div>
    <x-dialog v-model="isShowNewComment" hide-on-blur>
      <div class="comment_title">新建评论</div>
       <x-textarea  v-model="newCommentContent" placeholder="请输入你的评论" :max="40"></x-textarea>
 <x-button @click.native="submitComment">评论</x-button>
    </x-dialog>
    <div class="top">
      <div class="top">
        <fileIcon v-if="detail['F_ext']"
                  :type="detail['F_ext']"
                  size="small"></fileIcon>
        <div class="right">
          <h2>{{detail['F_name']}}</h2>
          <span>下载等级: Lv.{{detail['F_level']}}</span>
        </div>
      </div>
      <div class="middle">
        <div class="item">
          <img src="../assets/download.png"> {{detail['F_download_count']}}
        </div>
        <div class="item">
          <img src="../assets/eye.png"> {{detail['F_view_count']}}
        </div>
        <div class="item">
          <img src="../assets/humbuger.png"> {{type}}
        </div>
      </div>
      <div class="bottom">
        <div class="left">
          <div class="comment wrapper"><img src="../assets/commentColor.png"> {{detail['comment_count']}}</div>
          <div class="like wrapper"
               @click="like">
            <img v-if="detail['liked']"
                 src="../assets/heartColor.png">
            <img v-else
                 src="../assets/heart.png"> {{detail['like_count']}}
          </div>
        </div>
        <div class="right">
          <button id="download-btn"
                  @click="downloadClick">下载</button>
        </div>
      </div>
    </div>
    <div class="tab">
      <div class="preview">
        <!--<iframe src="http://view.officeapps.live.com/op/view.aspx?src=https://wx.97qingnian.com/upload/20170331/45ae784b3da3b7a1928998f99c9d70b2.doc"
                  frameborder="0"
                  style="width:100%;height:100%;">
                  </iframe>-->
      </div>
      <div class="comments">
        <commentList :list="commentArr"
                     @refresh="commentRefresh"
                     ref="refresh"></commentList>
      </div>
      <div class="bottom_btn" @click="isShowNewComment = true">新建评论</div>
    </div>
  </div>
</template>

<script>
import { fileIcon, commentList } from '@/components/'
import { getCategroyListById } from '@/utils'
import { mapState } from 'vuex'
import {XDialog, XTextarea, XButton} from 'vux'
export default {
  name: 'download',
  mounted() {
    let id = this.$route.query.id
    if (!id) {
      this.$vux.toast.show({
        text: '无文件id!',
        type: 'warn'
      })
      this.$router.push('/')
    }
    this.id = id
    this.$http.get(`/file?file_id=${id}`).then(res => {
      this.detail = res.body
    }, err => {
      this.$store.commit('updateError', { isError: true })
    })
   this.getComment()
  },
  data() {
    return {
      id: '',
      isShowNewComment: false,
      newCommentContent: '',
      detail: {},
      commentArr: [],
      commentPage: 0
    }
  },
  methods: {
    submitComment() {
      if (this.newCommentContent === '') {
         this.$vux.toast.show({
          text: '内容不能为空',
          type: 'warn'
        })
        return
      }
      this.$http.post(`/file/comment/new/`, {file_id: this.detail['F_Id'], content: this.newCommentContent}).then(res => {
       this.$vux.toast.show({
          text: '成功!'
        })
       this.isShowNewComment = false
      }, err => {
        //TODO

      })
    },
    commentRefresh() {
      this.getComment()
    },
    getComment() {
       this.$http.get(`/file/comment/?file_id=${this.id}&page=${this.commentPage}`).then(res => {
         if (res.body.length === 0) this.noMoreData()
      this.commentArr = this.commentArr.concat(res.body)
    }, err => {
      //TODO
    })
    this.commentPage++
  },
  noMoreData() {
    this.$refs.refresh.noMoreData()
  },
    downloadClick() {
      if (this.user.level < this.detail['F_level']) {
        this.$vux.toast.show({
          text: '权限不够哦~ 请去个人中心升级权限',
          type: 'warn'
        })
        return
      }
      window.location.href = `https://wx.97qingnian.com/file/download/?file_id=${this.detail['F_Id']}`
    },
    like() {
      this.$http.get(`/file/collect?file_id=${this.detail['F_Id']}`).then(res => {
        let isLiked = res.body['0'] === 'Collected'
        this.detail['liked'] = isLiked
        isLiked ? this.detail['like_count'] += 1 : this.detail['like_count'] -= 1
      }, err => {
        //TODO
      })
    }
  },
  computed: {
    type() {
      return getCategroyListById(this.detail['F_type'])
    },
    ...mapState({
      user: state => state.user
    })
  },
  components: {
    fileIcon,
    commentList,
    XDialog,
    XTextarea,
    XButton
  }
}
</script>

<style lang="scss" scoped>
@import '../style/base.scss';
.top {
  background-color: #fff;
  color: #455D7A;
  width: 100%;
  padding-top: 19px;
  padding-bottom: 18px;
  border-bottom: 1px solid #EEEEEE;
  .top {
    padding-top: 0px;
    padding-bottom: 0px;
    border: none;
    display: flex;
    justify-content: space-around;
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
      width: 20px;
      height: 20px;
      margin-right: 20px;
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
  }
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

  background-image: linear-gradient(-90deg, #EF5F3E 0%, #EB3369 100%);
}
.comment_title{
  padding:10px;
}
</style>

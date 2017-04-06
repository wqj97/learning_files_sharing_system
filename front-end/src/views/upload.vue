<template lang='html'>
  <div class='goBind'>
    <transition :name="transitionName" mode="out-in">
      <div class="panel" v-if="steep === 1">
        <div class="title">
          上传文件
        </div>
        <form enctype="multipart/form-data" id="form" action="">
          <div class="sub-title">
          文件名称(如不填写, 将自动获取)
        </div>
        <div class="inputer">
          <input name="file_name" v-model="fileName" type="text">
        </div>
        <div class="sub-title">
          选择文件
        </div>
        <div class="inputer">
          <input name="file" type="file" id="file">
        </div>
        </form>
        <div class="right-bottom" @click="upload">
          下一步 →
        </div>
      </div>
      <div class="panel" id="success" v-else>
        <div class="title">
          上传成功
        </div>
        <!--!!!!!!!!!!!-->
        <fileIcon :type="ext" size="big"></fileIcon>
        <!--12312312312312-->
          <div class="fileName">{{fileName}}</div>
          <h3 class="thanks">谢谢您的贡献</h3>
          <h5>+3积分</h5>
          <div class="right-bottom" @click="$router.push('/')">
          完成
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { fileIcon } from '../components'
import { mapMutations } from 'vuex'
import md5 from 'MD5'
function sha($file) {
  return new Promise((resolve, reject) => {
    var reader = new FileReader();
      reader.onload = (callback) => {
        console.log(md5(reader.result))
        resolve(md5(reader.result))
      }
      reader.readAsBinaryString($file.files[0]);
  })

}
function getFileName($file) {
  let file = $file.files[0]
  return file.name.split('.')[0]
}
export default {
  name: 'upload',
  components: {
    fileIcon
  },
  methods: {
    upload() {
      let $file = window.document.getElementById('file')
      if (!$file.files[0]) {
        this.$vux.toast.show({
          text: '请选择文件',
          type: 'warn'
        })
        return
      }
      this.setLoading({ isLoading: true })
      if (this.fileName === '') this.fileName = getFileName($file)

      sha(file).then(sha => {
        this.checkMD5(sha).then(result => {
          if (!result) {
             this.setLoading({ isLoading: false })
            this.$vux.toast.show({
          text: '该文件已有人上传~',
          type: 'warn'
        })
        return
      }
      this.uploadFile($file).then((result)=>{
      this.setLoading({ isLoading: false })
      console.log(result)
      this.ext = result['file_info']['file_ext']
      this.fileName = result['file_info']['file_name']
      this.steep = 2
      }, err=> {
        this.setLoading({ isLoading: false })
      })
        })
      })
    },
    checkMD5(sha) {
     return new Promise((resolve, reject) => {
        this.$http.get(`/file/upload/check?hash=${sha}`).then(res => {
        if (res.body.result&&res.body.result === 'success') resolve(true)
        resolve(false)
      }, res => reject(res))
     })
    },
    uploadFile($file) {
      return new Promise((resolve, rejcet) => {
        const form = new FormData(document.getElementById('form'))
        this.$http.post('/file/upload', form).then(res => {
          resolve(res.body)
        }, err => {
          this.setLoading({ isLoading: false })
           this.$vux.toast.show({
            text: err.body.reason,
           type: 'warn'
        })
          // reject(err)
        })
      })
    },
    ...mapMutations({
      setLoading: 'updateLoadingStatus'
    })
  },
  data() {
    return {
      steep: 1,
      transitionName: 'slide-left',
      fileName: '',
      ext: ''
    }
  },
  watch: {
    steep(val) {
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
    .list {
      .list-cell {
        position: relative;
        &:after {
          content: '>';
          position: absolute;
          display: block;
          right: 30px;
          top: 0;
        }
        margin:0 -30px;
        &:first-child {
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
    .right-bottom {
      font-size: 1rem;
      color: #455D7A;
      position: absolute;
      bottom: 35px;
      right: 30px;
    }
    .inputer {
      input {
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
      input[type="file"] {
        // position:absolute;
        // opacity: 0;
      }
    }
  }
}

#success {
  text-align: center;
  align-items: center;
  color: #455D7A;
  .fileName {
    font-weight: 400;
    margin: 23px 0;
  }
  .thanks {
    font-weight: 400;
    margin: 23px 0;
  }
}
</style>

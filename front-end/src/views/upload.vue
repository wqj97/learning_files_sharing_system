<template lang='html'>
  <div class='goBind'>
<loading v-model="isLoading" :text="tip"></loading>
    <transition :name="transitionName" mode="out-in">
      <div class="panel" v-if="steep === 1">
        <div class="title">
          上传文件 <span v-show="isLoading">:{{tip}}</span>
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
        <label for="file" class="inputer file_inputer" >
          <input @change="setUploadFileName" name="file" type="file"  id="file">
          <span> <span v-show="uploadFileName===''">点击选择你要上传的文件 </span> {{this.uploadFileName}}</span>
        </label>
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
import { Loading } from 'vux'
// import md5 from 'MD5'


export default {
  name: 'upload',
  components: {
    fileIcon,
    Loading
  },
  mounted() {
    this.file = window.document.getElementById('file')
  },
  methods: {
    setUploadFileName() {
      this.uploadFileName = this.getFileName()
    },
    getFileName() {
      let file = this.file.files[0]
      if (!file) return
      return file.name.split('.')[0]
    },
    upload() {
      if (!this.file.files[0]) {
        this.$vux.toast.show({
          text: '请选择文件',
          type: 'warn'
        })
        return
      }
      this.isLoading = true
      this.$nextTick(() => {
        if (this.fileName === '') {
          this.tip = '自动获取文件名称'
          this.fileName = this.getFileName()
        }
        this.tip = '上传中...'
        this.uploadFile().then((result) => {
          this.isLoading = false
          this.ext = result['file_info']['file_ext']
          this.fileName = result['file_info']['file_name']
          this.steep = 2
        }, err => {
          this.isLoading = false
        })
      })
    },
    checkMD5(sha) {
      return new Promise((resolve, reject) => {
        this.$http.get(`/file/upload/check?hash=${sha}`).then(res => {
          if (res.body.result && res.body.result === 'success') resolve(true)
          resolve(false)
        }, res => reject(res))
      })
    },
    uploadFile() {
      return new Promise((resolve, rejcet) => {
      this.$nextTick( () => {
          const form = new FormData(document.getElementById('form'))
        this.$http.post('/file/upload', form, { progress: this.getProgress }).then(res => {
          resolve(res.body)
        }, err => {
          this.isLoading = false
          this.fileName = ''
          this.$vux.toast.show({
            text: err.body.reason,
            type: 'warn'
          })
          // reject(err)
        })
      })
      })
    },
    getProgress(event) {
      let num = (((event.loaded / event.total) * 100).toFixed()).toString() + '%'
      this.tip = num
    },
    sha($file) {
      return new Promise((resolve, reject) => {
        var reader = new FileReader()
        reader.onload = (callback) => {
          let result
          setTimeout(() => {
            result = md5(reader.result)
            resolve(result)
          }, 600)
        }
        reader.readAsBinaryString($file.files[0]);
      })
    },
    ...mapMutations({
      setLoading: 'updateLoadingStatus'
    })
  },
  data() {
    return {
      uploadFileName: '',
      steep: 1,
      file: '',
      transitionName: 'slide-left',
      fileName: '',
      ext: '',
      isLoading: false,
      tip: '加载中...'
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
.file_inputer {
  #file {
    position: absolute;
    top: -100px;
  }
  span {
    padding-bottom: 10px;
  }
}

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
      input,
      span {
        display: block;
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

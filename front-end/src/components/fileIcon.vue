<template>

  <img :src="fileUrl" :alt="type" :class="size ? size : ''">

</template>

<script>
const imgBaseUrl = './static/img/fileType/'
export default {
  name: 'fileIcon',
  props: {
    type: {
      type: String,
      require: true
    },
    size: {
      type: String,   // big small
      require: false,
      default: 'big'
    }
  },
  data () {
    return {

    }
  },
  computed: {
    fileUrl() {
      return imgBaseUrl + this.type.toLowerCase() + '.svg'
    }
  }
}
</script>
<style lang="scss" scoped>
.big{
  width: 100px;
  height: 115px;
}
.small {
  width: 57px;
  height: 66px;
}
</style>

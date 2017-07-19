<template>
  <div class="scrollBar_wrapper">
<div class="scrollBar"><slot></slot></div>
  </div>
</template>

<script>
  export default {
    name: '',
    data () {
      return {

      }
    }
  }
</script>


<style lang="scss" scoped>
.scrollBar_wrapper{
  width: 100%;
  overflow: scroll;
  color:#855555;
  background-attachment: fixed;
  background-color: rgba(222, 212, 173, 0.42);
  &::-webkit-scrollbar {display:none}
}

.scrollBar{
  padding: 13px 0px;
   font-size: 15px;
   line-height: 15x;
  white-space: nowrap;
  position: relative;
  display: inline-block;
  animation: 8s linear 0s infinite scroll;
}
@keyframes scroll{
  from{transform:translateX(100vw)}
  to{transform:translateX(-100%)}
}
</style>

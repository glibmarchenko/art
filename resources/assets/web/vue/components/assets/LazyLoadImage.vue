<template>
    <img
            :src="src"
            alt=""
            :class="[imageClass, imageState]">
    <!--<div :class="[imageClass, imageState]" :id="imageId" :style="computedStyle" :data-width="imageWidth"-->
    <!--:data-height="imageHeight" :data-state="imageState"></div>-->
</template>

<script>
  import LazyLoadBackground from './LazyLoadBackground'

  export default {
    extends: LazyLoadBackground,

    computed: {
      src () {
        switch (this.imageState) {
          case 'loaded':
            return this.asyncImage.src
          case 'loading':
            return this.loadingImage
          case'error':
          default:
            return this.errorImage
        }
      }
    }
  }
</script>
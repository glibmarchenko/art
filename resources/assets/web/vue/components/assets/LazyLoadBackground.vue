<template>
  <div
    :class="[imageClass, imageState]"
    :id="imageId"
    :style="computedStyle"
    :data-width="imageWidth"
    :data-height="imageHeight"
    :data-state="imageState"/>
</template>

<script>
export default {
  props: {
    imageSource: {
      type: String,
      required: true,
    },
    imageId: {
      type: String,
      required: false,
      default: '',
    },
    imageClass: {
      type: String,
      required: false,
      default: '',
    },
    loadingImage: {
      type: String,
      required: true,
    },
    errorImage: {
      type: String,
      required: true,
    },
    imageErrorCallback: {
      type: Function,
      required: false,
      default() {
      },
    },
    imageSuccessCallback: {
      type: Function,
      required: false,
      default() {
        this.imageFadeout();
      },
    },
    backgroundSize: {
      type: String,
      required: false,
      default: 'cover',
    },
  },
  data() {
    return {
      imageWidth: 0,
      imageHeight: 0,
      imageState: 'loading',
      asyncImage: new Image(),
    };
  },
  computed: {
    computedStyle() {
      if (this.imageState === 'loading') {
        return `background-image: url(${this.loadingImage}); background-position: center; background-repeat:no-repeat; background-size: 55px;`;
      }
      if (this.imageState === 'error') {
        return `background-image: url(${this.errorImage}); background-position: center; background-repeat:no-repeat; background-size: 55px;`;
      }
      if (this.imageState === 'loaded') {
        return `background-image: url(${this.asyncImage.src}); background-position: center; background-repeat:no-repeat; background-size: ${this.backgroundSize}`;
      }
      return '';
    },
  },
  methods: {
    fetchImage(url) {
      this.asyncImage.onload = this.imageOnLoad;
      this.asyncImage.onerror = this.imageOnError;
      this.imageState = 'loading';
      this.asyncImage.src = this.imageSource;
    },
    imageOnLoad(success) {
      this.imageState = 'loaded';
      this.imageWidth = this.asyncImage.naturalWidth;
      this.imageHeight = this.asyncImage.naturalHeight;
      this.imageSuccessCallback();
    },
    imageOnError(error) {
      this.imageState = 'error';
      window.console.error(`Error while loading${this.imageSource}`);
      window.console.error('Error while loading');
      window.console.error(this.imageSource);
      this.imageErrorCallback();
    },
    imageFadeout() {
      $(`#${this.imageId}`).velocity('transition.fadeIn');
    },
  },
  mounted() {
    this.$nextTick(() => {
      this.fetchImage();
    });
  },
  watch: {
    imageSource: {
      handler(value) { // watch it
        this.fetchImage();
      },
      deep: 1,
    },

  },
};
</script>

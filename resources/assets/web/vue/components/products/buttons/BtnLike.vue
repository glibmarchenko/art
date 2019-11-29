<template>
  <div
    class="card-icon btn-icon-like"
    :class="{ liked }"
    @click="$emit('like')">
    <img
      class="i-liked"
      :src="'/web/images/ui/card/i-liked.svg'">
    <img
      class="i-original"
      :src="'/web/images/ui/card/i-like.svg'">
    <img
      class="i-hover"
      :src="'/web/images/ui/card/i-like-hover.svg'">
  </div>
</template>

<script>
  export default {
    props: {
      liked: {
        type: Boolean,
        default: false
      }
    }
  }
</script>
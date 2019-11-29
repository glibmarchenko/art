<template>
  <div class="card-icon btn-icon-like">
    <a
      :href="href"
      class="fb-share"
      target="_blank">
      <img
        class="i-liked"
        :src="'/web/images/ui/share-01.svg'">
      <img
        class="i-original"
        :src="'/web/images/ui/share-01.svg'">
      <img
        class="i-hover"
        :src="'/web/images/ui/share-01.svg'">
    </a>
  </div>
</template>

<script>
  export default {
    props: {
      href: {
        type: String,
        default: ''
      }
    }
  }
</script>
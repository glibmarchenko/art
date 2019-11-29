<template>
  <div
    class="card-right-block"
    v-if="product">
    <div
      class="card-icon btn-icon-close"
      @click="$emit('hide')"
      v-if="single_product === false && !$root.is_mobile">
      <img
        class="i-original"
        :src="'/web/images/ui/card/i-close.svg'">
      <img
        class="i-hover"
        :src="'/web/images/ui/card/i-close-hover.svg'">
    </div>

    <btn-zoom/>

    <btn-like
      :liked="product.isLikedByAuthUser"
      @like="$emit('like')"/>

    <btn-fb-share :href="product.facebookShareUrl"/>

    <div
      class="card-icons-footer"
      v-if="single_product === false">

      <btn-next-item @switchNextProduct="$emit('switchNextProduct')"/>
      <btn-prev-item @switchPrevProduct="$emit('switchPrevProduct')"/>

    </div>
  </div>
</template>

<script>
  import BtnZoom from './../buttons/BtnZoom'
  import BtnNextItem from './../buttons/BtnNextItem'
  import BtnPrevItem from './../buttons/BtnPrevItem'
  import BtnFbShare from './../buttons/BtnFbShare'
  import BtnLike from './../buttons/BtnLike'

  export default {
    props: ['single_product', 'product'],

    components: {
      BtnZoom,
      BtnNextItem,
      BtnPrevItem,
      BtnFbShare,
      BtnLike,
    }
  }
</script>

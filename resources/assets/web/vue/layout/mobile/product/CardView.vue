<template>
  <div class="preview">
    <lazy-load-image
      :image-source="current_preview"
      loading-image="/images/loading.svg"
      error-image="/images/error.svg"
      image-id="zoom-image"
      image-class="card-center-block"
      background-size="contain"
      :image-success-callback="()=>{}"
    />
    <div
      class="additional-images"
      v-if="product.type !== 1 && product.attachments.length">

      <div class="other-images-container">
        <div
          v-for="attachment in product.attachments"
          :class="{highlight: attachment.id === selected}"
          :style="'background-image: url('+attachment.path+');'"
          :key="attachment.path"
          :alt="attachment.name"
          @click="$emit('setPreview',attachment.id, attachment.path)"
        />
        <div
          :style="'background-image: url('+product.image_preview_m+');'"
          :alt="product.name"
          :class="{highlight: !selected}"
          @click="$emit('setPreview')"/>
      </div>
    </div>
    <div 
      class="product-actions" 
      :class="{'single-product' : single_product !== false}">
      <btn-prev-item 
        @switchPrevProduct="$emit('switchPrevProduct')" 
        v-if="single_product === false"/>
      <div class="middle-actions">
        <btn-zoom/>

        <btn-like
          :liked="product.isLikedByAuthUser"
          @like="$emit('like')"/>

        <btn-fb-share :href="product.facebookShareUrl"/>
      </div>
      <btn-next-item 
        @switchNextProduct="$emit('switchNextProduct')" 
        v-if="single_product === false"/>
    </div>
    <zoomable :image="product.image_preview_original"/>
  </div>
</template>

<script>
  import LazyLoadImage from '../../../components/assets/LazyLoadImage'
  import BtnNextItem from '../../../components/products/buttons/BtnNextItem'
  import BtnPrevItem from '../../../components/products/buttons/BtnPrevItem'
  import BtnZoom from '../../../components/products/buttons/BtnZoom'
  import BtnLike from '../../../components/products/buttons/BtnLike'
  import BtnFbShare from '../../../components/products/buttons/BtnFbShare'

  export default {
    props: ['single_product', 'product', 'selected', 'current_preview'],

    components: {
      LazyLoadImage,
      BtnNextItem,
      BtnPrevItem,
      BtnZoom,
      BtnLike,
      BtnFbShare,
    }
  }
</script>
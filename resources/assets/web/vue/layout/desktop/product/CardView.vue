<template>
  <section
    id="card-view"
    :class="{visible: this.single_product !== false}">

    <div
      class="card-left-block"
      v-if="product.type !== 1 && product.attachments.length">

      <div class="other-images-container">
        <img
          v-for="attachment in product.attachments"
          :class="{highlight:attachment.id === selected}"
          :src="attachment.path"
          :key="attachment.path"
          :alt="attachment.name"
          @click="$emit('setPreview',attachment.id, attachment.path)"
        >
        <img
          :src="product.image_preview_m"
          :alt="product.name"
          @click="$emit('setPreview')">
      </div>
    </div>

    <lazy-bg
      :image-source="current_preview"
      loading-image="/images/loading.svg"
      error-image="/images/error.svg"
      image-id="zoom-image"
      image-class="card-center-block"
      background-size="contain"
    />

    <div class="pic-wrap hidden">
      <div class="product-container">
        <a class="close-product-overview product-frame">
          <img
            id="product-image"
            :src="product.image_preview_m">
        </a>
      </div>
    </div>


    <card-right-block
      :product="product"
      :single_product="single_product"
      @hide="$emit('hide')"
      @like="$emit('like')"
      @switchNextProduct="$emit('switchNextProduct')"
      @switchPrevProduct="$emit('switchPrevProduct')"
    />

    <zoomable :image="product.image_preview_original"/>

  </section>
</template>

<script>
  import LazyBg from '../../../components/assets/LazyLoadBackground'
  import CardRightBlock from '../../../components/products/show/CardRightBlock'

  export default {
    props: ['single_product', 'product', 'selected', 'current_preview'],

    components: {
      LazyBg,
      CardRightBlock,
    }
  }
</script>

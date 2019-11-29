<template>
  <div
          class="buy-block"
          :class="{'opacity-95' : (this.single_product === false && $root.is_mobile), 'bottom' : is_bottom, 'after_preview' : is_center}"
          >
    <div class="price">
      <span
        v-if="$root.is_mobile"
        :class="'caps product-type text-fill-'+ product.type_class_colour">
        {{ product.type_name }}
      </span>
      <span class="amount" v-if="product.for_sale && product.status_id >= 3">{{ product.final_price }}</span>
      <span class="currency" v-if="product.for_sale &&  product.status_id >= 3">EUR</span>
    </div>
    <div class="btn-buy" v-if="product.for_sale &&  product.status_id >= 3">
      <a href="#" class="btn btn-fill-green btn-55 btn-m-89"
        @click="$emit('purchase')">
        {{ trans('pages.buy') }}
      </a>
    </div>
    <div
            v-if="$root.is_mobile & single_product === false & !is_center"
            class="card-right-block">
      <div
        class="card-icon btn-icon-close"
        @click="$emit('hide')"
        v-if="single_product === false">
        <img src="/web/images/ui/card/artdiller_product_close.svg">
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['product', 'single_product', 'is_bottom', 'is_center'],
  }
</script>

<template>
  <div
    v-if="product.type !== 1"
    class="options-listing">
    <p>{{ trans('dashboard.Materials') }}: <span
      v-for="material in product.materials"
      :key="material.name">{{ material.name }}</span>
        </p>
    <p>{{ trans('pages.Size') }}: <span>{{ product_size }}</span></p>
    <p>{{ trans('dashboard.weight') }}: <span>{{ product.weight }} {{ trans('dashboard.kg') }}</span></p>
  </div>
</template>

<script>
  export default {
    props: ['product', 'single_product', 'product_size'],
  }
</script>

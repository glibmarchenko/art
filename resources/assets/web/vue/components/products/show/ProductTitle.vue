<template>
    <div class="check-card">
        <h3 class="title" v-if="product.type === 1">
            {{ trans('pages.Print options') }}
        </h3>
        <h3 class="title" v-if="product.type !== 1">
            {{product.name}}
        </h3>


    <form
      class="form"
      name="form-card"
      v-if="product.type === 1 && $root.is_mobile">
      <p>{{ trans('pages.Material') }}: <span>{{ purchaseFormData.details.material.name }}</span></p>
      <p>{{ trans('pages.Size') }}: <span>{{ product_size }}</span></p>
    </form>
    <form
      class="form"
      name="form-card"
      v-if="product.type === 1 && !$root.is_mobile">
      <p>
        <label>{{ trans('pages.Material') }}</label>
        <span><i>{{ purchaseFormData.details.material.name }}</i></span>
      </p>
      <p>
        <label>{{ trans('pages.Size') }}</label>
        <span><i>{{ product_size }}</i></span>
      </p>
    </form>
  </div>
</template>

<script>
  export default {
    props: ['product', 'single_product', 'purchaseFormData', 'product_size'],
  }
</script>
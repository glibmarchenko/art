<template>
  <div class="card-block">
    <section
            id="card-menu"
      :class="{visible: this.single_product !== false}">
      <div class="card-menu">
        <author-block :product="product"/>

        <buy-block
                :product="product"
                :single_product="single_product"
                @hide="hide"
          @purchase="purchase"/>

        <item-colors :product="product"/>

        <product-title
                :product_size="product_size"
                :product="product"
          :purchase-form-data="purchaseFormData"/>

        <product-info
                :product="product"
          :product_size="product_size"/>

        <description :product="product"/>

        <key-words :product="product"/>
      </div>


    </section>

    <card-view
            :product="product"
            :single_product="single_product"
            :selected="selected"
            :current_preview="current_preview"
            @setPreview="setPreview"
            @hide="hide()"
            @like="like()"
            @switchPrevProduct="switchPrevProduct()"
            @switchNextProduct="switchNextProduct()"/>
  </div>
  <!--End Card product-->
</template>

<script>
  import ProductShowBase from '../../base/product/ProductShowBase';
  
  import CardView from './CardView';

  export default {
    extends: ProductShowBase,

    components: {
      CardView,
    },
  };
</script>

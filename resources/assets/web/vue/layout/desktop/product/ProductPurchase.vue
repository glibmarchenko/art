<template>
  <section
    id="purchase-product"
    class="purchase-product">

    <div
      id="product-purchase-container"
      class="product-purchase-container"
      @click.self="hide">

      <div class="content">
        <div
          class="product-image"
          :style="{
            backgroundImage: 'url(\'' + product.image_preview_m + '\')',
            backgroundSize: 'contain',
            backgroundRepeat: 'no-repeat',
            backgroundPosition: 'center' }"/>

        <div class="product-description">
          <div class="product-type">ПРИНТ</div>
          <div class="product-author">{{ product.author.name }} {{ product.author.surname }}</div>
          <div class="product-name">{{ product.name }}</div>

          <ul class="product-details-list">
            <li>Материал -
              <span
                v-if="product.type === 1">
                {{ purchaseFormData.details.material.name }}
              </span>
              <span
                v-for="(material, index) in product.materials"
                v-if="product.type !== 1">
                <span>{{ material.name }}</span>
                <span v-if="index+1 < product.materials.length">, </span>
              </span>
            </li>
            <li>Размер - <span>{{ product.width }} x {{ product.height }} мм</span></li>
          </ul>
        </div>


        <div class="product-price">
          {{ product.final_price }} <span>EUR</span>
        </div>


      </div>

      <div class="navigation">
        <a
          class="btn btn-outline-green  pull-left"
          @click="purchase(true)">Перейти к покупке</a>
        <a
          class="btn btn-outline-blue spaced-34 pull-left"
          @click="purchase()">Продолжить выбор</a>
        <a
          class="btn btn-outline-gray pull-right"
          @click="hide()">Отмена</a>
      </div>

    </div>

  </section>
</template>

<script>
import ProductPurchaseBase from '../../base/product/ProductPurchaseBase';

export default {
  extends: ProductPurchaseBase,
};
</script>

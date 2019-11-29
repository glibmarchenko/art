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
          class="modal-close-circle btn-icon-close"
          @click="purchase()">
          <img src="/web/images/ui/modal_close.svg">
        </div>
        <div class="product-description">
          <div class="product-type">ПРИНТ</div>
          <div class="product-price">
            {{ product.final_price }} <span>EUR</span>
          </div>
          <div class="product-info">
            <div
              class="product-image"
              :style="{ backgroundImage: 'url(\'' + product.image_preview_m + '\')', backgroundSize: 'contain', backgroundRepeat: 'no-repeat', backgroundPosition: 'center' }"/>

            <div class="product-text">
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
          </div>
        </div>

      </div>

      <div class="navigation">
        <a
          class="btn btn-outline-blue btn-m-89"
          @click="purchase()">Продолжить выбор</a>
        <a
          class="btn btn-outline-green btn-m-89"
          @click="purchase(true)">Перейти к покупке</a>
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

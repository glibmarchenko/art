<template>
  <div
    class="products-group"
    v-if="purchases">
    <div class="heading">
      <h3>{{ trans('pages.order_acc') }} - {{ trans('homepage.Prints') }}</h3>
    </div>
    <div class="separator"/>
    <div
      class="product"
      v-for="(purchase, index) in purchases">
      <div
        class="content"
        v-if="purchase.product.alias_name === 'poster'">
        <div
          class="product-image"
          :style="{ backgroundImage: 'url(\'' + purchase.product.image_preview_m + '\')', backgroundSize: 'contain', backgroundRepeat: 'no-repeat', backgroundPosition: 'center' }"/>
        <div class="product-description">
          <div class="product-type">{{ purchase.product.type_name }}</div>
          <div class="product-author">{{ purchase.product.author.name }}
            {{ purchase.product.author.surname }}
          </div>
          <div class="product-name">{{ purchase.product.name }}</div>
          <ul class="product-details-list">
            <li>{{ trans('pages.Material') }} -
              <span>{{ trans('homepage.Printing') }} {{ trans('homepage.on canvas') }}</span>
            </li>
            <li>{{ trans('pages.Size') }} -
              <span>{{ purchase.product.width }} x {{ purchase.product.height }} {{ trans('dashboard.mm') }}</span>
            </li>
          </ul>
        </div>
        <div class="product-price">
          {{ purchase.price }} <span>EUR</span>
        </div>
        <div class="product-delete">
          <div
            class="product-delete-btn"
            @click="$parent.deletePurchase(purchase)">
            <a href="#"><img src="/web/images/ui/cross.svg"></a>
          </div>
        </div>
      </div>
      <div
        class="separator-small"
        v-if="index !== purchases.length - 1"/>
    </div>
    <div class="separator"/>

    <div class="summary">

      <div class="description-container">
        <div class="description">
          <h2>{{ trans('pages.safe_transactions') }}</h2>
          <p>
            {{ trans('pages.payments_processed') }}<br>
            {{ trans('pages.visa_mc') }}<br>
            {{ trans('pages.security_purchase') }}.
          </p>
        </div>
      </div>

      <div class="summary-container">
        <div class="props">
          <table>
            <tr>
              <td>{{ trans('homepage.Artworks') }}</td>
              <td><span>{{ cartPrintAmount }}</span> EUR</td>
            </tr>
            <tr>
              <td>{{ trans('pages.delivery_hands') }}</td>
              <td><span>{{ printDeliveryAmount() }}</span> EUR</td>
            </tr>
            <tr>
              <td>{{ trans('pages.discount') }}</td>
              <td><span>0</span> EUR</td>
            </tr>
          </table>
        </div>

        <div class="summary">
          <table>
            <tr>
              <td class="regular">{{ trans('pages.total') }}</td>
              <td><span>{{ cartPrintAmount + printDeliveryAmount() }}</span> EUR</td>
            </tr>
          </table>
        </div>
      </div>

    </div>


    <div class="payment-container">
      <div class="ask-question">
        <p>{{ trans('pages.questions') }}:<span> pay@artdiller.com</span></p>
      </div>

      <div class="payment">
        <div class="payment-info">
          <img src="/web/images/ui/visa.svg">
          <img src="/web/images/ui/mastercard.svg">
        </div>
        <div class="payment-info-text">
          <p
            data-dismiss="modal"
            data-toggle="modal"
            data-target="#registration-modal"
            @click="$parent.drawRules()">Terms and Conditions</p>
        </div>
        <div class="payment-btn">
          <div
            class="btn btn-fill-green btn-55"
            @click="$parent.purchasePrintDecta(purchases)"
            :class="{inactive: !$parent.isDeliveryValid}">Pay
          </div>
        </div>

      </div>
    </div>

  </div>
</template>

<script>
  export default {
    name: 'PrintCartBlock',
    props: ['purchases'],
    data() {
      return {
        estimate_print_delivery: 0,
      }
    },
    computed: {
      cartTotalAmount() {
        let sum = 0;
        this.purchases.forEach((purchase) => {
          sum += purchase.product.final_price;
        });
        return sum;
      },

      cartPrintAmount() {
        let sum = 0;
        this.purchases.forEach((purchase) => {
          if (purchase.product.type === 1) {
            sum += purchase.product.final_price;
          }
        });
        return sum;
      },

    },
    methods: {
      printDeliveryAmount() {
        let amount = 0;
        if (this.isDeliveryValid) {
          this.printPurchases.map((purchase) => {
            if (purchase.product.width < 1000 && purchase.product.height < 1000) {
              amount += Number(this.deliverySettings.delivery_per_print_unit_price_small);
              amount += Number(this.deliverySettings.package_per_print_unit_price_small);
            } else {
              amount += Number(this.deliverySettings.delivery_per_print_unit_price_big);
              amount += Number(this.deliverySettings.package_per_print_unit_price_big);
            }
          });
        }
        return amount;
      },
    }
  }
</script>

<template>
  <div>
    <div
      v-for="purchase in purchases"
      v-if="purchase.product.alias_name !== 'poster'"
      class="products-group">
      <div class="heading">
        <h3>{{ trans('pages.order_acc') }} - {{ purchase.product.name }}</h3>
      </div>
      <div class="separator"/>
      <div class="product">
        <div class="content">
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
              <li>{{ trans('pages.Material') }} - <span
                v-for="material in purchase.product.materials">{{ material.name }} </span></li>
              <li>{{ trans('pages.Size') }} -
                <span>{{ purchase.product.width }} x {{ purchase.product.height }} {{ trans('dashboard.mm') }}</span>
              </li>
            </ul>
          </div>
          <div class="product-price">
            {{ purchase.price }} <span>EUR</span>
          </div>
          <div class="product-delete">
            <div class="product-delete-btn">
              <a href="#"><img
                @click="$parent.deletePurchase(purchase)"
                src="/web/images/ui/cross.svg"></a>
            </div>
          </div>
        </div>
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
                <td>{{ trans('pages.Artwork') }}</td>
                <td><span>{{ purchase.product.price }}</span> EUR</td>
              </tr>
              <tr>
                <td>{{ trans('pages.delivery_hands') }}</td>
                <td><span>0</span> EUR</td>
              </tr>
              <tr>
                <td>{{ trans('pages.Tax') }}</td>
                <td><span>0</span> EUR</td>
              </tr>
            </table>
          </div>

          <div class="summary">
            <table>
              <tr>
                <td class="regular">{{ trans('pages.total') }}</td>
                <td><span>{{purchase.product.price}}</span> EUR</td>
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
          <div class="payment-info-text">
            <p
              data-dismiss="modal"
              data-toggle="modal"
              data-target="#registration-modal"
              @click="drawRules()">Terms and Conditions</p>
          </div>
          <div class="payment-info">
            <img src="/web/images/ui/visa.svg">
            <img src="/web/images/ui/mastercard.svg">
          </div>
          <div class="payment-btn">
            <div
              class="btn btn-fill-green btn-55"
              @click="$parent.purchaseNonPrintDecta(purchase)"
              :class="{inactive: !$parent.isDeliveryValid}">Pay
            </div>
          </div>

        </div>
      </div>


    </div>
  </div>
</template>

<script>
  export default {
    name: 'OtherCartBlock',
    props: ['purchases']
  }
</script>

<template>
  <section id="purchase-cart">
    <a
      id="cart-open"
      class="cart-open"
      @click="toggle()">
      <img id="cart-icon" src="/web/images/ui/cart.svg">{{ cartTotalAmount }} <span>EUR</span>

      <div class="menu-trigger second cart-close">
        <span class="line line-1"/>
        <span class="line line-2"/>
        <span class="line line-3"/>
      </div>
    </a>

    <cart-delivery
      :show-delivery="showDelivery"
      @toggleShowDelivery="toggleShowDelivery"
      ref="delivery"/>

    <div id="content-side">

      <div v-if="!purchases.length" class="no-purchases">{{ trans('pages.Cart is empty') }}</div>

      <print-cart-block v-if="printPurchases.length" :purchases="printPurchases"/>

      <other-cart-block :purchases="purchases"/>

    </div>

    <div id="rules"></div>

  </section>
</template>

<script>
  import axios from 'axios';
  import {EventBus} from '../../event-bus';
  import PrintCartBlock from "./components/PrintCartBlock";
  import OtherCartBlock from "./components/OtherCartBlock";
  import CartDelivery from "./components/Delivery";

  export default {
    components: {
      CartDelivery,
      OtherCartBlock,
      PrintCartBlock,
    },
    data() {
      return {
        visible: false,

        filterData: {
          delivery: 1,
        },

        deliveryAmount: 20,

        isDeliveryValid: false,

        purchases: [],
        paymentDetails: {
          purchaseDetails: '12553',
          signature: '123',
        },

        purchaseOptions: {
          print_delivery_regular: 7,
          print_delivery_big: 14,
        },
        deliverySettings: {
          package_per_print_unit_price_small: '9999',
          package_per_print_unit_price_big: '9999',
          delivery_per_print_unit_price_small: '9999',
          delivery_per_print_unit_price_big: '9999',
        },
        showDelivery: false,
      };
    },

    computed: {
      printPurchases() {
        return this.purchases.filter(purchase => purchase.product.type === 1);
      },
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
    created() {
      this.getDeliverySettings();
      this.fetchCart();
      this.trackShowEvent();
    },
    methods: {

      getDeliverySettings() {
        axios.get('/api/settings/delivery').then((res) => {
          this.deliverySettings = res.data;
        });
      },
      fetchCart() {
        axios.get('/api/v1/purchase').then((res) => {
          this.purchases = res.data;
        });
      },
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
      trackShowEvent() {
        const $component = this;
        $artdiller.on('fetch-cart', () => {
          $component.fetchCart();
        });

        $artdiller.on('show-cart', () => {
          $component.show();
        });
      },

      hide() {
        this.$productNavigation = $('#delivery-side');
        this.$productMainFrame = $('#content-side');
        $('#cart-icon').animate({opacity: 1});
        $('.cart-close').removeClass('active opened');
        const scrollTop = parseInt($('#app').css('top'));
        $('#app').removeClass('noscroll');
        window.scrollTo(0, -scrollTop);
        this.$productNavigation.velocity('transition.bounceLeftOut');
        this.$productMainFrame.velocity('transition.bounceRightOut');
        this.visible = false;
      },

      show() {
        this.$productNavigation = $('#delivery-side');
        this.$productMainFrame = $('#content-side');
        $('#cart-icon').animate({opacity: 0});
        $('.cart-close').addClass('active opened');
        const scrollTop = window.pageYOffset;
        $('#app').addClass('noscroll');
        $('#app').css('top', `${-scrollTop}px`);
        this.$productNavigation.velocity('transition.bounceLeftIn');
        this.$productMainFrame.velocity('transition.bounceRightIn');
        this.visible = true;
      },

      toggle() {
        if (this.visible) {
          this.hide();
        } else {
          this.show();
        }
      },

      deletePurchase(purchase) {
        axios.delete(`/api/v1/purchase/${purchase.id}`).then((res) => {
        });

        this.purchases = this.purchases.filter(item => purchase.id !== item.id);
      },

      purchasePrintDecta(purchases) {
        if (!this.isDeliveryValid) {
          EventBus.$emit('dialog-popup', 'cant_submit');
          this.showDelivery = true;
        }
          // EventBus.$emit('dialog-popup', 'purchase_initiated');
        // axios.post('/api/v1/purchase/order/print/create/provider/decta', {purchases}).then((res) => {
        //   window.location.href = res.data;
        // });

          axios.post('/api/v1/purchase/order/print/create/provider/manual', {purchases}).then(res => {
              EventBus.$emit('dialog-popup', 'purchase_initiated');
              this.fetchCart();
          });
      },

      purchaseNonPrintDecta(purchase) {
        if (!this.isDeliveryValid) {
          EventBus.$emit('dialog-popup', 'cant_submit');
          this.showDelivery = true;
          return false;
        }

        if (purchase.product.type !== 1) {
            // axios.post('/api/v1/purchase/order/other/create/provider/decta', {purchase}).then(res => {
            //     EventBus.$emit('dialog-popup', 'purchase_initiated');
            // });

            axios.post('/api/v1/purchase/order/other/create/provider/manual', {purchase}).then(res => {
                EventBus.$emit('dialog-popup', 'purchase_initiated');
                this.fetchCart();
            });
            //
            // EventBus.$emit('dialog-popup', 'purchase_initiated');
        }
      },

      toggleShowDelivery() {
        this.showDelivery = !this.showDelivery;
      },

      drawRules() {
        $('#show-rules').trigger('click');
      },

    },

  };
</script>

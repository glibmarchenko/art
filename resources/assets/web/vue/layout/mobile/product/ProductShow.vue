<template>
  <div class="card-block">
    <section
      class="card-mobile"
      :class="{visible: this.single_product !== false}">
      <v-touch
        @swipeleft="onSwipeLeft"
        @swiperight="onSwipeRight"
        class="card-menu"
        id="card-menu-mobile">
        <buy-block
          :product="product"
          :single_product="single_product"
          @hide="hide"
          @purchase="purchase"/>

        <section class="card-content">
          <transition-group
            :name="transitionName"
            :enter-active-class="enterActiveClass"
            :leave-active-class="leaveActiveClass"
            class="slider-wrapper">
            <section :key="product.id">
              <card-view
                :product="product"
                :single_product="single_product"
                :selected="selected"
                :current_preview="current_preview"
                @setPreview="setPreview"
                @hide="hide()"
                @like="like()"
                @switchPrevProduct="onSwipeRight()"
                @switchNextProduct="onSwipeLeft()"/>

              <buy-block
                :product="product"
                :single_product="single_product"
                :is_center="true"
                @hide="hide"
                @purchase="purchase"/>

              <product-title
                :product_size="product_size"
                :product="product"
                :purchase-form-data="purchaseFormData"/>
              <product-info
                :product="product"
                :product_size="product_size"/>
              <description :product="product"/>
              <key-words :product="product"/>
            </section>
          </transition-group>
        </section>
        <item-colors :product="product"/>
        <author-block :product="product"/>
        <buy-block
          :product="product"
          :single_product="single_product"
          :is_bottom="true"
          @hide="hide"
          @purchase="purchase"/>
      </v-touch>
    </section>
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

  data() {
    return {
      transitionName: 'slideLeft',
      enterClass: 'slideInLeft',
      enterActiveClass: 'slideInRight',
      leaveActiveClass: 'slideOutLeft',
    };
  },

  methods: {
    hide() {
      document.getElementById('card-menu-mobile').scrollTop = 0;
      this.$productMainFrame = $('.card-mobile');
      this.$productMainFrame.velocity('transition.bounceLeftOut');
      const scrollTop = parseInt($('#app').css('top'));
      $('#app').removeClass('noscroll');
      window.scrollTo(0, -scrollTop);
    },

    show(product) {
      console.log('product show object');
      this.product = product;
      this.$productMainFrame = $('.card-mobile');
      const scrollTop = window.pageYOffset;
      $('#app').addClass('noscroll');
      $('#app').css('top', `${-scrollTop}px`);
      this.$productMainFrame.velocity('transition.bounceLeftIn');
    },

    /**
       * Next item
       */
    onSwipeLeft() {
      if (!this.single_product) {
        this.transitionName = 'slideRight';
        this.enterActiveClass = 'slideInRight';
        this.leaveActiveClass = 'slideOutLeft';
        this.$nextTick(() => { this.switchNextProduct(); });

        console.log('switchNextProduct');
      }
    },

    /**
       * Prev item
       */
    onSwipeRight() {
      if (!this.single_product) {
        this.transitionName = 'slideLeft';
        this.enterActiveClass = 'slideInLeft';
        this.leaveActiveClass = 'slideOutRight';
        this.$nextTick(() => { this.switchPrevProduct(); });

        console.log('switchPrevProduct');
      }
    },
  },
};
</script>

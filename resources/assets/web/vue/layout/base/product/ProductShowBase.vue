<template>
    <div class="card-block">
        <div class="check-card">
            <h3 class="title" v-if="product.type === 1">
                {{ trans('pages.Print options') }}
            </h3>
            <h3 class="title" v-if="product.type !== 1">
                {{product.name}}
            </h3>
        </div>
    </div>
    <!--End Card product-->
</template>

<script>
  import ItemColors from '../../../components/products/show/ItemColors';
  import BuyBlock from '../../../components/products/show/BuyBlock';
  import AuthorBlock from '../../../components/products/show/AuthorBlock';
  import ProductTitle from '../../../components/products/show/ProductTitle';
  import Description from '../../../components/products/show/Description';
  import KeyWords from '../../../components/products/show/KeyWords';
  import ProductInfo from '../../../components/products/show/ProductInfo';

  export default {
    components: {
      AuthorBlock,
      ItemColors,
      BuyBlock,
      ProductTitle,
      Description,
      KeyWords,
      ProductInfo,
    },

    data () {
      return {
        current_preview: {},
        selected: undefined,
        purchaseFormData: {
          product_id: 0,
          product_type: 'poster',
          price: 34,
          details: {
            material: {value: 4, name: trans('materials.nat_canvas')},
            size: 0
          },
        },
        material_options: [
          {value: 0, name: trans('materials.paper')},
          {value: 1, name: trans('materials.photo')},
          {value: 2, name: trans('materials.canvas')},
          {value: 4, name: trans('materials.nat_canvas')},
        ],
        $productNavigation: {},
        $productMainFrame: {},
        product: {
          id: '',
          body: '',
          width: '',
          height: '',
          image_preview: '',
          image_preview_s: '',
          image_preview_m: '',
          image_preview_original: '',
          final_price: '',
          price: '',
          description: '',
          name: '',
          materials: [{
            name: ''
          }],
          colors: [{
            hex: ''
          }],
          attachments: [
            {
              path: '',
              name: ''
            }
          ],
          author: {
            name: '',
            surname: '',
            profile_url: ''
          }
        }
      }
    },
    props: {
      single_product: {
        default: false
      }
    },
    computed: {
      product_size () {
        if (this.product.type === 1) {
          return this.product.width + ' x ' + this.product.height + ' ' + trans('dashboard.mm')
        }

        return this.product.width + ' x ' + this.product.height + ' x ' + this.product.depth + ' ' + trans('dashboard.mm')

      }
    },
    created () {
      $artdiller.on('product-overview', function (event) {
        if (event.action == 'show') {
          console.log('display product section')
        }

        if (event.action == 'hide') {
          console.log('hide product section')
        }
      });

      $('.fb-share').click(function (e) {
        e.preventDefault();
        console.log('sharing fb');
        window.open($(this).attr('href'), 'fbShareWindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
        return false
      });

      if (this.single_product !== false) {
        this.show(this.single_product)
      }

      this.current_preview = this.product.image_preview_m

    },
    mounted () {
      this.$parent.$on('onProductSelect', function (product) {
      });

      this.current_preview = this.product.image_preview_m
    },

    methods: {
      hide: function () {
        this.$productNavigation = $('#card-menu');
        this.$productMainFrame = $('#card-view');
        this.$productNavigation.velocity('transition.bounceLeftOut');
        this.$productMainFrame.velocity('transition.bounceRightOut')

      },

      show: function (product) {
        this.product = product;
        this.$productNavigation = $('#card-menu');
        this.$productMainFrame = $('#card-view');
        this.$productNavigation.velocity('transition.bounceLeftIn');
        this.$productMainFrame.velocity('transition.bounceRightIn')

      },

      setPreview: function (id = null, imagePath = null) {
        if (!imagePath) {
          imagePath = this.product.image_preview_m
        }
        this.selected = id;
        this.current_preview = imagePath
      },

      imageFadeout: function () {
        $('#zoom-image').velocity('transition.fadeIn')
      },

      like: function () {
        if (window.Utility.authCheck()) {
          axios.post('/api/v1/like/poster/' + this.product.id).then((res) => {
            this.product.isLikedByAuthUser = res.data
          })
        }
      },

      purchase () {
        if (window.Utility.authCheck()) {
          this.$parent.onProductPurchase(this.product, this.purchaseFormData)
        }
      },

      switchNextProduct () {
        this.product = this.$parent.getNextProduct(this.product)
      },

      switchPrevProduct () {
        this.product = this.$parent.getPrevProduct(this.product)
      },

      setMetatags () {
        let metatags = [
          {
            name: 'url',
            value: '/product/' + this.product.id,
          },
          {
            name: 'type',
            value: 'website'
          },
          {
            name: 'title',
            value: this.product.name
          },
          {
            name: 'description',
            value: this.product.description
          },
          {
            name: 'image',
            value: this.product.image_preview_m
          }
        ];
        $artdiller.trigger('metatags-set', [metatags])
      }

    },
    watch: {
      product: function (value) {
        if (typeof value !== 'undefined') {
          window.history.pushState({}, value.name, '/product/' + value.id);
          this.current_preview = value.image_preview_m;
          this.setMetatags()
        }
      }
    }
  }

</script>

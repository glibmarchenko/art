<template>
    <div>
        <product-filter
                :product_type="product_type"
                v-if="hasfilter && !single_product"/>

        <print-list
                :list="paginatedProducts.data"
                :author="author"
                v-if="!single_product"
                :product_type="product_type"
                :no-filter-layout="nofilterlayout"/>

        <product-show-mobile
                ref="productShow"
                :single_product="single_product"
                v-if="$root.is_mobile"/>

        <product-show
                ref="productShow"
                :single_product="single_product"
                v-else/>

        <product-purchase-mobile
                ref="productPurchase"
                v-if="$root.is_mobile"/>

        <product-purchase
                ref="productPurchase"
                v-else/>
    </div>
</template>

<script>
    import ProductShow from './desktop/product/ProductShow'
    import PrintList from '../components/products/listing/PrintList'
    import ProductFilter from '../components/products/listing/ProductFilter'
    import ProductPurchase from './desktop/product/ProductPurchase'

    import ProductShowMobile from './mobile/product/ProductShow'
    import ProductPurchaseMobile from './mobile/product/ProductPurchase'


    export default {
        components: {
            ProductFilter,
            PrintList,
            ProductShow,
            ProductShowMobile,
            ProductPurchase,
            ProductPurchaseMobile,
        },

        props: {
            products: {
                type: Array
            },
            product_type: {
                type: Number,
                default: 1
            },
            hasfilter: {
                default: true,
                type: Boolean
            },
            nofilterlayout: {
                default: false,
                type: Boolean
            },
            author: {},
            single_product: {
                default: false
            }
        },

        data() {
            return {
                list: [],
                paginatedProducts: {},
                currentProductId: '',
                selectedFilters: null
            }
        },

        methods: {
            onFilterUpdate(data, $page = 1) {
                if (data) {
                    this.selectedFilters = data;
                }
                axios.post('/api/product/' + this.product_type + '/filter?page=' + $page, data)
                    .then((res) => {
                        this.filters = res.data;
                        this.paginatedProducts = res.data.data
                    }).catch((err) => console.error(err)
                )
            },

            onProductSelect(product) {
                console.log('on product select container event')
                this.$refs.productShow.show(product)
            },

            onProductPurchase(product, purchaseFormData) {
                console.log('on product purchase')
                this.$refs.productPurchase.onProductPurchase(product, purchaseFormData)
            },

            getResults: function (page = 1) {
                this.onFilterUpdate(null, page)
            },

            getNextProduct(product) {
                if (this.$root.is_mobile) {
                    document.getElementById('card-menu-mobile').scrollTop = 0
                }
                let element = this.paginatedProducts.indexOf(product) + 1
                if (element >= this.paginatedProducts.length) {
                    element = 0
                }
                return this.paginatedProducts[element]
            },

            getPrevProduct(product) {
                if (this.$root.is_mobile) {
                    document.getElementById('card-menu-mobile').scrollTop = 0
                }
                let element = this.paginatedProducts.indexOf(product) - 1
                if (element < 0) {
                    element = this.paginatedProducts.length - 1
                }
                console.log(element)
                return this.paginatedProducts[element]
            }

        },


    }
</script>

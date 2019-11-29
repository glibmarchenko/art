<script>

    export default {
        data() {
            return {
                product: {
                    id: '',
                    body: '',
                    width: '',
                    height: '',
                    image_preview: '',
                    image_preview_s: '',
                    image_preview_m: '',
                    price: '',
                    description: '',
                    name: '',
                    materials: [{
                        name: ''
                    }],
                    colors: [{
                        hex: ''
                    }],
                    author: {
                        name: '',
                        surname: '',
                        profileURL: ''
                    }
                },
                purchaseFormData: {
                    product_id: 0,
                    product_type: 'poster',
                    price: 34,
                    details: {
                        material: {
                            name: '',
                            value: ''
                        },
                        size: ''
                    },
                },
                material_options: [
                    {value: 0, text: 'Бумага'},
                    {value: 1, text: 'Фотобумага'},
                    {value: 2, text: 'Холст'},
                ],
            }
        },
        created() {

        },
        methods: {
            onFilterUpdate(data) {

            },
            onProductPurchase(product, purchaseFormData) {
                this.product = product
                this.purchaseFormData = purchaseFormData
                this.purchaseFormData.product_id = this.product.id
                this.purchaseFormData.product_type = this.product.type
                console.log('here')
                console.log(this.product)
                this.show()
            },

            show() {
                console.log('display purchase window')
                let $section = $('#purchase-product')
                $section.velocity('transition.fadeIn')
            },

            hide() {
                let $section = $('#purchase-product')
                $section.velocity('transition.fadeOut')
            },

            purchase(showCart) {
                axios.post('/api/v1/purchase/', this.purchaseFormData).then((res) => {
                    $artdiller.trigger('fetch-cart')
                })

                console.log(this.purchaseFormData.details)

                this.hide()

                if (showCart) {
                    console.log('trigger show cart')
                    $artdiller.trigger('show-cart')
                }
                console.log('trigger fetch cart')
            }

        }
    }
</script>

<template>
    <section id="purchase-product">
        
        <div id="product-purchase-container" @click.self="hide">
            
            <div class="content">
                <div class="product-image" :style="{ backgroundImage: 'url(\'' + product.image_preview_m + '\')', backgroundSize: 'contain', backgroundRepeat: 'no-repeat', backgroundPosition: 'center' }">
                    
                </div>
                
                <div class="product-description">
                    <div class="product-type">ПРИНТ</div>
                    <div class="product-author">{{product.author.name}} {{product.author.surname}}</div>
                    <div class="product-name">{{product.name}}</div>
                    
                    <ul class="product-details-list">
                        <li>Материал - <span>{{purchaseFormData.details.material.name}}</span></li>
                        <li>Размер - <span>{{product.width}} x {{product.height}} мм</span></li>
                    </ul>
                </div>
                
                
                <div class="product-price">
                    {{product.final_price}} <span>EUR</span>
                </div>
      
                
            </div>
            
            <div class="navigation">
                <a class="btn btn-outline-green  pull-left" v-on:click="purchase(true)">{{ trans('pages.Go to purchase')
                    }}</a>
                <a class="btn btn-outline-blue spaced-34 pull-left" v-on:click="purchase()">{{ trans('pages.Continue
                    selection') }}</a>
                <a class="btn btn-outline-gray pull-right" v-on:click="hide()">{{ trans('dashboard.Cancel') }}</a>
            </div>
            
        </div>
        
    </section>
</template>


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
                    details : {
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
            };
        },
        created() {
      
        },
        methods: {
            onFilterUpdate(data) {
        
            },
            onProductPurchase(product, purchaseFormData) {
            this.product = product;
            this.purchaseFormData = purchaseFormData;
            this.purchaseFormData.product_id = this.product.id;
            this.show();
            },
           
            show() {
                console.log('display purchase window');
                let $section = $('#purchase-product');
                $section.velocity('transition.fadeIn');
            },
            
            hide() {
                let $section = $('#purchase-product');
                $section.velocity('transition.fadeOut');
            },
            
            purchase(showCart) {
                axios.post('/api/v1/purchase/',this.purchaseFormData).then((res) => {
                    $artdiller.trigger('fetch-cart');
                });
                
                this.hide();
                
                if(showCart) {
                    console.log('trigger show cart');
                    $artdiller.trigger('show-cart');
                }
                console.log('trigger fetch cart');
            }

        }
    }
</script>
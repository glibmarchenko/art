<template>
    <section
            id="main-content" ref="container"
            :class="{ noFilterLayout: noFilterLayout }">

        <section
                class="main-content-heading top-sp-68x2"
                v-if="product_section_name">
            <h1>{{ products[product_section_name].name }}</h1>
            <h2 class="sub_title">{{ products[product_section_name].description }}</h2>
        </section>

        <section
                class="main-content-heading"
                v-if="author">
            <h1>{{ author.nickname }}</h1>
        </section>

        <div class="wrapper">
            <div class="container" id="columns" v-masonry transition-duration="0" stagger="0.07s" item-selector=".pic-content-block">
                <div v-masonry-tile class="pic-content-block" v-for="(poster, index) in list" :key="index"
                     @click="onProductSelect(poster)" :id="poster.id">
                    <a class="product-overview" data-type="poster" :data-target="poster.id">
                        <figure>
                            <img class="pic-image" :src="poster.image_preview_s">
                        </figure>
                    </a>
                    <div class="pic-description-container">
                        <h2 class="pic-author"><a :href="poster.author.profile_url">{{ poster.author.nickname }}</a>
                        </h2>
                        <h3 class="pic-name">{{ poster.name }}</h3>
                        <p
                                class="pic-size"
                                v-if="poster.type < 3">{{ poster.width }} x {{ poster.height }} {{
                            trans('dashboard.mm') }}</p>
                        <p class="pic-size" v-if="poster.type  === 3">{{poster.width}} x {{poster.height}} x
                            {{poster.depth}} {{ trans('dashboard.mm') }} , {{ poster.weight }} {{ trans('dashboard.kg')
                            }}</p>
                        <hr>
                        <p class="pic-type" v-if="poster.type !== 1" :class="['obj-' + poster.type]">{{ poster.type_name
                            }}</p>
                        <p class="pic-type" v-if="poster.type === 1" :class="['obj-' + poster.type]">{{
                            trans('homepage.Printing') }} <span>{{ trans('homepage.on canvas') }}</span></p>
                        <a class="pic-price" v-if="poster.for_sale && poster.status_id >= 3">{{ poster.final_price }}
                            <span class="small">EUR</span></a>
                        <a class="sold" v-if="poster.sold && poster.status_id >= 3">{{trans('pages.sold')}}</a>
                        <a class="sold" v-if="!poster.for_sale && !poster.sold && poster.status_id >= 3">{{trans('pages.not_for_sale')}}</a>
                        <a class="sold" v-if="poster.status_id <= 2">{{trans('pages.'+poster.status)}}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="pagination-container">

            <pagination :data="pagination"
                        :limit="4"
                        @pagination-change-page="getResults">
                <span slot="prev-nav"><img src="/images/left.svg"/></span>
                <span slot="next-nav"><img src="/images/right.svg"/></span>
            </pagination>
        </div>
    </section>
</template>


<script>
    import Pagination from 'laravel-vue-pagination'
    import {EventBus} from "../../../event-bus";

    export default {

        components: {
            Pagination
        },

        data() {
            return {
                products: {
                    poster: {
                        name: trans('homepage.Prints'),
                        description: trans('pages.print_any'),
                    },
                    picture: {
                        name: trans('homepage.Paintings'),
                        description: trans('pages.paintings_buy'),
                    },
                    object: {
                        name: trans('homepage.Designs'),
                        description: trans('pages.design_buy'),
                    },
                    liked: {
                        name: trans('account.Favorite'),
                        description: trans('dashboard.works_liked'),
                    },
                    gallery: {
                        name: trans('pages.artworks'),
                        description: trans('pages.artworks_buy'),
                    },
                },
                poster: {
                    id: '',
                    body: '',
                    width: '',
                    height: '',
                    image_preview: '',
                    price: '',
                    type_name: '',
                    name: '',
                    author: {
                        name: '',
                        surname: '',
                        profileURL: ''
                    }
                }
            };
        },
        methods: {
            getResults: function (page = 1) {
                this.$refs.container.scrollTop = 0;
                console.log(this.$refs.container.scrollTop);
                this.$parent.onFilterUpdate(null, page)
            },
            onProductSelect(poster) {
                this.$parent.onProductSelect(poster);
            },
            redirectTo: function (url) {
                // return window.location.href = url;
            },
            redraw: function() {
                let component = this;
                component.$redrawVueMasonry();
                this.$nextTick(function () {
                    setTimeout(() => component.$redrawVueMasonry(), 600);
                });
                this.$nextTick(function () {
                    setTimeout(() => component.$redrawVueMasonry(), 800);
                });
            }
        },
        created() {
            this.$nextTick(function () {
                this.redraw();
            });

            EventBus.$on('products-redraw',function() {
                console.log('redraw');
                this.redraw();
            })
        },
        watch: {
            list:  {
                handler: function (newVal, oldVal) { // watch it
                    this.$nextTick(function () {
                        console.log('redraw list deep');
                        this.redraw();
                    });
                },
                deep: true
            }
        },
        computed: {
            product_section_name: function () {
                if (window.location.href.indexOf('poster') > -1) {
                    return 'poster'
                }
                if (window.location.href.indexOf('picture') > -1) {
                    return 'picture'
                }
                if (window.location.href.indexOf('object') > -1) {
                    return 'object'
                }
                if (window.location.href.indexOf('liked') > -1) {
                    return 'liked'
                }
                if (window.location.href.indexOf('gallery') > -1) {
                    return 'gallery'
                }
            }
        },
        props: ['list', 'noFilterLayout', 'product_type', 'author', 'pagination'],
    }
</script>

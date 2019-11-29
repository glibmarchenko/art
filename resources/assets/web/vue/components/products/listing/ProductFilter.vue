<template>
    <section id="sub-nav-section" class="filter-section">
        <nav class="">

            <ul class="inline">
                <li>
                    <model-select
                            :options="favorite_options"
                            v-model="filterData.favorite"
                            track-by="name"
                            label="name"
                            :show-labels="false"
                            placeholder="Все работы"
                    />
                </li>
                <li id="category">
                    <model-select
                            :options="category_options"
                            v-model="filterData.style"
                            track-by="name"
                            label="name"
                            :show-labels="false"
                            placeholder="Все категории"
                    />
                </li>
                <li v-if="product_type !== 3">
                    <model-select
                            :options="orient_options"
                            v-model="filterData.orientation"
                            track-by="name"
                            label="name"
                            :show-labels="false"
                            placeholder="Все ориентации"
                    />
                </li>
                <li>
                    <model-select
                            :options="size_options"
                            v-model="filterData.size"
                            track-by="name"
                            label="name"
                            :show-labels="false"
                            placeholder="Все размеры"
                    />
                </li>
                <li  v-if="product_type !== 1">
                    <model-select
                            :options="material_options"
                            v-model="filterData.material"
                            track-by="name"
                            label="name"
                            :show-labels="false"
                            placeholder="Все материалы"
                    />
                </li>
                <li>
                    <model-select
                            :options="price_options[product_type]"
                            v-model="filterData.price"
                            track-by="name"
                            label="name"
                            :show-labels="false"
                            placeholder="Все цены"
                    />
                </li>
                <li>
                    <color-pick-slider v-if="displayColor" @onColorSelect="setColor(value)"/>
                </li>
            </ul>

            <a href="#" class="reset-filter" v-if="isResetButtonVisible" v-on:click="resetFilters()">{{
                trans('pages.Reset') }}</a>

        </nav>
    </section>
</template>


<script>
  import axios from 'axios'

  export default {
        data() {
            return {
                displayColor: false,
                filterData: {
                    type: 1, // 0 - picture 1 - poster
                  favorite: {value: 1, name: trans('pages.Favorites')},
                  style: {value: 999, name: trans('pages.All categories')},
                  orientation: {value: 999, name: trans('pages.All orientations')},
                  price: {value: 999, name: trans('pages.All prices')},
                  material: {value: 999, name: trans('pages.All materials')},
                  size: {value: 999, name: trans('pages.All sizes')},
                    color: 'rgb(255, 255, 255)', // RGB color
                    json: 1
                },
                defaultFilters: {
                    type: 1, // 0 - picture 1 - poster
                  favorite: {value: 1, name: trans('pages.Favorites')},
                  style: {value: 999, name: trans('pages.All categories')},
                  orientation: {value: 999, name: trans('pages.All orientations')},
                  price: {value: 999, name: trans('pages.All prices')},
                  material: {value: 999, name: trans('pages.All materials')},
                  size: {value: 999, name: trans('pages.All sizes')},
                    color: 'rgb(255, 255, 255)', // RGB color
                    json: 1
                },
                value: '',
                favorite_options: [
                  {value: 999, name: trans('homepage.All artworks')},
                  {value: 1, name: trans('pages.Favorites')}
                ],
                orient_options: [
                  {value: 999, name: trans('pages.All orientations')},
                  {value: 'vertikalno', name: trans('category_types.names.portraiture')},
                  {value: 'gorizontalno', name: trans('category_types.names.landscape')},
                  {value: 'kvadrat', name: trans('pages.Square')},
                ],
                size_options: [
                  {value: 999, name: trans('pages.All sizes')},
                  {value: 's', name: 'S - ' + trans('pages.from') + ' 50 см'},
                  {
                    value: 'm',
                    name: 'M - ' + trans('pages.from') + ' 50 ' + trans('pages.to') + ' 95 ' + trans('pages.cm')
                  },
                  {
                    value: 'l',
                    name: 'L - ' + trans('pages.from') + ' 95 ' + trans('pages.to') + ' 150 ' + trans('pages.cm')
                  },
                  {value: 'xl', name: 'XL - ' + trans('pages.more') + ' 150 ' + trans('pages.cm')},
                ],
              category_options: [{value: 999, name: trans('pages.All categories')}],
              material_options: [{value: 999, name: trans('pages.All materials')}],
                price_options: {
                    1: [
                      {value: 999, name: trans('pages.All prices')},
                      {value: '1-50', name: trans('pages.cap_to') + ' 50 eur'},
                        {value: '50-100', name: '50 eur - 100 eur'},
                      {value: '100-9999', name: trans('pages.cap_from') + ' 100 eur'},
                    ],

                    2: [
                      {value: 999, name: trans('pages.All prices')},
                      {value: '1-500', name: trans('pages.cap_to') + ' 500 eur'},
                        {value: '500-1000', name: '500 eur - 1 000 eur'},
                        {value: '1000-2000', name: '1 000 eur - 2 000 eur'},
                        {value: '2000-5000', name: '2 000 eur - 5 000 eur'},
                        {value: '5000-10000', name: '5 000 eur - 10 000 eur'},
                      {value: '10000-99999', name: trans('pages.cap_from') + ' 10 000 eur'},
                    ],
                    3: [
                      {value: 999, name: trans('pages.All prices')},
                      {value: '1-50', name: trans('pages.cap_to') + ' 50 eur'},
                        {value: '50-100', name: '50 eur - 100 eur'},
                        {value: '100-500', name: '100 eur - 500 eur'},
                        {value: '500-1000', name: '500 eur - 1 000 eur'},
                        {value: '1000-2000', name: '1 000 eur - 2 000 eur'},
                      {value: '2000-9999', name: trans('pages.cap_from') + ' 2 000 eur'},

                    ]
                },
                isResetButtonVisible: false,
                loadedCategory: false,
            };
        },
        props: {
            product_type: {
                type: Number,
                default: 1
            }
        },
        created() {

            if (window.location.href.indexOf('category') > -1) {
                    this.loadedCategory = window.location.pathname.split("/").pop();
            }
            this.fetchCategories();
            this.fetchMaterials();
        },
        methods: {
            setColor: function (value) {
                this.filterData.color = value;
            },
            fetchCategories() {
                let that = this;
                axios.get('/categories/'+this.product_type).then((res) => {
                    this.category_options = this.category_options.concat(res.data);
                    if(this.loadedCategory) {
                        let category = this.category_options.filter(function(category){
                            return category.value == that.loadedCategory;
                        });
                        this.filterData.style = category[0];
                    }
                });
            },
            fetchMaterials() {
                axios.get('/materials/'+this.product_type).then((res) => {
                    this.material_options = this.material_options.concat(res.data)
                });
            },
            resetFilters() {
                Object.assign(this.filterData, this.defaultFilters);
                this.$nextTick(function () {
                    this.isResetButtonVisible = false;
                });
            },
            isDefaultFilters() {
                return (JSON.stringify(this.filterData) === JSON.stringify(this.defaultFilters))
            },
            checkResetFiltersButton() {
                if (!this.isDefaultFilters()) {
                    this.isResetButtonVisible = true;
                }
            }
        },
        watch: {
            filterData: {
                handler: function (value) { // watch it
                    this.checkResetFiltersButton();
                    this.$parent.onFilterUpdate(value);
                },
                deep: 1
            },
        }
    }
</script>

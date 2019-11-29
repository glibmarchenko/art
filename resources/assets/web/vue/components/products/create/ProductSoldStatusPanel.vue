<template>
    <div class="form-row row-with-check-btns picture-status">
        <div
                data-type="status"
                data-val="0"
                class="btn btn-large btn-outline-gray btn-m-89"
                @click="setForSale"
                :class="{ active: isForSale }">
            {{ trans('dashboard.Selling') }}
        </div>
        <div
                data-type="status"
                data-val="1"
                class="btn btn-large btn-outline-gray btn-m-89"
                @click="setNotForSale"
                :class="{ active: isNotForSale }">
            {{ trans('dashboard.Not for sale') }}
        </div>

        <div
                data-type="status"
                data-val="1"
                class="btn btn-large btn-outline-gray btn-m-89"
                @click="setSold"
                :class="{ active: isSold }">
            {{ trans('dashboard.Sold') }}
        </div>
        <input
                type="hidden"
                name="for_sale"
                :value="forSaleNumber">
        <input
                type="hidden"
                name="sold"
                :value="soldNumber">
    </div>
</template>


<script>
    export default {
        props: ['forsale', 'sold'],
        data() {
            return {
                isForSale: Boolean,
                isNotForSale: Boolean,
                isSold: Boolean
            };

        },
        mounted() {
            this.isForSale = !!+this.forsale;
            this.isNotForSale = !+this.forsale;
            this.isSold = !!+this.sold;
        },
        methods: {
            setForSale: function () {
                console.log('forsale');
                this.isForSale = true;
                this.isNotForSale = false;
                this.isSold = false;
            },
            setNotForSale: function () {
                console.log('forsale');
                this.isForSale = false;
                this.isNotForSale = true;
                this.isSold = false;
            },
            setSold: function () {
                console.log('forsale');
                this.isForSale = false;
                this.isNotForSale = false;
                this.isSold = true;
            }
        },
        computed: {
            forSaleNumber: function () {
                return Number(this.isForSale)
            },
            soldNumber: function () {
                return Number(this.isSold)
            }
        },
        watch: {
            forSaleNumber: function (value) {
                this.$parent.product.for_sale = value;
            },
            soldNumber: function (value) {
                this.$parent.product.sold = value;
            }
        }

    }
</script>
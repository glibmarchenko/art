<template>
    <div class="buy-block">
        <div class="price count-subscribers">{{amount}}</div>

        <div class="btn-buy">
            <a href="#" class="btn btn-55 btn-outline-green subscribe-now" v-on:click="subscribe" v-if="!liked">
                {{ trans('dashboard.Subscribe') }}
            </a>
            <a href="#" class="btn btn-55 btn-outline-gray subscribe-now" v-on:click="unsubscribe" v-if="liked">
                {{ trans('dashboard.Unsubscribe') }}
            </a>
        </div>
    </div>
</template>

<script>
  import axios from 'axios'

  export default {
        data() {
            return {
                list: [],
                currentProductId: '',
                liked: 0,
                amount: 0
            };
        },
        created() {
          this.liked = this.is_liked;
          this.amount = this.likes_amount;
        },
        methods: {
            subscribe: function(e) {
              e.preventDefault()
                if (window.Utility.authCheck()) {
                    axios.post('/subscribe/' + this.author_id).then((res) => {
                        this.liked = !this.liked;
                        this.amount = res.data.count;
                    });
                }
            },
            unsubscribe: function(e) {
              e.preventDefault()
                if (window.Utility.authCheck()) {
                    axios.post('/subscribe/' + this.author_id).then((res) => {
                        this.liked = !this.liked;
                        this.amount = res.data.count;
                    });
                }
            }
        }
        ,
        props: {
            likes_amount: {
                type: Number,
                default: 0
            },
            is_liked: {
                default: false
            },
            author_id: {
                type: Number
            }
        },
    }
</script>

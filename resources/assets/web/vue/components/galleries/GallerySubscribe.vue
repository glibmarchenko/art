<template>
    <span>
        <a href="#" class="btn btn-outline-black btn-large" v-if="!is_subscribed" @click.prevent="subscribe">
            {{ trans('dashboard.Subscribe') }}
        </a>

        <a href="#" class="btn btn-outline-transparent btn-large" v-if="is_subscribed" @click.prevent="unsubscribe">
            {{ trans('dashboard.Unsubscribe') }}
        </a>
    </span>
</template>

<script>
    export default {
        methods: {
            subscribe () {
                if (window.Utility.authCheck()) {
                    axios.post('/subscribe/' + this.gallery_id).then((res) => {
                        this.is_subscribed = !this.is_subscribed;
                    });
                }
            },

            unsubscribe () {
                if (window.Utility.authCheck()) {
                    axios.post('/subscribe/' + this.gallery_id).then((res) => {
                        this.is_subscribed = !this.is_subscribed;
                    });
                }
            }
        },

      props: ['is_subscribed', 'gallery_id'],
    }
</script>
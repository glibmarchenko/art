<template>
  <div
          class="author-block header"
    v-if="product && product.author">
    <figure>
      <img :src="product.author.avatar_link">
    </figure>
    <div class="about-user">
      <h5>
        <a
          class="caps"
          :href="product.author.profile_url">
          {{ product.author.nickname }}
        </a>
      </h5>
      <p>{{ product.author.country }}</p>
    </div>
    <div class="button">
      <a
              :href="product.author.profile_url"
        class="btn btn-d-34 btn-m-89 btn-fill-blue">{{ trans('account.Profile')
                }}</a>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      product: {
        type: Object,
      },
    },
  }
</script>

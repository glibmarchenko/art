<template>
    <div class="description">
        <h6 v-if="product.type === 1">{{product.name}}</h6>
        <p>
            {{product.description}}
        </p>
    </div>
</template>

<script>
  export default {
    props: ['product'],
  }
</script>
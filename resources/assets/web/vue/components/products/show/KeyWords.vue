<template>
    <div class="key-words">
        <ul>
            <li v-for="tag in product.tags" :key="tag.id">
                <a href="#" class="btn btn-regular btn-m-89">{{tag.name}}</a>
            </li>
        </ul>
    </div>
</template>

<script>
  export default {
    props: ['product'],
  }
</script>

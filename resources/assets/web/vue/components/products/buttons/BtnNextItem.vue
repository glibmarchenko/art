<template>
  <div
    class="card-icon show-next-prev-item btn-next-item"
    @click="$emit('switchNextProduct')">
    <img
      class="i-original"
      :src="'/web/images/ui/card/i-go-right.svg'">
    <img
      class="i-hover"
      :src="'/web/images/ui/card/i-go-right-hover.svg'">
  </div>
</template>
<template>
  <div
    class="card-icon no-margin-bottom show-next-prev-item btn-prev-item"
    @click="$emit('switchPrevProduct')">
    <img
      class="i-original"
      :src="'/web/images/ui/card/i-go-left.svg'">
    <img
      class="i-hover"
      :src="'/web/images/ui/card/i-go-left-hover.svg'">
  </div>
</template>
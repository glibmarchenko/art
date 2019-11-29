<template>
    <div class="item-colors">
        <div v-for="color in product.colors" v-bind:style="'background-color:'+color.hex"
             v-bind:class="[(color.hex==='#ffffff') ? 'bordered' : '']"></div>
    </div>
</template>

<script>
  export default {
    props: {
      product: {
        type: Object,
        default: {
          colors: [
            {
              'id': 8468,
              'user_id': 183,
              'item_type': 'poster',
              'item_id': 407,
              'h': 0,
              's': 0,
              'l': 100,
              'hex': '#ffffff',
              'created_at': null,
              'updated_at': null
            },
            {
              'id': 8469,
              'user_id': 183,
              'item_type': 'poster',
              'item_id': 407,
              'h': 0,
              's': 0,
              'l': 60,
              'hex': '#999999',
              'created_at': null,
              'updated_at': null
            },
            {
              'id': 8470,
              'user_id': 183,
              'item_type': 'poster',
              'item_id': 407,
              'h': 0,
              's': 0,
              'l': 80,
              'hex': '#cccccc',
              'created_at': null,
              'updated_at': null
            },
            {
              'id': 8471,
              'user_id': 183,
              'item_type': 'poster',
              'item_id': 407,
              'h': 30,
              's': 50,
              'l': 40,
              'hex': '#996633',
              'created_at': null,
              'updated_at': null
            },
            {
              'id': 8472,
              'user_id': 183,
              'item_type': 'poster',
              'item_id': 407,
              'h': 243,
              's': 12,
              'l': 29,
              'hex': '#424153',
              'created_at': null,
              'updated_at': null
            },
            {
              'id': 8473,
              'user_id': 183,
              'item_type': 'poster',
              'item_id': 407,
              'h': 43,
              's': 53,
              'l': 80,
              'hex': '#e7d8b1',
              'created_at': null,
              'updated_at': null
            },
            {
              'id': 8474,
              'user_id': 183,
              'item_type': 'poster',
              'item_id': 407,
              'h': 218,
              's': 39,
              'l': 76,
              'hex': '#abbcda',
              'created_at': null,
              'updated_at': null
            }
          ]
        }
      }
    }
  }
</script>
<template>
    <div class="language" @click="showList = !showList" v-click-outside="close">
        <span>{{ $store.state.lang.toUpperCase() }}</span>
        <ul v-show="showList">
            <li v-for="lang in locales" :key="lang" :class="{'active':lang === $store.state.lang}">
                <a :href="'/lang/'+lang" @click="selectLang($event, lang)">{{ lang.toUpperCase() }}</a>
            </li>
        </ul>
    </div>
</template>

<script>
  import vClickOutside from 'v-click-outside'

  export default {
    directives: {
      clickOutside: vClickOutside.directive
    },

    data () {
      return {
        showList: false
      }
    },

    computed: {
      locales(){
        let list = [
          'ru',
          'en'
        ]
        list.splice(list.indexOf(this.$store.state.lang),1)
        list.unshift(this.$store.state.lang)

        return list
      }
    },

    methods: {
      selectLang (event, lang) {
        if(lang === this.$store.state.lang){
          event.preventDefault()
        } else {
          this.$store.commit('updateLang', lang)
          // this.showList = false
        }
      },

      close () {
        this.showList = false
      }
    }
  }
</script>

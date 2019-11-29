import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

const storeOptions = {
  // https://vuex.vuejs.org/zh-cn/state.html
  state: {
    lang: document.documentElement.lang
  },
  // actions: {},
  // getters: {},
  mutations: {
    updateLang (state, lang) {
      lang = lang ? lang : (this.state.lang ? this.state.lang : navigator.language || navigator.userLanguage)

      this.state.lang = lang
      document.documentElement.lang = lang
      // window.moment.locale(lang)

      if (this.state.user) {
        this.state.user.locale = lang;
      }


      // window.axios.get('/lang/' + lang).then(r => {}).catch(error => {})
    }
  },
  modules: {},
  plugins: [
    createPersistedState(),
  ]
}

/* eslint-disable no-new */
const store = new Vuex.Store(storeOptions)

export default store

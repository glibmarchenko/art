import { VueMasonryPlugin } from 'vue-masonry'

import Vue from 'vue'
import VeeValidate from 'vee-validate'
import VueTouch from 'vue-touch'
import { Multiselect } from './components/assets/vue-multiselect'
import { getProp } from './helpers'

import store from './store'
import LanguageBlock from './components/header/LanguageBlock.vue'

import SettingsEditGallery from './layout/base/settings/EditGallery.vue';
import SettingsGallery from './layout/base/settings/Gallery.vue';

require('./bootstrap');

window.Vue = Vue;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

if (store.state.user && store.state.user.locale) {
  document.documentElement.lang = store.state.user.locale;
}

store.commit('updateLang');

window.trans = Vue.prototype.trans = (string, args) => {
  let value = getProp(require('./lang.json')[store.state.lang], string);

  if (args) {
    Object.entries(args).forEach(([paramKey, paramVal]) => {
      value = value.replace(`:${paramKey}`, paramVal);
    });
  }

  return value || string;
};

window.axios.interceptors.response.use((response) => {
  if (window.phpdebugbar) {
    phpdebugbar.ajaxHandler.handle(response.request);
  }
  return response;
});

Vue.use(VueMasonryPlugin);

// TODO: Remove all Vue.component instances
// Vue.component('model-select', require('./components/assets/vue-multiselect/src/Multiselect'));
Vue.component('model-select', Multiselect);

Vue.component('picture-input', require('./components/assets/PictureInput.vue'));

Vue.use(VeeValidate);
Vue.component('notifications', require('./components/notifications/Notifications.vue'));
Vue.component('dialog-box', require('./components/notifications/DialogBox.vue'));

Vue.component('product-list-container', require('./components/products/listing/ProductListContainer.vue'));

Vue.component('create-product-form', require('./components/products/create/CreateProductForm.vue'));
Vue.component('avatar-preview-upload', require('./components/products/create/AvatarPreviewUpload.vue'));

Vue.component('purchase-cart', require('./components/cart/PurchaseCart.vue'));
Vue.component('product-sold-status-panel', require('./components/products/create/ProductSoldStatusPanel.vue'));

Vue.component('author-subscribe', require('./components/authors/AuthorSubscribe.vue'));

Vue.component('gallery-subscribe', require('./components/galleries/GallerySubscribe.vue'));

Vue.component('zoomable', require('./components/products/show/Zoomable.vue'));

Vue.component('upload-pic-form', require('./components/assets/UploadPicForm.vue'));
Vue.component('upload-images', require('./components/assets/UploadImageGroup.vue'));
Vue.component('picture-upload-crop', require('./components/assets/PictureUploadCrop.vue'));

export const EventBus = new Vue();

Vue.use(VueTouch, {
  name: 'v-touch',
  direction: 'horizontal',
});
VueTouch.config.swipe = {
  direction: 'horizontal',
};

const app = new Vue({
  el: '#app',
  store,
  data() {
    return {
      is_mobile: window.is_mobile,
    };
  },
  components: {
    LanguageBlock,
    SettingsEditGallery,
    SettingsGallery,
  },
});

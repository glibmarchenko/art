<template>
  <section class="settings-block">
    <!-- Settings menu -->
    <h1 class="title">
      Редактирование профиля
    </h1>

    <div class="settings-avatar avatar-preview avatar-preview-xs gallery-bg">
      <img
        id="avatar-preview"
        :src="galleryBgUrl">

      <div
        class="sub-title"
        id="change-avatar">
        <a
          href="#"
          class="btn btn-fill-green btn-55 btn-m-89 add-avatar">Изменить фон</a>
        <input
          type="file"
          id="img-change-file"
          class="form-control hidden"
          accept="image/*"
          data-gallery="1">
        <input
          class="img-res hidden"
          name="avatar_base64">
      </div>
    </div>

    <div class="image-cropper">
      <div class="image-cropp-container">
        <img
          src="/"
          id="cropp">
      </div>
      <div class="crop-buttons">
        <button
          type="button"
          class="btn btn-55 btn-fill-green btn-m-89 btn-cancel-crop">
          Отмена
        </button>
        <button
          type="button"
          class="btn btn-55 btn-fill-green btn-m-89btn-save-crop">
          Сохранить
        </button>
      </div>
    </div>


    <gallery-profile-form :gallery_data="gallery"/>


  </section>
</template>

<script>
  import GalleryProfileForm from '../../../components/galleries/GalleryProfileForm.vue';

  export default {
  name: 'SettingsGallery',

  components: {
    GalleryProfileForm,
  },

  props: {
    gallery: {
      type: Object,
      required: true,
    },
  },

  computed: {
    galleryBgUrl() {
      return (this.gallery.bg && this.gallery.bg !== '') ? `/web/images/galleries/${this.gallery.bg}` : '/web/images/ui/icon-bg-gallery.svg';
    },
  },

};
</script>

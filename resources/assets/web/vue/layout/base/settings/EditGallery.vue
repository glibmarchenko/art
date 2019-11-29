<template>
  <section class="settings-block">
    <!-- Settings menu -->
    <h1 class="title">
      Редактирование профиля
    </h1>


    <div class="sub-title">
      <div class="settings-avatar avatar-preview avatar-preview-xs gallery-bg">
        <img
          id="avatar-preview"
          :src="galleryBgUrl">
        <div
          class="sub-title"
          id="change-avatar">
          <a
            href="#"
            class="btn btn-fill-green btn-55 add-avatar btn-m-89">Изменить фон</a>
          <input
            type="file"
            id="img-change-file"
            class="form-control hidden btn-55 btn-m-89"
            accept="image/*"
            data-gallery="1">
          <input
            type="hidden"
            class="img-res hidden"
            name="gallery_bg_base64">
        </div>
      </div>
    </div>


    <div
      class="content"
      id="author-avatar-cropper">
      <div class="form-block">
        <div class="sub-title">
          <div class="settings-avatar avatar-preview avatar-preview-xs">
            <img
              id="avatar-preview"
              :src="galleryAvatarUrl">
          </div>
          <a
            href="#"
            class="btn btn-outline-green btn-55 add-author-avatar btn-m-89">Загрузить
            логотип</a>
          <input
            type="file"
            id="img-change-avatar"
            class="form-control hidden no-gallery"
            accept="image/*">
          <input
            type="hidden"
            class="img-res hidden"
            name="avatar_base64">
        </div>
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
          class="btn btn-55 btn-fill-red btn-cancel-crop">Отмена
        </button>
        <button
          type="button"
          class="btn btn-55 btn-fill-green btn-save-crop">
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
  name: 'SettingsEditGallery',

  components: {
    GalleryProfileForm,
  },

  data() {
    return {
      gallery: window.gallery,
    };
  },

  computed: {
    galleryBgUrl() {
      return (this.gallery.bg && this.gallery.bg !== '') ? `/web/images/galleries/${this.gallery.bg}` : '/web/images/ui/icon-bg-gallery.svg';
    },

    galleryAvatarUrl() {
      return (this.gallery.avatar && this.gallery.avatar !== '') ? `/web/images/avatars/${this.gallery.avatar}` : '/web/images/ui/icon-default-avatar.svg';
    },
  },

};
</script>

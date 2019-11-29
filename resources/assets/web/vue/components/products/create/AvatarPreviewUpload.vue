<template>
  <div>
    <upload-pic-form/>
    <div class="settings-avatar avatar-preview avatar-preview-xs">
      <img
        id="avatar-preview"
        :src="image_preview">
      <input
        type="hidden"
        class="img-prev-data"
        name="img_prev_data"
        value="">
    </div>

    <a
      href="#"
      class="btn btn-fill-green btn-large add-preview"
      @click="onUploadButtonClick">Загрузить исходник</a>

    <input
      type="file"
      id="img-change-preview"
      class="form-control hidden"
      accept="image/*"
      name="image_preview"
      value=""
      @change="readURLlive(this)"
    >

    <div class="info-block-bold">
      <div class="form-error-message show-this"/>
      Формат - jpg, png<br>
      Размер - до 40 MB
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      image_preview: '/web/images/ui/icon-default-avatar.svg',
      fileOriginalTypes: ['jpg', 'png', 'pdf', 'ai', 'eps'],
    };
  },
  created() {
    $('.add-original').on('click', () => {
      $('#img-change-original-file').click();
    });

    $('#img-change-original-file').change(function () {
      this.readURLFileOriginal(this);
    });

    this.bindRemoveOriginalFiles();
  },
  methods: {
    onUploadButtonClick() {
      $('#img-change-preview').click();
    },

    readURLlive(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
          $('#avatar-preview').attr('src', e.target.result);
          $('.img-prev-data').val(e.target.result);
          $('#avatar-preview').parent().removeClass('hidden');
        };
        reader.readAsDataURL(input.files[0]);
      }
    },

    readURLFileOriginal(input) {
      if (input.files && input.files[0]) {
        const extension = input.files[0].name.split('.').pop().toLowerCase();
        // file extension from input file

        const isSuccess = fileOriginalTypes.indexOf(extension) > -1; // is extension in acceptable types
        if (isSuccess) { // yes
          const reader = new FileReader();
          reader.onload = function (e) {
            $('.original-files').html(`<div>.${extension}</div>`);
            this.bindRemoveOriginalFiles();
          };
          reader.readAsDataURL(input.files[0]);
        } else { // no
          alert('Р¤Р°Р№Р» РІС‹Р±СЂР°РЅРЅРѕРіРѕ С‚РёРїР° РЅРµ РїРѕРґРґРµСЂР¶РёРІР°РµС‚СЃСЏ');
        }
      }
    },

    bindRemoveOriginalFiles() {
      $('.original-files>div').unbind('click').on('click', function () {
        if (confirm('РЈРґР°Р»РёС‚СЊ СЌС‚РѕС‚ С„Р°Р№Р»?')) {
          $(this).remove();
          $('#img-change-original-file').val(null);
        }
      });
    },

  },
};
</script>

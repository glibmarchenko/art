<template>
  <div id="backgroundCropper">
    <div id="cropper">
      <img
        id="newImage"
        :src="imageSrc">
      <div
        class="crop-button
       -group">
        <button
          @click.self="hide"
          class="btn btn-default btn-fill-red btn-d-34 btn-m-89">Отмена
        </button>
        <button
          @click="crop()"
          class="btn btn-default btn-fill-green btn-d-34 btn-m-89">Сохранить
        </button>
      </div>
    </div>
  </div>
</template>

<script>
  import Cropper from 'cropperjs';
  import { EventBus } from '../../event-bus';

  export default {
  props: {
    is_gallery: {
      type: Boolean,
      default: false,
    },
  },

  data() {
    return {
      isAuthorForm: null,
      isUploadOn: 1,
      imageBase64: null,
      cropper: '',
      selectedFile: '',
      imageSrc: '',
      newImageSrc: '',
      $fixedCropper: null,
      $app: null,
    };
  },

  watch: {
    imageSrc() {
      const image = document.getElementById('newImage');
      setTimeout(() => {
        this.cropper = new Cropper(image, {
          guides: false,
          viewMode: 1,
        });
      }, 10);
    },
  },

  methods: {
    hide() {
      $(this.$el)
        .velocity('transition.fadeOut');
      this.$fixedCropper.velocity('transition.bounceRightOut');
      this.cropper.destroy();
      const scrollTop = parseInt(this.$app.css('top'));
      this.$app.removeClass('noscroll');
      window.scrollTo(0, -scrollTop);
    },

    crop() {
      this.cropper.crop();

      EventBus.$emit('newCropperSrc', {
        newImageSrc: this.cropper.getCroppedCanvas()
          .toDataURL(),
      });

      this.hide();
    },

    readURL(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
          if (this.cropper) this.cropper.destroy();

          let ratio = 1;
          if (!this.is_gallery) {
            console.log('author form!');
            this.isAuthorForm = 1;
          }
          if (this.is_gallery) {
            this.isAuthorForm = 0;
            ratio = 3.15;
          }

          $(input).val(null); // clear input val for change same file

          $('#cropp').attr('src', e.target.result);
          $('.image-cropper').show();
          const image = document.getElementById('cropp');
          this.cropper = new Cropper(image, {
            aspectRatio: ratio / 1,
            viewMode: 2,
            /* preview: '.avatar-preview',
        crop: function(e) {
            //start_img_cropp(cropper);
        }, */
            cropend() {
              this.startCroppingImage(this.cropper);
            },
          });
        };
        reader.readAsDataURL(input.files[0]);
      }
    },

    startCroppingImage() {
      const myimg = this.cropper.getCroppedCanvas({ width: 1920, height: 1920 });
      this.imageBase64 = myimg.toDataURL('image/jpeg');

      console.log('endCroppingImage');
      console.log($('.img-res').val());
    },

    /**
     * Save image via ajax
     * TODO: Выпилить функцию. Или сохранять фото обычным form submit,
     * или на vue.js с блокированием действий, пока не сохранится
     *
     * @deprecated
     * @return void
     */
    saveCroppedImage() {
      if (this.isAuthorForm) {
        var imageBase64 = $('#author-avatar-cropper').find('.img-res').val();
      } else {
        var imageBase64 = this.imageBase64;
      }

      console.log(this.isUploadOn);
      if (this.isUploadOn === 1) {
        $.ajax({
          url: '/settings/profile/avatar',
          type: 'POST',
          data: { _token: CSRF_TOKEN, avatar_base64: imageBase64, gallery: this.is_gallery },
          dataType: 'JSON',
          success(data) {
            $('.img-res').val('');
            console.log($('.img-res').val());
          },
          error() {
          },
        });
      }
    },
    /**
     * TODO: finish moving cropper to single component
     *
     * @return void
     */
    initSecondCropper() {
      /* CROPPER */

      if ($('#avatar-preview').length) {
        if ($('#avatar-preview').hasClass('no-upload')) {
          this.isUploadOn = 0;
        }
        $('#img-change-file').change(function () {
          console.log($(this));

          this.readURL(this);
        });

        $('#img-change-avatar').change(function () {
          console.log('change avatar?');
          this.readURL(this);
        });

        $('.add-avatar').on('click', () => {
          $('#img-change-file').click();
        });

        $('.add-author-avatar').on('click', () => {
          $('#img-change-avatar').click();
        });

        $('.btn-cancel-crop').on('click', () => {
          $('.img-res').val('');
          $('.image-cropper').hide();
        });

        $('.btn-save-crop').on('click', function () {
          this.startCroppingImage(this.cropper);
          console.log('is author form?');
          console.log(this.isAuthorForm);
          if (this.isUploadOn === 0) {
            $('#avatar-preview').attr('src', $('.img-res').val());
            $('.image-cropper').hide();
            return true;
          }
          if (this.isAuthorForm) {
            $('#author-avatar-cropper').find('#avatar-preview').attr('src', $('.img-res').val());
            $('.image-cropper').hide();
            // this.saveCroppedImage();
          } else {
            $('#avatar-preview').attr('src', $('.img-res').val());
            $('.image-cropper').hide();
            if ($('#avatar-preview').hasClass('default-gallery-bg')) {
              $('#avatar-preview').removeClass('default-gallery-bg');
            }
            if ($(this).data('author') !== '1') {
              // this.saveCroppedImage();
            }
          }
        });
      }
    },
  },

  mounted() {
    this.$fixedCropper = $('#cropper');
    this.$app = $('#app');
  },

  created() {
    EventBus.$on('cropperFile', (data) => {
      this.selectedFile = data.file;
      this.imageSrc = window.URL.createObjectURL(data.file);
      const scrollTop = window.pageYOffset;
      this.$app.addClass('noscroll');
      this.$app.css('top', `${-scrollTop}px`);
    });
  },
};
</script>

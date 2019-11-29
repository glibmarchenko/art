<template>
    <div id="SelectUserImage">
        <img id="selectedImage" :src="formData.avatar">
        <input type="file" name="changeImage" id="changeImage" @change="changeImage()"/>
        <label for="changeImage" class="upload-label">
            <a class="btn btn-outline-gray btn-large btn-m-89">
                {{ trans('dashboard.Upload image') }}
            </a>
        </label>
    </div>
</template>

<script>

  import { EventBus } from '../../event-bus'

  export default {
    props: {
      avatar: {
        required: true,
        default: 'http://s3.amazonaws.com/37assets/svn/765-default-avatar.png'
      }
    },

    data () {
      return {
        formData: {
          avatar: 'http://s3.amazonaws.com/37assets/svn/765-default-avatar.png'
        },
        input: null,
      }
    },

    watch: {
      imageSrc: function () {
        document.getElementById('changeImage').value = ''
      }
    },

    methods: {
      updateUserAvatar: function () {
        EventBus.$emit('create-picture-image', this.formData.avatar)
      },

      changeImage: function () {
        console.log('changeImage')

        let files = $(this.input)[0].files
        let file = files[0]

        EventBus.$emit('cropperFile', {
          file: file
        })

        this.showCropper()
      },

      showCropper: function () {
        let $backgroundCropper = $('#backgroundCropper')
        let $fixedCropper = $('#cropper')
        $backgroundCropper.velocity('transition.fadeIn')
        $fixedCropper.velocity('transition.bounceRightIn')
      },

      generateBase64Avatar: function () {
        this.formData.base64 = new Buffer(
          this.formData.avatar,
          'binary'
        ).toString('base64')
      }
    },

    created: function () {
      let avatar = this.avatar

      if (this.avatar === null) {
        avatar = '/web/images/ui/icon-default-avatar.svg'
      }

      this.formData.avatar = avatar

      EventBus.$on('newCropperSrc', data => {
        this.formData.avatar = data.newImageSrc
        this.$nextTick(function () {
          this.updateUserAvatar()
        })
      })

      EventBus.$on('cancelCropper', () => {
        if (this.input) {
          this.input.value = ''
        }
      });
    },

    mounted () {
      this.input = this.$el.querySelector('#changeImage')
    }
  }
</script>

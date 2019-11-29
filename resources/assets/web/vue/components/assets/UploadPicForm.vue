<template>
    <div class="hello">
        <picture-input
                ref="pictureInput"
                @change="onChange"
                width="600"
                height="600"
                margin="16"
                accept="image/jpeg,image/png"
                size="10"
                :crop="false"
                buttonClass="btn"
                :customStrings="{
        upload: '<h1>Bummer!</h1>',
        drag: 'Drag a 😺 GIF or GTFO'
      }">
        </picture-input>
    </div>
</template>

<script>
    export default {
        name: 'app',
        data() {
            return {}
        },
        components: {},
        methods: {
            onChange(image) {
                console.log('New picture selected!');
                if (image) {
                    console.log('Picture loaded.');
                    this.image = image
                    console.log(this.image);
                } else {
                    console.log('FileReader API not supported: use the <form>, Luke!')
                }
            }
        }
    }
</script>
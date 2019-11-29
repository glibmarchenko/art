<template>
    <section class="image-upload-crop">

        <div class="picture-upload-crop" :style="{height: '500px'}">
            <vueCropper
                    ref="cropper"
                    :img="example2.img"
                    :outputSize="example2.size"
                    :outputType="example2.outputType"
                    :info="example2.info"
                    :canScale="example2.canScale"
                    :autoCrop="example2.autoCrop"
                    :autoCropWidth="example2.autoCropWidth"
                    :autoCropHeight="example2.autoCropHeight"
                    :fixed="example2.fixed"
                    :fixedNumber="example2.fixedNumber"
            />
        </div>
        
    </section>

</template>


<script>
    import VueCropper from 'vue-cropper'
    export default {
        components: {
            VueCropper
        },
        data() {
            return {
                example2: {
                    img: 'http://ofyaji162.bkt.clouddn.com/bg1.jpg',
                    info: true,
                    size: 1,
                    outputType: 'jpeg',
                    canScale: false,
                    autoCrop: true,
                    autoCropWidth: 300,
                    autoCropHeight: 250,
                    fixed: true,
                    fixedNumber: [4, 3]
                }
            }
        }
    }
</script>
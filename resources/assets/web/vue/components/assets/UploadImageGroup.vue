<template>
    <div id="images-upload">
        <div class="vue_component__upload--image" v-bind:class="{ 'dragover': onDragover }">


            <div class="upload_image_form__thumbnails">

                <div class="upload_image_form__thumbnail" v-for="(image, key) in recentlyUploaded"
                     :key="image.id">
                        <span class="delete" v-on:click="deleteUploadedBefore(image.id)">
                    </span>
                    <img v-bind:src="image.path" v-bind:class="{ 'show': image.name}">
                </div>

                <div class="upload_image_form__thumbnail" v-for="(image, key) in filteredImages" :key="image.id"
                     v-on:click="fileView($event, key)"
                     v-bind:class="{
                         'attempted': image.attempted,
                         'uploaded': image.uploaded,
                            }">
                        <span class="delete" v-on:click="fileDelete($event, key)">
                    </span>
                    <img v-bind:src="image.content" v-bind:class="{ 'show': image}">
                </div>


            </div>


            <form v-bind:id="'upload_image_form'" name="upload-files-form" enctype="multipart/form-data">

                <input type="file" v-bind:id="'upload_image_form__input'" hidden multiple/>
                <div>
                    <div class="btn-m-89"
                         id="submitButton"
                         v-on:click="submit"
                         v-bind:class="button_class"
                         v-bind:disabled="onUploading"
                         v-html="button_html"></div>
                </div>
            </form>

            <div v-for="(image) in filteredImages" :key="image.id">
                <input type="hidden" name="attachments[]" v-bind:value="image.id">
            </div>

        </div>
    </div>
</template>

<script>
  import axios from 'axios'

  export default {
        name: 'upload-image',
        props: {
            uploadedbeforeimages: {
                type: Array,
                required: true,
                default: []
            },
            url: {
                type: String,
                required: false,
                default: '/api/v1/attachment'
            },
            name: {
                type: String,
                required: false,
                default: 'images[]'
            },
            max_batch: {
                type: Number,
                required: false,
                default: 1
            },
            max_files: {
                required: false,
                default: 4
            },
            max_filesize: {
                type: Number,
                required: false,
                default: 8000
            },
            button_html: {
                type: String,
                required: false,
              default: trans('dashboard.Additional images')
            },
            button_class: {
                type: String,
                required: false,
                default: 'btn btn-outline-gray btn-large'
            },
        },
        created() {
            console.log(this.uploadedbeforeimages);
            this.recentlyUploaded = this.uploadedbeforeimages;
        },
        computed: {
            filteredImages: function () {
                return this.images.filter(image => typeof image.content !== 'undefined')
            },
        },

        data: function () {
            return {
                form: null,
                input: null,
                index: 0,
                total: 0,
                files: {},
                images: [],
                batch: {},
                onDragover: false,
                onUploading: false,
                recentlyUploaded: []
            }
        },
        mounted: function () {
            this.form = document.getElementById('upload_image_form');
            this.input = document.getElementById('upload_image_form__input');

            ['drag', 'dragstart', 'dragend',
                'dragover', 'dragenter', 'dragleave', 'drop'].forEach(event => this.form.addEventListener(event, (e) => {
                e.preventDefault();
                e.stopPropagation();
            }));
            ['dragover', 'dragenter']
                .forEach(event => this.form.addEventListener(event, this.dragEnter));
            ['dragleave', 'dragend', 'drop']
                .forEach(event => this.form.addEventListener(event, this.dragLeave));
            ['drop']
                .forEach(event => this.form.addEventListener(event, this.fileDrop));
            ['change']
                .forEach(event => this.input.addEventListener(event, this.fileDrop));

            this.form.addEventListener('click', (e) => {
                this.input.click();
            });
        },
        methods: {
            deleteUploadedBefore: function (id) {

                axios.delete('/api/v1/attachment/' + id).then((resp) => {
                    console.log(resp.data);
                    console.log('changing data');
                    this.recentlyUploaded = resp.data;
                });
            },
            upload: function () {
                if (!this._can_xhr()) return false;
            },
            submit: function (e) {
                console.log('submit');
                if (!this.onUploading) {
                    this.upload();
                }
            },
            dragEnter: function (e) {
                e.preventDefault();
                this.onDragover = true;
            },
            dragLeave: function (e) {
                e.preventDefault();
                this.onDragover = false;
            },
            fileDrop: function (e) {
                e.preventDefault();
                let newFiles = e.target.files || e.dataTransfer.files;
                for (let i = 0; i < newFiles.length; i++) {

                    if (this.images.length >= this.max_files) {
                        break;
                    }

                    Vue.set(this.files, this.index, newFiles[i]);
                    this.fileInit(this.index);
                    this.fileRead(this.index);
                    this.index++;
                }
                e.target.value = '';
            },
            fileInit: function (key) {
                let file = this.files[key];
                if ((file.size * 0.001) > this.max_filesize) {
                    Vue.set(this.files[key], 'bad_size', true);
                }
            },
            fileRead: function (key) {
                let reader = new FileReader();
                reader.addEventListener("load", (e) => {
                    console.log('before set');
                    Vue.set(this.images, key, {
                        content: reader.result,
                        name: this.genuid(),
                        attempted: false,
                        uploaded: false
                    });
                });
                console.log('before reader');
                reader.readAsDataURL(this.files[key]);
                Vue.delete(this.files, key);
            },
            fileDelete: function (e, key) {
                Vue.delete(this.images, key);
            },
            fileView: function (e, key) {
                e.preventDefault();
                e.stopPropagation();
            },
            _can_xhr() {
                if (this.total >= this.max_files) {
                    return false;
                }
                return true;
            },
            _can_upload_file(key) {
                let file = this.files[key];
                if (file.attempted || file.bad_size) {
                    return false;
                }
                return true;
            },
            genuid() {
                return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
                    (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
                )
            },
            pluck(array, key) {
                return array.map(o => o[key]);
            }

        },
        watch: {
            images: {
                handler: function (images) { // watch it
                    let component = this;
                    images.forEach(function (image, iteration) {

                        if (image.attempted === false && image.uploaded === false) {
                            image.attempted = true;
                            axios.post(component.url, {image: image}).then((resp) => {
                                image.path = resp.data.path;
                                image.id = resp.data.id;
                                image.uploaded = true;
                            });
                        }


                    });
                },
                deep: 1
            },
            filteredImages: function (filteredImages) {
                console.log(filteredImages);
                this.$parent.product.attachments = filteredImages.map(image => image.name);
            }
        }
    }
</script>



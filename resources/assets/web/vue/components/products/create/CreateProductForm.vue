<template>
  <div
          id="create-product"
          class="create-product">


    <div
            class="loader"
            :class="{percentageLoader: uploadPercentage > 0}"
            v-if="isSaving">
      <h1 v-if="uploadPercentage > 0">{{ uploadPercentage }} %</h1>
    </div>

    <div
            class="sub-title"
            v-if="is_gallery">

      <label>Автор</label>
      <model-select
              v-model="chosenAuthor"
              :options="gallery.authors"
              placeholder="Выбери автора"
              label="full_name"
      />
    </div>

    <div
            class="group-centered"
            v-if="is_gallery && !isFormVisible">
      <a href="/settings/authors/add">
        <div class="btn btn-fill-green btn-large btn-m-89">Добавить автора</div>
      </a>
    </div>

    <section
            v-if="isFormVisible"
            class="form-section"
            :class="{disabled: isSaving}">

      <div class="sub-title">

                <div v-if="product_type === 1" class="info-block-bold notification">
                    {{ trans('dashboard.we_print') }}
          <br>
          {{ trans('dashboard.one_print') }}
        </div>

        <picture-input
                v-if="isPicUploadVisible && product_type === 1"
                ref="pictureInput"
                @change="onPreviewChange"
                width="600"
                height="600"
                margin="1"
                accept="image/jpeg,image/png"
                size="60"
                :crop="false"
                button-class="btn btn-outline-gray btn-large btn-m-89"
                :custom-strings="{
            change: changeImageStrings[product_type]
        }"/>

        <section-select-image
                :avatar="product.image_preview_m"
                v-if="isPicUploadVisible && product_type > 1"/>

        <section-cropper/>

        <div
                class="preview"
                v-if="!isPicUploadVisible">
          <img :src="product.image_preview_m">
        </div>

        <div
                class="btn btn-outline-gray btn-large btn-m-89"
                v-if="!isPicUploadVisible"
                @click="isPicUploadVisible = true">
          {{ trans('dashboard.Change original') }}
        </div>

        <div
                v-if="product_type === 1"
                class="info-block-bold notification">
          {{ trans('dashboard.max_size') }} <br>
                    {{ trans('dashboard.accepted_files') }} <br>
          {{ trans('dashboard.max_dimensions') }} <br>
          {{ trans('dashboard.canvas_twist') }}
          <!--<span class="btn btn-no-fill btn-55">{{ trans('dashboard.Learn More') }}</span>-->
        </div>


      </div>


      <upload-images
              max_files="5"
              v-if="product_type !== 1"
              :uploadedbeforeimages="product.attachments"/>

      <div
              v-if="product_type !== 1"
              class="info-block-bold notification small-info-block">
        {{ trans('dashboard.maximum_4') }}
      </div>


      <product-sold-status-panel
              v-if="product_type !== 1"
              :forsale="product.for_sale"
              :sold="product.sold"/>


      <div
              class="form-row"
              :class="{invalid: errors.first('name')}">
        <label>{{ trans('dashboard.Name') }}</label>
        <input
                type="text"
                v-model="product.name"
                v-validate="'required'"
                name="name"
        >

      </div>

      <div class="form-row-group-inputs inputs-2">
        <div
                class="form-row"
                :class="{invalid: errors.first('price')}">
          <label>{{ trans('dashboard.price_eur') }}
            <span v-if="product_type===1">{{ trans('dashboard.1_print') }}</span>
            <span v-if="product_type!==1">{{ trans('dashboard.comission_10') }}</span>
          </label>
          <input
                  type="number"
                  v-model="product.price"
                  v-validate="validatePrice"
                  name="price"
          >

        </div>

        <div
                class="form-row"
                :class="{invalid: errors.first('year')}">
          <label>{{ trans('dashboard.Year of creation') }}</label>
          <input
                  type="number"
                  name="year"
                  min="0"
                  step="1"
                  pattern="\d*"
                  v-model="product.year"
                  v-validate="'required|numeric|max:2018'"
          >
        </div>
      </div>

      <div
              class="form-row-group-inputs inputs-4"
              :class="{'inputs-2':product_type === 1 }">
        <div
                class="form-row"
                :class="{invalid: errors.first('width')}">
          <label>{{ trans('dashboard.width') }}, <b>{{ trans('dashboard.mm') }}</b></label>

          <input
                  v-if="product.type === 1"
                  type="number"
                  name="width"
                  min="0"
                  step="1"
                  pattern="\d*"
                  v-validate="'required|numeric|max_value:1300'"
                  v-model="product.width">

          <input
                  v-if="product.type !== 1"
                  type="number"
                  name="width"
                  min="0"
                  step="1"
                  pattern="\d*"
                  v-validate="'required|numeric'"
                  v-model="product.width">


        </div>
        <div
                class="form-row"
                :class="{invalid: errors.first('height')}">
          <label>{{ trans('dashboard.height') }}, <b>{{ trans('dashboard.mm') }}</b></label>
          <input
                  type="number"
                  name="height"
                  min="0"
                  step="1"
                  pattern="\d*"
                  v-validate="'required|numeric'"
                  v-model="product.height">
        </div>

        <div
                class="form-row"
                v-if="product_type !== 1"
                :class="{invalid: errors.first('depth')}">
          <label>{{ trans('dashboard.depth') }}, <b>{{ trans('dashboard.mm') }}</b></label>
          <input
                  type="number"
                  name="height"
                  min="0"
                  step="1"
                  pattern="\d*"
                  v-validate="'required|numeric'"
                  v-model="product.depth">
        </div>

        <div
                class="form-row"
                v-if="product_type !== 1">
          <label>{{ trans('dashboard.weight') }}, <b>{{ trans('dashboard.kg') }}</b></label>
          <input
                  type="number"
                  name="height"
                  min="0"
                  step="0.1"
                  v-validate="'required'"
                  v-model="product.weight">
        </div>

      </div>


      <div class="form-row">
        <label>{{ trans('dashboard.categories_3') }}</label>
        <div class="form-row row-with-check-btns picture-materials">
          <div
                  v-for="category in categories"
                  class="multi-checked-btn btn btn-outline-gray btn-large btn-m-89"
                  :class="{active: category.selected}"
                  @click="toggleCategory(category)">{{trans('category_types.names.'+category.alias) }}
          </div>
        </div>
      </div>


      <div
              class="form-row"
              v-if="product.type === 2">
        <label>{{ trans('dashboard.Wherewith') }}</label>
        <div class="form-row row-with-check-btns picture-materials">
          <div
                  v-for="material in materials"
                  v-if="material.type===2"
                  class="multi-checked-btn btn btn-outline-gray btn-large btn-m-89"
                  :class="{active: material.selected}"
                  @click="toggleMaterial(material)">{{trans('materials.'+material.alias) }}
          </div>
        </div>
      </div>

      <div
              class="form-row"
              v-if="product.type !== 1">
        <label v-if="product_type===2">{{ trans('dashboard.Whereupon') }}</label>
        <label v-if="product_type===3">{{ trans('dashboard.Materials') }}</label>
        <div class="form-row row-with-check-btns picture-materials">
          <div
                  v-for="material in materials"
                  v-if="material.type===1"
                  class="multi-checked-btn btn btn-outline-gray btn-large btn-m-89"
                  :class="{active: material.selected}"
                  @click="toggleMaterial(material)">{{trans('materials.'+material.alias) }}
          </div>
        </div>
      </div>

      <div class="form-row tags-row">
        <label>{{ trans('dashboard.tags_') }}</label>
        <model-select
                v-model="product.tags"
                :multiple="true"
                :options="tags"
                :taggable="true"
                :close-on-select="false"
                @tag="addTag"
                tag-placeholder="Add this as new tag"
                :placeholder="trans('dashboard.Tags')"
                label="name"
                track-by="name"
        />
      </div>

      <div
              class="form-row"
              :class="{invalid: errors.first('description')}">
        <label>{{ trans('dashboard.Description') }}</label>
        <textarea
                v-model="product.description"
                v-validate="'required'"
                name="description"
        >{{ product.description }}</textarea>
      </div>

      <div
              class="form-row submit-row"
              v-if="!isSaving">
        <a
                v-if="product.id"
                type="button"
                class="btn btn-outline-gray btn-large delete btn-m-89"
                @click="deleteProduct()">
          {{ trans('dashboard.Delete') }}
        </a>
        <button
                type="submit"
                v-if="!product.id"
                class="btn btn-fill btn-large btn-fill-green btn-m-89"
                :class="{'btn-inactive': isFormInvalid}"
                @click="submitCreateForm">{{ trans('dashboard.Save') }}
        </button>

        <button
                type="submit"
                v-if="product.id"
                class="btn btn-fill btn-large btn-fill-green btn-m-89"
                :class="{'btn-inactive': isFormInvalid}"
                @click="submitUpdateForm">{{ trans('dashboard.Save') }}
        </button>
      </div>

      <div
              v-if="product_type === 2"
              class="info-block-bold notification">
        {{ trans('dashboard.painting_must1') }}<br>
        {{ trans('dashboard.painting_must2') }}<br>
        {{ trans('dashboard.painting_must3') }}
      </div>

      <div
              v-if="!product.id"
              class="info-block-bold notification">
        Все поля обязательны к заполнению
      </div>
    </section>
  </div>
</template>


<script>
  import { EventBus } from '../../../event-bus';
  // Vue.component('section-cropper', require('./components/assets/Cropper.vue'))
  import SectionCropper from '../../assets/Cropper.vue';
  import SectionSelectImage from '../../assets/UploadImageCropper.vue';

  import axios from 'axios'

  export default {
    components: {
      SectionCropper,
      SectionSelectImage,
    },

    data() {
      return {
        deleteAllowed: false,
        isPicUploadVisible: true,
        isFormVisible: true,
        isSaving: false,
        changeImageStrings: {
          1: trans('dashboard.Upload original'),
          2: trans('dashboard.Painting image'),
          3: trans('dashboard.Design image')
        },
        gallery: {
          authors: [],
        },
        chosenAuthor: {},
        product: {
          image_preview_m: '/web/images/ui/icon-default-avatar.svg',
          image_preview: null,
          name: '',
          user_id: '',
          price: '',
          width: '',
          height: '',
          year: '',
          for_sale: true,
          sold: false,
          depth: null,
          weight: null,
          type: 1,
          description: '',
          categories: [],
          tags: [],
          fileUploaded: false,
          attachments: [],
          materials: [],
        },
        categories: [
          {
            id: 1,
            name: 'test',
          },
        ],
        tags: ['test'],
        materials: [],
        uploadPercentage: 0,
      };
    },
    created() {
      if (this.product_prop.id) {
        this.product = this.product_prop;
        this.isPicUploadVisible = false;
      }
      if (this.is_gallery) {
        this.isFormVisible = false;
        this.fetchGalleryAuthors();
        if (this.product.user_id > 0) {
          this.chosenAuthor = this.product.author;
          this.isFormVisible = true;
        }
      }
      this.product.type = this.product_type;
      this.fetchCategories();
      this.fetchTags();
      this.fetchMaterials();

      const that = this;
      EventBus.$on('delete_confirmed', () => {
        that.deleteAllowed = 1;
        that.deleteProduct();
      });

      EventBus.$on('create-picture-image', (image) => {
        console.log(image);
        that.product.image_preview = image;
        that.product.fileUploaded = true;
      });
    },
    props: {
      product_type: {
        default:
          1,
      },
      product_prop: {
        default:
          null,
      },
      is_gallery: {
        default:
          0,
      },
    },
    watch: {
      product(value) {
        console.log(value.categories);
      },
      deep: 1,
      chosenAuthor(author) {
        this.product.user_id = author.id;
        this.isFormVisible = 1;
      },
    },
    computed: {
      axiosConfig() {
        return {
          onUploadProgress: (progressEvent) => {
            this.uploadPercentage = Math.floor((progressEvent.loaded * 100) / progressEvent.total);
            console.log(this.uploadPercentage);
          },
        };
      },

      isFormInvalid() {
        let invalidStatus = false;
        if (Object.keys(this.fields)
          .some(key => this.fields[key].invalid)) {
          invalidStatus = true;
        }
        if (!this.product.image_preview || this.product.image_preview === '') {
          invalidStatus = true;
        }
        return invalidStatus;
      },
      validatePrice() {
        return this.product.for_sale ? 'required|numeric' : 'numeric';
      },
    },
    methods: {
      fetchGalleryAuthors() {
        axios.get('/api/v1/user/author')
          .then((res) => {
            this.gallery.authors = res.data;
          });
      },
      fetchCategories() {
        axios.get(`/api/v1/category/type/${this.product.type}`)
          .then((res) => {
            this.categories = res.data;
            const that = this;
            this.categories.forEach((category) => {
              if (that.indexWhere(that.product.categories, p_category => p_category.id === category.id) !== -1) {
                category.selected = true;
              }
            });
          });
      },
      fetchTags() {
        axios.get('/api/v1/tag')
          .then((res) => {
            this.tags = res.data;
          });
      },
      fetchMaterials() {
        if (this.product.type === 1) {
          return false;
        }
        axios.get(`/api/v1/material/${this.product_type}`)
          .then((res) => {
            this.materials = res.data;
            const that = this;
            this.materials.forEach((material) => {
              if (that.indexWhere(that.product.materials, p_material => p_material.id === material.id) !== -1) {
                material.selected = true;
              }
            });
          });
      },
      displaySubmitError() {
          EventBus.$emit('dialog-popup', 'cant_submit');
      },
      scrollToError() {
        const container = $('.new-item-content');
        const targetElem = $('.invalid')
          .first();
        const targetOffset = targetElem.offset();
        const divScrollTop = container.scrollTop();

        container.animate({
          scrollTop: (divScrollTop + targetOffset.top - targetElem.height()),
        }, 500);
      },
      submitCreateForm() {
        if (this.isFormInvalid) {
          this.scrollToError();
          this.displaySubmitError();
          return false;
        }
        console.log('submitting form');
        console.log(this.product);
        this.isSaving = true;

        this.setMaterials();
        this.setCategories();
        console.log(this.product);

        this.$nextTick(function () {
          if (!this.product.tags.length || !this.product.categories.length) {
            return console.log('no tags / categories');
          }
          console.log(this.product.tags.length);
          console.log(this.product.categories.length);

          axios.post('/api/v1/product', this.product, this.axiosConfig)
            .then((res) => {
              window.location.href = '/settings/items';
              window.sessionStorage.setItem('dialog-box', 'save');
            });
        });
      },
      submitUpdateForm() {
        if (this.isFormInvalid) {
          this.scrollToError();
          this.displaySubmitError();
          return false;
        }
        this.setMaterials();
        this.setCategories();
        this.isSaving = true;

        this.$nextTick(function () {
          axios.put(`/api/v1/product/${this.product.id}`, this.product, this.axiosConfig)
            .then((res) => {
              window.location.href = '/settings/items';
              window.sessionStorage.setItem('dialog-box', 'update');
            });
        });
      },
      setMaterials() {
        const materialsList = this.materials.filter(material => material.selected);
        this.product.materials = materialsList;
      },
      setCategories() {
        const categoriesList = this.categories.filter(category => category.selected);
        this.product.categories = categoriesList;
      },
      toggleMaterial(material) {
        return material.selected = !material.selected;
      },
      toggleCategory(category) {
        if (!category.selected) {
          const categoriesList = this.categories.filter(category => category.selected);
          if (categoriesList.length >= 3) {
            return false;
          }
        }
        return category.selected = !category.selected;
      },
      deleteProduct() {
        console.log('trry delete');
        if (this.deleteAllowed) {
          axios.delete(`/api/v1/product/${this.product.id}`)
            .then((res) => {
              window.location.href = '/settings/items';
              window.sessionStorage.setItem('dialog-box', 'delete');
            });
        } else {
          console.log('emit confirmation');
          EventBus.$emit('dialog-popup', 'delete_confirmation');
        }
      },

      addTag(newTag) {
        console.log(newTag);
        const tag = {
          name: newTag,
        };
        this.tags.push(tag);
        this.product.tags.push(tag);
      },

      onPreviewChange(image) {
        console.log('New picture selected!');
        if (image) {
          console.log('Picture loaded.');
          this.product.image_preview = image;
          this.product.fileUploaded = true;
          console.log(this.product);
        } else {
          console.log('FileReader API not supported: use the <form>, Luke!');
        }
      },
      indexWhere(array, conditionFn) {
        if (array === null) {
          return [];
        }
        const item = array.find(conditionFn);
        return array.indexOf(item);
      },
    },
  };
</script>

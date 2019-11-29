<template>
  <div
    id="delivery-side"
    class="delivery-side"
    :class="{ h100: showDelivery }">
    <div
      class="delivery-header"
      @click="toggleShowDelivery">
      <h3>{{ trans('pages.Delivery') }}</h3>
      <span
        :class="{ down: showDelivery }"
        class="delivery-arrow"/>
    </div>
    <transition :name="transitionClassName">
      <div
        class="delivery-content"
        v-show="showDelivery || !$root.is_mobile">
        <form @change="onFormChange">

          <div class="col-50">
            <label>{{ trans('homepage.Country') }}</label>
            <select v-model="deliveryDetails.country">
              <option :value="'Украина'">{{ trans('pages.Ukraine') }}</option>
            </select>

          </div>

          <div class="col-50 margin-left-16">
            <label>{{ trans('dashboard.City') }}</label>
            <input
              type="text"
              class="input"
              :class="{invalid: errors.first('city')}"
              v-model="deliveryDetails.city"
              v-validate="'required'"
              name="city">
          </div>

          <label>{{ trans('pages.Shipping company') }}</label>
          <select v-model="deliveryDetails.delivery_id">
            <option
              v-for="option in delivery_options"
              :value="option.value">{{ option.name }}
            </option>
          </select>

          <label>{{ trans('pages.Street, house') }}</label>
          <input
            type="text"
            class="input"
            :class="{invalid: errors.first('street')}"
            v-model="deliveryDetails.street"
            v-validate="'required'"
            name="street">


          <div class="col-50">
            <label>{{ trans('pages.Apartment') }}</label>
            <input
              type="text"
              class="input"
              :class="{invalid: errors.first('house')}"
              v-model="deliveryDetails.house"
              name="house">
          </div>

          <div class="col-50 margin-left-16">
            <label>{{ trans('homepage.Phone') }}</label>
            <input
              type="text"
              class="input"
              :class="{invalid: errors.first('phone')}"
              v-model="deliveryDetails.phone"
              v-validate="'required'"
              name="phone">
          </div>


          <label>{{ trans('pages.recipient') }}</label>
          <input
            type="text"
            class="input"
            :class="{invalid: errors.first('name')}"
            v-model="deliveryDetails.name"
            v-validate="'required'"
            name="name">


          <label>{{ trans('dashboard.Note') }}</label>
          <textarea
            class="input"
            v-model="deliveryDetails.details"/>

          <div
            v-if="$root.is_mobile"
            class="delivery-approve">
            <a
              @click="toggleShowDelivery"
              class="btn btn-m-89 btn-fill-red">Отменить</a>
            <a
              @click="toggleShowDelivery"
              class="btn btn-m-89 btn-fill-green">Подтвердить</a>
          </div>
        </form>
      </div>
    </transition>
  </div>
</template>


<script>
  import {Validator} from 'vee-validate';


  export default {
    name: 'CartDelivery',
    props: {
      showDelivery: {
        type: Boolean,
        default: false,
      },
    },

    data() {
      return {
        delivery_options: [
          {value: 1, name: 'Новая Почта'},
        ],
        deliveryDetails: {
          delivery_id: {value: 1, name: 'Новая Почта'},
          name: '',
          phone: '',
          country: 'Украина',
          city: '',
          street: '',
          postal: '',
          house: '',
          details: '',
        },
      }
    },
    created() {
      this.fetchUserDeliveryDetails()
    },
    computed: {
      isFormInvalid() {
        return Object.keys(this.fields).some(key => this.fields[key].invalid)
      },

      transitionClassName() {
        return this.showDelivery ? 'fadeUp' : 'fadeDown'
      },
    },
    methods: {
      fetchUserDeliveryDetails() {
        axios.get('/api/v1/user/delivery').then((res) => {
          if (res.data instanceof Object) {
            Object.assign(this.deliveryDetails, res.data);
            console.log('Assigning delivery details');
          }
        })
      },

      onFormChange() {
        this.storeUserDeliveryData()
      },

      storeUserDeliveryData() {
        axios.post('/api/v1/user/delivery', this.deliveryDetails).then((res) => {
          console.log('User delivery data stored')
        })
      },

      toggleShowDelivery() {
        this.$emit('toggleShowDelivery')
      },

    },
    watch: {
      isFormInvalid(value) {
        this.$parent.isDeliveryValid = !value
      },
    },
  }
</script>

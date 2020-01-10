
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vuex from 'vuex';
import Router from 'vue-router';
import VueSession from 'vue-session';
import router from './router'
import { store } from './store.js';
import { messages } from './language.js';
import VueRouter from 'vue-router'; // importing Vue router library
import VueI18n from 'vue-i18n'
import VeeValidate from 'vee-validate';
import validationMessages from 'vee-validate/dist/locale/en';
import validationMessagesArabic from 'vee-validate/dist/locale/ar';
import ProductZoomer from 'vue-product-zoomer'


window.Vue = require('vue');

export const bus = new Vue()

Vue.use(bus)
Vue.use(Vuex)
Vue.use(Router)
Vue.use(VueSession)
Vue.use(VueRouter)
Vue.use(VueI18n)
Vue.use(VeeValidate, { 
  fieldsBagName: 'veeFields',
  i18nRootKey: 'validations', // customize the root path for validation messages.
  i18n,
  dictionary: {
    en: validationMessages,
    ar: validationMessagesArabic
  } 
})

Vue.use(ProductZoomer)

Vue.prototype.$eventHub = new Vue(); // Global event bus
  
  const i18n = new VueI18n({
    locale: 'en',
    messages
  })
const app = new Vue({
    el: '#app',
    mode: 'history',
    store,
    router,
    i18n,
});


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.App = {
	baseUrl: document.getElementById('homepage').getAttribute('content'),
	csrfToken: document.getElementById('csrf-token').getAttribute('content')
};

window.Dropzone = require('dropzone')
Dropzone.autoDiscover = false

import Buefy from 'buefy';
Vue.use(Buefy);

window._ = require('lodash');

window.url = function (urlString) {
  if (urlString === '/') {
    return App.baseUrl
  }

  if (! urlString) {
    return false
  }
  
  if (urlString.substr(0, 4) == 'http') {
    return urlString
  }

  if (urlString.substr(0, 2) == '//') {
    return urlString
  }
  
  return App.baseUrl + '/' + urlString
};


window.axios = require('axios');
window.axios.defaults.headers.common = {
  'X-CSRF-TOKEN': window.App.csrfToken,
  'X-Requested-With': 'XMLHttpRequest',
};
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Vue.component('to-do', require('./components/ToDo.vue'));
Vue.component('image-card', require('./components/ImageCard.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app'
// });

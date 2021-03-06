
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// import Vue from 'vue'
// import BootstrapVue from 'bootstrap-vue'

// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'

// Vue.use(BootstrapVue)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('comments-component', require('./components/CommentsComponent.vue').default);
Vue.component('commentform-component', require('./components/CommentFormComponent.vue').default);
Vue.component('answer-component', require('./components/AnswerComponent.vue').default);
Vue.component('pooling-component', require('./components/PoolingComponent.vue').default);
Vue.component('twitter-component', require('./components/TwitterComponent.vue').default);
Vue.component('profile-component', require('./components/ShowProfileComponent.vue').default);
Vue.component('select-city', require('./components/CitySelectComponent.vue').default);
Vue.component('change-password', require('./components/PasswordChangeComponent.vue').default);
Vue.component('image-upload', require('./components/ImageUploadComponent.vue').default);

Vue.component('profile-edit-page', require('./pages/ProfileEdit.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.prototype.$eventBus = new Vue(); // Global event bus

const app = new Vue({
    el: '#app'
});
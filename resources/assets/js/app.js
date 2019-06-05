/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
require('./prism');

import VueMarkdown from 'vue-markdown'
Vue.component('VueMarkdown', VueMarkdown)
// Vue.use(VueMarkdown)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/**
 * App Components
 */
Vue.component('quiz', require('./components/Quiz'));
Vue.component('profile', require('./components/Profile'));
Vue.component('LoadingModal', require('./components/LoadingModal'));
Vue.component('TypeTest', require('./components/TypeTest'));
Vue.component('TypeHelloTest', require('./components/Hello'));

/**
 * Matrix BG
 */
Vue.component('Matrix', require('./components/Matrix'));

const app = new Vue({
    el: '#app',
    name: 'MobisReloaded',
});

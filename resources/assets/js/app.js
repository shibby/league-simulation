/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueResource from 'vue-resource'
import eventbus from './plugins/eventbus'

Vue.use(eventbus)
Vue.use(VueResource);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('fixture-component', require('./components/FixtureComponent.vue'));
Vue.component('league-table-component', require('./components/LeagueTableComponent.vue'));
Vue.component('weekly-match-component', require('./components/WeeklyMatchComponent.vue'));

const app = new Vue({
  el: '#app'
});

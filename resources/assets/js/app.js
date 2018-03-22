
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import Vuetify from 'vuetify'
import VueRouter from 'vue-router'

// 1. Define route components.
// These can be imported from other files
const videos = { template: '<video-component></video-component>'}
const rules = { template: '<rule-component></rule-component>'}
const settings = { template: '<setting-component></setting-component>'}

// 2. Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// `Vue.extend()`, or just a component options object.
// We'll talk about nested routes later.
const routes = [
    { path: '/', component: videos },
    { path: '/rules', component: rules },
    { path: '/settings', component: settings }
]

Vue.use(VueRouter)

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
    routes // short for `routes: routes`
})

import VueEcho from 'vue-echo';
import Echo from 'laravel-echo';

const EchoInstance = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});
Vue.use(VueEcho, EchoInstance);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('main-layout', require('./components/app'));
Vue.component('video-component', require('./components/VideoComponent'));
Vue.component('rule-component', require('./components/RuleComponent'));
Vue.component('setting-component', require('./components/SettingComponent'));

Vue.use(Vuetify);

new Vue({
    router,
    el: '#app'
});
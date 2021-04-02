/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

import App from './components/App.vue';

Vue.use(Vuetify)

const opts = {}

export default new Vuetify(opts)


const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    components: {
        App
    }
});

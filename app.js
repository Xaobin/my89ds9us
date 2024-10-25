/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia'
//import { defineStore } from 'pinia'



const app = createApp({});
const pinia = createPinia();



 




import ExampleComponent from './components/ExampleComponent.vue';
app.component('ex-cp', ExampleComponent);

import Loginx from './components/Loginx.vue';
app.component('loginx-cp', Loginx);

import DModal from './components/dmodal.vue'; app.component('dmodal-cp', DModal);
import Card from './components/Card.vue'; app.component('card-cp', Card);
import Table from './components/Table.vue'; app.component('table-cp', Table);
import Alert from './components/Alert.vue'; app.component('alert-cp', Alert);

import Home from './components/Home.vue'; app.component('home-cp', Home);

import Marca from './components/Marca.vue'; app.component('marca-cp', Marca);
//node_modules\.vite\deps
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */ 
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
app.use(pinia);
app.mount('#app');




//const app = new Vue({  el: '#app' });
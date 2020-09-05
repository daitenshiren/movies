require('./bootstrap');

window.Vue = require('vue');

Vue.component(
    'movies',
    require('../components/MovieComponent.vue').default
);

const app = new Vue({
    el: '#app'
});

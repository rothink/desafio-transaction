import Vue from 'vue';
import jquery from 'jquery';
import axios from 'axios';
import VueAxios from 'vue-axios';
import moment from 'moment';

import App from './App.vue';
import router from '~/router/index';
import store from './store';
import vuetify from './plugins/vuetify';
import passport from './plugins/passport';
import notification from './helper/notification';
import money from 'v-money'
import './plugins/axios';
import './components';

import helper from '~/services/helper';
import Form from '~/services/form';

moment.lang('pt-br');

var $ = jquery;
window.$ = $;

window.Form = Form;
window.axios = axios;
window.notification = notification;
window.helper = helper;
window._has = require('lodash/has');
window.moment = moment

Vue.config.productionTip = false;
Vue.use(VueAxios, axios);
Vue.use(passport);

Vue.use(money, {
    decimal: ',',
    thousands: '.',
    prefix: 'R$ ',
    precision: 2,
    masked: false
});

Vue.mixin({
    methods: {
        isAdmin() {
            return helper.isAdmin();
        },
        isUser() {
            return helper.isUser();
        },
    },
});

export const app = new Vue({
    router,
    store,
    vuetify,
    render: h => h(App),
}).$mount('#app');

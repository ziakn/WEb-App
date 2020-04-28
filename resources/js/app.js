require('./bootstrap');
import common from './common';
Vue.mixin(common);

import "babel-polyfill";

window.Vue = require('vue');
import Vue from 'vue'
import vuetify from './plugins/vuetify'





let userType = window.authUser.userType
router.beforeEach((to, from, next) => {

    var flag=0;
    if(to.meta){
        let allowed = to.meta.type
        for(let a of allowed){
            if(a==userType){                
                flag=1;
            }
        }
    }
    if(flag==1)
    next();
    else
    return;
  
  });

  router.afterEach((to, from) => {
    Vue.nextTick(() => {
        document.title = to.meta.title + '| Al-Mass Water' ? to.meta.title : 'Al-MASS Title';
    });
})


Vue.component('z-dashboard', require('./components/dashboard.vue').default);


import router from './router'
import store from './store'

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store: store,
});

import Vue from 'vue'
import App from './App.vue' 
import router from './router'
import vuetify from './plugins/vuetify'
import axios from 'axios'

Vue.config.productionTip = false

const phpAxios = axios.create({
  baseURL: 'http://localhost:8010/api',
})

const jsAxios = axios.create({
  baseURL: 'http://localhost:3000/api',
})

phpAxios.interceptors.request.use(function (config) {
  const token = localStorage.user;
  if (token) {
    config.headers.Authorization = 'Bearer ' + token ;
  }

  return config;
});

Vue.prototype.$http = phpAxios;
Vue.prototype.$jshttp = jsAxios;


new Vue({
  router,
  vuetify,
  render: h => h(App)
  
}).$mount('#app')

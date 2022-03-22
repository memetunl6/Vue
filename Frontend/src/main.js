import Vue from 'vue'
import App from './App.vue' 
import router from './router'
import vuetify from './plugins/vuetify'
import axios from 'axios'

Vue.config.productionTip = false

axios.defaults.baseURL = 'http://localhost:8000/api';
axios.interceptors.request.use(function (config) {
  const token = localStorage.user;
  if (token) {
    config.headers.Authorization = 'Bearer ' + token ;
  }

  return config;
});

Vue.prototype.$http = axios;


new Vue({
  router,
  vuetify,
  render: h => h(App)
  
}).$mount('#app')

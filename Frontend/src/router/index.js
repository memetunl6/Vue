import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView.vue'

Vue.use(VueRouter)




const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/Register',
    name: 'Kayıt',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "kayıt" */ '../views/AboutView.vue')
  },
  {
    path: '/Giris',
    name: 'Giris',
    component: () => import(/* webpackChunkName: "Giris" */ '../views/GirisYap.vue')
  },
  {
    path: '/Panel',
    name: 'Panel',
    component: () => import(/* webpackChunkName: "Panel" */ '../views/AdminPanel.vue')
  },
  {
    path: '/UserList',
    name: 'UserList',
    component: () => import(/* webpackChunkName: "UserList" */ '../views/UserList.vue')
  }

]
const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to,from,next) => {
  const token = localStorage.getItem('user');
  if (!token && to.path !== '/Giris' && to.path !== '/Register' && to.path !== '/') {
    next('/Giris');
  }
  else {
    next();
  }
});
  
export default router

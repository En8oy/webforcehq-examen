import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Product from '../views/Product.vue'
import Login from '../views/Login.vue'
import Car from '../views/Car.vue'


Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/products',
    name: 'Products',
    component: Product
  },
  {
    path: '/login',
    name : 'Log in',
    component : Login
  },
  {
    path: '/my-car',
    name : 'My Car',
    component : Car
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router

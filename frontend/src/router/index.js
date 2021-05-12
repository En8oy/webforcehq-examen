import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Product from '../views/Product.vue'
import Products from '../views/Products.vue'
import Login from '../views/Login.vue'
import Cart from '../views/Cart.vue'
import Error from '../views/Error.vue'



Vue.use(VueRouter)

const routes = [
  {
    // will match everything
    path: '*',
    name: 'Page Not Found',
    component: Error
  },
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/products',
    name: 'Products',
    component: Products
  },
  {
    path: '/products/:slug',
    name: 'Product',
    component: Product
  },
  {
    path: '/login',
    name : 'Log in',
    component : Login
  },
  {
    path: '/my-cart',
    name : 'My Car',
    component : Cart
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router

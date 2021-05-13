import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Product from '../views/Product.vue'
import Products from '../views/Products.vue'
import Login from '../views/Login.vue'
import Cart from '../views/Cart.vue'
import Error from '../views/Error.vue'
import store from '@/store'
// Auth
import OrderAdmin from '../views/Auth/Order.vue'
import ProductAdmin from '../views/Auth/Product.vue'
import UserAdmin from '../views/Auth/User.vue'


function guardMyroute(to, from, next){
  if(store.state.User.token != ""){
      next()
  }else{
    next("/login")
  }
}

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
    component : Login,
    beforeEnter: (to, from, next) => { 
      if (store.state.User.token) {
        next("/auth/orders")
      } else {
        next()
      }
    },
  },
  {
    path: '/my-cart',
    name : 'My Car',
    component : Cart
  },
  {
    path: '/auth/orders',
    name : 'Orders',
    beforeEnter : guardMyroute,
    component : OrderAdmin
  },
  {
    path: '/auth/products',
    name : 'Products Admin',
    beforeEnter : guardMyroute,
    component : ProductAdmin
  },
  {
    path: '/auth/users',
    name : 'Users',
    beforeEnter : guardMyroute,
    component : UserAdmin
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router

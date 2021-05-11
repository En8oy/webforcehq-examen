import Vue from 'vue'
import Vuex from 'vuex'
import Product from './product'
import User from './user'
import Cart from './cart'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)
export default new Vuex.Store({
  state: {
    url : "http://127.0.0.1:8000/api/",
    color : "blue",
    colors : [
      {color : "red darken-4", name : "Red"},
      {color : "pink darken-1", name : "Pink"},
      {color : "purple darken-4", name : "Purple"},
      {color : "indigo", name : "Indigo"},
      {color : "deep-orange", name : "Orange"},
      {color : "brown" , name : "Brown"},
      {color : "blue darken-3", name : "Blue"},
      {color : "cyan darken-4", name : "Cyan"},
      {color : "teal", name : "Teal"},
      {color : "green darken-3", name : "Green"},
      {color : "yellow darken-2", name : "Yellow"},
      {color : "grey darken-3", name : "Grey"},
      {color : "grey darken-4", name : "Black"}
    ]
  },
  mutations: {
    CHANGE_COLOR(state, payload){
    }
  },
  actions: {
  },
  modules: {
    Product,
    User,
    Cart
  },
  plugins: [createPersistedState()]
})

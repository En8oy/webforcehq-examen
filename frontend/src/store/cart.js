import axios from 'axios'
export default { 
    namespaced : true,
    state : {
        carts : [],
        total : 0
    },
    mutations : {
        SET_CART(state, payload, commit){
            let product = null
            for (let index = 0; index < state.carts.length; index++) {
                if(state.carts[index].id == payload.id){
                    product = index
                }
            }

            if (product != null) {
                state.carts[product].quantity = payload.quantity
            }else{
                let totalPrice = payload.price * payload.quantity
                state.carts.push(payload)
            }
        },
        REMOVE_TO_CART(state, payload){
            let finalPrice = state.carts[payload.index].quantity * state.carts[payload.index].price
            state.carts.splice(payload.index, 1)
        },
        UPDATE_TOTAL(state){
            let total = 0
            for (let index = 0; index < state.carts.length; index++) {
                let price = state.carts[index].price * state.carts[index].quantity
                total = total + price;
            }
            state.total = total
        }
    },
    actions : {
        addToCart({rootState, commit}, payload){
            return new Promise((resolve) => {
                commit("SET_CART", payload)
                commit("UPDATE_TOTAL")
                resolve(payload.quantity + " Products aggregates")
            })
        },
        deleteProduct({commit}, payload){
            return new Promise((resolve) => {
                commit("REMOVE_TO_CART", payload)
                commit("UPDATE_TOTAL")
                resolve("Product Deleted")
            })
        }
    }
}
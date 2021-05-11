import axios from 'axios'
export default { 
    namespaced : true,
    state : {
        products : [],
        product : {}
    },
    mutations : {
        SET_PRODUCTS(state, payload){
            state.products = payload
        },
        SET_PRODUCT(state, payload){
            state.product = payload
        }
    },
    actions : {
        getProducts({rootState, commit}, payload){
            return new Promise((resolve, reject) => {
                axios.get(rootState.url + "products")
                .then(res => {
                    commit("SET_PRODUCTS", res.data.products)
                    resolve("Products Updated")
                })
                .catch(err => {
                    console.error(err);
                    reject("Products Error")
                })
            })
        },
        getProduct({rootState, commit}, payload){
            return new Promise((resolve, reject) => {
                axios.get(rootState.url + "products/"+ payload.slug)
                .then(res => {
                    commit("SET_PRODUCT", res.data.product)
                    resolve("Product Success")
                })
                .catch(err => {
                    console.error(err);
                    reject("Products Error")
                })
            })
        }
    }
}
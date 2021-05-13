import axios from 'axios'
export default { 
    namespaced : true,
    state : {
        token : "",
        user : {}
    },
    mutations : {
        SET_USER(state, payload, commit){
            state.token = payload.token,
            state.user = payload.user
        },
        
    },
    actions : {
        login({rootState, commit}, payload){
            return new Promise((resolve, reject) => {
                axios.post(rootState.url + "login",payload)
                .then(res => {
                    commit("SET_USER", res.data);
                    resolve("Login Success")
                })
                .catch(err => {
                    reject(err)
                })
            })
        },
    }
}
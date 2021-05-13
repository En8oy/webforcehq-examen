import axios from 'axios'
export default { 
    namespaced : true,
    state : {
        token : "",
        user : {}
    },
    mutations : {
        SET_USER(state, payload){
            state.token = payload.token,
            state.user = payload.user
        },
        CLEAN_USER(state, payload){
            state.token = "",
            state.user = {}
        }
        
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
        logout({rootState, commit}, payload){
            axios.get(rootState.url + "admin/logout",{headers: { Authorization: "Bearer " + rootState.User.token }})
            .then(res => {
                commit("CLEAN_USER");
            })
            .catch(err => {
                console.log(err)
            })
        }
    }
}
import axios from 'axios'
export default { 
    namespaced : true,
    state : {
        token : "",
        user : {}
    },
    mutations : {
        SET_USER(state, payload, commit){
    
        },
        
    },
    actions : {
        login({rootState, commit}, payload){
            return new Promise(resolve => {
                axios.post(rootState.url + "login",params)
                .then(res => {
                    console.log(res)
                    resolve("success")
                })
                .catch(err => {
                    console.error(err); 
                })
            })
        },
    }
}
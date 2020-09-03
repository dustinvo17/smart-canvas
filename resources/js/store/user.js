import axios from '../axios_config'
export const user = {
    state: () => ({ 
         user_info:{}
        
    })           
    ,
    mutations: {
        updateUser(state,user) {
          // `state` is the local module state
          state.user_info = {...user}
        }
    },
    getters: {
        getUser(state){
          return state.user_info
        }   
    },
    actions: {
        async fetchUser({state,commit}) {
            const res = await axios.get('/api/user')
            await commit('updateUser',res.data)
            return res.data
            
        }
        
        
    }
}
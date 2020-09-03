import axios from '../axios_config'

export const todos = {
    state: () => ({ 
        todos: []
       
   })           
   ,
   mutations: {
      updateTodos(state,todos) {
          return state.todos = todos.reverse();
      },
      addTodo(state,todo) {
          return state.todos.unshift(todo)
      },
      updateSingleTodo(state,todos) {
          return state.todos = todos.reverse()
      },
      deleteSingleTodo(state,todos) {
        return state.todos = todos.reverse()
    }
   },
   getters: {
        getTodos(state){
            return state.todos
        }
   },
   actions: {
        async fetchTodos({state,commit}){
            const res = await axios.get('/api/todos')
            await commit('updateTodos',res.data)
            return res.data
        },
        async addNewTodo({state,commit},todo){
            const res = await axios.post('/api/todos',todo)
       
            await commit('addTodo',res.data)
            return res.data
        },
        async updateTodo({state,commit},todo){
            const res = await axios.put(`/api/todos/${todo.id}`,todo)
            await commit('updateSingleTodo',res.data)
            return res.data
        },
        async deleteTodo({state,commit},id) {
            const res = await axios.delete(`/api/todos/${id}`)
            await commit('deleteSingleTodo',res.data)
            return res.data
        }

        
       
   }
}
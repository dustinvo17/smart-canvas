import axios from '../axios_config'
export const events = {
    state: () => ({ 
        events:[],
        upcomingEvents:[]
        
    })           
    ,
    mutations: {
        updateEvents(state, events){
            return state.events = events;
        },
        addNewEvent(state,event) {
            return state.events.push(event)
        },
        updateEvent(state,eventUpdated) {
            const oldItemIndex = state.events.findIndex(event => event.id == eventUpdated.id)
            return state.events.splice(oldItemIndex,1,eventUpdated)
  
        },
        deleteEvent(state,deletedId) {
            return state.events = state.events.filter(event => event.id != deletedId)
        },
        upcomingEvents(state,events) {
            return state.upcomingEvents = events
        }


    },
    getters: {
      getEvents(state){
          return state.events
      },
      getEventById: (state) => (id) =>{ 
   
          return state.events.find(event => event.id == id)
      },
      getUpcomingEvents(state){
          return state.upcomingEvents
      }
    },
    actions: {
        async fetchEvents({state,commit}) {
            const res = await axios.get('/api/events')
            await commit('updateEvents',res.data)
            return res.data
            
        },
        async addEvent({state,commit},event){
            const res = await axios.post('/api/events',event)
            await commit('addNewEvent',res.data)
           
            return res.data
        },
        async updateEvent({state,commit},event){
            const res = await axios.put('/api/events/' + event.id,event)
           
            await commit('updateEvent',res.data)
            return res.data
        },
        async deleteEvent({state,commit},id){
            const res = await axios.delete('/api/events/' + id)
            await commit('deleteEvent',res.data)
            return res.data
        },
        async fetchUpComingEvents({state,commit}){
            const res = await axios.get('/api/events/upcoming')
            await commit('upcomingEvents',res.data)
         
            return res.data.data
        }
        
        
    }
}
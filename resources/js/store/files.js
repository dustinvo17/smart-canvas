import axios from '../axios_config'
export const files = {
    state: () => ({ 
         files:[],
         favoriteFiles: []
        
    })           
    ,
    mutations: {
      updateFiles(state, files){
          return state.files = files.reverse();
      },
      addNewFile(state,file){
          return state.files.unshift(file)
      },
      deleteFile(state,deletedFileId){
          return state.files = state.files.filter(file => file.id != deletedFileId)
      },
      updateFavoriteState(state,favoriteFiles){
          return state.favoriteFiles = favoriteFiles.reverse()
      },
      updateFavoriteFile(state,favoriteFile) {
        const oldItemIndex = state.files.findIndex(file => file.id == favoriteFile.id)
        return state.files.splice(oldItemIndex,1,favoriteFile)
      }

    },
    getters: {
       getFiles (state){
           return state.files
       },
       getFavoriteFiles (state){
           return state.favoriteFiles
       }

    },
    actions: {
        async fetchFiles({state,commit}) {
            const res = await axios.get('/api/files')
            await commit('updateFiles',res.data)
            return res.data
            
        },
        async uploadNewFile({state,commit},file) {
            let formData = new FormData();
            formData.append('file',file)
            formData.append('title',file.name.replace('.pdf',''))
            const res = await axios.post('/api/files',formData, {headers: {'Content-Type': 'multipart/form-data'} }
            )
            await commit('addNewFile',res.data)
            return res.data
        },
        async removeFile({state,commit},file) {
            const res = await axios.delete('/api/files/' + file.id)
            console.log(res.data)
            await commit('deleteFile',res.data)
            console.log(state.files)
            return res.data
        },
        async fetchFavorite({state,commit}) {
            const res = await axios.get('/api/files/favorite')
            await commit('updateFavoriteState',res.data)
         
            return res.data
        },
        async toggleFavorite({state,commit},file){
            const res = await axios.put('/api/files/' + file.id, {
                favorite:!file.favorite
            })
            await commit('updateFavoriteFile',res.data)
            console.log(res.data)
            return res.data
        }
        
    }
}
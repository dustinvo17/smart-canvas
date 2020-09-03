import axios from 'axios'

axios.defaults.headers.common['Authorization'] = `Bearer ${access_token}`

export default axios;
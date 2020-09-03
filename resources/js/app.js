import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import VModal from 'vue-js-modal'
//font-awesome // 

import { library } from '@fortawesome/fontawesome-svg-core'
import { faUserSecret, faTachometerAlt, faFileAlt, faArchive, faCalendar, faFolder, faCalendarAlt, faQuestionCircle, faExclamation, faExclamationCircle, faPlus, faWindowClose, faTimes, faPencilAlt, faFilePdf, faSpinner, faCircleNotch, faTrash, faFlag } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
 
library.add(faTachometerAlt)
library.add(faFolder)
library.add(faCalendarAlt)
library.add(faQuestionCircle)
library.add(faExclamationCircle)
library.add(faPlus)
library.add(faTimes)
library.add(faPencilAlt)
library.add(faPlus)
library.add(faFilePdf)
library.add(faCircleNotch)
library.add(faTrash)
library.add(faFlag)
// //

Vue.use(VueRouter)
Vue.use(Vuex)

// App components //
import App from './components/App'
import Files from './components/files'
import Home from './components/Home'
import File from './components/file-component/File.vue'
import Events from './components/Events.vue'
//
const basePath = '/dashboard'

// init route
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/dashboard/home',
            name: 'home',
            component: Home
        },
        {
            path: '/dashboard/files',
            name: 'files',
            component: Files,
        },
        {
            path:'/dashboard/files/:id',
            name:'file',
            component:File,
            props:true
        },
        {
            path:'/dashboard/events',
            name:'events',
            component:Events

        }
    ],
});
// 

// init store 

// module store // 
import {user} from './store/user'
import {todos} from './store/todos'
import {files} from './store/files'
import {events} from './store/events'
// 
const store = new Vuex.Store({
    modules: {
      user,
      todos,
      files,
      events
    }
  })   

//

// add font awesome // 
Vue.component('font-awesome-icon', FontAwesomeIcon)
// //

// Add datetime-picker //
import { Datetime } from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css'
Vue.component('datetime', Datetime);
//

// Setup Notification //
import Notifications from 'vue-notification'
Vue.use(Notifications)

// // 

// vue point //
import VueWaypoint from 'vue-waypoint'

Vue.use(VueWaypoint)
// //

// vue context// 

// Modal //
Vue.use(VModal)

  
const app = new Vue({
    el: '#app',
    render: h => h(App),
    router,
    store
})
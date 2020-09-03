<template>
    <div class="dashboard-page-navbar">

        <div class="dashboard-page-navbar__img">
            <img :src="user.avatar">
            <div  class="dashboard-page-navbar__img-logout">
                <a href="/logout" class="logout">Logout</a>
            </div>
        </div>
        <router-link to="/dashboard/home" >

             <font-awesome-icon icon="tachometer-alt" />
        </router-link>
           <router-link to="/dashboard/files" >

             <font-awesome-icon icon="folder" />
        </router-link>
            <router-link to="/dashboard/events" >

             <font-awesome-icon icon="calendar-alt" />
        </router-link>
   
    </div>
</template>

<script>
    export default {
        name:'navbar',
        data : () => {
            return {
                user:{},
            
              

            }
        },
        created: async function(){
            await this.$store.dispatch('fetchUser') 
            this.user = this.$store.getters.getUser
          
        }
    }
</script>
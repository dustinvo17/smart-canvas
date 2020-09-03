<template>
    <div class="dashboard-page">
    
        <navbar></navbar>

        <div class="dashboard-page-view">
            <router-view></router-view>
        </div>
            <notifications group="foo" />
    </div>
</template>

<script>
    import Navbar from './Navbar'
    export default {
       
      
        components:{
            'navbar':Navbar
        }

    }
</script>
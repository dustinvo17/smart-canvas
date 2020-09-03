<template>
    <div>
       <div class="vm--modal-top">
           <h3> {{edit ? 'Edit' : 'Create'}} Event</h3>
           <font-awesome-icon icon="times"  @click="closeModal"/>
       </div>
       <form class="vm--modal-form">
           <div class="vm--modal-form_group">
               <label for="title">Title:</label>
               <input v-model="title" type="text" id="title" required>
          

           </div>
           <div class="vm--modal-form_group">
               <label for="date">Date:</label>
               <input v-model="date" type="date" id="date">
          

           </div>
             <div class="vm--modal-form_group">
                 <div class="time-group">
                      <label for="from">From:</label>
               <input v-model="from" type="time" id="time">
                 </div>
              
                <div class="time-group">
                     <label for="to">To:</label>
               <input v-model="to" type="time" id="to">
                </div>

           </div>
           <div class="vm--modal-form_group">
               <label for="location">Location:</label>
               <input v-model="location" type="text" id="location">
          

           </div>
       </form>
        <div class="vm--modal-bottom" >
             <button class="vm--modal-bottom-delete" @click="handleDelete" v-if="edit" type="button">Delete</button>
           <button @click="submitForm" type="button">{{edit ? 'Update' : 'Submit'}}</button>
       </div>
    </div>
</template>

<script>
export default {
    name:'event-modal',
    props:['startDate','edit','title','from','to','location','date','id'],

    created(){
 
    },
    methods: {
        closeModal(){
            this.$emit('close')
        },
        async submitForm(){
       
            const eventObject = {
                title:this.title,
                date:this.date,
                from:this.from,
                to:this.to,
                location:this.location,
                id:this.id
            }
            if(this.edit){
                console.log('run')
             await this.$store.dispatch('updateEvent',eventObject)
                
            }else{
             await this.$store.dispatch('addEvent',eventObject)
            }
      
           this.closeModal()
        },
       async handleDelete(){
            await this.$store.dispatch('deleteEvent',this.id)
            this.closeModal()
        }
    }
}
</script>

<style>

</style>
<template>
  <li class="todo-item">
      <div v-if="showForm === false " >
             <p>{{todo.item}}</p>
      <small v-if="todo.due_day"> <b>Due Day</b>: {{new Date(todo.due_day).toLocaleDateString()}}</small>
      </div>
      
    <form class="todo-item-edit-form"  v-if="showForm" >
        <textarea v-model="item"></textarea>
             <datetime title="To Do Due Day" v-model="date"></datetime>
            <div>
            <button @click="updateItem(todo.id)" type="button">Update Item</button>
            <button  type="button" v-on:click="showForm=false">
              <font-awesome-icon icon="times" />
            </button>
          </div>
    </form>
      
        <div class="edit-icons">
            <font-awesome-icon icon="pencil-alt" />
            <ul class="edit-icons-dropdown">
                <li>
                    <p @click="showForm = true">Edit</p>
                </li>
                <li @click="deleteItem(todo.id)">
                      <p>Archive</p>
                  
                </li>
            </ul>
        </div>
         
  </li>
</template>

<script>
export default {
    props:{
        todo:{
        }
    },

    data(){
        return {
            showForm:false,
            date: this.todo.due_day,
            item:this.todo.item,
        }
    },
    methods: {
        async updateItem(id){
          
            let todo_updated = {
                id,
                item:this.item
            }
            if(this.date) {
                todo_updated.due_day =  this.date
            }
            await this.$store.dispatch('updateTodo',todo_updated)
      
            this.showForm = false;

        },
        async deleteItem(id){
            await this.$store.dispatch('deleteTodo',id)
          
            this.showForm = false;
        }
    }
}
</script>

<style>

</style>
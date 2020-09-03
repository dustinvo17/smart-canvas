<template>
  <div class="dashboard-home">
    <div class="dashboard-home__top">
      <div class="dashboard-home__top-content">
        <div class="dashboard-home__top-content-notification">
          <div>
            <font-awesome-icon icon="exclamation-circle" />Welcome to Smart Canvas! The Best Place To Maximize Your Productivity, Manage Your Learning Material, Events, And Goals. 
          </div>
        </div>
        <div class="dashboard-home__top-main">
          <div class="dashboard-home__top-main--tapbar">
            <div>
              <button
                :class="showFavorite ? 'tap-active' : ''"
                @click="showFavorite = true"
                type="button"
              >Favorite Resources</button>
              <button
                :class="showFavorite == false ? 'tap-active' : ''"
                @click="showFavorite = false"
                type="button"
              >Upcoming Events</button>
            </div>
          </div>
          <div v-if="showFavorite" class="dashboard-home__top-main--resource">
            <div v-if="favoriteFiles.length > 0" class="files-pdf-container">
              <div
                class="file-pdf"
                :data-file-id="file.id"
                v-for="file in favoriteFiles"
                v-bind:key="file.id"
              >
                <router-link :data-file-id="file.id" :to="'/dashboard/files/' + file.id">
                  <pdf :src="file.file_path" />
                  <p v-if="file.title">
                    <font-awesome-icon icon="file-pdf" />
                    {{file.title}}
                  </p>
                </router-link>
              </div>
            </div>
            <h3 v-else>No Favorite Resources Added</h3>
          </div>
          <div v-if="showFavorite === false && upcomingEvents" class="dashboard-home__top-main--events">
            <div v-if="upcomingEvents.length > 0">
              <h3>You Have {{upcomingEvents.length}} Upcoming Events</h3>
              <div v-for="event in upcomingEvents" :key="event.id"  class="dashboard-home__top-main--event">
                <p><span>Event</span>: {{event.title}}</p>
                <p><span>Date</span>: {{event.date}}</p>
                <p v-if="event.from"><span>From</span>: {{event.from ? event.from : 'N/A'}}</p>
                <p v-if="event.to"><span>To</span>: {{event.to ? event.to : 'N/A'}}</p>
                <p v-if="event.location"><span>Location</span>: {{event.location ? event.location : 'N/A'}}</p>
              </div>
            </div>
            <h3 v-else>You Have No Upcoming Events</h3>

          </div>
        </div>
      </div>
      <div class="dashboard-home__top-todo">
        <h4>TO DO</h4>
        <div class="add-to-do-ui" v-on:click="showForm=true" v-if="showForm === false">
          <font-awesome-icon icon="plus" />
          <span>Add another item</span>
        </div>
        <form class="add-to-do-form" v-if="showForm" v-on:submit="onFormSubmit">
          <div class="add-to-do-form-field">
            <label>Item</label>
            <textarea v-model="todo" />
          </div>
          <div class="add-to-do-form-field">
            <label>Due Day (Optional)</label>
            <datetime title="To Do Due Day" v-model="date"></datetime>
          </div>
          <div class="add-to-do-form-field">
            <button>Add Item</button>
            <button type="button" v-on:click="showForm=false">
              <font-awesome-icon icon="times" />
            </button>
          </div>
        </form>
        <ul v-if="todos.length > 0" class="todolist">
          <home-todo v-for="todo in todos" v-bind:key="todo.id" :todo="todo"></home-todo>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
import pdf from "vue-pdf";
import HomeTodo from "./home-component/HomeTodo";

export default {
  components: {
    "home-todo": HomeTodo,
    pdf,
  },
  computed: {
    todos() {
      return this.$store.getters.getTodos;
    },
    favoriteFiles() {
      return this.$store.getters.getFavoriteFiles;
    },
    upcomingEvents() {
      return this.$store.getters.getUpcomingEvents.data;
    },
  },
  data: () => {
    return {
      showForm: false,
      todo: "",
      date: "",
      showFavorite: false,
    };
  },
  created: async function () {
    await this.$store.dispatch("fetchTodos");
    await this.$store.dispatch("fetchFavorite");
    await this.$store.dispatch("fetchUpComingEvents");
  },
  methods: {
    async onFormSubmit(e) {
      e.preventDefault();
      if (!this.todo) {
        // notify user
        return;
      }
      const todo_to_send = {
        item: this.todo,
      };

      if (this.date) {
        todo_to_send.due_day = this.date;
      }
      await this.$store.dispatch("addNewTodo", todo_to_send);
      this.todo = "";
      this.date = "";
      this.showForm = false;
    },
  },
};
</script>
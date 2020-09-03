<template>
  <div class="calendar-container">
    <FullCalendar ref="calendar" :options="calendarOptions"  />
    <event-modal></event-modal>
  </div>
</template>

<script>
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import interactionPlugin from "@fullcalendar/interaction";
import ListPlugin from "@fullcalendar/list";
import Modal from "./Modal";
export default {
  components: {
    FullCalendar,
  },
  computed: {
 
    calendarOptions:function() {
      return {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin, ListPlugin],
        selectable: true,
        events:this.$store.getters.getEvents,
        dateClick: this.handleDateClick,
       
        headerToolbar:{
           left: 'prev,next today',
        center: '',
      right:'title'
        },
        eventClick:this.handleEventClick,
  
        buttonText: {
          today: "Today",
        },
      }
        
      },
  },
 
  async created() {
    await this.$store.dispatch("fetchEvents");

  },
  methods: {
    handleDateClick: function (arg) {
      console.log(arg);
      this.$modal.show(Modal, { date: arg.dateStr });
    },
    handleEventClick: function(info) {
      
      const event = this.$store.getters.getEventById(info.event.id)
 
      const {title,location,from,to,date,id} = event 
      this.$modal.show(Modal,{ title,location,from,to,date,id, edit:true})
    }
   
  },
};
</script>

<style>
</style>
<template>
  <div class="files-container">
    <div class="files-top">
      <h2>Learning Resources</h2>
    </div>
    <div class="pdf-tracking-bar" >
        <p>Page {{currentPage}} / {{numPages}}</p>
    </div>
      <div class="file-pdf loading-item" v-if="fullyLoaded === false" >
    
          <font-awesome-icon icon="circle-notch" />
          <div class="loading">
            
            <div class="loading__letter">L</div>
            <div class="loading__letter">o</div>
            <div class="loading__letter">a</div>
            <div class="loading__letter">d</div>
            <div class="loading__letter">i</div>
            <div class="loading__letter">n</div>
            <div class="loading__letter">g</div>
            <div class="loading__letter">.</div>
            <div class="loading__letter">.</div>
            <div class="loading__letter">.</div>
          </div>
     
      </div>
    <div class="pdf-item-wrapper" >
      <pdf
        :src="file.file_path"
        :data-page="i"
        v-for="i in numPages"
        :key="i"
        v-waypoint="{ active: true, callback:onWaypoint}"
        @page-loaded="handleProgress"
        :page="i"
        v-bind:style="[!fullyLoaded ? {'opacity':0} : {'opacity':1}]"
      />
    </div>
    
  </div>
</template>

<script>
import axios from "../../axios_config";
import pdf from "vue-pdf";
export default {
  props: ["id"],
  components: {
    pdf,
  },
  data() {
    return {
      file: {},
      fullyLoaded:false,
      numPages: undefined,
      currentPage:1,
      
    };
  },
  methods: {
    handleProgress(e) {
        // show when all pages loaded
      if (e === this.numPages) this.fullyLoaded = true;
    },
    onWaypoint({ going, direction, el }) {
      
         if (going === this.$waypointMap.GOING_IN  ) { 
            this.currentPage = el.getAttribute("data-page")
            
          }

    
    }
  },

  async created() {
    const res = await axios.get("/api/files/" + this.id);

    this.file = res.data;
    pdf.createLoadingTask(res.data.file_path).promise.then((pdf) => {
      this.numPages = pdf.numPages;
    });

  },
  
  async mounted() {
    console.log(this);
  },
};
</script>

<style>
</style>
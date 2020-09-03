<template>
  <div class="files-container">
    <div class="files-top">
      <h2>Learning Resources</h2>
    </div>
    <form class="files-upload">
      <input @change="catchFileUpload" type="file" ref="file_upload" class="file-select" multiple />
      <div  >
           <button @click="triggerFileUpload" type="button" >
        <font-awesome-icon icon="plus" />New File 
      </button>
      <p>Maximun 3 Files, PDF Type Requied, File Must Less Than 10MB</p>
      </div>

   
    </form>

    <div class="files-pdf-container">
     
      <div class="file-pdf loading-item" v-for="item in loadingItems" v-bind:key="item">
    
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
      <div class="file-pdf" :data-file-id="file.id" v-for="file in files" v-bind:key="file.id" @contextmenu.prevent="$refs.menu.open($event,file)">
      <router-link :data-file-id="file.id"  :to="'/dashboard/files/' + file.id" >
        <pdf :src="file.file_path" />
        <p :data-file-id="file.id" v-if="file.title">
          <font-awesome-icon icon="file-pdf" />
          {{file.title}}
        </p>
      </router-link>

      </div>
          <vue-context ref="menu" >
            <template slot-scope="child" v-if="child.data">
           <li>
             <a href="#" @click.prevent="toggleMark(child.data)"> <span>{{child.data.favorite == 1 ? 'Remove From' : 'Add To'}} Favorite </span><font-awesome-icon icon="flag" /> </a>
           </li>
                <li>
            <a href="#" @click.prevent="handleDelete(child.data)"> <span>Delete Item</span>  <font-awesome-icon icon="trash" /></a>
           </li>
            </template>
      
   
    </vue-context>
        
    </div>
  </div>
</template>
<script>
import pdf from "vue-pdf";
import VueContext from 'vue-context';
export default {
  data() {
    return {
 
      loadingItems:0,
    
    };
  },
  components: {
    pdf,
      VueContext
  },
  computed: {
    files: function () {
      return this.$store.getters.getFiles;
    },
  },
  methods: {
    triggerFileUpload(e) {
      this.$refs.file_upload.click();
    },
    async catchFileUpload(e) {
      if (e.target.files.length > 3) {
        // notify user error upload max 3 files
        return;
      }
      this.loadingItems = e.target.files.length
      for (let i = 0; i < e.target.files.length; i++) {
        let file = e.target.files[i];
   
        if (file.type === "application/pdf" && file.size < 10485760) {
       
          await this.$store.dispatch("uploadNewFile", file);
          this.loadingItems -=1;
        }
      }

    },
    handleDelete(file){
      this.$store.dispatch('removeFile',file)
     
    },
    toggleMark(file){
      this.$store.dispatch('toggleFavorite',file)
    }
  },
  created: async function () {
    await this.$store.dispatch("fetchFiles");
  },
};
</script>
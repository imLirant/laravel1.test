<style scoped>
  .fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
  opacity: 0;
}

.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active до версии 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}

</style>

<template>
  <div class="card" style="width: 20rem;">
    <transition name="slide-fade">
      <img v-show="!is_refresh" class="card-img-top" :src="user.image" alt="User image">
    </transition>
    
    <div class="card-body">
      <input class="form-control" @change="fileChange($event.target.files)" type="file" name="file">
      <br>
      <button @click="submit" class="btn btn-primary active">Upload</button>
    </div>
  </div>
</template>

<script>
  export const HTTP = axios.create({
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  })

  export default {
    props: {
      user: Object,
    },
    data: ()=> ({
      file: null,
      errorDialog: null,
      errorText: '',
      uploadFieldName: 'file',
      maxSize: 1024,

      is_refresh: false,
    }),
    methods: {
      launchFilePicker(){
        this.$refs.file.click();
      },
      
      fileChange(files) {
        
        if (files.length > 0) {
          this.file = files[0];
        }
      },

      submit: function() {
        
        this.is_refresh = true;

        let data = new FormData();
        
        data.append('image', this.file, this.file.name);
        
        const config = {
            headers: { 'content-type': 'multipart/form-data' }
        }

        axios.post('/profile/edit', data, config)
          .then((response) => {
            this.user.image = response.data.user.image;
          })
          .catch(e => {
          // this.errors.push("Failed to send comment: " + e.message)
            console.log("Failed to upload image: " + e.message)
          })
          .finally(() => { this.is_refresh = false })
        ;
      }
    }
  }
</script>
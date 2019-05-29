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


  <div>   
    <link href="https://cdn.jsdelivr.net/npm/animate.css@3.5.1" rel="stylesheet" type="text/css">

    <transition
      name="custom-classes-transition"
      enter-active-class="animated tada"
      leave-active-class="animated bounceOutRight"
    >
      <div v-if="!is_refresh" class="card text-center" style="width: 18rem;">
        <img :src="image" class="card-img-top" :alt="answer">
        <div class="card-body">
          <h5 class="card-title">{{answer}}</h5>
          <a @click="update" class="btn btn-primary">Refresh</a>
        </div>
      </div>
    </transition>
        
  </div>
    
</template>

<script>

  export default {
      data: function() {
        return {
            answer: '',
            image: '',
            errors: [],
            is_refresh: false,
        }
      },

      mounted() {
            this.update()
        },
      
      methods: {
        update: function() {
          this.is_refresh = true;
          axios.get('/answer-get').then((response) => {
            this.answer = response.data.answer
            this.image = response.data.image
            this.is_refresh = false;
          })
          .catch(e => {
            this.errors.push("Failed to send comment: " + e.message)
          });
        },
      }
  }
</script>

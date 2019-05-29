<template>
  <div class="row justify-content-center">   
    
    <div class="card" style="width: 16rem;">
      <img v-if="user" class="card-img-top" :src="user.image" alt="Card image cap">
      <img v-else class="card-img-top" src=/images/anonymous-user.jpg alt="Card image cap">
      
      <div v-if="user" class="card-body">
        <h5 class="card-title">{{user.name}}</h5>
          <p class="text-center text-muted">{{user.first_name}} {{user.last_name}}</p>
        <p class="text-center text-muted"> {{user.residence}}</p>
        <div v-if="userGeted">
          <p class="text-right text-muted">Followers: {{twitterUser.followers_count}}</p>  
        </div>
      </div>
      
      <div v-else class="card-body">
        <h5 class="card-title">Unknown</h5>
      </div>
    
    </div>

    <iframe v-if="user.marscn" width="882" height="369" :src="user.marscn" frameborder="0"></iframe>    
    
  </div>
</template>

<script>
  export default {
      props: {
          user: Object,
        },
      data: function() {
        return {
            twitterUser: Object,
            userGeted: false
        }
      },
      created() {
        this.$eventBus.$on('set-twitterUser', this.setTU);
        if (this.user.marscn) {
            this.user.marscn = "https://mars.nasa.gov/layout/embed/send-your-name/mars2020/certificate/?cn=" + this.user.marscn;
          }
      },
      mounted() {
               
        },
      methods: {
        setTU: function(tuser) {
          this.twitterUser = tuser;
          this.userGeted = true;
          console.log(tuser);
        },
      }
  }
</script>

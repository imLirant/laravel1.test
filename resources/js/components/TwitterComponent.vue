<template>

    <div class="row justify-content-center">   

    <div v-for="comm in items" :key="comm.id">
      <transition name="fade">
      
        <div class="card mb-3" style="max-width: 540px;">
          
          <div class="row align-items-center">
            <div class="col-md-4">
              <img class="card-img-top img-thumbnail" :src= comm.user.profile_image_url alt="Card image cap">              
            </div>
        
            <div class="col-md-8">
              
              <div class="card-body">
                <h5 class="card-title">
                  <a class="nav-link " :href= comm.user.profileUrl>
                    {{comm.user.name}}
                  </a>
                </h5>
                  
                <!-- <h6 class="card-subtitle mb-2 text-center text-muted">{{ comm.theme }}</h6> -->
                <p class="card-text mb-2 text-muted">{{ comm.text }}</p>
                <p class="card-text"><small class="text-muted">{{ comm.created_at }}</small></p>
                  
              </div>
            </div>
          </div>
        </div>

      </transition>
    </div>
      
  </div>
</template>

<script>
  export default {
      props: {
          username: '',
          //Count: Number
        },
      data: function() {
        return {
            items: {},
            params: {
              username: "",
              count: -1, 
            },
        }
      },
      mounted() {
            this.send();
        },
      methods: {
        send: function() {

            // this.params.username = this.userName;
            // this.params.count = this.count;

            this.params.username = this.userName;
            this.params.count = "5";


            axios.post('/getTimeline', this.params).then((response) => {
              console.log(response.data)
              this.items = response.data
            })
            .catch(e => {
              console.log(e)
            });
        },
      }
  }
</script>

<template>
  <div class="row justify-content-center">   
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Twitts</div>
        <div class="card-body">
          <div class="container">
            <div class="row justify-content-md-center">
              <div class="col-md-auto">
                <button @click="update" class="btn btn-default text mb-1" v-if="!is_refresh">
                  Refresh
                </button>
                <span class="badge badge-primary mb-1" v-if="is_refresh">Refreshing</span>
                
                <div v-for="twitt in items" :key="twitt.id">
                  <div class="card mb-3" style="max-width: 540px;">
                    <div class="row align-items-center">
                      <div class="col-md-4">
                        <img class="card-img-top img-thumbnail" :src= imagePath alt="Card image cap">
                      </div>
                      <div class="col-md-8"> 
                        <div class="card-body">
                          <h5 class="card-title">
                            <!-- <a class="nav-link " :href= twitt.user.profileUrl> -->
                              {{twitt.user.name}}
                            <!-- </a> -->
                          </h5>
                          
                          <p v-if="twitt.in_reply_to_screen_name" class="card-text mb-2 text-muted">
                            Reply to: {{ twitt.in_reply_to_screen_name }}
                          </p>

                          <p class="card-text mb-2 text-muted">{{ twitt.text }}</p>
                          
                          <p class="card-text">
                            <small class="text-muted">
                              {{ twitt.created_at }}
                            </small>
                          </p>
                          
                          <p class="card-text text-right">
                            <small class="text-muted">
                              Favorits {{ twitt.favorite_count }} Retweeted {{ twitt.retweet_count }}
                            </small>
                          </p>

                          <p class="card-text text-left">
                            <small v-for="url in twitt.entities.urls" class="text-muted">
                              <a class="nav-link " :href= url.expanded_url>{{url.display_url}}</a>
                            </small>
                          </p>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      user: Object,
    },
    data: function() {
      return {
        items: {},
        params: {
          username: '',
          count: -1, 
        },
        is_refresh: false,
        imagePath: "",
      }
    },
    created() {
      this.$eventBus.$on('pooling-tick', this.update);
    },
    beforeDestroy() {
      this.$eventBus.$off('pooling-tick');
    },

    mounted() {
      this.update();
      this.$eventBus.$emit('pooling-start');
    },
    methods: {
      update: function() {
        this.is_refresh = true;
        this.params.username = this.user.name;
        this.params.count = this.user.count;

        axios.post('/getTimeline', this.params).then((response) => {
          this.items = response.data
          if(this.items.length > 0) {
            this.imagePath = this.items[0].user.profile_image_url_https.replace('_normal', '');
            this.$eventBus.$emit('set-twitterUser', this.items[0].user);
          }
        })
        .catch(e => {
          console.log(e)
        }).finally(() => { this.is_refresh = false });
      },
    }
  }
</script>

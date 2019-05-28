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

  <div class="row justify-content-center">   

    <div style="width: 100%; max-width: 530px; padding: 15px; margin: auto;">
      
      <div v-if="errors && errors.length">
        <div v-for="(error, index) of errors" :key="index" class="alert alert-danger alert-dismissible fade show" role="alert">
          {{error}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>

      <div v-if="messages && messages.length">
        <div v-for="(message, index) of messages" :key="index" class="alert alert-success alert-dismissible fade show" role="alert">
          {{message}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      
    </div>
      <div class="col-md-8">
        <div class="card">

          <div class="card-header">Comments {{totalCount}}</div>
          <div class="card-body">
            <div class="container">
              <div class="row justify-content-md-center">
                <div v-if="pageCount > 1">
                  <nav aria-label="...">
                    <ul class="pagination justify-content-center pagination">

                      <li class="page-item" v-bind:class="{ disabled: currentPage === 0 }">
                        <a class="page-link" @click="prevPage" tabindex="-1">Previous</a>
                      </li>

                      <li v-for="n in pageCount" class="page-item" v-bind:class="{ active: (n-1) === currentPage }">
                        <a class="page-link" @click="getPage(n-1)"> {{n}} </a>
                      </li>
                      
                      <li class="page-item" v-bind:class="{ disabled: (currentPage + 1) >= pageCount }">
                        <a class="page-link" @click="nextPage" tabindex="-1">Next</a>
                      </li>

                    </ul>
                  </nav>
                </div>
                <div class="col-md-auto">
                  <button @click="update" class="btn btn-default text mb-1" v-bind:class="{ disabled: is_refresh, active: !is_refresh }">
                    Refresh
                  </button>
                  <!-- <span class="badge badge-primary mb-1" v-if="is_refresh">Refreshing</span> -->

                  <div v-for="comm in items.data" :key="comm.id">
                    <transition name="fade">
                    
                      <div v-if="comm.user !== null && comm.id !== deleteId" class="card mb-3" style="max-width: 540px;">
                        
                        <div class="row align-items-center">
                          <div class="col-md-4">
                            <img class="card-img-top img-thumbnail" :src= comm.user.image alt="Card image cap">              
                          </div>
                      
                          <div class="col-md-8">
                            
                            <a v-if="userId === comm.user_id" class="close" @click="del(comm.id)">×</a>
                            
                            <div class="card-body">
                              <h5 class="card-title">
                                <a class="nav-link " :href= comm.user.profileUrl>
                                  {{comm.user.name}}
                                </a>
                              </h5>
                                
                              <h6 class="card-subtitle mb-2 text-center text-muted">{{ comm.theme }}</h6>
                              <p class="card-text mb-2 text-muted">{{ comm.text }}</p>
                              <p class="card-text"><small class="text-muted">{{ comm.created_at }}</small></p>
                                
                            </div>
                          </div>
                        </div>
                      </div>

                    </transition>
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
          in_page: Number,
        },
        data: function() {
            return {
                items: {},
                currentPage: 0,
                pageCount: 0,
                totalCount: 0,
                is_refresh: false,
                errors: [],
                messages: [],
                userId: -1,
                deleteId: -1,
                lastId: -1,
            }
        },
        mounted() {
            this.tick();
            this.longPoolStart();
        },
        created() {
            this.$eventBus.$on('comment_send', this.update);
            this.$eventBus.$on('pooling-tick', this.tick);
        },
        beforeDestroy(){
            this.$eventBus.$off('comment_send');
            this.$eventBus.$on('pooling-tick');
        },

        methods: {
            update: function() {
                this.getPage(0);
            },

            nextPage: function() {
              
              if (this.currentPage + 1 < this.pageCount)
              {
                this.getPage(++this.currentPage);  
              }
            },

            prevPage: function() {
              
              if (this.currentPage > 0) {
                this.getPage(--this.currentPage);
              }
            },

            getPage: function(page) {
              this.is_refresh = true;

              axios.get('/comments/get-json?in_page=' + this.in_page + '&page=' + page).then((response) => {
                    this.items = response.data
                    this.pageCount = this.items.pageCount
                    this.totalCount = this.items.totalCount
                    this.userId = response.data.userId;
                    this.is_refresh = false
                    this.currentPage = page
                    this.deleteId = -1
                });

            },

            longPoolStart: function() {
              this.$eventBus.$emit('pooling-start');
            },

            tick: function() {
              if (!this.is_refresh && this.currentPage === 0) {
                axios.get('/comments/get-count').then((response) => {
                  if (response.data.lastId !== this.lastId || response.data.count !== this.totalCount) {
                    this.update();
                    this.lastId = response.data.lastId;
                  }
                })
                .catch(e => {
                  // this.errors.push("Failed to get comments count: " + e.message)
                });
              }
            },

            del: function(id) {
              this.deleteId = id;
              // axios.delete('/comments', {data: { comment_id: id }}).then((response) => {
                axios.get('/comment-delete?comment_id=' + id).then((response) => {
                
                this.getPage(this.currentPage)
              })
              .catch(e => {
                    console.log(e.message)
                    // this.errors.push("Failed to get comments count: " + e.message)
                  });
            },
        }
    }
</script>

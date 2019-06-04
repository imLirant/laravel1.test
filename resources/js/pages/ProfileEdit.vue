<template>

  <div>

    <div class="container">
      <div class="row">
        <div class="col-md-6">

          <div class="form-group row">
          
            <label for="staticLogin" class="col-md-3 col-form-label text-md-right">Login</label>
            <div class="col-md-9">
              <fieldset disabled>
                <input type="text" class="form-control" id ="staticLogin" :value="userInfo.name">
              </fieldset>
            </div>
          </div>
          
          <div class="form-group row">
            <label for="first_name" class="col-md-3 col-form-label text-md-right">First name</label>
            <div class="col-md-9">
              <input type="text" class="form-control" v-model="first_name" :placeholder="userInfo.first_name ? userInfo.first_name :'First name'">
            </div>
          </div>

          <div class="form-group row">
            <label for="last_name" class="col-md-3 col-form-label text-md-right">Last name</label>
            <div class="col-md-9">
              <input type="text" v-model="last_name" class="form-control" :placeholder="userInfo.last_name ? userInfo.last_name : 'Last name'">
            </div>
          </div>

          <change-password v-bind:min_length="8"></change-password>
        
          <div class="form-group row">
            <label for="email" class="col-md-2 col-form-label text-md-right">Email</label>
              <div class="col-md-10">
                <input type="email" v-model="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" 
                  :placeholder="userInfo.email ? userInfo.email : 'Enter email'">
                <small v-if="emailValid" id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                <small v-else id="emailHelp" class="form-text text-muted">Email invalid</small>
              </div>
          </div>
          
          <div class="form-group row">
            <label for="twitter" class="col-md-2 col-form-label text-md-right">Twitter</label>
            <div class="col-md-4">
              <input type="text" v-model="twitter" class="form-control" id="twitter" 
                   :placeholder="userInfo.twitter ? userInfo.twitter : 'Enter twitter'">
            </div>
          
            <label for="marscn" class="col-md-2 col-form-label text-md-right">Mars</label>
            <div class="col-md-4">
              <input type="text" v-model="marscn" class="form-control" id="marscn" 
                   :placeholder="userInfo.marscn ? userInfo.marscn : 'Enter mars cn'">
            </div>
          </div>
          
          <select-city v-bind:residence="userInfo.residence"></select-city>
          
          <center>
            <div class="row">    
              <div class="col">
                <button @click="get_info" class="btn btn-primary btn-lg active">Save</button>
              </div>
            </div>
          </center>
        </div>
        
        <div class="col-md-6">
          <div v-if="messages && messages.length">
          <br>
            <div v-for="(message, index) of messages" :key="index" class="alert alert-success alert-dismissible fade show" role="alert">
              {{message}}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
          <br>
          <center>
            <image-upload v-bind:user="userInfo"></image-upload>
          </center>
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
        userInfo: this.user,
        first_name: null,
        last_name: null,
        country_id: null,
        region_id: null,
        city_id: null,
        email: null,
        twitter: null,
        marscn: null,
        messages: [],
        emailValid: true,
      }
    },
    watch: {
      email: function(){
        if (this.email) {
          this.emailValid = this.validateEmail();
        }
        else {
          this.emailValid = true;
        }
      }
    },
    mounted() {
      
    },
    created() {
        this.$eventBus.$on('set_passwords', this.send);
        this.$eventBus.$on('city_selected', this.city);
    },
    
    beforeDestroy(){
        this.$eventBus.$off('set_passwords');
        this.$eventBus.$off('city_selected');
    },

    
    methods: {
      get_info: function() {
        this.$eventBus.$emit("get_passwords");
      },
      
      validateEmail: function() {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(this.email).toLowerCase());
      },

      send: function(oldPass, newPass, confirmPass, valid) {
        var props = {};

        if (valid) {
          props['old_pass'] = oldPass;
          props['password'] = newPass;
          props['password_confirmation'] = confirmPass;
        }

        if (this.city_id) {
          props['country_id'] = this.country_id;
          props['region_id'] = this.region_id;
          props['city_id'] = this.city_id;
        }

        if (this.first_name) {
          props['first_name'] = this.first_name;
        }

        if (this.last_name) {
          props['last_name'] = this.last_name;
        }

        if (this.email && this.emailValid) {
          props['email'] = this.email;
        }

        if (this.twitter) {
          props['twitter'] = this.twitter;
        }

        if (this.marscn) {
          props['marscn'] = this.marscn;
        }

        axios.post('/profile/edit', props)
          .then(
            (response) => {
              this.userInfo = response.data.user;
              this.messages = response.data.messages;
              if (response.data.email_changed) {
                
                setTimeout(function() { 
                  window.location.href = '/email/resend'; 
                }, 2000);
                 
              }
              this.clear();
            },
            (error) => { 
              this.messages.push(error.message);
            }
          )
        },
      
      city: function(city_id, region_id, country_id) {
        this.city_id = city_id;
        this.region_id = region_id;
        this.country_id = country_id;
      },

      clear: function() {
        this.first_name = null;
        this.last_name = null;
        this.country_id = null;
        this.region_id = null;
        this.city_id = null;
        this.email = null;
        this.twitter = null;
        this.marscn = null;
      }
    }
  }
  
</script>

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

      <input class="form-control" v-model="params.theme" type="text" placeholder="Theme">
      <textarea class="form-control" v-model="params.text" cols="40" rows="5" placeholder="Comment"></textarea>
      <br>
      <center><button @click="send" class="btn btn-primary btn-lg active">Send</button></center>
    
    </div>
      
  </div>
</template>

<script>
  export default {
    data: function() {
      return {
          params: {
              theme: null,
              text: null,
          },
          
          textValid: false,
          themeValid: false,

          errors: [],
          messages: [],
      }
    },
    
    methods: {
      send: function() {
        if (this.validate()) {
          axios.post('/comments-save', this.params).then((response) => {
              this.params.text = null
              this.params.theme = null
              this.messages.push(response.data.message)
              this.$eventBus.$emit('comment_send');
            })
          .catch(e => {
            this.errors.push("Failed to send comment: " + e.message)
          });
        }
      },
      validate: function() { 
        // console.log("Check");
        var err = false;

        if (!this.params.theme || this.params.theme.trim().length == 0) {
          this.errors.push("Theme is required");
          err = true;
        }

        if (!this.params.text || this.params.text.trim().length == 0) {
          this.errors.push("Text is required");
          err = true;
        }

        if (err) {
          return false;
        }

        return true;
      }
    }
  }
</script>

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

      <input class="form-control" v-model="params.theme" type="text" placeholder="Theme" required>
      <textarea class="form-control" v-model="params.text" cols="40" rows="5" placeholder="Comment" required></textarea>
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
                theme: '',
                text: '',
            },
            errors: [],
            messages: [],
        }
      },
      
      methods: {
        send: function() {
            axios.post('/comments-save', this.params).then((response) => {
                this.params.text = ""
                this.params.theme = ""
                this.messages.push(response.data.message)
                this.$eventBus.$emit('comment_send');
              })
            .catch(e => {
              this.errors.push("Failed to send comment: " + e.message)
            });
        },
      }
  }
</script>

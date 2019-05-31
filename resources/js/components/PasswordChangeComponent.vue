<template>

  <div class="form-group row">
          
    <label for="inputPassword" class="col-md-2 col-form-label text-md-right">Old</label>
    <div class="col-md-10">
      <input type="password" v-model="old_pass" class="form-control" id="inputOldPassword" placeholder="Old Password" >
    </div>
    
    <label for="inputPassword" class="col-md-2 col-form-label text-md-right">New</label>
    <div class="col-md-10">
      <input type="password" v-model="password" class="form-control" id="inputNewPassword" placeholder="New Password" >
    </div>
    
    <label for="inputPassword" class="col-md-2 col-form-label text-md-right">Confirm</label>
    <div class="col-md-10">
      <input type="password" v-model="password_confirmation" class="form-control" id="inputConfirmPassword" placeholder="Confirm Password"  aria-describedby="pass-err">
      <small v-if="ne" id="pass-err" class="form-text text-muted">Пароли не совпадают</small>
      <small v-if="small" id="pass-err" class="form-text text-muted">Пароль маинький</small>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      min_length: Number,
    },
    data: function() {
      return {
        old_pass: null,
        password: null,
        password_confirmation: null,
        ne: false,
        small: false,
      }
    },
    watch: {
      password: function() {
        if (this.password_confirmation !== null) {
          this.ne = this.password !== this.password_confirmation;
        }
        this.small = this.password.length < this.min_length;
      },

      password_confirmation: function() {
        this.ne = this.password !== this.password_confirmation;
      },
    },
    mounted() {
      
    },
    created() {
        this.$eventBus.$on('get_passwords', this.send);
    },
    
    beforeDestroy(){
        this.$eventBus.$off('get_passwords');
    },

    
    methods: {
      send: function() {
        var valid = (
          !this.ne && 
          !this.small && 
          this.old_pass !== null && 
          this.password !== null &&
          this.password_confirmation !== null);
        
        this.$eventBus.$emit('set_passwords', this.old_pass, this.password, this.password_confirmation, valid);
      }
    }
  }
</script>

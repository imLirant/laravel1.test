<template>
    
</template>

<script>
  export default {
      props: {
          delay: Number,
      },

      data: function() {
        return {
            pooling: false,
            timerId: null,
        }
      },
      created() {
        this.$eventBus.$on('pooling-stop', this.PoolingStop)
        this.$eventBus.$on('pooling-start', this.PoolingStart)
      },
      
      beforeDestroy(){
        this.$eventBus.$off('pooling-stop');
        this.$eventBus.$off('pooling-start');
      },
      
      methods: {
        Pooling: function() {
          if (this.pooling) {
            this.timerId = setInterval(function() {
              this.$eventBus.$emit('pooling-tick')
            }.bind(this), this.delay);
          }
        },

        PoolingStart: function() {
          this.pooling = true;
          this.Pooling();
        },

        PoolingStop: function() {
          this.pooling = false;
          clearInterval(this.timerId);
        },
      }
  }
</script>

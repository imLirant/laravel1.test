<template>

  <div class="form-group row">   
    
    <div v-if="residence" class="col-md-12">
      <small class="text-muted">{{ residence }} </small>
    </div>
    <label for="country_id" class="col-md-2 col-form-label text-md-right">Country</label>
    
    <div class="col-md-10">
      <select class="custom-select my-1 mr-sm-2" v-model="country_id" id="country_id">
        <option value="0">- select country -</option>
        <option v-for="country in countries" :value="country.country_id">{{country.country_name}}</option>
      </select>
    </div>

    <label for="region_id" class="col-md-2 col-form-label text-md-right">Region</label>
    <div class="col-md-10">
      <select class="custom-select my-1 mr-sm-2" v-model="region_id" id="region_id" v-bind:disabled="country_id == 0 || regions.length === 0">
        <option value="0">- select region -</option><br>
        <option v-for="region in regions" :value="region.region_id">{{region.region_name}}</option>
      </select>
    </div>    
    
    <label for="city_id" class="col-md-2 col-form-label text-md-right">City</label>
    <div class="col-md-10">
      <select class="custom-select my-1 mr-sm-2" v-model="city_id" id="city_id" v-bind:disabled="region_id == 0 || cities.length === 0">
        <option value="0">- select city -</option>
        <option v-for="city in cities" :value="city.city_id">{{city.city_name}}</option>
      </select>
    </div>

  </div>
</template>

<script>
  export default {
    props: {
      residence: String,
    },
    data: function() {
      return {
          countries: [],
          regions: [],
          cities: [],
          country_id: 0,
          region_id: 0,
          city_id: 0,
      }
    },
    watch: {
      country_id: function() {
        this.region_id = 0;
        this.city_id = 0;
        this.getRegions();
      },

      region_id: function() {
        this.city_id = 0;
        this.getCities();
      },

      city_id: function() {
        this.$eventBus.$emit('city_selected', this.city_id, this.region_id, this.country_id);
      },
    },
    mounted() {
      this.getCountries();
    },
    
    methods: {
      getCountries: function() {
        axios.get('/get_countries')
          .then((response) => {
            this.countries = response.data
          });
      },

      getRegions: function() {
        axios.get('/get_regions?country_id=' + this.country_id)
          .then((response) => {
            this.regions = response.data.regions
          });
      },

      getCities: function() {
        axios.get('/get_city?region_id=' + this.region_id)
          .then((response) => {
            this.cities = response.data.cities
          });
      }
    }
  }
</script>

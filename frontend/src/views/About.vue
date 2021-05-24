<template>
  <div class="about">
    <h1 v-for="city in cities" :key="city.name" v-text="city.name"></h1>
    <v-img :src="city.flag" v-for="city in cities" :key="city.name"></v-img>

    <v-autocomplete :items="cities" item-text="name" item-value="alpha3Code" v-model="city">
    </v-autocomplete>
    <v-btn :loading="loading">
      Hola
    </v-btn>
  </div>
</template>
<script>
import axios from 'axios'
export default {
  data() {
    return {
      cities : [],
      city : "",
      loading : false
    }
  },
  methods: {
    getCities(){
      axios.get("https://restcountries.eu/rest/v2/all")
      .then(res => {
        this.cities = res.data
        this.loading = false
        this.$toast.open({
          position: "top-right",
          message: "Datos obtenidos correctamente",
          type: "success",
        });
      })
      .catch(err => {
        this.loading = false

         this.$toast.open({
          position: "top-right",
          message: "Hubo un error en la consulta de datos",
          type: "error",
        });
      })
    }
  },
  mounted() {
    this.loading = true
    this.getCities()
  },
}
</script>

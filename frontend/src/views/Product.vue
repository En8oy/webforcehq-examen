<template>
  <div>
    <p class="text-center mb-16" style="font-size: 3rem;">Find all products with us</p>
    <v-row class="text-center">
      <v-col xl="3" v-for="card in [0, 1, 2, 33, 4, 5, 6, 7]" :key="card">
        <v-card :loading="loading" elevation="5">
          <template slot="progress">
            <v-progress-linear
              :color="$store.state.color"
              height="10"
              indeterminate
            ></v-progress-linear>
          </template>
          <v-img
            height="250"
            src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
          ></v-img>
          <v-card-title> Cafe Badilico </v-card-title>
          <div class="text-left">
            <v-card-text>
              <v-row align="center" class="mx-0">
                <v-rating
                  :value="4.5"
                  color="amber"
                  dense
                  half-increments
                  readonly
                  size="14"
                ></v-rating>
                <div class="grey--text ml-4">4.5 (413)</div>
              </v-row>
              <div class="my-4 subtitle-1">$ • Italian, Cafe</div>
              <div>
                Small plates, salads & sandwiches - an intimate setting with 12
                indoor seats plus patio seating.
              </div>
            </v-card-text>
            <v-divider class="mx-4"></v-divider>
            <v-card-title>There are stock?</v-card-title>
            <v-card-text>
              <v-chip :color="$store.state.color" class="white--text"
                >Stock</v-chip
              >
            </v-card-text>
          </div>
          <v-card-actions>
            <v-btn :color="$store.state.color" text @click="reserve">
              <v-icon>mdi-plus</v-icon>
              Add
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>
<script>
export default {
  data: () => ({
    loading: false,
    selection: 1,
  }),
  methods: {
    reserve() {
      this.loading = true;
      setTimeout(() => (this.loading = false), 2000);
    },
  },
};
</script>
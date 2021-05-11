<template>
  <div>
    <p class="text-center mb-16" style="font-size: 3rem">
      Find all products with us
    </p>
    <v-row class="text-center">
      <v-col
        xl="3"
        v-for="product in $store.state.Product.products"
        :key="product.slug"
        :to="'products/' + product.slug"
      >
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
          <v-card-title> {{ product.name }} </v-card-title>
          <div class="text-left">
            <v-card-text>
              <v-row align="center" class="mx-0">
                <!-- <v-rating
                  :value="4.5"
                  color="amber"
                  dense
                  half-increments
                  readonly
                  size="14"
                ></v-rating> -->
                <!-- <div class="grey--text ml-4">4.5 (413)</div> -->
              </v-row>
              <div>
                {{ product.description }}
              </div>
            </v-card-text>
            <v-divider class="mx-4"></v-divider>
            <v-card-text>
              <p style="font-size: 1.5rem">Price: $ {{ product.price }}</p>
            </v-card-text>
            <v-divider class="mx-4"></v-divider>
            <v-card-title>There are stock?</v-card-title>
            <v-card-text>
              <v-chip v-if="product.stock > 0" color="success" dark
                >Stock</v-chip
              >
              <v-chip v-else color="red" dark>No Stock</v-chip>
            </v-card-text>
          </div>
          <v-card-actions>
            <v-row class="pa-5">
              <v-col cols="12">
                <v-btn
                  color="green"
                  dark
                  :loading="loading"
                  @click="toCart(product)"
                  block
                  :to="'products/'+product.slug"
                >
                  <v-icon class="ma-1">mdi-eye</v-icon>
                  View More
                </v-btn>
              </v-col>
            </v-row>
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
  mounted() {
    this.$store
      .dispatch("Product/getProducts")
      .then((message) => {
        this.$toast.open({
          position: "top-right",
          message: message,
          type: "success",
        });
      })
      .catch((err) => {
        this.$toast.open({
          position: "top-right",
          message: message,
          type: "error",
        });
      });
  },
  methods: {
    // toCart(product) {
    //   this.loading = true;
    //   this.$store.dispatch("Cart/addToCart", {id : product.id, name: product.name, price: product.price, quantity: 1, add : true}).then((message) => {
    //     this.loading = false;
    //     this.$toast.open({
    //       position: "top-right",
    //       message: message,
    //       type: "success",
    //     });
    //   });
    // },
  },
};
</script>
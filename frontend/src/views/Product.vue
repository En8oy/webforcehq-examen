<template>
  <div>
    <v-row>
      <v-col cols="12" sm="12" md="6" class="text-center">
        <v-img
          src="https://picsum.photos/1920/1080"
        ></v-img>
      </v-col>
      <v-col cols="12" sm="12" md="6" class="text-center">
        <v-card elevation="10">
          <p style="font-size: 2rem" class="pa-5">
            <strong v-text="$store.state.Product.product.name"></strong>
          </p>
          <v-card-text class="text-left pa-10">
            <p style="font-size: 3rem" class="mt-10 mb-10">
              <strong v-text="'$' + $store.state.Product.product.price"></strong>
            </p>
            <p style="font-size: 1.2rem" class="mt-5 mb-5">
              Stock: {{$store.state.Product.product.stock}}/{{$store.state.Product.product.total_quantity}} Available
            </p>
            <p style="font-size: 1.2rem">
              Description: {{$store.state.Product.product.description}}
            </p>
            <div class="pa-10">
              <p style="font-size: 1.2rem" class="text-center mt-5 mb-5">
                BUY NOW
              </p>
              <v-row>
                <v-col>
                  <v-text-field label="Quantity" type="number" :max="$store.state.Product.product.stock" min="1" v-model="quantity"></v-text-field>
                </v-col>
                <v-col>
                  <v-btn @click="addToCart()" block large :color="$store.state.color" dark v-show="quantity <= $store.state.Product.product.stock">
                    <v-icon class="ma-2">mdi-plus</v-icon>
                    Add to cart
                  </v-btn>
                </v-col>
              </v-row>
              <v-row>
                <v-col>
                  <v-btn color="success" block large dark v-show="quantity <= $store.state.Product.product.stock"> Buy Now </v-btn>
                </v-col>
              </v-row>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>
<script>
export default {
  data() {
    return {
        quantity : 1
    }
  },
  mounted() {
      this.$store.dispatch("Product/getProduct", {slug : this.$route.params.slug}).then(message => {
        if (this.$store.state.Product.product.stock == 0) {
          this.$toast.open({
            position: "top-right",
            message: "There are no stock",
            type: "error",
          });
          this.$router.push("/products")
        }
      }).catch(err =>{
        this.$router.push("/error")
        this.$toast.open({
          position: "top-right",
          message: "Not Found",
          type: "error",
        });
      })
  },
  methods: {
    addToCart(){
      this.$store.dispatch("Cart/addToCart",  {id : this.$store.state.Product.product.id, name: this.$store.state.Product.product.name, price: this.$store.state.Product.product.price, quantity: this.quantity, stock : this.$store.state.Product.product.stock }).then(message => {
        this.$toast.open({
          position: "top-right",
          message: message,
          type: "success",
        });
      }).catch(err => {
        this.$toast.open({
          position: "top-right",
          message: err,
          type: "error",
        });
      })
    }
  },
};
</script>
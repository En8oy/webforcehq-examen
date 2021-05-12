<template>
  <v-row>
    <v-col sm="12">
      <p class="text-center mb-10" style="font-size: 5em">
        Welcome To WebforceHQ Store
      </p>
    </v-col>
    <v-row class="ma-10">
      <v-col color="black" cols="12" sm="12" md="6">
        <v-container fluid>
          <v-layout justify-center align-center>
            <v-flex shrink>
              <v-img
                class="white--text align-end"
                width="30rem"
                src="https://storage.googleapis.com/wfhq_webforcehq/images/wfs-img-01@2x.png"
              >
              </v-img>
            </v-flex>
          </v-layout>
        </v-container>
      </v-col>
      <v-col cols="12" sm="12" md="6">
        <v-container fluid>
          <v-layout justify-center align-center>
            <v-flex shrink>
              <p class="text-center mb-10" style="font-size: 3rem">
                Secure Buys For You
              </p>
              <p style="font-size: 2rem" class="grey--text">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque
                omnis temporibus tenetur ut voluptate quas, aut iure, officia
                commodi quasi sunt voluptatibus voluptas beatae illo rerum
                doloribus explicabo nam neque. Lorem ipsum dolor sit amet
                consectetur adipisicing elit. Optio doloribus excepturi
                repellendus inventore eum atque, voluptatem ipsum velit aliquam
                sed autem quasi ex veniam consequatur eveniet nisi harum quia
                nam!
              </p>
            </v-flex>
          </v-layout>
        </v-container>
      </v-col>
      <v-col cols="12" sm="12" lg="6">
        <v-card elevation="5">
          <p class="text-center pa-5" style="font-size: 3rem">
            Find Your Purchases
          </p>
          <v-card-text>
            <v-row class="pa-15">
              <v-col cols="12" md="12">
                <v-form @submit.prevent="getOrders">
                  <v-text-field
                    v-model="email"
                    label="Your Email"
                    type="email"
                    required
                    :rules="requiredRules"
                  ></v-text-field>
                  <v-btn
                    :color="$store.state.color"
                    dark
                    block
                    large
                    type="submit"
                    :loading="loading"
                  >
                    Find My Products
                  </v-btn>
                </v-form>
              </v-col>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="12" lg="6" v-show="orders.length > 0">
        <v-card>
          <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">Product</th>
                  <th class="text-left">Quantity</th>
                  <th class="text-left">Total Price</th>
                  <th class="text-left">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="order in orders" :key="order.id">
                  <td> 
                    <v-btn text :to="'products/'+order.product.slug">
                      {{order.product.name}}
                    </v-btn>   
                  </td>
                  <td>{{order.quantity}}</td>
                  <td>$ {{order.total_sale_price}}</td>
                  <td>{{order.status}}</td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-card>
      </v-col>
    </v-row>
  </v-row>
</template>

<script>
import axios from "axios";
export default {
  name: "Home",
  data() {
    return {
      email: "",
      orders: [],
      loading: false,
      requiredRules: [(v) => !!v || "required"],
    };
  },
  methods: {
    getOrders() {
      this.loading = true;
      axios
        .post(this.$store.state.url + "orders/get", { email: this.email })
        .then((res) => {
          if (res.data.orders.length > 0) {
            this.orders = res.data.orders;
            this.$toast.open({
              position: "top-right",
              message: "Orders success",
              type: "success",
            });
          } else {
            this.$toast.open({
              position: "top-right",
              message: "There are no orders",
              type: "error",
            });
          }
        })
        .catch((err) => {
          console.error(err);
        });
      this.loading = false;
    },
  },
  mounted() {
    if (this.$route.query.email) {
      this.email = this.$route.query.email;
      this.getOrders();
    }
  },
};
</script>

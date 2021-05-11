<template>
  <div>
    <v-row v-if="$store.state.Cart.carts.length > 0">
      <p class="text-center pa-5" style="font-size: 2rem">Items In Your Cart</p>
      <v-col cols="12" sm="12">
        <v-card elevation="10" class="pa-10">
          <p class="text-center" style="font-size: 2rem">Products Selected</p>
          <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">Quantity</th>
                  <th class="text-left">Product</th>
                  <th class="text-left">Price</th>
                  <th class="text-left">Total Price</th>
                  <th class="text-left">Remove</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item, index in $store.state.Cart.carts" :key="item.name">
                  <td>
                      <v-text-field v-model="item.quantity" type="number" min="1" @change="changeQuantity(item)">
                      </v-text-field>
                  </td>
                  <td>{{ item.name }}</td>
                  <td>{{ item.price }}</td>
                  <td>{{ (item.price * item.quantity).toFixed(2) }}</td>
                  <td>
                    <v-btn color="red"  class="ma-2" dark @click="deleteProduct(item, index)">
                      <v-icon>mdi-delete</v-icon>
                    </v-btn>
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-card>
      </v-col>
      <v-col cols="12" sm="12" md="6">
        <v-card elevation="10">
          <p class="text-center pa-5" style="font-size: 2rem">
            Personal Information
          </p>
          <v-card-text>
            <v-form>
              <v-container>
                <v-row>
                  <v-col cols="12">
                    <v-text-field label="Full name" required></v-text-field>
                  </v-col>

                  <v-col cols="12">
                    <v-text-field label="Full Address" required></v-text-field>
                  </v-col>

                  <v-col cols="12">
                    <v-text-field label="Country" required></v-text-field>
                  </v-col>

                  <v-col cols="12">
                    <v-text-field label="State" required></v-text-field>
                  </v-col>

                  <v-col cols="12">
                    <v-text-field label="E-mail" required></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="12" sm="12" md="6">
        <v-card elevation="10">
          <p class="text-center pa-5" style="font-size: 2rem">
            Credit Card Information
          </p>
          <v-img
            class="ma-10"
            style="display: block; justify-content: center"
            max-height="150"
            max-width="250"
            src="https://storage.googleapis.com/wfs/images/cc.png"
          ></v-img>
          <v-card-text>
            <v-form>
              <v-container>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      label="Credit Card Number"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col cols="6">
                    <v-text-field
                      label="Credit Card Expiration Date"
                      required
                    ></v-text-field>
                  </v-col>
                  <v-col cols="6">
                    <v-text-field
                      label="Credit Card CCV"
                      required
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12">
        <v-card elevation="10" class="text-center pa-10">
          <p style="font-size: 2rem">
            Total : {{ $store.state.Cart.total.toFixed(2) }}
          </p>
          <v-btn large color="success">
            <v-icon class="ma-1" block>mdi-check</v-icon>
            Confirm
          </v-btn>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-else>
      <v-col cols="12">
        <v-card class="text-center pa-10">
          <v-card-title> Not products yet </v-card-title>
          <v-btn :color="$store.state.color" to="/products" dark>
            Continue Shopping
          </v-btn>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>
<script>
export default {
  data() {
    return {
    }
  },
  methods: {
    changeQuantity(product) {
      this.$store
        .dispatch("Cart/addToCart", {
          id: product.id,
          name: product.name,
          price: product.price,
          quantity: product.quantity,
        })
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
            message: err,
            type: "error",
          });
        });
    },
    deleteProduct(product, index) {
      this.$store
        .dispatch("Cart/deleteProduct", { index: index, price: product.price })
        .then((message) => {
          this.$toast.open({
            position: "top-right",
            message: message,
            type: "warning",
          });
        })
        .catch((err) => {
          this.$toast.open({
            position: "top-right",
            message: err,
            type: "error",
          });
        });
    },
  },
};
</script>
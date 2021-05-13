<template>
  <div>
    <v-row>
      <v-col cols="12" sm="12">
        <p class="text-center" style="font-size: 2rem">All Orders</p>
      </v-col>
      <v-col cols="12" sm="12">
        <v-card elevation="5" class="pa-10">
          <v-card-title>
            Search
            <v-spacer></v-spacer>
            <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
            ></v-text-field>
          </v-card-title>
          <v-data-table :headers="headers" :items="orders" :search="search">
            <template v-slot:item.actions="{ item }">
              <div class="text-right">
                <v-btn class="ma-1" :color="$store.state.color" dark>
                  <v-icon>mdi-pencil</v-icon>
                </v-btn>
                <v-btn class="ma-1" color="red" dark>
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
              </div>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
      <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
          <v-card-title>
            <span class="headline">User Profile</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" sm="6" md="4">
                  <v-text-field
                    label="Legal first name*"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                  <v-text-field
                    label="Legal middle name"
                    hint="example of helper text only on focus"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                  <v-text-field
                    label="Legal last name*"
                    hint="example of persistent helper text"
                    persistent-hint
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field label="Email*" required></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    label="Password*"
                    type="password"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-select
                    :items="['0-17', '18-29', '30-54', '54+']"
                    label="Age*"
                    required
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-autocomplete
                    :items="[
                      'Skiing',
                      'Ice hockey',
                      'Soccer',
                      'Basketball',
                      'Hockey',
                      'Reading',
                      'Writing',
                      'Coding',
                      'Basejump',
                    ]"
                    label="Interests"
                    multiple
                  ></v-autocomplete>
                </v-col>
              </v-row>
            </v-container>
            <small>*indicates required field</small>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="dialog = false">
              Close
            </v-btn>
            <v-btn color="blue darken-1" text @click="dialog = false">
              Save
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      dialog: false,
      search: "",
      headers: [
        { text: "Quantity", value: "quantity" },
        { text: "Product", value: "product.name" },
        { text: "Client", value: "name" },
        { text: "Total", value: "total_sale_price" },
        { text: "Action", value: "actions" },
      ],
      orders: [],
      order : {
          name : "",
          address : "",
          country : "",
          state : "",
          email : "",
          ccn : "",
          ccd : "",
          ccv : ""
      }
    };
  },
  mounted() {
    this.getProducts();
  },
  methods: {
    getProducts() {
      axios
        .get(this.$store.state.url + "auth/orders", {
          headers: { Authorization: "Bearer " + this.$store.state.User.token },
        })
        .then((res) => {
          this.orders = res.data.orders;
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
};
</script>
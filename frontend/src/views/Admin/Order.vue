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
                <v-btn
                  class="ma-1"
                  :color="$store.state.color"
                  dark
                  @click="(dialog = true), (action = 'Edit'), setData(item)"
                >
                  <v-icon>mdi-pencil</v-icon>
                </v-btn>
                <v-btn
                  @click="deleteOrder(item)"
                  class="ma-1"
                  color="red"
                  dark
                >
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
            <span class="headline">{{ action }} orders</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" sm="12">
                  <v-text-field
                    disabled
                    v-model="order.name"
                    label="Name"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field
                    disabled
                    type="number"
                    v-model="order.product_id"
                    label="Product"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field
                    disabled
                    type="number"
                    v-model="order.quantity"
                    label="Quantity"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field
                    disabled
                    v-model="order.address"
                    label="Address"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field
                    disabled
                    v-model="order.country"
                    label="Country"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field
                    disabled
                    v-model="order.state"
                    label="State"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field
                    disabled
                    type="email"
                    v-model="order.email"
                    label="Email"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field
                    disabled
                    v-model="order.ccn"
                    label="Credit Card Number"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field
                    disabled
                    v-model="order.ccd"
                    label="Credit Card Date"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field
                    disabled
                    v-model="order.ccv"
                    label="Credit Card Validation"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field
                    disabled
                    v-model="order.ccv"
                    label="Total Sale Price"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-select
                    :items="['Preparing', 'Sending', 'Delivered']"
                    v-model="order.status"
                    item-text="text"
                    item-value="value"
                  >
                  </v-select>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red darken-1" text @click="restoreData()">
              Close
            </v-btn>
            <v-btn :color="$store.state.color" text @click="commit()">
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
      action: "",
      search: "",
      headers: [
        { text: "Name", value: "name" },
        { text: "email", value: "email" },
        { text: "address", value: "address" },
        { text: "Credit Card Number", value: "ccn" },
        { text: "quantity", value: "quantity" },
        { text: "total_sale_price", value: "total_sale_price" },
        { text: "Status", value: "status" },
        { text: "Action", value: "actions" },
      ],
      orders: [],
      order: {
        id: "",
        name: "",
        product_id: "",
        quantity: "",
        address: "",
        country: "",
        state: "",
        email: "",
        ccn: "",
        ccd: "",
        ccv: "",
        total_sale_price: "",
        status: true,
      },
    };
  },
  mounted() {
    this.getOrders();
  },
  methods: {
    getOrders() {
      axios
        .get(this.$store.state.url + "admin/orders", {
          headers: { Authorization: "Bearer " + this.$store.state.User.token },
        })
        .then((res) => {
          this.orders = res.data.orders;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    setData(data) {
      this.order.id = data.id
      this.order.name = data.name
      this.order.product_id = data.product_id
      this.order.quantity = data.quantity
      this.order.address = data.address
      this.order.country = data.country
      this.order.state = data.state
      this.order.email = data.email
      this.order.ccn = data.ccn
      this.order.ccd= data.ccd
      this.order.ccv= data.ccv
      this.order.total_sale_price = data.total_sale_price
      this.order.status = data.status
    },
    restoreData() {
        this.order = {
          id: "",
          name: "",
          product_id: "",
          quantity: "",
          address: "",
          country: "",
          state: "",
          email: "",
          ccn: "",
          ccd: "",
          ccv: "",
          total_sale_price: "",
          status: true,
        },
        this.getOrders();
        this.dialog = false;
    },
    commit() {
      if (
        this.orders.name != "" &&
        this.orders.product_id != "" &&
        this.orders.quantity != "" &&
        this.orders.address != "" &&
        this.orders.country != "" &&
        this.orders.state != "" &&
        this.orders.email != "" &&
        this.orders.ccn != "" &&
        this.orders.total_sale_price != "" &&
        this.orders.status != ""
      ) {
        switch (this.action) {
          case "Edit":
            axios.put(
                this.$store.state.url + "admin/orders/" + this.order.id,
                this.order,
                {
                  headers: {
                    Authorization: "Bearer " + this.$store.state.User.token,
                  },
                }
              )
              .then((res) => {
                this.$toast.open({
                  position: "top-right",
                  message: "Order updated",
                  type: "success",
                });
              })
              .catch((err) => {
                this.$toast.open({
                  position: "top-right",
                  message: "Order update error",
                  type: "error",
                });
              });
            break;
        }
        this.restoreData()
      } else {
        this.$toast.open({
          position: "top-right",
          message: "Input empty",
          type: "warning",
        });
      }
    },
    deleteOrder(data) {
      axios.delete(this.$store.state.url + "admin/orders/" + data.id, {
          headers: { Authorization: "Bearer " + this.$store.state.User.token },
        })
        .then((res) => {
          this.$toast.open({
            position: "top-right",
            message: "Order deleted",
            type: "success",
          });
          this.restoreData();
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
};
</script>
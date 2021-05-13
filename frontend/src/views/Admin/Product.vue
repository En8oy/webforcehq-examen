<template>
  <div>
    <v-row>
      <v-col cols="12" sm="12">
        <p class="text-center" style="font-size: 2rem">All Products</p>
      </v-col>
      <v-col cols="12" sm="12" class="text-center">
        <v-btn
          :color="$store.state.color"
          dark
          large
          @click="(dialog = true), (action = 'Add')"
        >
          <v-icon>mdi-plus</v-icon>
          New Product
        </v-btn>
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
          <v-data-table :headers="headers" :items="products" :search="search">
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
                  @click="deleteProduct(item)"
                  class="ma-1"
                  color="red"
                  dark
                >
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
                <v-file-input
                    show-size
                    label="Image"
                    truncate-length="50"
                    @change="changeImage($event, item)"
                    accept="image/*"
                ></v-file-input>
              </div>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
      <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
          <v-card-title>
            <span class="headline">{{ action }} product</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" sm="12">
                  <v-text-field
                    v-model="product.name"
                    label="Name"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field
                    type="number"
                    v-model="product.price"
                    label="Price"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field
                    type="number"
                    v-model="product.stock"
                    label="Stock"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-select
                    :items="[
                      { text: 'Active', value: true },
                      { text: 'Inactive', value: false },
                    ]"
                    v-model="product.status"
                    item-text="text"
                    item-value="value"
                  >
                  </v-select>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-textarea
                    v-model="product.description"
                    label="Description"
                    required
                  ></v-textarea>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red darken-1" text @click="restoreData()">
              Close
            </v-btn>
            <v-btn color="blue darken-1" text @click="commit()"> Save </v-btn>
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
        { text: "Description", value: "description" },
        { text: "Price", value: "price" },
        { text: "Stock", value: "stock" },
        { text: "Status", value: "status" },
        { text: "Action", value: "actions" },
      ],
      products: [],
      product: {
        total_quantity : "",
        id: "",
        slug: "",
        name: "",
        description: "",
        price: "",
        stock: "",
        status: true,
      },
    };
  },
  mounted() {
    this.getProducts();
  },
  methods: {
    getProducts() {
      axios
        .get(this.$store.state.url + "admin/products", {
          headers: { Authorization: "Bearer " + this.$store.state.User.token },
        })
        .then((res) => {
          this.products = res.data.products;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    setData(data) {
      this.product.total_quantity = data.total_quantity
      this.product.id = data.id;
      this.product.slug = data.slug;
      this.product.name = data.name;
      this.product.description = data.description;
      this.product.price = data.price;
      this.product.stock = data.stock;
    },
    restoreData() {
      (this.products = []),
        (this.product = {
          id: "",
          slug: "",
          name: "",
          description: "",
          price: "",
          stock: "",
          status: true,
        }),
        this.getProducts();
      this.dialog = false;
    },
    commit() {
      if (
        this.product.name != "" &&
        this.product.description != "" &&
        this.product.stock != "" &&
        this.product.status != "" &&
        this.product.price != ""
      ) {
        this.product.total_quantity = this.product.stock
        switch (this.action) {
          case "Add":
            axios.post(
                this.$store.state.url + "admin/products/",
                this.product,
                {
                  headers: {
                    Authorization: "Bearer " + this.$store.state.User.token,
                  },
                }
              )
              .then((res) => {
                this.$toast.open({
                  position: "top-right",
                  message: "Product registred",
                  type: "success",
                });
              })
              .catch((err) => {
                this.$toast.open({
                  position: "top-right",
                  message: "Product add error",
                  type: "error",
                });
              });
            break;
          case "Edit":
            axios.put(
                this.$store.state.url + "admin/products/" + this.product.slug,
                this.product,
                {
                  headers: {
                    Authorization: "Bearer " + this.$store.state.User.token,
                  },
                }
              )
              .then((res) => {
                this.$toast.open({
                  position: "top-right",
                  message: "Product updated",
                  type: "success",
                });
              })
              .catch((err) => {
                this.$toast.open({
                  position: "top-right",
                  message: "Product update error",
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
    deleteProduct(data) {
      axios.delete(this.$store.state.url + "admin/products/" + data.slug, {
          headers: { Authorization: "Bearer " + this.$store.state.User.token },
        })
        .then((res) => {
          this.$toast.open({
            position: "top-right",
            message: "User deleted",
            type: "warning",
          });
          this.restoreData();
        })
        .catch((err) => {
          console.error(err);
        });
    },
    changeImage(event, data){
      const fd = new FormData();
      fd.append('image', event, event.name)
      fd.append('id', data.id)
      axios.post(this.$store.state.url + "admin/products/image", fd,{ headers: { Authorization: "Bearer " + this.$store.state.User.token }})
      .then(res => {
        this.restoreData()
        this.$toast.open({
          message: "Image Changed",
          type: "success",
          position: "top-right",
        });
      })
      .catch(err => {
        this.$toast.open({
          message: "Error",
          type: "error",
          position: "top-right",
        });
        })
    }
  },
};
</script>
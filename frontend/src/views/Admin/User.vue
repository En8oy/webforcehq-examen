<template>
  <div>
    <v-row>
      <v-col cols="12" sm="12">
        <p class="text-center" style="font-size: 2rem">All Users</p>
      </v-col>
      <v-col cols="12" sm="12" class="text-center">
        <v-btn :color="$store.state.color" dark large @click="dialog = true, action = 'Add'">
          <v-icon>mdi-plus</v-icon>
          New User
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
          <v-data-table :headers="headers" :items="users" :search="search">
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
                  @click="deleteUser(item)"
                  class="ma-1"
                  color="red"
                  dark
                  v-show="item.name != $store.state.User.user.name"
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
            <span class="headline">{{ action }} user</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" sm="12">
                  <v-text-field
                    v-model="user.name"
                    label="Name"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field
                    v-model="user.email"
                    label="Email"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12">
                  <v-text-field
                    v-model="user.password"
                    label="Password"
                    type="password"
                    required
                  ></v-text-field>
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
        { text: "Email", value: "email" },
        { text: "Action", value: "actions" },
      ],
      users: [],
      user: {
        id: "",
        slug: "",
        name: "",
        email: "",
        password: "",
      },
    };
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    getUsers() {
      axios
        .get(this.$store.state.url + "admin/users", {
          headers: { Authorization: "Bearer " + this.$store.state.User.token },
        })
        .then((res) => {
          this.users = res.data.users;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    setData(data) {
      console.log(data);
      this.user.name = data.name;
      this.user.email = data.email;
      this.user.password = "";
      this.user.id = data.id;
      this.user.slug = data.slug;
    },
    restoreData() {
      (this.user = {
        name: "",
        email: "",
        password: "",
      }),
        (this.users = []),
        (this.action = ""),
        (this.dialog = false),
        (this.search = "");
      this.getUsers();
    },
    commit() {
      if (
        this.user.name != "" &&
        this.user.email != "" &&
        this.user.password != ""
      ) {
        switch (this.action) {
          case "Add":
            axios.post(
                this.$store.state.url + "admin/users/",
                this.user,
                {
                  headers: {
                    Authorization: "Bearer " + this.$store.state.User.token,
                  },
                }
              )
              .then((res) => {
                this.$toast.open({
                  position: "top-right",
                  message: "User registred",
                  type: "success",
                });
              })
              .catch((err) => {
                this.$toast.open({
                  position: "top-right",
                  message: "User add error",
                  type: "error",
                });
              });
            break;
          case "Edit":
            axios.put(
                this.$store.state.url + "admin/users/" + this.user.slug,
                this.user,
                {
                  headers: {
                    Authorization: "Bearer " + this.$store.state.User.token,
                  },
                }
              )
              .then((res) => {
                this.$toast.open({
                  position: "top-right",
                  message: "User updated",
                  type: "success",
                });
              })
              .catch((err) => {
                this.$toast.open({
                  position: "top-right",
                  message: "User update error",
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
    deleteUser(data){
      axios.delete(this.$store.state.url + "admin/users/" + data.slug, {
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
    }
  },
};
</script>
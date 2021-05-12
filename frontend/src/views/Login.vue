<template>
  <div>
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
          <v-card class="pa-5" elevation="5">
            <v-card-title> Login </v-card-title>
            <v-card-text>
                <v-form v-on:submit.prevent="login()">
                    <v-text-field label="Email" type="email" v-model="email" :rules="requiredRules">
                    </v-text-field>
                     <v-text-field label="Password" type="password" v-model="password" :rules="requiredRules">
                    </v-text-field>
                    <v-btn type="submit" block large :color="$store.state.color" dark :loading="loading">
                        Login
                    </v-btn>
                </v-form>
            </v-card-text>
          </v-card>
        </v-container>
      </v-col>
    </v-row>
  </div>
</template>
<script>
export default {
    data() {
        return {
            email : "",
            password : "",
            loading : false,
            requiredRules: [(v) => !!v || "required"],
        }
    },
    methods: {
        login(){
          if (this.email != "" && this.password != "") {
            this.$store.dispatch("User/login", {user: this.user, password : this.password}).then(message => {
                  this.$toast.open({
                  position: "top-right",
                  message: "Good",
                  type: "success",
                });
            }).catch(error => {
                this.$toast.open({
                position: "top-right",
                message: "Email Or Password Isn't Correct",
                type: "warning",
              });
            })
        
          } else {
             this.$toast.open({
              position: "top-right",
              message: "Input empty",
              type: "warning",
            });
          }
          // this.loading = true
          // axios.post(this.$store.state.url + "login", {email : this.email, password : this.password})
          // .then(res => {
          //   console.log(res.data)
          //   this.loading = false
          // })
          // .catch(err => {
          //   this.loading = false
          //   console.error(err); 
          // })
        }
    },
}
</script>
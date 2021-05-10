<template>
  <v-app>
    <v-app-bar
      app
      :color="$store.state.color"
      dark
    >
      <v-spacer></v-spacer>
      <div>
        <p style="font-size : 2rem">WebforceHQ Store</p>
      </div>
      <v-spacer></v-spacer>
      <template v-slot:extension>
        <v-tabs centered>
            <v-tab class="white--text" :to="route.path" v-for="route in publicRoutes" :key="route.name">
              <v-icon v-text="route.icon" class="ma-5"></v-icon>
              {{route.name}}
            </v-tab>
            <v-tab to="/my-car" class="white--text">
              <v-badge
                color="red"
                content="6"
              >
                <v-icon class="mr-5">mdi-cart-outline</v-icon>
                My Car
              </v-badge>
            </v-tab>
            <!-- <v-tab class="white--text" to="/my-car">
              <v-badge
                color="green"
                content="6"
              >
                <v-icon class="ma-5">mdi-cart-outline</v-icon>
              Car
              </v-badge>
              
            </v-tab> -->
        </v-tabs>
      </template>
    </v-app-bar>
    <v-main>
      <transition name="fade" :duration="500">
        <div class="pa-16">
          <router-view></router-view>
        </div>
      </transition>
    </v-main>
    <v-footer>
      <v-row rows="12">
        <v-col>
          <v-card class="text-center pa-10 white--text" elevation="5" color="grey darken-3">
            {{new Date().getFullYear() }} © WebForce LLC.
          </v-card>
        </v-col>
      </v-row>
    </v-footer>
  </v-app>
</template>

<script>

import Footer from './components/Footer'
export default {
  component : {
    Footer
  },
  data() {
    return {
      publicRoutes : [
        {
          name : "Home",
          path : "/",
          icon : "mdi-home"
        },
        {
          name : "Products",
          path : "/products",
          icon : "mdi-store"
        },
        // {
        //   name : "Log in",
        //   path : "/login",
        //   icon : "mdi-login"
        // }
      ]
    }
  },
}
</script>

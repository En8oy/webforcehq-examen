<template>
  <v-app>
    <v-app-bar
      app
      color="primary"
      dark
    >
      <div class="d-flex align-center">
        <router-link to="/">
          <v-btn text >
            WebforceHQ Store
          </v-btn>
        </router-link>
      </div>
      <v-spacer></v-spacer>
      <router-link :to="route.path" v-for="route in publicRoutes" :key="route.name">
        <v-btn
          text
          
        >
          <v-icon v-text="route.icon"></v-icon>
          <span class="mr-2" v-text="route.name"></span>
        </v-btn>
      </router-link>
    </v-app-bar>

    <v-main>
      <router-view/>
    </v-main>
  </v-app>
</template>

<script>
export default {
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
          path : "/about",
          icon : "mdi-store"
        },
        {
          name : "Log in",
          path : "/login",
          icon : "mdi-login"
        }
      ]
    }
  },
}
</script>

<template>
  <v-app>
    <v-app-bar app :color="$store.state.color" dark>
      <v-spacer></v-spacer>
      <div>
        <p style="font-size: 2rem">WebforceHQ Store</p>
      </div>
      <v-spacer></v-spacer>
      <template v-slot:extension>
        <v-tabs centered v-if="$store.state.User.token != ''">
          <v-tab
            class="white--text"
            :to="route.path"
            v-for="route in authRoutes"
            :key="route.name"
          >
            <v-icon v-text="route.icon" class="ma-5"></v-icon>
            {{ route.name }}
          </v-tab>
        </v-tabs>
        <v-tabs centered v-else>
          <v-tab
            class="white--text"
            :to="route.path"
            v-for="route in publicRoutes"
            :key="route.name"
          >
            <v-icon v-text="route.icon" class="ma-5"></v-icon>
            {{ route.name }}
          </v-tab>
          <v-tab
            to="/my-cart"
            class="white--text"
            v-if="$store.state.Cart.carts.length > 0"
          >
            <v-badge color="red" :content="$store.state.Cart.carts.length">
              <v-icon class="mr-5">mdi-cart-outline</v-icon>
              My Cart
            </v-badge>
          </v-tab>
          <v-tab class="white--text" to="/my-cart" v-else>
            <v-icon class="ma-5">mdi-cart-outline</v-icon>
            My Cart
          </v-tab>
        </v-tabs>
      </template>
    </v-app-bar>
    <v-main>
      <transition name="fade" :duration="500">
        <div class="pa-16">
          <transition name="fade" :duration="500">
            <router-view></router-view>
          </transition>
        </div>
      </transition>
    </v-main>
    <v-footer>
      <v-row rows="12">
        <v-col>
          <v-card
            class="text-center pa-10 white--text"
            elevation="5"
            color="grey darken-3"
          >
            {{ new Date().getFullYear() }} © WebForce LLC.
            <br />
            <v-btn class="ma-5" href="https://github.com/en8oy" target="_blank">
              <v-icon>mdi-github</v-icon>
              Made By En8oy
            </v-btn>
          </v-card>
        </v-col>
      </v-row>
    </v-footer>
  </v-app>
</template>

<script>
import Footer from "./components/Footer";
export default {
  component: {
    Footer,
  },
  data() {
    return {
      publicRoutes: [
        {
          name: "Home",
          path: "/",
          icon: "mdi-home",
        },
        {
          name: "Products",
          path: "/products",
          icon: "mdi-store",
        },
        // {
        //   name : "Log in",
        //   path : "/login",
        //   icon : "mdi-login"
        // }
      ],
      authRoutes: [
        {
          name: "Orders",
          path: "/auth/orders",
          icon: "mdi-currency-usd",
        },
        {
          name: "Products",
          path: "/auth/products",
          icon: "mdi-store",
        },
        {
          name: "Users",
          path: "/auth/users",
          icon: "mdi-account",
        },
      ],
    };
  },
};
</script>

<template>
  <v-app>
    <v-main class="pa-10">
      <v-app-bar color="transparent" elevation="0" absolute>
        <a href="/" class="d-flex align-center">
          <v-img
            alt="Rodos Logo"
            class="shrink mr-2"
            contain
            src='../assets/rodoslogo.png'
            transition="scale-transition"
            width="40"
          />
        </a>

        <v-spacer></v-spacer>
        <v-switch
          color="secondary"
          append-icon="mdi-moon"
          hide-details
          true
          @click="tema"
        ></v-switch>
        <v-btn to="/Giris" text>
          <span class="mr-2 text-capitalize">Giriş Yap</span>
        </v-btn>
      </v-app-bar>
      <v-layout align-center fill-height>
        <v-flex xs12 sm12 md12 lg5>
          <h1
            class="font-weight-bold"
            style="line-height: 4.6rem; font-size: 4.6rem"
          >
            <div class="transition-ease-out-in">Hello, I'm Mehmet!</div>
            <v-hover v-slot="{ hover }">
              <div style="color: #a2a2a2">
                A junior front-end <br />
                developer
                <span
                  :key="hover ? 1 : 0"
                  :class="{
                    'primary--text transition-ease-in-out': hover,
                  }"
                  >currently</span
                >
                <br />
                making & mostly <br />
                breaking things at <br />
              </div>
            </v-hover>
            RodosGroup.
          </h1>
        </v-flex>
      </v-layout>
      <v-footer absolute fixed app color="transparent" height="52" insets>
        <a
          class=""
          style="text-decoration: none"
          href="mailto: memet.2031@gmail.com"
          >memet.2031@gmail.com</a
        >
        <v-spacer></v-spacer>
        <div>
          <a
            target="_blank"
            style="text-decoration: none"
            href="https://github.com/memetunl6"
            ><v-icon>mdi-github</v-icon></a
          >
          <a
            style="text-decoration: none"
            href="https://www.instagram.com/memetunl6/"
            target="_blank"
            ><v-icon class="ma-1">mdi-instagram</v-icon></a
          >
          <a
            style="text-decoration: none"
            href="https://www.twitter.com/memetunl6/"
            target="_blank"
            ><v-icon class="ma-1">mdi-twitter</v-icon></a
          >
        </div>
      </v-footer>
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: "HomeView",
  components: {},
  mounted() {
    
  },
  methods: {
    
    tema() {
      this.$vuetify.theme.isDark = !this.$vuetify.theme.isDark;
  },
}
}
</script>

<style lang="scss"></style>

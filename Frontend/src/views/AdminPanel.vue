<template>
  <v-app>
    <v-app-bar app color="transparent" elevation="0">
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <a href="/" class="d-flex align-center">
        <v-img
          alt="Rodos Logo"
          class="shrink mr-2"
          contain
          src="../assets/rodoslogo.png"
          transition="scale-transition"
          width="40"
        />
      </a>

      <v-spacer></v-spacer>
      <v-btn to="/" text>
        <span class="mr-2">Çıkış Yap</span>
      </v-btn>
    </v-app-bar>
    <v-main>
      <v-navigation-drawer v-model="drawer" absolute bottom temporary>
        <v-list nav dense>
          <v-list-item-group v-model="group" active-class="text--accent-5">
            <v-list-item to="/UserList">
              <v-list-item-title>Kullanıcı Listesi</v-list-item-title>
            </v-list-item>

            <v-list-item>
              <v-list-item-title>Bar</v-list-item-title>
            </v-list-item>

            <v-list-item>
              <v-list-item-title>Fizz</v-list-item-title>
            </v-list-item>

            <v-list-item>
              <v-list-item-title>Buzz</v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list>
      </v-navigation-drawer>
    </v-main>
  </v-app>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      drawer: false,
      group: null,
    };
  },
};
</script>

<template>
  <v-app>
    <v-app-bar app color="transparent" elevation="0">
      <div>
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
      </div>
      <v-spacer></v-spacer>
    </v-app-bar>
    <v-main>
      <v-card
        shaped
        height="700"
        elevation="10"
        text-md-center
        class="mx-auto my-16 text-center"
        max-width="600"
        justify="center"
      >
        <h1 class="pt-15">Giriş Yap</h1>

        <v-container grid-list-md class="pt-16">
          <v-row>
            <v-text-field
              v-model="bilgi.kullaniciAdi"
              label="Kullanıcı Adı"
              name="email"
              hide-details="auto"
              style="max-width: 50%"
              class="mx-auto"
            ></v-text-field>
          </v-row>
          <v-row>
            <v-text-field
              v-model="bilgi.sifre"
              label="Şifre"
              name="password"
              type="password"
              hide-details="auto"
              style="max-width: 50%"
              class="mx-auto"
            ></v-text-field>
          </v-row>
          <v-row>
            <v-col cols="12" class="mr-5 text-center">
              <v-btn class="mr-3" color="blue" dark @click="girisYap()"
                >Giris</v-btn
              >
            </v-col>
          </v-row>
        </v-container>
      </v-card>
      <v-snackbar :color="renk" v-model="snackbar">
        {{ snackbarText }}
        <template v-slot:action="{ attrs }">
          <v-btn text v-bind="attrs" @click="snackbar = false" dark icon>
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </template>
      </v-snackbar>
    </v-main>
  </v-app>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      bilgi: {
        kullaniciAdi: "",
        sifre: "",
      },

      snackbar: false,
      renk: "error",
      snackbarText: "",
    };
  },
  methods: {
    girisYap() {
      if (this.bilgi.kullaniciAdi !== "" && this.bilgi.sifre !== "") {
        this.$http
          .post("/Login", { data: this.bilgi })
          .then((res) => {
            this.renk = res.data.status ? "success" : "error";
            this.snackbarText = res.data.message;
            this.snackbar = true;
            if (res.data.status == true) {
              setTimeout(() => {
                this.$router.push("/Panel");
              }, 700);
              console.log(res);
            }
          })
          .catch((err) => {
            console.log(err);
          });
      }
      //(this.kullaniciAdi === "memet" && this.sifre === "memet@21") {
      //   this.renk = "success";
      //   this.snackbarText = "Giriş Başarılı";
      //   this.snackbar = true;
      //   setTimeout(() => {
      //     this.$router.push("/Panel");
      //   }, 700);}
      else {
        this.snackbarText = "Alan Boş bırakılamaz";
        this.snackbar = true;
      }
    },
  },
};
</script>

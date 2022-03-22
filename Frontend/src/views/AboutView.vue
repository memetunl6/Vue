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
        <h1 class="pt-15"></h1>

        <v-container grid-list-md class="pt-16">
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="transparent" class="mb-2" v-bind="attrs" v-on="on">
              Kayıt ol
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.ogradisoyadi"
                      label="Adı Soyadı"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.tcno"
                      label="T.C. No"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.mail"
                      label="Mail"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.password"
                      label="Şifre"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>

              <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
            </v-card-actions>
          </v-card>
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
      drawer: false,
      group: null,
      snackbar: false,
      dialog: false,
      dialogDelete: false,
      headerlar: [
        {
          text: "Öğrenci Adı Soyadı",
          align: "start",
          value: "ogradisoyadi",
        },
        { text: "Kimlik No", value: "tcno" },
        { text: "Mail Adresi", value: "mail" },
        { text: "İşlemler", value: "crudThings" },
      ],
      ogrenciler: [],

      editedIndex: -1,
      editedItem: {
        ogradisoyadi: "",
        tcno: "",
        mail: "",
        password: "",
      },
      defaultItem: {
        ogradisoyadi: "",
        tcno: "",
        mail: "",
        password: "",
      },
      renk: "success",
      snackbarText: "",
    };
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Kayıt OL" : "Kullanıcı Düzenle";
    },
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
      this.item = [{}];
    },

    editItem(item) {
      this.editedIndex = this.ogrenciler.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
    save() {
      if (this.editedIndex > -1) {
        this.$http
          .post("/KullaniciDuzenle", { data: this.editedItem })
          .then((res) => {
            this.renk = res.data.status ? "success" : "error";
            this.snackbarText = res.data.message;
            this.snackbar = true;
            this.dialog = false;
          });
      } else {
        this.$http
          .post("/KullaniciEkle", { data: this.editedItem })
          .then((res) => {
            this.renk = res.data.status ? "success" : "error";
            this.snackbarText = res.data.message;
            this.snackbar = true;
            this.dialog = false;
          })
          .catch((err) => {
            console.log(err);
            console.warn(err);
          });
      }
      this.close();
    },
    kullaniciRest() {
      this.ogrenciler = JSON.parse(JSON.stringify(this.ogrenciler));
    },
    
  },
};
</script>

<template>
  <v-app>
    <v-app-bar app color="transparent" elevation="0">
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <a href="/Panel" class="d-flex align-center">
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
            <v-list-item>
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
      <v-card
        background-color="blue"
        max-width="700"
        max-height="800"
        justify="center"
        text-md-center
        shaped
        elevation="10"
        class="mx-auto my-16 overflow-y-auto"
      >
        <v-data-table
          :headers="headerlar"
          :items="ogrenciler"
          show-select
          :loading="false"
          class="elevation-1"
          max-height="500"
          hide-default-footer
        >
          <template v-slot:top>
            <v-toolbar flat>
              <v-toolbar-title>Kullanıcı Listesi</v-toolbar-title>
              <v-divider class="mx-4" inset vertical></v-divider>
              <v-spacer></v-spacer>
              <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    color="transparent"
                    class="mb-2"
                    v-bind="attrs"
                    v-on="on"
                  >
                    Kullanıcı Ekle
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
                    <v-btn color="blue darken-1" text @click="close">
                      Cancel
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="save">
                      Save
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card class="text-center pa-3">
                  <span class="text-h6 text-center" pt-4
                    >Silmek İstediğine emin misin?</span
                  >
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeDelete"
                      >Cancel</v-btn
                    >
                    <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                      >OK</v-btn
                    >
                    <v-spacer></v-spacer>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>

          <!-- search="search"-->
          <!-- eslint-disable-next-line -->
          <template v-slot:item="{ item }">
            <tr>
              <td></td>
              <td>{{ item.ogradisoyadi }}</td>
              <td>{{ item.tcno }}</td>
              <td>{{ item.mail }}</td>
              <td>
                <v-icon small class="mr-2" @click="editItem(item)">
                  mdi-pencil
                </v-icon>
                <v-icon small class="mr-2" @click="deleteItem(item)">
                  mdi-delete
                </v-icon>
              </td>
            </tr>
          </template>
          <template v-slot:no-data>
            <v-btn color="primary" @click="initialize"> Reset </v-btn>
          </template>
        </v-data-table>
        <v-snackbar :color="renk" v-model="snackbar">
          {{ snackbarText }}
          <template v-slot:action="{ attrs }">
            <v-btn text v-bind="attrs" @click="snackbar = false" dark icon>
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </template>
        </v-snackbar>
      </v-card>
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
      return this.editedIndex === -1 ? "Kullanıcı Ekle" : "Kullanıcı Düzenle";
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
    this.getUsers();
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
    deleteItem(item) {
      this.editedIndex = this.ogrenciler.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.$http
        .post("/KullaniciSil", { data: this.editedItem })
        .then((res) => {
          this.renk = res.data.status ? "success" : "error";
          this.snackbarText = res.data.message;
          this.snackbar = true;
          this.dialog = false;
          this.getUsers();
        });
      this.closeDelete();
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
            this.getUsers();
          });
      } else {
        this.$http
          .post("/KullaniciEkle", { data: this.editedItem })
          .then((res) => {
            this.renk = res.data.status ? "success" : "error";
            this.snackbarText = res.data.message;
            this.snackbar = true;
            this.dialog = false;
            this.getUsers();
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
    getUsers() {
      this.$http.post("/getUser", { data: this.ogrenciler }).then((res) => {
        console.log(res.data);
        if (res.data.status == "success") {
          this.ogrenciler = res.data.data;
        } else {
          console.log(res.data.status);
        }
      });
    },
  },
};
</script>

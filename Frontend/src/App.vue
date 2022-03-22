<template>
<v-slide-x-transition >
  
  <router-view />
</v-slide-x-transition>
</template>

<script>
export default {
  name: "App",

  data: () => ({
    //
  }),
  mounted() {
    this.$vuetify.theme.isDark = true
  },
};
</script>


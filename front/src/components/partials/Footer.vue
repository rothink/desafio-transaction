<template>
  <v-footer
      absolute
      fixed
      color="rgb(1, 153, 90)"
      app
      class="white--text"
  >
    <v-spacer></v-spacer>
  </v-footer>
</template>

<script>

import logo from '~/assets/logo.jpeg';

export default {
  data() {
    return {};
  },
  methods: {
    getAvatarLogo() {
      return logo;
    },
  },
};
</script>

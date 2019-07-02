<template>
  <v-dialog
    v-model="loader"
    persistent
    width="300"
  >
    <v-card
      color="grey lighten-2"
      dark
    >
      <v-card-title>
        <v-progress-linear
          indeterminate
          color="red darken-3"
        ></v-progress-linear>
      </v-card-title>
    </v-card>
  </v-dialog>
</template>

<script>
  export default {
    props: {
      loader: {
        type: Boolean
      }
    }
  }
</script>
<template>
  <v-dialog v-model="dialog" persistent max-width="500">
    <v-card>
      <v-card-title class="headline grey lighten-2" primary-title>Eliminar Registro</v-card-title>
      <v-card-text>{{ message }}</v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="grey darken-1" flat @click.native="hide" :disabled="loader">Cancelar</v-btn>
        <v-btn color="red darken-1" flat @click.native="deleted" :loading="loader" >Aceptar</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
  export default {
    props: {
      dialog: {
        type: Boolean
      },
      loader: {
        type: Boolean
      },
      message: {
        type: String
      }
    },

    methods: {
      hide () {
        this.$emit('hide')      
      },

      deleted() {
        this.$emit('deleted')
      }
    }
  }
</script>
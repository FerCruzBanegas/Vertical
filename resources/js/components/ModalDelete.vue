<template>
  <v-dialog v-model="remove" persistent max-width="500">
    <v-card>
      <v-card-title class="headline grey lighten-2" primary-title>Eliminar Registro</v-card-title>
      <v-card-text>{{ message }}</v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="grey darken-1" flat @click.native="hide" :disabled="loading">Cancelar</v-btn>
        <v-btn color="red darken-1" flat @click.native="deleted" :loading="loading" >Aceptar</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
  export default {
    props: {
      remove: {
        type: Boolean
      },
      loading: {
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
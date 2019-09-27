<template>
  <v-dialog v-model="state" persistent max-width="500">
    <v-card>
      <v-card-title class="headline grey lighten-2" primary-title>{{ title }}</v-card-title>
      <v-card-text>{{ message }}</v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="grey darken-1" flat @click.native="hide" :disabled="loading">Cancelar</v-btn>
        <v-btn color="red darken-1" flat @click.native="change_state" :loading="loading" >Aceptar</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
  export default {
    props: {
      state: {
        type: Boolean
      },
      title: {
        type: String
      },
      message: {
        type: String
      },
      loading: {
        type: Boolean
      }
    },

    methods: {
      hide () {
        this.$emit('hide')      
      },

      change_state() {
        this.$emit('change_state')
      }
    }
  }
</script>
<template>
  <v-dialog v-model="dialog" persistent max-width="700">
    <v-card>
      <v-card-title class="headline grey lighten-2" primary-title>Detalles</v-card-title>
      <v-card-text>
        <pivot-material :materials="materials"></pivot-material>
        <pivot-people :people="people"></pivot-people>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="grey darken-1" flat @click.native="hide">Cerrar</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
  import PMaterial from './PMaterial.vue'
  import PPeople from './PPeople.vue'

  export default {
    props: {
      dialog: {
        type: Boolean
      },

      materials: {
        type: Array
      },

      people: {
        type: Array
      }
    },

    components: {
      'pivot-material' : PMaterial,
      'pivot-people' : PPeople
    },

    methods: {
      hide () {
        this.$emit('hide')      
      }
    }
  }
</script>


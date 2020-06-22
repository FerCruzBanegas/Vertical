<template>
  <v-dialog v-model="dialog" persistent max-width="700">
    <v-card>
      <v-system-bar color="grey darken-3" dark>
        <div class="title">DETALLES</div>
        <v-spacer></v-spacer>
        <v-icon @click="hide">close</v-icon>
      </v-system-bar>
      <v-card-text>
        <pivot-material :materials="materials"></pivot-material>
        <pivot-people :people="people"></pivot-people>
      </v-card-text>
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


<template>
  <v-dialog v-model="dialog" persistent max-width="700">
    <v-card>
      <v-card-title class="headline grey lighten-2" primary-title>Detalles</v-card-title>
      <v-card-text>
        <v-layout wrap>
          <v-flex xs12 sm12 md12 lg12>
            <v-toolbar dense dark color="grey darken-1">
              <div class="title font-weight-light">MATERIALES</div>
            </v-toolbar>
            <v-data-table
              :headers="headers"
              :items="data"
              :rows-per-page-items="[3,5,10]"
              class="elevation-1"
            >
              <template v-slot:items="props">
                <td>{{ props.item.name }}</td>
                <td>{{ props.item.unity }}</td>
                <td>{{ props.item.price }}</td>
              </template>
            </v-data-table>
          </v-flex>
        </v-layout>
        <v-layout wrap>
          <v-flex xs12 sm12 md12 lg12>
            <v-toolbar dense dark color="grey darken-1">
              <div class="title font-weight-light">PERSONAS</div>
            </v-toolbar>
            <v-data-table
              :headers="headers"
              :items="data"
              :rows-per-page-items="[3,5,10]"
              class="elevation-1"
            >
              <template v-slot:items="props">
                <td>{{ props.item.name }}</td>
                <td>{{ props.item.unity }}</td>
                <td>{{ props.item.price }}</td>
              </template>
            </v-data-table>
          </v-flex>
        </v-layout>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="grey darken-1" flat @click.native="hide">Cerrar</v-btn>
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
      data: {
        type: Array
      },
    },

    data () {
      return {
        headers: [
          { text: 'Nombre', value: 'nombre' },
          { text: 'Unidad', value: 'unidad' },
          { text: 'Precio', value: 'precio' },
        ]
      }
    },

    methods: {
      hide () {
        this.$emit('hide')      
      }
    }
  }
</script>


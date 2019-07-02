<template>
  <v-dialog v-model="modal" persistent max-width="500">
    <v-card>
      <v-card-title class="headline grey lighten-2" primary-title>DETALLES DEL REGISTRO</v-card-title>
      <v-card-text>
        <v-list two-line subheader v-if="data !== null">
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>NOMBRE</v-list-tile-title>
              <v-list-tile-sub-title>{{ data.name }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>DESCRIPCIÓN</v-list-tile-title>
              <v-list-tile-sub-title>{{ data.description }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>FECHA DE REGISTRO</v-list-tile-title>
              <v-list-tile-sub-title>Registrado el <span class='text--primary'>{{ data.created.date | formatDate('DD/MM/YYYY') }} </span> por {{ data.created.causer }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>FECHA DE ACTUALIZACIÓN</v-list-tile-title>
              <v-list-tile-sub-title>Actualizado el <span class='text--primary'>{{ data.updated.date | formatDate('DD/MM/YYYY') }} </span> por {{ data.updated.causer }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
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
      modal: {
        type: Boolean
      },
      data: {
        type: Object
      }
    },

    methods: {
      hide () {
        this.$emit('hide')      
      }
    }
  }
</script>
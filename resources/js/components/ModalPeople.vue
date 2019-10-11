<template>
  <v-dialog v-model="modal" persistent max-width="500">
    <v-card>
      <v-system-bar color="grey darken-3" dark>
        <div class="title">DETALLES DEL REGISTRO</div>
        <v-spacer></v-spacer>
        <v-icon @click="hide">close</v-icon>
      </v-system-bar>
      <v-card-text>
        <v-list two-line subheader v-if="data !== null">
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Nombre(s)</v-list-tile-title>
              <v-list-tile-sub-title>{{ data.name }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Apellidos</v-list-tile-title>
              <v-list-tile-sub-title>{{ data.surnames }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Teléfono</v-list-tile-title>
              <v-list-tile-sub-title>{{ data.phone }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Dirección</v-list-tile-title>
              <v-list-tile-sub-title>{{ data.address }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Fecha De Registro</v-list-tile-title>
              <v-list-tile-sub-title>Registrado el <span class='text--primary'>{{ data.created.date | formatDate('DD/MM/YYYY') }} </span> por {{ data.created.causer }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Fecha De Actualizacíón</v-list-tile-title>
              <v-list-tile-sub-title>Actualizado el <span class='text--primary'>{{ data.updated.date | formatDate('DD/MM/YYYY') }} </span> por {{ data.updated.causer }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-card-text>
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
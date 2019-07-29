<template>
  <v-dialog v-model="modal" persistent max-width="500">
    <v-card>
      <v-card-title class="headline grey lighten-2" primary-title>DETALLES DEL REGISTRO</v-card-title>
      <v-card-text>
        <v-list two-line subheader v-if="data !== null">
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Nombre de Usuario</v-list-tile-title>
              <v-list-tile-sub-title>{{ data.name }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Correo Electrónico</v-list-tile-title>
              <v-list-tile-sub-title>{{ data.email }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Estado</v-list-tile-title>
              <v-list-tile-sub-title>
                <v-chip label outline color="gray darken-3" v-if="data.state === 1">Activo</v-chip>
                <v-chip label outline color="red darken-3" v-else>Inactivo</v-chip>
              </v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Perfil de Usuario</v-list-tile-title>
              <v-list-tile-sub-title>{{ data.profile }}</v-list-tile-sub-title>
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
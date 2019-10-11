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
              <v-list-tile-title>Título</v-list-tile-title>
              <v-list-tile-sub-title>{{ data.title }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Fecha Apertura</v-list-tile-title>
              <v-list-tile-sub-title>{{ data.date | formatDate('DD/MM/YYYY') }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Número de cuenta</v-list-tile-title>
              <v-list-tile-sub-title>{{ data.number }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Monto Inicial</v-list-tile-title>
              <v-list-tile-sub-title>{{ data.amount | currency }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Estado</v-list-tile-title>
              <v-list-tile-sub-title>
                <v-chip label outline color="gray darken-3" v-if="data.state === 1">Activa</v-chip>
                <v-chip label outline color="red darken-3" v-else>Inactiva</v-chip>
              </v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Nota</v-list-tile-title>
              <v-list-tile-sub-title>{{ data.note }}</v-list-tile-sub-title>
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
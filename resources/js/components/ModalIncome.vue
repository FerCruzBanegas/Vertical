<template>
  <v-dialog v-model="openLastIncome.modalIn" :value.sync="openLastIncome.showIn" persistent>
    <v-card>
      <v-system-bar color="grey darken-3" dark>
        <div class="title">MOVIMIENTOS</div>
        <v-spacer></v-spacer>
        <v-icon @click="close">close</v-icon>
      </v-system-bar>
      <v-card-text>
        <!-- <div class="text-xs-center" v-if="openLastIncome.modal">
          <v-progress-circular
            indeterminate
            color="grey ligthen-3"
          ></v-progress-circular>
        </div>     -->
        <div>
          <v-toolbar flat color="white">
            <v-toolbar-title>Últimos ingresos registrados</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn outline @click="redirect"><v-icon left>add_circle</v-icon>Nuevo Ingreso</v-btn>
          </v-toolbar>
          <table-move :items="incomes"></table-move>
        </div>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
  import TableMove from './TableMove.vue'
  import { mapGetters } from 'vuex'

  export default {
    name: 'modal-income',

    components: {
      'table-move' : TableMove
    },

    computed: mapGetters([
      'openLastIncome',
      'incomes'
    ]),

    methods: {
      redirect() {
        this.close()
        this.$router.push({ name: 'CreateIncome' })
      },

      close () {
        this.$store.dispatch('closeModalIncome')
      }
    }
  }
</script>

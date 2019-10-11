<template>
  <v-dialog v-model="openLastExpense.modalEx" :value.sync="openLastExpense.showEx" persistent>
    <v-card>
      <v-system-bar color="grey darken-3" dark>
        <div class="title">MOVIMIENTOS</div>
        <v-spacer></v-spacer>
        <v-icon @click="close">close</v-icon>
      </v-system-bar>
      <v-card-text>
        <!-- <div class="text-xs-center" v-if="openLastExpense.modal">
          <v-progress-circular
            indeterminate
            color="grey ligthen-3"
          ></v-progress-circular>
        </div>     -->
        <div>
          <v-toolbar flat color="white">
            <v-toolbar-title>Últimos egresos registrados</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn outline router @click="redirect"><v-icon left>add_circle</v-icon>Nuevo Egreso</v-btn>
          </v-toolbar>
          <table-move :items="expenses"></table-move>
        </div>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
  import TableMove from './TableMove.vue'
  import { mapGetters } from 'vuex'

  export default {
    name: 'modal-expense',

    components: {
      'table-move' : TableMove
    },

    computed: mapGetters([
      'openLastExpense',
      'expenses'
    ]),

    methods: {
      redirect() {
        this.close()
        this.$router.push({ name: 'CreateExpense' })
      },

      close () {
        this.$store.dispatch('closeModalExpense')
      }
    }
  }
</script>

<template>
  <v-dialog width="1000px" v-model="getSmallBoxesActives.modalBox" :value.sync="getSmallBoxesActives.showBox" persistent>
    <v-card>
      <v-system-bar color="grey darken-3" dark>
        <div class="title">CAJA CHICA</div>
        <v-spacer></v-spacer>
        <v-icon @click="close">close</v-icon>
      </v-system-bar>
      <v-card-text>
        <div>
          <v-toolbar flat color="white">
            <v-toolbar-title>Lista de cajas activas</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn outline router @click="redirectCreate"><v-icon left>add_circle</v-icon>Abrir Caja</v-btn>
          </v-toolbar>
          <v-data-table
            :headers="headers"
            :items="boxes"
            item-key="name"
            rows-per-page-text="Items por página"
          >
            <template v-slot:items="props">
              <tr @click="props.expanded = !props.expanded">
                <td class="justify-center layout px-0">
                  <v-btn icon class="mx-0" @click="redirectShow(props.item.id)">
                    <v-icon color="grey darken-1">visibility</v-icon>
                  </v-btn>
                </td>
                <td>{{ props.item.date_init | formatDate('DD/MM/YYYY') }}</td>
                <td>{{ props.item.start_amount | currency }}</td>
                <td>{{ props.item.add_amount | currency }}</td>
                <td>{{ props.item.name }}</td>
              </tr>
            </template>
            <template slot="no-data">
              <center>Sin Resultados</center>
            </template>
            <template v-slot:pageText="props">
              {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
            </template>
          </v-data-table>
        </div>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
  import TableMove from './TableMove.vue'
  import { mapGetters } from 'vuex'
  import AmountService from '../services/amount.service'

  export default {
    $_veeValidate: {
      validator: 'new'
    },
    name: 'modal-smallbox',
    data() {
      return{
        currency_config: {
          decimal: '.',
          thousands: ',',
          prefix: 'Bs ',
          suffix: '',
          precision: 2,
          masked: false,
          allowBlank: false,
          min: Number.MIN_SAFE_INTEGER,
          max: Number.MAX_SAFE_INTEGER
        },
        expand: false,
        headers: [
          { text: '', align: 'left', sortable: false, width: "50" },
          { text: 'Fecha Apertura', value: 'fecha', width: "100" },
          { text: 'Monto Inicial', value: 'incial', width: "100" },
          { text: 'Monto Adicional', sortable: false, value: 'adicional', width: "100" },
          { text: 'Encargado', sortable: false, value: 'encargado', width: "100" },
        ],
      }
    },

    components: {
      'table-move' : TableMove
    },

    computed: mapGetters([
      'getSmallBoxesActives',
      'boxes'
    ]),

    methods: {
      // addAmount:async function(item) {
      //   this.$validator.errors.clear();
      //   try {
      //     item.loading = true
      //     let data = {
      //       quantity: item.new_amount,
      //       small_box_id: item.id
      //     }

      //     const response = await AmountService.storeAmount(data)
      //     if (response.status === 201) {
      //       item.loading = false
      //     }
      //   } catch (err) {
      //     if(err.response.status === 422) this.$setErrorsFromResponse(err.response.data);
      //     item.loading = false
      //   }
      // },

      redirectCreate() {
        this.close()
        this.$router.push({ name: 'CreateSmallBox' })
      },

      redirectShow(id) {
        this.close()
        this.$router.push({ name: 'ShowSmallBox', params: { id: id }})
      },

      close () {
        this.$store.dispatch('closeModalSmallBox')
      }
    }
  }
</script>

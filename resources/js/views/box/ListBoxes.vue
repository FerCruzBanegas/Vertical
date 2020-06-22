<template>
  <v-container fluid grid-list-md>
    <v-layout row wrap>
      <v-flex xs12 sm12 md12 lg12 xl12>
        <v-system-bar status color="grey lighten-4">
          <v-breadcrumbs :items="bread">
            <template v-slot:divider>
              <v-icon>forward</v-icon>
            </template>
          </v-breadcrumbs>
        </v-system-bar>
        <modal-delete :message="message" :loading="loading" :remove="remove" @hide="remove = !remove" @deleted="deleted"></modal-delete>
        <v-card flat>
          <v-card-title primary-title>
            <h3 class="headline mb-0">LISTA DE CAJA GENERAL</h3>
          </v-card-title>
          <v-container fluid>
            <v-layout>
              <v-flex xs12 sm12 md12 lg12 xl12>
                <v-card>
                  <v-card-title>
                    <v-btn
                      v-if="permission('boxes.create')"
                      outline
                      to="boxes/create"
                    >
                      <v-icon left>add_circle</v-icon>NUEVO ARQUEO
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn flat icon color="red darken-3" @click="allData">
                      <v-icon>cached</v-icon>
                    </v-btn>
                    <v-flex xs12 sm12 md6 lg6 xl6>
                      <v-menu
                        ref="menu" v-model="menuRange" :close-on-content-click="false" :nudge-right="30"
                        lazy transition="scale-transition" offset-y full-width min-width="290px"
                      >
                        <v-text-field box label="Rango de fechas" color="grey darken-2" slot="activator" :value="formattedRange" readonly>
                        </v-text-field>
                        <date-range-picker v-model="dateRange">
                          <v-spacer></v-spacer>
                          <v-btn @click="search" color="red darken-3" flat>OK</v-btn>
                        </date-range-picker>
                      </v-menu>
                    </v-flex>
                  </v-card-title>
                  <v-data-table
                    :headers="headers"
                    :items="items"
                    :pagination.sync="pagination"
                    :total-items="totalItems"
                    :loading="progress"
                    class="elevation-1"
                    rows-per-page-text="Items por página"
                  >
                    <v-progress-linear height="3" slot="progress" color="red darken-3" indeterminate></v-progress-linear>
                    <template slot="items" slot-scope="props">
                      <td class="justify-center layout px-0">
                        <v-btn v-if="permission('boxes.show')" icon class="mx-0" :to="{ name: 'ShowBox', params: { id: props.item.id }}">
                          <v-icon color="grey darken-1">visibility</v-icon>
                        </v-btn>
                      </td>
                      <td>{{ props.item.date_init | formatDate('DD/MM/YYYY') }}</td>
                      <td>{{ props.item.date_end | formatDate('DD/MM/YYYY') }}</td>
                      <td>{{ props.item.causer.causer }}</td>
                      <td>{{ props.item.amount | currency }}</td>
                      <td>
                        <v-btn
                          v-if="permission('boxes.update')"
                          small 
                          flat 
                          icon class="mx-0" 
                          color="grey"
                          :to="{ name: 'EditBox', params: { id: props.item.id }}"
                        >
                          <v-icon small color="grey">edit</v-icon>
                        </v-btn>
                        <v-btn 
                          v-if="permission('boxes.destroy')"
                          small
                          flat 
                          icon class="mx-0" 
                          color="red"
                          @click="showModal(props.item)"
                        >
                          <v-icon small color="red">delete</v-icon>
                        </v-btn>
                      </td>
                    </template>
                    <template slot="no-data">
                      <center>Sin Resultados</center>
                    </template>
                    <template v-slot:pageText="props">
                      {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                    </template>
                  </v-data-table>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import moment from 'moment'
  import DateRangePicker from '../../components/DateRangePicker'
  import permission from '../../mixins/permission'
  import ModalDelete from '../../components/ModalDelete.vue'
  import BoxService from '../../services/box.service'

  export default {
    name: 'list-boxes',
    data () {
      return {
        bread: [
          {
            text: 'Inicio',
            disabled: false,
            href: '/dashboard'
          },
          {
            text: 'Cajas',
            disabled: true
          }
        ],
        menuRange: false,
        dateRange: [],
        progress: false,
        message: 'Realmente desea borrar los datos de este registro?',
        remove: false,
        loading: false,
        headers: [
          { text: '', align: 'left', sortable: false, width: "50" },
          { text: 'Desde', value: 'desde', width: "150" },
          { text: 'Hasta', value: 'hasta', width: "150" },
          { text: 'Encargado', value: 'encargado', width: "150" },
          { text: 'Monto Total', value: 'total', width: "150" },
          { text: 'Acciones', sortable: false, value: 'acciones', width: "150" }
        ],
        items: [],
        totalItems: 0,
        pagination: {
          rowsPerPage: 10
        }
      }
    },

    mixins: [permission],

    components: {
      'modal-delete' : ModalDelete,
      DateRangePicker
    },

    computed: {
      formattedRange () {
        if (this.dateRange.length) {
          let range = moment(this.dateRange[0]).format('D MMMM')
          if (this.dateRange[1]) {
            range += ' - ' + moment(this.dateRange[1]).format('D MMMM')
          }
          return range
        }
      }
    },
    
    watch: {
      pagination: {
        handler () {
          this.getDataFromApi()
          .then(data => {
            this.items = data.items
          })
        },
        deep: true
      }
    },

    methods: {
      showModal(item) {
        this.remove = true
        this.id = item.id
      },

      deleted:async function() {
        this.loading = true
        const response = await BoxService.deleteBox(`boxes/${this.id}`)
        if (response.status === 200) {
          this.loading = false
          this.remove = false
          this.getDataFromApi()
          .then(data => {
            this.items = data.items
          })
        }
      },

      search() {
        this.menuRange = false
        this.getDataFromApi().then(data =>{
          this.items = data.items
        })
      },

      allData() {
        this.dateRange = []
        this.pagination.page = 1
        this.getDataFromApi().then(data =>{
          this.items = data.items
        })
      },
      
      filterData() {
        this.getDataFromApi().then(data =>{
          this.items = data.items
        })
      },

      getDataFromApi() {
        this.progress = true
        return new Promise((resolve, reject) => {
          const { sortBy, descending, page } = this.pagination
          BoxService.getBoxes(this.buildURL())
          .then((response) => {
            this.totalItems = response.data.meta.total
            let items = response.data.data
            resolve({
              items
            })
            this.progress = false
          })
        })
      },

      buildURL() {
        let page = `?page=${this.pagination.page}`
        let rowsPerPage = `&rowsPerPage=${this.pagination.rowsPerPage}`
        let dateRange = `&dateRange=${JSON.stringify(this.dateRange)}`
        return `boxes${page}${rowsPerPage}${dateRange}`
      }
    }
  }
</script>

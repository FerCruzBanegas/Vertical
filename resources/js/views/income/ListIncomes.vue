<template>
  <v-container fluid grid-list-md>
    <info-events v-if="infoIncome" :data="infoIncome"></info-events>
    <v-layout>
      <v-flex xs12 sm12 md12 lg12>
        <v-card flat>
          <modal-delete :message="message" :loading="loading" :remove="remove" @hide="remove = !remove" @deleted="deleted"></modal-delete>
          <v-card-title primary-title>
            <h3 class="headline mb-0">Lista de Ingresos</h3>
          </v-card-title>
          <v-container fluid>
            <v-layout>
              <v-flex xs12 sm12 md12 lg12>
                <v-card>
                  <v-card-title>
                    <v-btn
                      dark color="grey darken-1" 
                      slot="activator" 
                      class="mb-2" 
                      to="incomes/create"
                    >
                      <v-icon dark>note_add</v-icon>
                    </v-btn>
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn flat icon color="red darken-3" @click="allData">
                      <v-icon>cached</v-icon>
                    </v-btn>
                    <v-text-field
                      color="grey darken-2"
                      v-model="search"
                      @keypress.enter.prevent="filterData"
                      append-icon="search"
                      label="Buscar"
                      single-line
                      hide-details
                    ></v-text-field>
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
                        <v-btn icon class="mx-0" :to="{ name: 'ShowIncome', params: { id: props.item.id }}">
                          <v-icon color="grey darken-1">visibility</v-icon>
                        </v-btn>
                      </td>
                      <td>{{ props.item.title }}</td>
                      <td>{{ props.item.date | formatDate('DD/MM/YYYY') }}</td>
                      <td><strong>Bs. {{ props.item.amount | currency }}</strong></td>
                      <td>{{ props.item.project }}</td>
                      <td>
                        <v-btn
                          small 
                          flat 
                          icon class="mx-0" 
                          color="grey"
                          :to="{ name: 'EditIncome', params: { id: props.item.id }}"
                        >
                          <v-icon small color="grey">edit</v-icon>
                        </v-btn>
                        <v-btn 
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
  import InfoEvents from '../../components/InfoEvents.vue'
  import ModalDelete from '../../components/ModalDelete.vue'
  import IncomeService from '../../services/income.service'

  export default {
    name: 'list-income',
    data () {
      return {
        search: '',
        progress: false,
        message: 'Realmente desea borrar los datos de este registro?',
        remove: false,
        loading: false,
        infoIncome: null,
        headers: [
          { text: '', align: 'left', sortable: false},
          { text: 'Título', value: 'titulo', width: "300" },
          { text: 'Fecha Ingreso', value: 'fecha ingreso', width: "50" },
          { text: 'Monto', sortable: false, value: 'monto', width: "120" },
          { text: 'Proyecto', sortable: false, value: 'proyecto', width: "200" },
          { text: 'Acciones', sortable: false, value: 'acciones', width: "120" }
        ],
        items: [],
        totalItems: 0,
        pagination: {
          rowsPerPage: 10
        }
      }
    },

    components: {
      'info-events' : InfoEvents,
      'modal-delete' : ModalDelete
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

    created() {
      this.getInfoIncome()
    },

    methods: {
      getInfoIncome: async function() {
        const response = await IncomeService.getIncomes('incomes/amounts')
        if (response.status === 200) {
          this.infoIncome = response.data
        }
      },

      showModal(item) {
        this.remove = true
        this.id = item.id
      },

      deleted:async function() {
        this.loading = true
        const response = await IncomeService.deleteIncome(`incomes/${this.id}`)
        if (response.status === 200) {
          this.loading = false
          this.remove = false
          this.getDataFromApi()
          .then(data => {
            this.items = data.items
          })
        }
      },

      allData() {
        this.search = ''
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
          IncomeService.getIncomes(this.buildURL())
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
        let filter = this.search === '' ? '' : `&filter=${this.search}`
        return `incomes${page}${rowsPerPage}${filter}`
      }
    }
  }
</script>

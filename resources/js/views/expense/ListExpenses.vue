<template>
  <v-container fluid grid-list-md>
    <info-events v-if="infoExpense" :data="infoExpense" :icon="'trending_down'"></info-events>
    <v-layout row wrap>
      <v-flex xs12 sm12 md12 lg12 xl12>
        <v-card flat>
          <modal-delete :message="message" :loading="loading" :remove="remove" @hide="remove = !remove" @deleted="deleted"></modal-delete>
          <v-card-title primary-title>
            <h3 class="headline mb-0">Lista de Egresos</h3>
          </v-card-title>
          <v-container fluid>
            <v-layout>
              <v-flex xs12 sm12 md12 lg12 xl12>
                <v-card>
                  <v-card-title>
                    <v-container fluid>
                      <v-layout row wrap>
                        <v-flex xs12 sm12 md4 lg4>
                          <v-btn
                            dark color="grey darken-1" 
                            slot="activator" 
                            class="mb-2" 
                            to="expenses/create"
                          >
                            <v-icon dark>note_add</v-icon>
                          </v-btn>
                        </v-flex>
                        <v-spacer></v-spacer>
                        <v-flex xs12 sm12 md6 lg6>
                          <v-text-field
                            color="grey darken-2"
                            v-model="search"
                            @keypress.enter.prevent="filterData"
                            append-icon="search"
                            label="Buscar"
                            single-line
                            hide-details
                            clearable
                          >
                            <template v-slot:prepend>
                              <v-btn flat icon color="red darken-3" @click="allData">
                                <v-icon>cached</v-icon>
                              </v-btn>
                            </template>
                          </v-text-field>
                        </v-flex>
                      </v-layout>
                      <filters @changeDate="dateFilter" @selectProject="projectFilter"></filters>
                    </v-container>
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
                        <v-btn icon class="mx-0" :to="{ name: 'ShowExpense', params: { id: props.item.id }}">
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
                          :to="{ name: 'EditExpense', params: { id: props.item.id }}"
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
  import Filters from '../../components/Filters.vue'
  import ExpenseService from '../../services/expense.service'

  export default {
    name: 'list-expense',
    data () {
      return {
        date: '',
        project: null,
        search: null,
        progress: false,
        message: 'Realmente desea borrar los datos de este registro?',
        remove: false,
        loading: false,
        infoExpense: null,
        headers: [
          { text: '', align: 'left', sortable: false, width: "50" },
          { text: 'Título', value: 'titulo', width: "250" },
          { text: 'Fecha Egreso', value: 'fecha egreso', width: "60" },
          { text: 'Monto', sortable: false, value: 'monto', width: "130" },
          { text: 'Proyecto', sortable: false, value: 'proyecto', width: "190" },
          { text: 'Acciones', sortable: false, value: 'acciones', width: "150" }
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
      'modal-delete' : ModalDelete,
      'filters' : Filters
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
      this.getInfoExpense()
    },

    methods: {
      dateFilter(date) {
        this.date = date
        this.getDataFromApi().then(data =>{
          this.items = data.items
        })
      },

      projectFilter(project) {
        this.project = project
        this.getDataFromApi().then(data =>{
          this.items = data.items
        })
      },

      getInfoExpense: async function() {
        const response = await ExpenseService.getExpenses('expenses/amounts')
        if (response.status === 200) {
          this.infoExpense = response.data
        }
      },

      showModal(item) {
        this.remove = true
        this.id = item.id
      },

      deleted:async function() {
        this.loading = true
        const response = await ExpenseService.deleteExpense(`expenses/${this.id}`)
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
        this.$bus.$emit('updatingData')
        this.date = ''
        this.project = null
        this.search = null
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
          ExpenseService.getExpenses(this.buildURL())
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
        let filter = this.search === null ? '' : `&filter=${this.search}`
        let project = this.project === null ? '' : `&project=${this.project}`
        let date = this.date === '' ? '' : `&date=${this.date}`
        return `expenses${page}${rowsPerPage}${filter}${date}${project}`
      }
    }
  }
</script>

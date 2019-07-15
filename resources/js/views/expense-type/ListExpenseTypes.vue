<template>
  <v-container fluid grid-list-md>
    <v-layout>
      <v-flex d-flex xs12 sm12 md12>
        <modal-delete :message="message" :loading="loading" :remove="remove" @hide="remove = !remove" @deleted="deleted"></modal-delete>
          <modal-loader :loader="loader"></modal-loader>
          <modal-type :modal="modal" @hide="modal = !modal" :data="expense_type"></modal-type>
        <v-card>
          <v-card-title primary-title>
            <h3 class="headline mb-0">Lista Tipos de Egreso</h3>
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
                      to="expense-types/create"
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
                        <v-btn icon class="mx-0" @click="getDetail(props.item.id)">
                          <v-icon color="grey darken-1">visibility</v-icon>
                        </v-btn>
                      </td>
                      <td>{{ props.item.name }}</td>
                      <td>{{ props.item.description }}</td>
                      <td>
                        <v-badge color="grey darken-1">
                          <template v-slot:badge>
                            <span>{{ props.item.expenses }}</span>
                          </template>
                        </v-badge>
                      </td>
                      <td>{{ props.item.created }}</td>
                      <td>
                        <v-btn
                          small 
                          flat 
                          icon class="mx-0" 
                          color="grey"
                          :to="{ name: 'EditExpenseType', params: { id: props.item.id }}"
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
  import ModalLoader from '../../components/ModalLoader.vue'
  import ModalType from '../../components/ModalType.vue'
  import ModalDelete from '../../components/ModalDelete.vue'
  import ExpenseTypeService from '../../services/expense.type.service'

  export default {
    name: 'list-expense-types',
    data () {
      return {        
        search: '',
        progress: false,
        message: '',
        remove: false,
        loading: false,
        loader: false,
        modal: false,
        expense_type: null,
        headers: [
          { text: '', align: 'left', sortable: false},
          { text: 'Nombre', value: 'nombre', width: "200" },
          { text: 'Descripción', value: 'descripcion', width: "400" },
          { text: 'Egresos', sortable: false, value: 'egresos' },
          { text: 'Registrado', value: 'registrado' },
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
      'modal-loader' : ModalLoader,
      'modal-type' : ModalType,
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

    methods: {
      setMessage (item) {
        const expenses = item.expenses
        if( expenses >= 1) {
          this.message = `Existen ${expenses} egresos relacionados a esta categoría, si la elimina los egresos también se borrarán. Desea continuar?`
        } else {
          this.message = 'Realmente desea borrar los datos de este registro?'
        }
      },

      showModal(item) {
        this.setMessage(item)
        this.remove = true
        this.id = item.id
      },

      deleted:async function() {
        this.loading = true
        const response = await ExpenseTypeService.deleteExpenseType(`expense-types/${this.id}`)
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
          ExpenseTypeService.getExpenseTypes(this.buildURL())
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

      getDetail: async function(id) {
        this.loader = true
        const response = await ExpenseTypeService.getExpenseTypes(`expense-types/${id}`)
        if (response.status === 200) {
          this.expense_type = response.data.data
          this.loader = false
          this.modal = true
        }
      },

      buildURL() {
        let page = `?page=${this.pagination.page}`
        let rowsPerPage = `&rowsPerPage=${this.pagination.rowsPerPage}`
        let filter = this.search === '' ? '' : `&filter=${this.search}`
        return `expense-types${page}${rowsPerPage}${filter}`
      }
    }
  }
</script>

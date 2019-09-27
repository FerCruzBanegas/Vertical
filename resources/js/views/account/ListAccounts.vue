<template>
  <v-container fluid grid-list-md>
    <v-layout row wrap>
      <v-flex xs12 sm12 md12 lg12 xl12>
        <modal-state :title="title_state" :message="message_state" :loading="loading_state" :state="state" @hide="state = !state" @change_state="changeState"></modal-state>
        <modal-delete :message="message" :loading="loading" :remove="remove" @hide="remove = !remove" @deleted="deleted"></modal-delete>
        <modal-loader :loader="loader"></modal-loader>
        <modal-account :modal="modal" @hide="modal = !modal" :data="account"></modal-account>
        <v-card flat>
          <v-card-title primary-title>
            <h3 class="headline mb-0">Lista de Cuentas</h3>
          </v-card-title>
          <v-container fluid>
            <v-layout>
              <v-flex xs12 sm12 md12 lg12 xl12>
                <v-card>
                  <v-card-title>
                    <v-btn
                      v-if="permission('accounts.create')"
                      dark color="grey darken-1" 
                      slot="activator" 
                      class="mb-2" 
                      to="accounts/create"
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
                      clearable
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
                        <v-btn v-if="permission('accounts.show')" icon class="mx-0" @click="getDetail(props.item.id)">
                          <v-icon color="grey darken-1">visibility</v-icon>
                        </v-btn>
                      </td>
                      <td>{{ props.item.title }}</td>
                      <td>{{ props.item.date | formatDate('DD/MM/YYYY') }}</td>
                      <td><strong>{{ props.item.amount | currency }}</strong></td>
                      <td>
                        <v-chip
                          v-if="props.item.state === 1"
                          color="green lighten-4"
                          class="ml-0"
                          label
                          small
                        >
                          Activa
                        </v-chip>
                        <v-chip
                          v-else
                          color="red lighten-4"
                          class="ml-0"
                          label
                          small
                        >
                          Inactiva
                        </v-chip>
                      </td>
                      <td>
                        <v-btn
                          v-if="permission('accounts.update')"
                          small 
                          flat 
                          icon class="mx-0" 
                          color="grey"
                          :to="{ name: 'EditAccount', params: { id: props.item.id }}"
                        >
                          <v-icon small color="grey">edit</v-icon>
                        </v-btn>
                        <v-btn 
                          v-if="permission('accounts.destroy')"
                          small
                          flat 
                          icon class="mx-0" 
                          color="red"
                          @click="showModalState(props.item)"
                        >
                          <v-icon small color="red">power_settings_new</v-icon>
                        </v-btn>
                        <v-btn 
                          v-if="permission('accounts.destroy')"
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
  import permission from '../../mixins/permission'
  import ModalLoader from '../../components/ModalLoader.vue'
  import ModalAccount from '../../components/ModalAccount.vue'
  import ModalDelete from '../../components/ModalDelete.vue'
  import ModalState from '../../components/ModalState.vue'
  import AccountService from '../../services/account.service'

  export default {
    name: 'list-accounts',
    data () {
      return {
        search: '',
        progress: false,
        message: 'Realmente desea borrar los datos de este registro?',
        remove: false,
        loading: false,
        loader: false,
        modal: false,
        account: null,
        state: false,
        title_state: null,
        message_state: null,
        loading_state: false,
        headers: [
          { text: '', align: 'left', sortable: false, width: "50" },
          { text: 'Título', value: 'titulo', width: "200" },
          { text: 'Fecha Apertura', value: 'fecha', width: "200" },
          { text: 'Monto Inicial', value: 'monto', width: "100" },
          { text: 'Estado', value: 'estado', width: "100" },
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
      'modal-loader' : ModalLoader,
      'modal-account' : ModalAccount,
      'modal-delete' : ModalDelete,
      'modal-state' : ModalState
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
      showModalState(item) {
        if (item.state === 1) {
          this.title_state = 'Desactivar Cuenta'
          this.message_state = 'Realmente quiere desactivar esta cuenta?'
        } else {
          this.title_state = 'Activar Cuenta'
          this.message_state = 'Realmente desea volver a activar esta cuenta?'
        }
        this.state = true
        this.id = item.id
      },

      showModal(item) {
        this.remove = true
        this.id = item.id
      },

      changeState:async function() {
        this.loading_state = true
        const response = await AccountService.changeState(this.id)
        if (response.status === 200) {
          this.loading_state = false
          this.state = false
          this.getDataFromApi()
          .then(data => {
            this.items = data.items
          })
        }
      },

      deleted:async function() {
        this.loading = true
        const response = await AccountService.deleteAccount(`accounts/${this.id}`)
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
          AccountService.getAccounts(this.buildURL())
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
        const response = await AccountService.getAccounts(`accounts/${id}/detail`)
        if (response.status === 200) {
          this.account = response.data.data
          this.loader = false
          this.modal = true
        }
      },

      buildURL() {
        let page = `?page=${this.pagination.page}`
        let rowsPerPage = `&rowsPerPage=${this.pagination.rowsPerPage}`
        let filter = this.search === '' ? '' : `&filter=${this.search}`
        return `accounts${page}${rowsPerPage}${filter}`
      }
    }
  }
</script>

<template>
  <v-container fluid grid-list-md>
    <v-layout row wrap>
      <v-flex xs12 sm12 md12 lg12 xl12>
        <modal-delete :message="message" :loading="loading" :remove="remove" @hide="remove = !remove" @deleted="deleted"></modal-delete>
        <modal-loader :loader="loader"></modal-loader>
        <modal-users :modal="modal" @hide="modal = !modal" :data="user"></modal-users>
        <v-card flat>
          <v-card-title primary-title>
            <h3 class="headline mb-0">Lista de Usuarios</h3>
          </v-card-title>
          <v-container fluid>
            <v-layout>
              <v-flex xs12 sm12 md12 lg12 xl12>
                <v-card>
                  <v-card-title>
                    <v-btn 
                      v-if="permission('users.create')"
                      dark color="grey darken-1" 
                      slot="activator" 
                      class="mb-2"
                      to="users/create"
                    >
                      <v-icon dark>note_add</v-icon>
                    </v-btn>
                    </v-btn>
                    <v-spacer></v-spacer>
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
                        <v-btn v-if="permission('users.show')" icon class="mx-0" @click="getDetail(props.item.id)">
                          <v-icon color="grey darken-1">visibility</v-icon>
                        </v-btn>
                      </td>
                      <td>{{ props.item.name }}</td>
                      <td>{{ props.item.email }}</td>
                      <td>{{ props.item.created | formatDate('DD/MM/YYYY') }}</td>
                      <td>{{ props.item.updated | formatDate('DD/MM/YYYY') }}</td>
                      <td>
                        <v-btn
                          v-if="permission('users.update')" 
                          small 
                          flat 
                          icon class="mx-0" 
                          color="grey"
                          :to="{ name: 'EditUser', params: { id: props.item.id }}"
                        >
                          <v-icon small color="grey">edit</v-icon>
                        </v-btn>
                        <v-btn
                          v-if="permission('users.destroy')" 
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
  import ModalUsers from '../../components/ModalUsers.vue'
  import ModalDelete from '../../components/ModalDelete.vue'
  import UserService from '../../services/user.service'

  export default {
    name: 'list-users',
    data () {
      return {
        search: '',
        progress: false,
        message: 'Realmente desea borrar los datos de este registro?',
        remove: false,
        loading: false,
        loader: false,
        modal: false,
        user: null,
        headers: [
          { text: '', align: 'left', sortable: false, width: "50" },
          { text: 'Nombre', value: 'nombre', width: "100" },
          { text: 'Correo', value: 'correo', width: "200" },
          { text: 'Registrado', sortable: false, value: 'registrado', width: "75" },
          { text: 'Actualizado', value: 'actualizado', width: "75" },
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
      'modal-users' : ModalUsers,
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
      showModal(item) {
        this.remove = true
        this.id = item.id
      },

      deleted:async function() {
        this.loading = true
        const response = await UserService.deleteUser(`users/${this.id}`)
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
          UserService.getUsers(this.buildURL())
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
        const response = await UserService.getUsers(`users/${id}/detail`)
        if (response.status === 200) {
          this.user = response.data.data
          this.loader = false
          this.modal = true
        }
      },

      buildURL() {
        let page = `?page=${this.pagination.page}`
        let rowsPerPage = `&rowsPerPage=${this.pagination.rowsPerPage}`
        let filter = this.search === '' ? '' : `&filter=${this.search}`
        return `users${page}${rowsPerPage}${filter}`
      }
    }
  }
</script>

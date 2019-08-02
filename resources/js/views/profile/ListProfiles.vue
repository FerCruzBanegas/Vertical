<template>
  <v-container fluid grid-list-md>
    <v-layout row wrap>
      <v-flex xs12 sm12 md12 lg12 xl12>
        <v-card flat>
          <modal-delete :message="message" :loading="loading" :remove="remove" @hide="remove = !remove" @deleted="deleted"></modal-delete>
          <v-card-title primary-title>
            <h3 class="headline mb-0">Perfiles</h3>
          </v-card-title>
          <v-container fluid>
            <v-layout>
              <v-flex xs12 sm12 md12 lg12 xl12>
                <v-card>
                  <v-card-title>
                    <v-btn 
                      v-if="permission('profiles.create')"
                      dark color="grey darken-1" 
                      slot="activator" 
                      class="mb-2"
                      to="profiles/create"
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
                      <td>{{ props.item.description }}</td>
                      <td>{{ props.item.created }}</td>
                      <td>{{ props.item.updated }}</td>
                      <td>
                        <v-btn
                          v-if="permission('profiles.update')" 
                          small 
                          flat 
                          icon class="mx-0" 
                          color="grey"
                          :to="{ name: 'EditProfile', params: { id: props.item.id }}"
                        >
                          <v-icon small color="grey">edit</v-icon>
                        </v-btn>
                        <v-btn
                          v-if="permission('profiles.destroy')" 
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
  import ModalDelete from '../../components/ModalDelete.vue'
  import ProfileService from '../../services/profile.service'

  export default {
    name: 'list-profiles',
    data () {
      return {
        search: '',
        progress: false,
        message: 'Si elimina el registro, también se eliminarán todos los usuarios que tengan este perfil. Desea continuar?',
        remove: false,
        loading: false,
        headers: [
          { text: 'Descripción', value: 'descripcion', width: "150" },
          { text: 'Registrado', value: 'registrado', sortable: false, width: "75" },
          { text: 'Actualizado', value: 'actualizado', sortable: false, width: "75" },
          { text: 'Acciones', value: 'acciones', sortable: false, width: "75" }
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
        const response = await ProfileService.deleteProfile(`profiles/${this.id}`)
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
          ProfileService.getProfiles(this.buildURL())
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
        return `profiles${page}${rowsPerPage}${filter}`
      }
    }
  }
</script>

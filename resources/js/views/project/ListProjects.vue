<template>
  <v-container fluid grid-list-md>
    <v-layout row wrap>
      <v-flex xs12 sm12 md12 lg12 xl12>
        <modal-delete :message="message" :loading="loading" :remove="remove" @hide="remove = !remove" @deleted="deleted"></modal-delete>
        <v-card flat>
          <v-card-title primary-title>
            <h3 class="headline mb-0">Lista de Proyectos</h3>
          </v-card-title>
          <v-container fluid>
            <v-layout>
              <v-flex xs12 sm12 md12 lg12 xl12>
                <v-card>
                  <v-card-title>
                    <v-btn
                      v-if="permission('projects.create')"
                      dark color="grey darken-1" 
                      slot="activator" 
                      class="mb-2" 
                      to="projects/create"
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
                        <v-btn v-if="permission('projects.show')" icon class="mx-0" :to="{ name: 'ShowProject', params: { id: props.item.id }}">
                          <v-icon color="grey darken-1">visibility</v-icon>
                        </v-btn>
                      </td>
                      <td>{{ props.item.name }}</td>
                      <td>{{ props.item.project_type }}</td>
                      <td>
                        <v-chip
                          v-if="props.item.state == 'Terminado'"
                          color="red lighten-4"
                          class="ml-0"
                          label
                          small
                        >
                          {{ props.item.state }}
                        </v-chip>
                        <v-chip
                          v-else
                          color="green lighten-4"
                          class="ml-0"
                          label
                          small
                        >
                          {{ props.item.state }}
                        </v-chip>
                      </td>
                      <td>{{ props.item.created }}</td>
                      <td>
                        <v-btn
                          v-if="permission('projects.update')"
                          small 
                          flat 
                          icon class="mx-0" 
                          color="grey"
                          :to="{ name: 'EditProject', params: { id: props.item.id }}"
                        >
                          <v-icon small color="grey">edit</v-icon>
                        </v-btn>
                        <v-btn 
                          v-if="permission('projects.destroy')"
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
  import ProjectService from '../../services/project.service'

  export default {
    name: 'list-projects',
    data () {
      return {
        search: '',
        progress: false,
        message: 'Realmente desea borrar los datos de este registro?',
        remove: false,
        loading: false,
        headers: [
          { text: '', align: 'left', sortable: false, width: "50" },
          { text: 'Nombre', value: 'nombre', width: "200" },
          { text: 'Tipo de Proyecto', value: 'tipo', width: "250" },
          { text: 'Estado', value: 'estado', width: "100" },
          { text: 'Registrado', value: 'registrado', width: "100" },
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
      // setMessage (item) {
      //   const materials = item.materials
      //   if( materials > 1) {
      //     this.message = `Existen ${materials} materiales relacionados a esta categoría, si la elimina los materiales también se borrarán. Desea continuar?`
      //   } else {
      //     this.message = 'Realmente desea borrar los datos de este registro?'
      //   }
      // },

      showModal(item) {
        // this.setMessage(item)
        this.remove = true
        this.id = item.id
      },

      deleted:async function() {
        this.loading = true
        const response = await ProjectService.deleteProject(`projects/${this.id}`)
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
          ProjectService.getProjects(this.buildURL())
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
        return `projects${page}${rowsPerPage}${filter}`
      }
    }
  }
</script>

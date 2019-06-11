<template>
  <v-container fluid grid-list-md>
    <v-layout row child-flex wrap>
      <v-flex d-flex xs12 sm3 md3 lg3 xl3>
        <v-card class="mx-auto" color="grey" dark>
          <v-card-title>
            <v-icon x-large left>trending_up</v-icon>
            <span class="title font-weight-light">En General</span>
          </v-card-title>
          <v-divider dark></v-divider>
          <v-card-text class="headline font-weight-bold text-md-center">
           Bs. 1,200.46
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex d-flex xs12 sm3 md3 lg3 xl3>
        <v-card class="mx-auto" color="grey" dark>
          <v-card-title>
            <v-icon x-large left>trending_up</v-icon>
            <span class="title font-weight-light">Este Mes</span>
          </v-card-title>
          <v-divider dark></v-divider>
          <v-card-text class="headline font-weight-bold text-md-center">
           Bs. 23,200,200.46
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex d-flex xs12 sm3 md3 lg3 xl3>
        <v-card class="mx-auto" color="grey" dark>
          <v-card-title>
            <v-icon x-large left>trending_up</v-icon>
            <span class="title font-weight-light">Esta Semana</span>
          </v-card-title>
          <v-divider dark></v-divider>
          <v-card-text class="headline font-weight-bold text-md-center">
           Bs. 1,200.46
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex d-flex xs12 sm3 md3 lg3 xl3>
        <v-card class="mx-auto" color="grey" dark>
          <v-card-title>
            <v-icon x-large left>trending_up</v-icon>
            <span class="title font-weight-light">Hoy</span>
          </v-card-title>
          <v-divider dark></v-divider>
          <v-card-text class="headline font-weight-bold text-md-center">
           Bs. 1,200.46
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
    <v-layout>
      <v-flex d-flex xs12 sm12 md12>
        <v-card>
          <modal-delete :message="message" :loader="loader" :dialog="dialog" @hide="hide" @deleted="deleted"></modal-delete>
          <v-card-title primary-title>
            <h3 class="headline mb-0">Lista Tipos de Material</h3>
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
                      to="material-types/create"
                    >
                      <v-icon dark>note_add</v-icon>
                    </v-btn>
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-text-field
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
                    :loading="loading"
                    class="elevation-1"
                    rows-per-page-text="Items por página"
                  >
                    <v-progress-linear height="3" slot="progress" color="red darken-3" indeterminate></v-progress-linear>
                    <template slot="items" slot-scope="props">
                      <td>{{ props.item.name }}</td>
                      <td>{{ props.item.description }}</td>
                      <td>
                        <v-badge color="grey darken-1">
                          <template v-slot:badge>
                            <span>{{ props.item.materials }}</span>
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
                          :to="{ name: 'EditMaterialType', params: { id: props.item.id }}"
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
  import ModalDelete from '../../components/ModalDelete.vue'
  import MaterialTypeService from '../../services/material.type.service'

  export default {
    name: 'list-material-types',
    data () {
      return {
        loader: false,
        dialog: false,
        message: '',
        search: '',
        loading: false,
        headers: [
          { text: 'Nombre', value: 'nombre', width: "200" },
          { text: 'Descripción', value: 'descripcion', width: "400" },
          { text: 'Materiales', sortable: false, value: 'materiales' },
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
      'modal-delete' : ModalDelete,
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
        const materials = item.materials
        if( materials > 1) {
          this.message = `Existen ${materials} materiales relacionados a esta categoría, si la elimina los materiales también se borrarán. Desea continuar?`
        } else {
          this.message = 'Realmente desea borrar los datos de este registro?'
        }
      },

      showModal(item) {
        this.setMessage(item)
        this.dialog = true
        this.id = item.id
      },

      hide() {
        this.dialog = false
      },

      deleted:async function() {
        this.loader = true
        const response = await MaterialTypeService.deleteMaterialType(`categories/${this.id}`)
        if (response.status === 200) {
          this.loader = false
          this.dialog = false
          this.getDataFromApi()
          .then(data => {
            this.items = data.items
          })
        }
      },

      filterData() {
        this.getDataFromApi().then(data =>{
          this.items = data.items
        })
      },

      getDataFromApi() {
        this.loading = true
        return new Promise((resolve, reject) => {
          const { sortBy, descending, page } = this.pagination
          MaterialTypeService.getMaterialTypes(this.buildURL())
          .then((response) => {
            this.totalItems = response.data.meta.total
            let items = response.data.data
            resolve({
              items
            })
            this.loading = false
          })
        })
      },

      buildURL() {
        let page = `?page=${this.pagination.page}`
        let rowsPerPage = `&rowsPerPage=${this.pagination.rowsPerPage}`
        let filter = this.search === '' ? '' : `&filter=${this.search}`
        return `categories${page}${rowsPerPage}${filter}`
      }
    }
  }
</script>

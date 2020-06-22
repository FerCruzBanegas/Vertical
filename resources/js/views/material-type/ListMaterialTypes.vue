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
          <modal-loader :loader="loader"></modal-loader>
          <modal-type :modal="modal" @hide="modal = !modal" :data="material_type"></modal-type>
        <v-card flat>
          <v-card-title primary-title>
            <h3 class="headline mb-0">LISTA TIPOS DE MATERIAL</h3>
          </v-card-title>
          <v-container fluid>
            <v-layout>
              <v-flex xs12 sm12 md12 lg12 xl12>
                <v-card>
                  <v-card-title>
                    <v-btn
                      v-if="permission('material-types.create')"
                      outline
                      to="material-types/create"
                    >
                      <v-icon left>add_circle</v-icon>
                      NUEVO
                    </v-btn>
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn flat icon color="red darken-3" @click="allData">
                      <v-icon>cached</v-icon>
                    </v-btn>
                    <v-text-field
                      box
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
                        <v-btn v-if="permission('material-types.show')" icon class="mx-0" @click="getDetail(props.item.id)">
                          <v-icon color="grey darken-1">visibility</v-icon>
                        </v-btn>
                      </td>
                      <td>{{ props.item.name }}</td>
                      <td>{{ props.item.description }}</td>
                      <td>
                        <v-badge color="grey darken-1">
                          <template v-slot:badge>
                            <span>{{ props.item.materials }}</span>
                          </template>
                        </v-badge>
                      </td>
                      <td>{{ props.item.created | formatDate('DD/MM/YYYY') }}</td>
                      <td>
                        <v-btn
                          v-if="permission('material-types.update')"
                          small 
                          flat 
                          icon class="mx-0" 
                          color="grey"
                          :to="{ name: 'EditMaterialType', params: { id: props.item.id }}"
                        >
                          <v-icon small color="grey">edit</v-icon>
                        </v-btn>
                        <v-btn 
                          v-if="permission('material-types.destroy')"
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
  import ModalType from '../../components/ModalType.vue'
  import ModalDelete from '../../components/ModalDelete.vue'
  import MaterialTypeService from '../../services/material.type.service'

  export default {
    name: 'list-material-types',
    data () {
      return {     
        bread: [
          {
            text: 'Inicio',
            disabled: false,
            href: '/dashboard'
          },
          {
            text: 'Tipos de Material',
            disabled: true,
            href: '/material-types'
          }
        ],   
        search: '',
        progress: false,
        message: '',
        remove: false,
        loading: false,
        loader: false,
        modal: false,
        material_type: null,
        headers: [
          { text: '', align: 'left', sortable: false, width: "50" },
          { text: 'Nombre', value: 'nombre', width: "200" },
          { text: 'Descripción', value: 'descripcion', width: "400" },
          { text: 'Materiales', sortable: false, value: 'materiales', width: "50" },
          { text: 'Registrado', value: 'registrado', width: "50" },
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
        const materials = item.materials
        if( materials >= 1) {
          this.message = `Existen ${materials} materiales relacionados a esta categoría, si la elimina los materiales también se borrarán. Desea continuar?`
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
        const response = await MaterialTypeService.deleteMaterialType(`material-types/${this.id}`)
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
          MaterialTypeService.getMaterialTypes(this.buildURL())
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
        const response = await MaterialTypeService.getMaterialTypes(`material-types/${id}`)
        if (response.status === 200) {
          this.material_type = response.data.data
          this.loader = false
          this.modal = true
        }
      },

      buildURL() {
        let page = `?page=${this.pagination.page}`
        let rowsPerPage = `&rowsPerPage=${this.pagination.rowsPerPage}`
        let filter = this.search === '' ? '' : `&filter=${this.search}`
        return `material-types${page}${rowsPerPage}${filter}`
      }
    }
  }
</script>

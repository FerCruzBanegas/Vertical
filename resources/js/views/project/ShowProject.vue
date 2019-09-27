<template>
  <v-container fluid grid-list-xl>
    <modal-detail :materials="materials" :people="people" :dialog="dialog" @hide="dialog = !dialog">
    </modal-detail>
    <v-layout wrap>
      <v-flex xs12 sm12 md12 lg12>
        <v-card v-if="project" flat>
          <v-toolbar dense>
            <v-toolbar-title>{{ project.name }}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-tooltip left v-if="project.state === 0">
              <template v-slot:activator="{ on }">
                <v-btn v-if="permission('projects.update')" icon v-on="on" @click="openProject()" :disabled="loading" :loading="loading"><v-icon>history</v-icon></v-btn>
              </template>
              <span>Abrir Proyecto</span>
            </v-tooltip>
            <v-tooltip left v-else>
              <template v-slot:activator="{ on }">
                <v-btn v-if="permission('projects.update')" icon v-on="on" @click="finishProject()" :disabled="loading" :loading="loading"><v-icon>event</v-icon></v-btn>
              </template>
              <span>Finalizar Proyecto</span>
            </v-tooltip>
          </v-toolbar>
          <v-container fluid>
            <v-layout wrap>
              <v-flex xs12 sm12 md6 lg6>
                <v-card>
                  <v-list three-line>
                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Dirección</v-list-tile-title>
                        <v-list-tile-sub-title>{{ project.location }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Fecha de Inicio</v-list-tile-title>
                        <v-list-tile-sub-title>{{ project.start_date | formatDate('DD/MM/YYYY') }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider ></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Fecha de Finalización</v-list-tile-title>
                        <v-list-tile-sub-title v-if="!project.end_date">Sin Fecha</v-list-tile-sub-title>
                        <v-list-tile-sub-title v-else>{{ project.end_date | formatDate('DD/MM/YYYY') }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Registro</v-list-tile-title>
                        <v-list-tile-sub-title>Registrado por: {{ project.created.causer }} en fecha {{ project.created.date | formatDate('DD/MM/YYYY') }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>
                  </v-list>
                </v-card>
              </v-flex>
              <v-flex xs12 sm12 md6 lg6>
                <v-card>
                  <v-list three-line>
                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Tipo de Proyecto</v-list-tile-title>
                        <v-list-tile-sub-title>{{ project.project_type }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Comentarios</v-list-tile-title>
                        <v-list-tile-sub-title>{{ project.comments }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider ></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Estado</v-list-tile-title>
                          <v-list-tile-sub-title>
                            <v-chip label v-if="project.state === 1">
                              <v-icon left>build</v-icon>
                              En ejecución
                            </v-chip>
                            <v-chip label color="grey darken-3" text-color="white" v-else>
                              <v-icon left>check_circle</v-icon>
                              Finalizado
                            </v-chip>
                          </v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Actualización</v-list-tile-title>
                        <v-list-tile-sub-title>Modificado por: {{ project.created.causer }} en fecha {{ project.updated.date | formatDate('DD/MM/YYYY') }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>
                  </v-list>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card>
      </v-flex>
    </v-layout>
    <v-layout wrap>
      <v-flex xs12 sm12 md12 lg12>
        <v-card v-if="project">
          <v-card-title primary-title>
            <div><h3 class="headline mb-0">Lista de Ingresos y Egresos</h3></div>
            <v-container fluid grid-list-md>
              <v-layout row wrap>
                <v-flex d-flex xs12 sm12 md3 lg3>
                  <v-btn outline color="grey" @click="allData">
                    Ver todos
                  </v-btn>
                </v-flex>
                <v-flex d-flex xs12 sm12 md3 lg3>
                  <v-radio-group v-model="type" :mandatory="false">
                    <v-radio @change="filterEvents" label="Ver Ingresos" color="grey" value="1"></v-radio>
                  </v-radio-group>
                </v-flex>
                <v-flex d-flex xs12 sm12 md3 lg3>
                  <v-radio-group v-model="type" :mandatory="false">
                    <v-radio @change="filterEvents" label="Ver Egresos" color="grey" value="2"></v-radio>
                  </v-radio-group>
                </v-flex>
                <v-flex xs12 sm12 md3 lg3 class="py-2">
                  <v-btn-toggle mandatory>
                    <v-btn flat :to="{ name: 'CreateIncome', query: {q: $route.params.id}}">
                      Ingreso <v-icon>attach_money</v-icon>
                    </v-btn>
                    <v-btn flat :to="{ name: 'CreateExpense', query: {q: $route.params.id}}">
                      Egreso <v-icon>money_off</v-icon>
                    </v-btn>
                  </v-btn-toggle>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-title>
          <v-data-table
            :headers="headers"
            :items="events"
            :loading="progress"
            :pagination.sync="pagination"
            :total-items="totalItems"
            class="elevation-1"
            rows-per-page-text="Items por página"
          >
            <v-progress-linear height="3" slot="progress" color="grey" indeterminate></v-progress-linear>
            <template v-slot:items="props">
              <tr :class="props.item.type" :key="props.item.id">
                <td>{{ props.item.title }}</td>
                <td><strong>{{ props.item.payment }}</strong></td>
                <td>{{ props.item.date | formatDate('DD/MM/YYYY') }}</td>
                <td v-if="props.item.type == 'income'" colspan="2" class="text-xs-left"><strong>{{ props.item.amount | currency }}</strong></td>
                <td v-else colspan="2" class="text-xs-right"><strong>{{ props.item.amount | currency }}</strong></td>
                <td>
                  <v-btn 
                    v-if="props.item.type == 'expense'"
                    small
                    flat 
                    icon class="mx-0" 
                    @click="getDetails(props.item)"
                  >
                    <v-icon>zoom_in</v-icon>
                  </v-btn>
                </td>
              </tr>
            </template>
            <template slot="no-data">
              <center>Sin Resultados</center>
            </template>
            <template v-slot:pageText="props">
              {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
            </template>
            <template v-slot:footer v-if="totalEvents">
              <td colspan="2"></td>
              <td class="text-xs-right total"><strong>TOTAL</strong></td>
              <td class="text-xs-left in"><strong>Bs. {{ totalEvents.income | currency }}</strong></td>
              <td class="text-xs-right ex"><strong>Bs. {{ totalEvents.expense | currency }}</strong></td>
              <td></td>
            </template>
          </v-data-table>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import permission from '../../mixins/permission'
  import ModalDetail from '../../components/ModalDetail.vue'
  import ProjectService from '../../services/project.service'

  export default {
    name: 'show-project',
    data () {
      return {
        loading: false,
        dialog: false,
        materials: [],
        people: [],
        progress: false,
        project: null,
        type: null,
        events: [],
        id: this.$route.params.id,
        headers: [
          { text: 'Titulo', value: 'titulo'},
          { text: 'Pago', value: 'pago'},
          { text: 'Fecha', value: 'fecha' },
          { text: 'Monto I', value: 'montoi', align: 'left', width: "150" },
          { text: 'Monto E', value: 'montoe', align: 'right', width: "150" },
          { text: 'Detalles', sortable: false, value: 'detalles' }
        ],
        totalEvents: null,
        totalItems: 0,
        pagination: {
          rowsPerPage: 5
        }
      }
    },

    mixins: [permission],

    components: {
      'modal-detail' : ModalDetail
    },

    watch: {
      pagination: {
        handler () {
          this.getDataFromApi()
          .then(data => {
            this.events = data.items
          })
        },
        deep: true
      }
    },

    created() {
      this.getProject()
    },

    methods: {
      allData() {
        this.type = null
        this.pagination.page = 1
        this.getDataFromApi().then(data =>{
          this.events = data.items
        })
      },
      
      filterEvents(s) {
        this.type = s
        this.pagination.page = 1
        this.getDataFromApi().then(data =>{
          this.events = data.items
        })
      },

      openProject: async function() {
        this.loading = true
        const response = await ProjectService.getProjects(`projects/${this.id}/open`)
        if (response.status === 200) {
          this.project.end_date = response.data.end_date
          this.project.state = response.data.state
          this.loading = false
        }
      },

      finishProject: async function() {
        this.loading = true
        const response = await ProjectService.getProjects(`projects/${this.id}/finish`)
        if (response.status === 200) {
          this.project.end_date = response.data.end_date
          this.project.state = response.data.state
          this.loading = false
        }
      },

      getProject: async function() {
        const response = await ProjectService.getProjects(`projects/${this.id}/detail`)
        if (response.status === 200) {
          this.project = response.data.data;
        }
      },

      getDetails(item) {
        this.dialog = true
        this.materials = item.materials
        this.people = item.people
      },

      getDataFromApi() {
        this.progress = true
        return new Promise((resolve, reject) => {
          const { sortBy, descending, page } = this.pagination
          ProjectService.getProjects(this.buildURL())
          .then((response) => {
            if (!this.totalEvents !== null) this.totalEvents = response.data.meta.totals
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
        let type = this.type === null ? '' : `&type=${this.type}`
        return `projects/${this.id}/events${page}${rowsPerPage}${type}`
      }
    }
  }
</script>

<style scoped>
  .income {
    background-color: #CDE6FF;
  }

  .expense {
    background-color: #FFF083;
  }

  .total {
    background-color: #636363;
    color: #FFFFFF;
  }

  .in {
    background-color: #017EE7;
    color: #FFFFFF;
  }

  .ex {
    background-color: #D8A504;
    color: #FFFFFF;
  }
</style>
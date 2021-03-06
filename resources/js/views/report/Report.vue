<template>
  <v-container fluid grid-list-md v-show="success">
    <v-layout row wrap>
      <v-flex xs12 sm12 md12 lg12 xl12>
        <v-system-bar status color="grey lighten-4">
          <v-breadcrumbs :items="bread">
            <template v-slot:divider>
              <v-icon>forward</v-icon>
            </template>
          </v-breadcrumbs>
        </v-system-bar>
        <v-card>
          <v-container fluid>
            <v-layout row wrap>
              <v-flex xs12 sm12 md5 lg5 xl5>
                <v-autocomplete
                  v-model="model"
                  :items="reports"
                  box
                  color="grey darken-2"
                  label="Lista de Informes"
                  item-text="name"
                  return-object
                >
                  <template v-slot:item="data">
                    <template v-if="typeof data.item !== 'object'">
                      <v-list-tile-content v-text="data.item"></v-list-tile-content>
                    </template>
                    <template v-else>
                      <v-list-tile-content>
                        <v-list-tile-title v-html="data.item.name"></v-list-tile-title>
                        <v-list-tile-sub-title v-html="data.item.group"></v-list-tile-sub-title>
                      </v-list-tile-content>
                    </template>
                  </template>
                </v-autocomplete>
              </v-flex>
              <v-flex xs12 sm12 md4 lg4 xl4 v-show="projectShow">
                <v-autocomplete
                  v-model="params"
                  :items="projectData"
                  box
                  color="grey darken-2"
                  label="Proyecto"
                  item-text="name"
                  item-value="id"
                  return-object
                ></v-autocomplete>
              </v-flex>
              <v-flex xs12 sm12 md4 lg4 xl4 v-show="accountShow">
                <v-autocomplete
                  v-model="params"
                  :items="accountData"
                  box
                  color="grey darken-2"
                  label="Cuenta"
                  item-text="title"
                  item-value="id"
                  return-object
                ></v-autocomplete>
              </v-flex>
              <v-flex xs12 sm12 md3 lg3 xl3 v-show="yearShow">
                <v-autocomplete
                  v-model="params"
                  :items="yearData"
                  box
                  color="grey darken-2"
                  label="Año"
                ></v-autocomplete>
              </v-flex>
              <v-flex xs12 sm12 md3 lg3 xl3 v-show="rangeShow">
                <v-menu
                  ref="menu" v-model="menuRange" :close-on-content-click="false" :nudge-right="30"
                  lazy transition="scale-transition" offset-y full-width min-width="290px"
                >
                  <v-text-field box color="grey darken-2" slot="activator" :value="formattedRange" readonly></v-text-field>
                  <date-range-picker v-model="dateRange">
                    <v-spacer></v-spacer>
                    <v-btn @click="menuRange = false" color="red darken-3" flat>OK</v-btn>
                  </date-range-picker>
                </v-menu>
              </v-flex>
              <v-flex xs12 sm12 md4 lg4 xl4 v-if="monthShow">
                <v-menu
                  ref="menu"
                  v-model="menuMonth"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  :return-value.sync="params"
                  lazy
                  transition="scale-transition"
                  offset-y
                  full-width
                  max-width="290px"
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      box
                      color="grey darken-2"
                      v-model="params"
                      label="Picker in menu"
                      prepend-icon="event"
                      readonly
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    color="red darken-3" 
                    v-model="params"
                    type="month"
                    no-title
                    scrollable
                    locale="es-es"
                  >
                    <v-spacer></v-spacer>
                    <v-btn flat color="red darken-3" @click="menuMonth = false">Cancelar</v-btn>
                    <v-btn flat color="red darken-3" @click="$refs.menu.save(params)">OK</v-btn>
                  </v-date-picker>
                </v-menu>
              </v-flex>
              <!-- <pre>{{ $data }}</pre> -->
            </v-layout>
          </v-container>
        </v-card>
      </v-flex>              
    </v-layout>
    <v-layout row wrap>
      <v-flex xs12 sm12 md12 lg12 xl12>
        <v-card>
          <v-btn large @click="generateReport" :disabled="!submitShow" :loading="loading">Generar Informe</v-btn>
          <div id="wdr-component"></div>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import moment from 'moment'
  import DateRangePicker from '../../components/DateRangePicker'
  import traslate from '../../libraries/es.json'
  import ReportService from '../../services/report.service'
  import ProjectService from '../../services/project.service'
  import AccountService from '../../services/account.service'

  export default {
    name: 'Report',
    data () {
      return {
        bread: [
          {
            text: 'Inicio',
            disabled: false,
            href: '/dashboard'
          },
          {
            text: 'Reportes',
            disabled: true,
            href: '/reports'
          }
        ],
        success: false,
        dateRange: [],
        menuRange: false,
        menuMonth: false,
        loading: false,
        pivot: null,
        params: null,
        model: null,
        reports: [
          { header: 'General' },
          { name: 'Ingresos / Egresos mensual por Año', data: { url: 'report-months-year', type:'year' } },
          { name: 'Ingresos / Egresos por Años', data: { url: 'report-year', type: null } },
          { name: 'Ingresos / Egresos Rango de Fechas', data: { url: 'report-range', type: 'range' } },
          { name: 'Ingresos / Egresos por Mes', data: { url: 'report-month', type: 'month' } },
          { divider: true },
          { header: 'Proyectos' },
          { name: 'Ingresos / Egresos por Proyecto' , data: { url: 'report-project', type: 'project' } },
          { name: 'Detalle de Egresos por Proyecto' , data: { url: 'report-detail', type: 'project' } },
          { name: 'Gasto de materiales por Proyecto' , data: { url: 'report-material', type: 'project' } },
          { name: 'Gasto de personas por Proyecto' , data: { url: 'report-person', type: 'project' } },
          { header: 'Cuentas' },
          { name: 'Movimientos por Cuenta' , data: { url: 'report-account', type: 'account' } },
          { header: 'Tipos de Proyecto' },
          { name: 'Ingresos / Egresos por Tipo' , data: { url: 'report-type-project', type: null } },
        ],
        submitShow: false,
        yearData: ['2018','2019', '2020', '2021'],
        yearShow: false ,
        projectData: [],
        projectShow: false,
        accountData: [],
        accountShow: false,
        rangeShow: false,
        monthShow: false,
      }
    },

    components: { DateRangePicker },

    computed: {
      formattedRange () {
        if (this.dateRange.length) {
          let range = moment(this.dateRange[0]).format('D MMMM')
          if (this.dateRange[1]) {
            range += ' - ' + moment(this.dateRange[1]).format('D MMMM')
          }
          return range
        }
      }
    },

    watch: {
      model(val) {
        this.params = null
        this.dateRange = []
        const value = val.data.type
        if (value) {
          switch (value) {
            case 'year':
              this.yearShow = true;
              this.rangeShow = false;
              this.projectShow = false;
              this.monthShow = false;
              this.accountShow = false;
              this.params = new Date().getFullYear().toString();
              break;
            case 'project':
              this.projectShow = true;
              this.rangeShow = false;
              this.yearShow = false;
              this.monthShow = false;
              this.accountShow = false;
              break;
            case 'account':
              this.accountShow = true;
              this.rangeShow = true;
              this.projectShow = false;
              this.yearShow = false;
              this.monthShow = false;
              break;
            case 'range':
              this.rangeShow = true;
              this.projectShow = false;
              this.yearShow = false;
              this.monthShow = false;
              this.accountShow = false;
              break;
            case 'month':
              this.monthShow = true;
              this.rangeShow = false;
              this.yearShow = false;
              this.projectShow = false;
              this.accountShow = false;
              this.params = new Date().toISOString().substr(0, 7);
              break;
          }
          if (this.params) {
            this.submitShow = true
          } else if (this.dateRange.length > 0 && !this.params) {
            this.submitShow = true
          } else this.submitShow = false
        } else {
          this.submitShow = true
          this.yearShow = false
          this.projectShow = false
          this.rangeShow = false;
          this.monthShow = false
        }
      },
      params(val) {
        if (val) {
          this.submitShow = true
        } else if (!val && this.submitShow) {
          this.submitShow = true
        } else {
          this.submitShow = false
        }
      },
      dateRange(val) {
        if (val.length > 0) {
          this.submitShow = true
        } else if (this.params && this.submitShow) {
          this.submitShow = true
        } else if (!this.params && this.submitShow) {
          this.submitShow = true
        } else {
          this.submitShow = false
        }
      }
    },

    mounted() {
      this.pivot = new WebDataRocks({
        container: "#wdr-component",
        toolbar: true,
        height: 490,
        global: {
          localization: traslate
        }
      });
    },

    created() {
      Promise.all([this.listProjects(), this.listAccounts()])
      .then(() =>{
        this.success = true
      })
    },

    methods: {
      listProjects: async function() {
        const projects = await ProjectService.getProjects('projects/list-report')
        if (projects.status === 200) {
          this.projectData = projects.data;
        }
      },

      listAccounts: async function() {
        const accounts = await AccountService.getAccounts('accounts/listing/report')
        if (accounts.status === 200) {
          this.accountData = accounts.data;
        }
      },

      generateReport: async function() {
        this.loading = true;
        let url;
        let params
        if (this.params) {
          if (this.accountShow && this.rangeShow) {
            params = { params: { data: { account: this.params, range: this.dateRange }}};
            url = `${this.model.data.url}` 
          } else {
            params = { params: { data: this.params }};
            url = `${this.model.data.url}`
          }
        } else if (this.dateRange.length > 0) {
          params = { params: { data: this.dateRange }};
          url = `${this.model.data.url}`
        } else url = this.model.data.url
        try {
          const response = await ReportService.getReports(url, params)
          if (response.status === 200) {
            if (response.data.data.dataSource.data.length > 0) {
              this.pivot.setReport(response.data.data)
            } else {
              this.pivot.setOptions({
                grid: {
                  title: "Sin Resultados"
                }
              });
              this.pivot.refresh();
              this.pivot.updateData({});
            }
            this.loading = false
          }
        } catch (err) {
          this.loading = false
        }
      }
    }
  }
</script>


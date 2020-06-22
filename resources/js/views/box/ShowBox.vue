<template>
  <v-container fluid grid-list-md>
    <v-layout row wrap>
      <v-flex xs12 sm12 md12>
        <v-system-bar status color="grey lighten-4">
          <v-breadcrumbs :items="bread">
            <template v-slot:divider>
              <v-icon>forward</v-icon>
            </template>
          </v-breadcrumbs>
        </v-system-bar>
        <v-card v-show="success">
          <v-card-title primary-title>
            <h3 class="headline mb-0">DETALLE ARQUEO DE CAJA GENERAL</h3>
            <v-spacer></v-spacer>
            <v-btn fab flat small color="red darken-3" @click="downloadPdf" :loading="loading">
              <v-icon>get_app</v-icon>
            </v-btn>
          </v-card-title>
          <v-container fluid>
            <strong>Datos del registro</strong>
            <div class="group">
              <div class="body-2">Se registro el día:
                <span class="body-1 grey--text"> {{ box.date_init | formatDate('DD/MM/YYYY') }}</span>
              </div>
              <div></div>
              <div class="body-2">Se actualizó por ultima vez el:
                <span class="body-1 grey--text"> {{ box.date_init | formatDate('DD/MM/YYYY') }}</span>
                <span>Por:</span>
                <span class="body-1 grey--text" v-if="box.updated"> {{ box.updated.causer }}</span>
              </div>
            </div>
            <strong>Rango de Tiempo del Arqueo</strong>
            <div class="div-group top">
              <div class="subdiv-group">
                <div class="title">Fecha Desde:
                  <span class="subheading"> {{ box.date_init | formatDate('DD/MM/YYYY') }}</span>
                </div>
                <div class="title">Fecha Hasta:
                  <span class="subheading"> {{ box.fecha_init | formatDate('DD/MM/YYYY') }}</span>
                </div>
              </div>
              <div class="title">Arqueo realizado por:
                <br>
                <span class="subheading" v-if="box.created"> {{ box.created.causer }}</span>
              </div>
            </div>
            <table-accounts :show="true" :accounts="accounts"></table-accounts>
            <div class="title top">Saldo actual en caja:</div>
            <div class="div-group">
              <div class="display-1">TOTAL:
                <span class="display-1 grey--text"> {{ box.amount | currency }}</span>
              </div>
            </div>
            <br>
            <v-layout wrap>
              <v-flex xs12 sm12 md10 lg10>
                <div class="title">Detalle de caja chica:</div>
                <table-smallbox :items="small_boxes"></table-smallbox>
              </v-flex>
            </v-layout>
            <div class="title top">Nota / Observaciones:</div>
            <div class="group">
              <div class="body-2">{{ box.note }}</div>
            </div>
          </v-container>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import TableAccounts from '../../components/TableAccounts.vue'
  import TableSmallBox from '../../components/TableSmallBox.vue'
  import Box from '../../models/Box'
  import BoxService from '../../services/box.service'
  import ReportService from '../../services/report.service'

  export default {
    name: 'show-box',
    data() {
      return {
        bread: [
          {
            text: 'Inicio',
            disabled: false,
            href: '/dashboard'
          },
          {
            text: 'Cajas',
            disabled: false,
            href: '/boxes'
          },
          {
            text: 'Detalle',
            disabled: true
          }
        ],
        success: false,
        loading: false,
        accounts: [],
        small_boxes: [],
        box: new Box(),
        id: this.$route.params.id,
      }
    },

    components: {
      'table-accounts' : TableAccounts,
      'table-smallbox' : TableSmallBox
    },

    created() {
      this.getBox();
    },

    methods: {
      downloadPdf: async function() {
        this.loading = true
        const config = {
          method: 'post',
          url: 'pdf-report',
          data: {
            accounts: this.accounts,
            small_boxes: this.small_boxes,
            box: this.box
          },
          responseType: 'arraybuffer'
        }
        try {
          const response = await ReportService.getReportPdf(config)
            if (response.status === 200) {
            let blob = new Blob([response.data], { type: 'application/pdf' })
            let link = document.createElement('a')
            link.href = window.URL.createObjectURL(blob)
            link.download = 'arqueo-caja.pdf'
            link.click()
            this.loading = false
          }
        } catch (err) {
          this.loading = false
        }
      },

      getBox: async function() {
        const response = await BoxService.getBoxes(`boxes/${this.id}`)
        if (response.status === 200) {
          this.accounts = response.data.data.accounts;
          this.small_boxes = response.data.data.small_boxes;
          this.box = response.data.data;
          this.success = true
        }
      },
    }
  }
</script>
<style scoped>
  .top {
    padding-top: 1em;
  }
  .div-group {
    width: 100%;
    border: 2px solid #ddd; 
    padding: 1em;
    display:flex;
    flex-direction:row;
  }
  .subdiv-group {
    display:flex;
    flex-direction:column;
  }
  .div-group div:last-child {
    margin-left: auto
  }

  .group {
  width: 100%;
  border: 2px solid #ddd;
  padding: 1em;
  overflow: auto;
}

.group div {
   display: block;
   width: 50%;
}

.group div:nth-of-type(1) {
  float: left;
}

.group div:nth-of-type(2) {
  float: right;
  text-align: right;
}
</style>


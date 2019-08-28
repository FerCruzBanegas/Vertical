<template>
  <v-container fluid grid-list-md>
    <v-layout row wrap>
      <v-flex d-flex xs12 sm12 md12>
        <v-card v-show="success">
          <v-card-title primary-title>
            <h3 class="headline mb-0">Arqueo de Caja</h3>
          </v-card-title>
          <v-container fluid>
            <!-- <pre>{{ $data }}</pre> -->
            <v-btn @click="test">test</v-btn>
            <table-accounts :show="true" :accounts="accounts"></table-accounts>
          </v-container>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import TableAccounts from '../../components/TableAccounts.vue'
  import Box from '../../models/Box'
  import BoxService from '../../services/box.service'
  import ReportService from '../../services/report.service'

  export default {
    name: 'show-box',
    data() {
      return {
        success: false,
        accounts: [],
        box: new Box(),
        id: this.$route.params.id,
        causer: null
      }
    },

    components: {
      'table-accounts' : TableAccounts
    },

    created() {
      this.getBox();
    },

    methods: {
      test: async function() {
        const config = {
          method: 'post',
          url: 'pdf-report',
          data: {
            accounts: this.box.accounts,
            box: this.box
          },
          responseType: 'arraybuffer'
        }
        const response = await ReportService.getReportPdf(config)
        if (response.status === 200) {
          let blob = new Blob([response.data], { type: 'application/pdf' })
          let link = document.createElement('a')
          link.href = window.URL.createObjectURL(blob)
          link.download = 'arqueo-caja.pdf'
          link.click()
        }
      },

      getBox: async function() {
        const response = await BoxService.getBoxes(`boxes/${this.id}`)
        if (response.status === 200) {
          this.accounts = response.data.data.accounts;
          this.box = response.data.data;
          this.success = true
        }
      },
    }
  }
</script>
<style scoped>
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
</style>


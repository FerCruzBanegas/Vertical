<template>
  <v-container fluid grid-list-xl>
    <v-layout wrap>
      <v-flex xs12 sm12 md12 lg12>
         <div>
          <v-breadcrumbs :items="items" divider="/"></v-breadcrumbs>
        </div>
        <v-card v-if="income" flat>
          <v-toolbar dense>
            <v-toolbar-title>{{ income.title }}</v-toolbar-title>
            <v-spacer></v-spacer>
          </v-toolbar>
          <v-container fluid>
            <v-layout wrap>
              <v-flex xs12 sm12 md6 lg6>
                <v-card>
                  <v-list two-line subheader>
                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Tipo de Pago</v-list-tile-title>
                        <v-list-tile-sub-title>{{ income.payment }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Fecha de Ingreso</v-list-tile-title>
                        <v-list-tile-sub-title>{{ income.date | formatDate('DD/MM/YYYY') }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Proyecto</v-list-tile-title>
                        <v-list-tile-sub-title>{{ income.project }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Registro</v-list-tile-title>
                        <v-list-tile-sub-title>Registrado por: {{ income.created.causer }} en fecha {{ income.created.date | formatDate('DD/MM/YYYY') }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>
                  </v-list>
                </v-card>
              </v-flex>
              <v-flex xs12 sm12 md6 lg6>
                <v-card>
                  <v-list two-line subheader>
                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Monto</v-list-tile-title>
                        <v-list-tile-sub-title>Bs. {{ income.amount | currency }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Tipo de Ingreso</v-list-tile-title>
                        <v-list-tile-sub-title>{{ income.income_type }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Nota</v-list-tile-title>
                        <v-list-tile-sub-title>{{ income.note }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Actualización</v-list-tile-title>
                        <v-list-tile-sub-title>Modificado por: {{ income.created.causer }} en fecha {{ income.updated.date | formatDate('DD/MM/YYYY') }}</v-list-tile-sub-title>
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
  </v-container>
</template>

<script>
  import IncomeService from '../../services/income.service'

  export default {
    name: 'show-income',
    data () {
      return {
        income: null,
        id: this.$route.params.id,
        items: [
          {
            text: 'Lista de Ingresos',
            disabled: false,
            href: '/incomes'
          },
          {
            text: 'Registrar Nuevo',
            disabled: false,
            href: '/incomes/create'
          },
          {
            text: 'Detalle',
            disabled: true
          }
        ]
      }
    },

    created() {
      this.getIncome()
    },

    methods: {
      getIncome: async function() {
        const response = await IncomeService.getIncomes(`incomes/${this.id}/detail`)
        if (response.status === 200) {
          this.income = response.data.data;
        }
      }
    }
  }
</script>

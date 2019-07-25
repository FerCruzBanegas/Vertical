<template>
  <v-container fluid grid-list-xl>
    <v-layout wrap>
      <v-flex xs12 sm12 md12 lg12>
         <div>
          <v-breadcrumbs :items="items" divider="/"></v-breadcrumbs>
        </div>
        <v-card v-if="expense" flat>
          <v-toolbar dense>
            <v-toolbar-title>{{ expense.title }}</v-toolbar-title>
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
                        <v-list-tile-sub-title>{{ expense.payment }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Fecha de Egreso</v-list-tile-title>
                        <v-list-tile-sub-title>{{ expense.date | formatDate('DD/MM/YYYY') }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Proyecto</v-list-tile-title>
                        <v-list-tile-sub-title>{{ expense.project }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Registro</v-list-tile-title>
                        <v-list-tile-sub-title>Registrado por: {{ expense.created.causer }} en fecha {{ expense.created.date | formatDate('DD/MM/YYYY') }}</v-list-tile-sub-title>
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
                        <v-list-tile-sub-title>Bs. {{ expense.amount | currency }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Tipo de Egreso</v-list-tile-title>
                        <v-list-tile-sub-title>{{ expense.expense_type }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Nota</v-list-tile-title>
                        <v-list-tile-sub-title>{{ expense.note }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>

                    <v-divider></v-divider>

                    <v-list-tile avatar>
                      <v-list-tile-content>
                        <v-list-tile-title>Actualización</v-list-tile-title>
                        <v-list-tile-sub-title>Modificado por: {{ expense.created.causer }} en fecha {{ expense.updated.date | formatDate('DD/MM/YYYY') }}</v-list-tile-sub-title>
                      </v-list-tile-content>
                    </v-list-tile>
                  </v-list>
                </v-card>
              </v-flex>
            </v-layout>
            <v-layout wrap>
              <v-flex xs12 sm12 md12 lg12>
                <pivot-material v-if="expense.materials.length > 0" :materials="expense.materials"></pivot-material>
                <pivot-people v-if="expense.people.length > 0" :people="expense.people"></pivot-people>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import PMaterial from '../../components/PMaterial.vue'
  import PPeople from '../../components/PPeople.vue'
  import ExpenseService from '../../services/expense.service'

  export default {
    name: 'show-expense',
    data () {
      return {
        expense: null,
        id: this.$route.params.id,
        items: [
          {
            text: 'Lista de Egresos',
            disabled: false,
            href: '/expenses'
          },
          {
            text: 'Registrar Nuevo',
            disabled: false,
            href: '/expenses/create'
          },
          {
            text: 'Detalle',
            disabled: true
          }
        ]
      }
    },

    components: {
      'pivot-material' : PMaterial,
      'pivot-people' : PPeople
    },

    created() {
      this.getExpense()
    },

    methods: {
      getExpense: async function() {
        const response = await ExpenseService.getExpenses(`expenses/${this.id}/detail`)
        if (response.status === 200) {
          this.expense = response.data.data;
        }
      }
    }
  }
</script>

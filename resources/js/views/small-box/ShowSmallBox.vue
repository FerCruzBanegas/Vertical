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
        <v-card v-if="success && smallbox">
          <v-card-title primary-title>
            <h3 class="headline mb-0">Detalle Caja Chica</h3>
            <v-spacer></v-spacer>
            <h3 class="headline mb-0">{{ smallbox.user.name }}</h3>
          </v-card-title>
          <v-container fluid>
            <v-layout row wrap>
              <v-flex xs12 sm12 md5 lg5 xl5>
                <v-card>
                  <v-layout row wrap>
                    <v-flex xs12 sm12 md6 lg6 xl6>
                      <v-list two-line subheader>
                        <v-subheader>Datos Generales</v-subheader>
                        <v-list-tile avatar>
                          <v-list-tile-content>
                            <v-list-tile-title>Fecha Apertura</v-list-tile-title>
                            <v-list-tile-sub-title>{{ smallbox.date_init | formatDate('DD/MM/YYYY') }}</v-list-tile-sub-title>
                          </v-list-tile-content>
                        </v-list-tile>
                        <v-list-tile avatar>
                          <v-list-tile-content>
                            <v-list-tile-title>Cuenta</v-list-tile-title>
                            <v-list-tile-sub-title>{{ smallbox.account.title }}</v-list-tile-sub-title>
                          </v-list-tile-content>
                        </v-list-tile>
                        <v-list-tile avatar>
                          <v-list-tile-content>
                            <v-list-tile-title>Monto Utilizado</v-list-tile-title>
                            <v-list-tile-sub-title>{{ smallbox.used_amount | currency }}</v-list-tile-sub-title>
                          </v-list-tile-content>
                        </v-list-tile>
                      </v-list>
                    </v-flex>
                    <v-flex xs12 sm12 md6 lg6 xl6>
                      <v-list two-line subheader>
                        <v-subheader></v-subheader>
                        <v-list-tile avatar>
                          <v-list-tile-content>
                            <v-list-tile-title>Fecha Cierre</v-list-tile-title>
                            <v-list-tile-sub-title v-if="smallbox.date_end">{{ smallbox.date_end | formatDate('DD/MM/YYYY') }}</v-list-tile-sub-title>
                            <v-list-tile-sub-title v-else>-</v-list-tile-sub-title>
                          </v-list-tile-content>
                        </v-list-tile>
                        <v-list-tile avatar>
                          <v-list-tile-content>
                            <v-list-tile-title>Monto Apertura</v-list-tile-title>
                            <v-list-tile-sub-title>{{ smallbox.start_amount | currency }}</v-list-tile-sub-title>
                          </v-list-tile-content>
                        </v-list-tile>
                        <v-list-tile avatar>
                          <v-list-tile-content>
                            <v-list-tile-title>Total Adicionado</v-list-tile-title>
                            <v-list-tile-sub-title>{{ totalAmounts | currency }}</v-list-tile-sub-title>
                          </v-list-tile-content>
                        </v-list-tile>
                      </v-list>
                    </v-flex>
                  </v-layout>
                </v-card>
              </v-flex>
              <v-flex xs12 sm12 md7 lg7 xl7>
                <v-card>
                  <v-card-title primary-title>
                    <h3 class="headline mb-0">Montos Adicionados</h3>
                    <v-spacer></v-spacer>
                    <v-currency-field 
                      box 
                      color="grey darken-2"
                      label="Adicionar Monto" 
                      v-model="amount"
                      data-vv-name="amount"
                      data-vv-as="monto"
                      v-validate="'required|max:9'"
                      :error-messages="errors.collect('amount')" 
                      v-if="smallbox.state == 1"
                    ></v-currency-field>
                    <v-btn 
                      v-if="smallbox.state == 1" 
                      :disabled="loading" 
                      :loading="loading" 
                      outline 
                      @click="addAmount"
                    ><v-icon>add_circle</v-icon></v-btn>
                  </v-card-title>
                  <v-alert
                    v-if="alert" 
                    :value="true"
                    type="error"
                  >
                    {{ msg_error }}
                  </v-alert>
                  <v-data-table
                    :headers="headerAmount"
                    :items="amounts"
                    item-key="name"
                    rows-per-page-text="Items por página"
                  >
                    <template slot="items" slot-scope="props">
                      <td>{{ props.item.amount | currency  }}</td>
                      <td>{{ props.item.created.date | formatDate('DD/MM/YYYY') }}</td>
                      <td>{{ props.item.created.causer }}</td>
                      <td>
                        <v-btn
                          small 
                          flat 
                          icon class="mx-0" 
                          color="red"
                          :disabled="props.item.flag"
                          :loading="props.item.flag"
                          @click="deleteAmount(props.item)"
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
            <v-layout>
              <v-flex xs12 sm12 md12 lg12 xl12>
                <v-card>
                  <v-card-title primary-title>
                    <h3 class="headline mb-0">LISTA DE EGRESOS</h3>
                  </v-card-title>
                  <v-data-table
                    :headers="headerExpense"
                    :items="expenses"
                    item-key="name"
                    rows-per-page-text="Items por página"
                  >
                    <template slot="items" slot-scope="props">
                      <td>{{ props.item.title }}</td>
                      <td>{{ props.item.payment }}</td>
                      <td>{{ props.item.date | formatDate('DD/MM/YYYY') }}</td>
                      <td>{{ props.item.amount | currency }}</td>
                      <td>{{ props.item.project }}</td>
                    </template>
                    <template slot="no-data">
                      <center>Sin Resultados</center>
                    </template>
                    <template v-slot:pageText="props">
                      {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
                    </template>
                    <template v-slot:footer>
                      <td colspan="2"></td>
                      <td class="text-xs-right total"><strong>TOTAL</strong></td>
                      <td class="text-xs-left ex"><strong>{{ totalExpenses | currency }}</strong></td>
                      <td></td>
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
  import SmallBox from '../../models/SmallBox'
  import SmallBoxService from '../../services/small.box.service'
  import ReportService from '../../services/report.service'
  import AmountService from '../../services/amount.service'

  export default {
    $_veeValidate: {
      validator: 'new'
    },
    name: 'show-smallbox',
    props: ["id"],
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
            href: '/small-boxes'
          },
          {
            text: 'Detalle',
            disabled: true
          }
        ],
        amount: 0,
        success: false,
        loading: false,
        amounts: [],
        expenses:[],
        smallbox: null,
        msg_error: '',
        alert: false,
        headerAmount: [
          { text: 'Cantidad', value: 'cantidad', width: "80" },
          { text: 'Registrado', value: 'registrado', width: "80" },
          { text: 'Encargado', value: 'encargado', width: "80" },
          { text: '', sortable: false, value: 'encargado', width: "80" },
        ],
        headerExpense: [
          { text: 'Título', value: 'titulo', width: "100" },
          { text: 'Pago', value: 'pago', width: "100" },
          { text: 'Fecha', value: 'fecha', width: "100" },
          { text: 'Monto', value: 'monto', width: "100" },
          { text: 'Proyecto', value: 'proyecto', width: "100" },
        ],
      }
    },

    computed: {
      totalExpenses() {
        let total = 0;
        if (this.expenses) {
          this.expenses.forEach(item => {
            total = total + item.amount
          })
        }
        return total;
      },
      totalAmounts() {
        let total = 0;
        if (this.amounts) {
          this.amounts.forEach(item => {
            total = total + item.amount
          })
        }
        return total;
      }
    },

    created() {
      this.getSmallBox();
    },

    methods: {
      deleteAmount:async function(item) {
        item.flag = true
        const response = await AmountService.deleteAmount(`amounts/${item.id}`)
        if (response.status === 200) {
          const index = this.amounts.findIndex(x => x.id == item.id)
          if (index > -1) {
            this.amounts.splice(index, 1)
          }
          item.flag = false
        }
      },

      addAmount:async function() {
        this.alert = false
        this.$validator.errors.clear();
        try {
          this.loading = true
          let data = {
            amount: this.amount,
            small_box_id: this.id,
            account_id: this.smallbox.account.id
          }

          const response = await AmountService.storeAmount(data)
          if (response.status === 201) {
            this.amounts.unshift(response.data.data)
            this.loading = false
          }
        } catch (err) {
          let error = err.response.data.errors.account_id
          if(err.response.status === 422) this.$setErrorsFromResponse(err.response.data);
          if(error) {
            this.msg_error = error[0]
            this.alert = true
          } 
          this.loading = false
        }
      },

      getSmallBox: async function() {
        const response = await SmallBoxService.getSmallBoxes(`small-boxes/${this.id}/detail`)
        if (response.status === 200) {
          let amounts = response.data.data.amounts
          this.amounts = amounts.sort((obj2, obj1) => obj1.id - obj2.id)
          this.smallbox = response.data.data
          this.getExpenseSmallBox()
        }
      },

      getExpenseSmallBox: async function() {
        let params = { params: { data: { id: this.smallbox.id, account: this.smallbox.account.id, user: this.smallbox.user.id, date_init: this.smallbox.date_init } }};

        const response = await SmallBoxService.getExpenseSmallBox('small-boxes/expenses', params)
        if (response.status === 200) {
          this.expenses = response.data
          this.success = true
        }
      },
    }
  }
</script>
<style scoped>
  .ex {
    background-color: #FF8383;
    color: #FFFFFF;
  }
</style>


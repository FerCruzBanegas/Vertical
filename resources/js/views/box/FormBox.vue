<template>
  <v-container fluid grid-list-md>
    <v-layout row wrap  v-show="success">
      <v-flex d-flex xs12 sm12 md12 v-if="accounts.length > 0">
        <v-card>
          <v-card-title primary-title>
            <h3 class="headline mb-0">Arqueo de Caja</h3>
          </v-card-title>
          <v-container fluid>
            <div class="div-group">
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
                <span class="subheading"> {{ (causer) ? causer : currentUser.name }}</span>
              </div>
            </div>
            <v-layout wrap>
              <v-flex xs12 sm12 md12 lg12 xl12>
                <table-accounts :show="false" :accounts="accounts"></table-accounts>
              </v-flex>
            </v-layout>
            <div class="title">Saldo actual en caja:</div>
            <div class="div-group">
              <div class="display-1">TOTAL:
                <span class="display-1 grey--text"> {{ totalBox | currency }}</span>
              </div>
            </div>
            <v-layout wrap>
              <v-flex xs12 sm12 md12 lg12>
                <small>Agregar alguna nota u observación</small>
                <v-text-field
                  box
                  color="grey darken-2"
                  label="Nota"
                  v-model="box.note"
                  data-vv-name="note"
                  data-vv-as="nota"
                  v-validate="'min:5|max:120'"
                  :error-messages="errors.collect('note')"
                  clearable
                ></v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
          <v-card-actions>
            <v-btn :disabled="loading" to="/boxes">
              Cancelar
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn @click="submit" :loading="loading">
              {{ id == null ? 'Registrar' : 'Actualizar' }}
            </v-btn>
          </v-card-actions>
          <!-- <pre>{{ $data }}</pre> -->
        </v-card>
      </v-flex>
      <v-flex d-flex xs12 sm12 md12 v-else>
        <v-card color="grey darken-2" class="white--text">
          <v-card-title primary-title>
            <div>
              <div class="headline">Sin movimientos</div>
              <span>No puede realizar esta acción por que no se realizaron movimientos en las cuentas desde su último arqueo.</span>
            </div>
          </v-card-title>
          <v-card-actions>
            <v-btn flat dark to="/incomes/create">Nuevo Ingreso</v-btn>
            <v-btn flat dark to="/expenses/create">Nuevo Egreso</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import { mapGetters } from 'vuex'
  import TableAccounts from '../../components/TableAccounts.vue'
  import Box from '../../models/Box'
  import AccountService from '../../services/account.service'
  import BoxService from '../../services/box.service'

  export default {
    $_veeValidate: {
      validator: 'new'
    },

    name: 'form-material',
    data() {
      return {
        success: false,
        loading: false,
        accounts: [],
        box: new Box(),
        id: this.$route.params.id,
        causer: null
      }
    },

    components: {
      'table-accounts' : TableAccounts
    },

    computed: {
      ...mapGetters([
        'currentUser'
      ]),

      totalBox () {
        let total = 0;
        this.accounts.forEach(item => {
          total = total + item.cash
        })
        this.box.amount = total
        return total;
      }
    },

    created() {
      if (this.id) {
        this.showBox();
      } else {
        this.getAccounts();
      }
    },

    methods: {
      getAccounts: async function() {
        const accounts = await AccountService.getAccounts('accounts/box')
        if (accounts.status === 200) {
          this.success = true
          let total = 0;
          accounts.data.accounts.forEach(account => {
            total = total + account.incomes + account.expenses
          })
          if (total > 0) {
            this.accounts = accounts.data.accounts;
          }
          this.box.date_init = accounts.data.dates.init;
          this.box.date_end = accounts.data.dates.end;
        }
      },

      showBox:async function() {
        const response = await BoxService.getBoxes(`boxes/${this.id}/edit`)
        if (response.status === 200) {
          this.accounts = response.data.data.accounts;
          this.box.date_init = response.data.data.date_init;
          this.box.date_end = response.data.data.date_end;
          this.box.note = response.data.data.note;
          this.causer = response.data.data.created.causer;
          this.success = true
        }
      },

      submit: async function() {
        this.$validator.errors.clear();
        const vm = this
        const data = {box: vm.box, accounts: vm.accounts}
        vm.loading = true
        try {
          if(vm.id) {
            vm._save = await BoxService.updateBox(vm.id, data)
          } else {
            vm._save = await BoxService.storeBox(data)
          }
          if (vm._save.status === 201 || vm._save.status === 200) {
            vm.$snotify.simple(vm._save.data.message, 'Felicidades')
            vm.loading = false
            vm.$router.push('/boxes')
          }
        } catch (err) {
          if(err.response.status === 422) this.$setErrorsFromResponse(err.response.data);
          vm.loading = false
        }
      }
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


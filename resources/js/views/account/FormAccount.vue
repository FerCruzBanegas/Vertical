<template>
  <v-container fluid grid-list-md>
    <v-layout row wrap>
      <v-flex d-flex xs12 sm12 md12>
        <v-card v-show="success">
          <v-card-title primary-title>
            <h3 class="headline mb-0">{{ addSubtitle }}</h3>
          </v-card-title>
          <v-container fluid>
            <v-layout>
              <v-flex xs12 sm12 md12 lg12>
                <v-card>
                  <v-card-text>
                    <small>Los campos con (*) son obligatorios.</small>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-text-field
                          box
                          color="grey darken-2"
                          label="Título *"
                          v-model="account.title"
                          data-vv-name="title"
                          data-vv-as="título"
                          v-validate="'required|min:3|max:60'"
                          :error-messages="errors.collect('title')"
                          clearable
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-menu
                          v-model="picker"
                          :close-on-content-click="false"
                          :nudge-right="40"
                          lazy
                          transition="scale-transition"
                          offset-y
                          full-width
                          min-width="290px"
                        >
                          <template v-slot:activator="{ on }">
                            <v-text-field
                              box
                              color="grey darken-2"
                              v-model="dateFormatted"
                              label="Fecha de Apertura *"
                              hint="DD/MM/YYYY format"
                              prepend-icon="event"
                              readonly
                              v-on="on"
                              data-vv-name="date"
                              data-vv-as="fecha apertura"
                              v-validate="'required'"
                              :error-messages="errors.collect('date')"
                            ></v-text-field>
                          </template>
                          <v-date-picker 
                            color="red darken-3" 
                            v-model="account.date" 
                            @input="picker = false"
                            :first-day-of-week="0"
                            locale="es-es"
                          ></v-date-picker>
                        </v-menu>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-text-field
                          box
                          color="grey darken-2"
                          label="Número de Cuenta"
                          v-model="account.number"
                          data-vv-name="number"
                          data-vv-as="numero cuenta"
                          v-validate="'min:5|max:32'"
                          :error-messages="errors.collect('number')"
                          clearable
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-currency-field 
                          box 
                          color="grey darken-2"
                          label="Monto de Apertura *" 
                          v-bind="currency_config" 
                          v-model="account.amount"
                          data-vv-name="amount"
                          data-vv-as="monto apertura"
                          v-validate="'required|max:9|decimal:2'"
                          :error-messages="errors.collect('amount')" 
                        ></v-currency-field>
                      </v-flex>
                    </v-layout>
                    
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-textarea
                          box
                          color="grey darken-2"
                          label="Nota"
                          v-model="account.note"
                          data-vv-name="note"
                          data-vv-as="nota"
                          v-validate="'min:5|max:120'"
                          :error-messages="errors.collect('note')"
                        ></v-textarea>
                      </v-flex>
                    </v-layout>
                    <v-switch
                      v-if="!id"
                      color="red"
                      v-model="retry"
                      label="Quedarme en la página después de registrar los datos."
                    ></v-switch>
                  </v-card-text>
                  <v-divider class="mt-5"></v-divider>
                  <v-card-actions>
                    <v-btn :disabled="loading" to="/accounts">
                      Cancelar
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn @click="submit" :loading="loading">
                      {{ id == null ? 'Registrar' : 'Actualizar' }}
                    </v-btn>
                  </v-card-actions>
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
  import Account from '../../models/Account'
  import AccountService from '../../services/account.service'

  export default {
    $_veeValidate: {
      validator: 'new'
    },

    name: 'form-account',
    data() {
      return {
        success: false,
        loading: false,
        currency_config: {
          decimal: '.',
          thousands: ',',
          prefix: 'Bs ',
          suffix: '',
          precision: 2,
          masked: false,
          allowBlank: false,
          min: Number.MIN_SAFE_INTEGER,
          max: Number.MAX_SAFE_INTEGER
        },
        picker: false,
        account: new Account(),
        dateFormatted: '',
        id: this.$route.params.id,
        retry: false
      }
    },

    computed: {
      addSubtitle () {
        if(this.id) {
          return 'Editar Cuenta'
        }
        return 'Registrar Cuenta'
      }
    },

    watch: {
      'account.date': function (newVal, oldVal){
        this.dateFormatted = this.formatDate(this.account.date)
      }
    },

    created() {
      if (this.id) {
        this.showAccount();
      } else{
        this.success = true
      }
    },

    methods: {
      formatDate (date) {
        if (!date) return null

        const [year, month, day] = date.split('-')
        return `${day}/${month}/${year}`
      },

      showAccount:async function() {
        const response = await AccountService.getAccounts(`accounts/${this.id}/edit`)
        if (response.status === 200) {
          this.account = response.data.data;
          this.success = true
        }
      },

      submit: async function() {
        this.$validator.errors.clear();
        const vm = this
        vm.loading = true
        try {
          if(vm.id) {
            vm._save = await AccountService.updateAccount(vm.id, vm.account)
          } else {
            vm._save = await AccountService.storeAccount(vm.account)
          }
          if (vm._save.status === 201 || vm._save.status === 200) {
            vm.$snotify.simple(vm._save.data.message, 'Felicidades')
            vm.loading = false
            if (vm.retry) {
              vm.account = new Account()
            } else {
              vm.$router.push('/accounts')
            }
          }
        } catch (err) {
          if(err.response.status === 422) this.$setErrorsFromResponse(err.response.data);
          vm.loading = false
        }
      }
    }
  }
</script>



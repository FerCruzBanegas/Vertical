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
                        <v-alert 
                          v-if="alert" 
                          color="error"
                          icon="warning" 
                          outline 
                          :value="true"
                        >
                          {{ message }}
                        </v-alert>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
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
                                  label="Fecha de Ingreso *"
                                  hint="DD/MM/YYYY format"
                                  prepend-icon="event"
                                  readonly
                                  v-on="on"
                                  data-vv-name="date"
                                  data-vv-as="fecha"
                                  v-validate="'required'"
                                  :error-messages="errors.collect('date')"
                                ></v-text-field>
                              </template>
                              <v-date-picker 
                                color="red darken-3" 
                                v-model="small_box.date_init" 
                                @input="picker = false"
                                :first-day-of-week="0"
                                locale="es-es"
                              ></v-date-picker>
                            </v-menu>
                          </v-flex>
                        </v-layout>
                        <v-flex xs12 sm12 md12 lg12>
                          <v-autocomplete
                            box
                            color="grey darken-2"
                            :items="accounts"
                            v-model="small_box.account_id"
                            label="Cuenta *"
                            data-vv-name="account_id"
                            data-vv-as="cuenta"
                            v-validate="'required'"
                            :error-messages="errors.collect('account_id')"
                            item-text="title"
                            item-value="id"
                          ></v-autocomplete>
                        </v-flex>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-currency-field 
                              box 
                              color="grey darken-2"
                              label="Monto de Apertura *" 
                              v-bind="currency_config" 
                              v-model="small_box.start_amount"
                              data-vv-name="start_amount"
                              data-vv-as="monto apertura"
                              v-validate="'required|max:9'"
                              :error-messages="errors.collect('start_amount')" 
                            ></v-currency-field>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-textarea
                              box
                              color="grey darken-2"
                              label="Nota"
                              v-model="small_box.note"
                              data-vv-name="note"
                              data-vv-as="nota"
                              v-validate="'min:5|max:120'"
                              :error-messages="errors.collect('note')"
                            ></v-textarea>
                          </v-flex>
                        </v-layout>
                      </v-flex>
                    </v-layout>
                  </v-card-text>
                  <v-divider class="mt-5"></v-divider>
                  <v-card-actions>
                    <v-btn :disabled="loading" to="/small-boxes">
                      Cancelar
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn @click="submit" :loading="loading" v-if="small_box.date_init">
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
  import { mapGetters } from 'vuex'
  import moment from 'moment'
  import SmallBox from '../../models/SmallBox'
  import AccountService from '../../services/account.service'
  import SmallBoxService from '../../services/small.box.service'

  export default {
    $_veeValidate: {
      validator: 'new'
    },
    name: 'form-small-box',
    data() {
      return {
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
        dateFormatted: '',
        success: false,
        loading: false,
        alert: false,
        message: '',
        accounts: [],
        small_box: new SmallBox(),
        id: this.$route.params.id,
      }
    },

    watch: {
      'small_box.date_init': function (newVal, oldVal){
        this.dateFormatted = this.formatDate(this.small_box.date_init)
      }
    },

    computed: {
      bread() {
        let bread = [
          { text: 'Inicio',disabled: false,href: '/dashboard' },
          { text: 'Cajas',disabled: false,href: '/small-boxes' }
        ];
        if(this.id) {
          bread.push({text: 'Modificar Caja', disabled: true})
          return bread
        } else {
          bread.push({text: 'Nueva Caja', disabled: true})
          return bread
        }
      },

      addSubtitle () {
        if(this.id) {
          return 'Editar Caja Chica'
        }
        return 'Registrar Caja Chica'
      },

      ...mapGetters([
        'currentUser'
      ]),
    },

    created() {
      this.listAccounts();

      if (this.id) {
        this.showSmallBox();
      }
    },

    methods: {
      formatDate (date) {
        if (!date) return null

        const [year, month, day] = date.split('-')
        return `${day}/${month}/${year}`
      },

      listAccounts: async function() {
        const accounts = await AccountService.getAccounts('accounts/listing')
        if (accounts.status === 200) {
          this.accounts = accounts.data;
          this.success = true
        }
      },

      showSmallBox:async function() {
        const response = await SmallBoxService.getSmallBoxes(`small-boxes/${this.id}/edit`)
        if (response.status === 200) {
          this.small_box = response.data.data;
          this.small_box.date_init = moment(this.small_box.date_init).format('YYYY-MM-DD')
          this.success = true
        }
      },

      submit: async function() {
        const vm = this
        vm.alert = false
        vm.$validator.errors.clear();
        vm.small_box.date_init = moment(this.small_box.date_init).format('YYYY-MM-DD HH:mm:ss')
        vm.small_box.user_id = this.currentUser.id
        vm.loading = true
        try {
          if(vm.id) {
            vm._save = await SmallBoxService.updateSmallBox(vm.id, vm.small_box)
          } else {
            vm._save = await SmallBoxService.storeSmallBox(vm.small_box)
          }
          if (vm._save.status === 201 || vm._save.status === 200) {
            vm.$snotify.simple(vm._save.data.message, 'Felicidades')
            vm.loading = false
            vm.$router.push('/small-boxes')
          }
        } catch (err) {
          vm.small_box.date_init = moment(this.small_box.date_init).format('YYYY-MM-DD')
          if(err.response.status === 422) {
            vm.alert = true
            vm.message = err.response.data.message
            vm.$setErrorsFromResponse(err.response.data);
          }
          vm.loading = false
        }
      }
    }
  }
</script>



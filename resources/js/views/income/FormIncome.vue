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
                          v-model="income.title"
                          data-vv-name="title"
                          data-vv-as="título"
                          v-validate="'required|min:3|max:60'"
                          :error-messages="errors.collect('title')"
                          clearable
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-autocomplete
                          box
                          color="grey darken-2"
                          :items="income_types"
                          v-model="income.income_type_id"
                          data-vv-name="income_type_id"
                          data-vv-as="tipo de ingreso"
                          v-validate="'required'"
                          :error-messages="errors.collect('income_type_id')"
                          label="Tipo de Ingreso *"
                          item-text="name"
                          item-value="id"
                        ></v-autocomplete>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-autocomplete
                          box
                          color="grey darken-2"
                          :items="projects"
                          v-model="income.project_id"
                          data-vv-name="project_id"
                          data-vv-as="proyecto"
                          v-validate="'required'"
                          :error-messages="errors.collect('project_id')"
                          label="Proyecto *"
                          item-text="name"
                          item-value="id"
                        ></v-autocomplete>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-autocomplete
                          box
                          color="grey darken-2"
                          :items="payment"
                          label="Método de Pago *"
                          v-model="income.payment"
                          data-vv-name="payment"
                          data-vv-as="pago"
                          v-validate="'required'"
                          :error-messages="errors.collect('payment')"
                        ></v-autocomplete>
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
                            v-model="income.date" 
                            @input="picker = false"
                            :first-day-of-week="0"
                            locale="es-es"
                          ></v-date-picker>
                        </v-menu>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-text-field
                          box
                          color="grey darken-2"
                          label="Nota"
                          v-model="income.note"
                          data-vv-name="note"
                          data-vv-as="nota"
                          v-validate="'min:5|max:120'"
                          :error-messages="errors.collect('note')"
                          clearable
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 offset-md6 offset-lg6>
                        <v-currency-field 
                          box 
                          color="grey darken-2"
                          label="Monto *" 
                          v-bind="currency_config" 
                          v-model="income.amount"
                          data-vv-name="amount"
                          data-vv-as="monto"
                          v-validate="'required|max:9|decimal:2'"
                          :error-messages="errors.collect('amount')" 
                        ></v-currency-field>
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
                    <v-btn :disabled="loading" to="/incomes">
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
  import Income from '../../models/Income'
  import IncomeTypeService from '../../services/income.type.service'
  import IncomeService from '../../services/income.service'
  import ProjectService from '../../services/project.service'

  export default {
    $_veeValidate: {
      validator: 'new'
    },

    name: 'form-income',
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
        income_types: [],
        projects: [],
        payment: ['Tarjeta', 'Efectivo', 'Cheque', 'Credito', 'Transferencia'],
        income: new Income(),
        dateFormatted: '',
        id: this.$route.params.id,
        retry: false
      }
    },

    computed: {
      addSubtitle () {
        if(this.id) {
          return 'Editar Ingreso'
        }
        return 'Registrar Ingreso'
      }
    },

    watch: {
      'income.date': function (newVal, oldVal){
        this.dateFormatted = this.formatDate(this.income.date)
      }
    },

    created() {
      if (this.id) {
        this.showIncome();
      }

      Promise.all([this.listIncomeTypes(), this.listProjects()])
      .then(() =>{
        this.success = true
      })
    },

    methods: {
      formatDate (date) {
        if (!date) return null

        const [year, month, day] = date.split('-')
        return `${day}/${month}/${year}`
      },

      listIncomeTypes: async function() {
        const types = await IncomeTypeService.getIncomeTypes('income-types/listing')
        if (types.status === 200) {
          this.income_types = types.data;
        }
      },

      listProjects: async function() {
        const projects = await ProjectService.getProjects('projects/listing')
        if (projects.status === 200) {
          this.projects = projects.data;
        }
      },

      showIncome:async function() {
        const response = await IncomeService.getIncomes(`incomes/${this.id}`)
        if (response.status === 200) {
          this.income = response.data.data;
          this.success = true
        }
      },

      submit: async function() {
        this.$validator.errors.clear();
        const vm = this
        vm.loading = true
        try {
          if(vm.id) {
            vm._save = await IncomeService.updateIncome(vm.id, vm.income)
          } else {
            vm._save = await IncomeService.storeIncome(vm.income)
          }
          if (vm._save.status === 201 || vm._save.status === 200) {
            vm.$snotify.simple(vm._save.data.message, 'Felicidades')
            vm.loading = false
            if (vm.retry) {
              vm.income = new Income()
            } else {
              vm.$router.push('/incomes')
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



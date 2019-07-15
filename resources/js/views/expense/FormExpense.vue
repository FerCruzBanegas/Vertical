<template>
  <v-container fluid grid-list-xl>
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
                          v-model="expense.title"
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-autocomplete
                          box
                          color="grey darken-2"
                          :items="expense_types"
                          v-model="expense.expense_type_id"
                          label="Tipo de Egreso *"
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
                          v-model="expense.project_id"
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
                          v-model="expense.payment"
                          label="Método de Pago *"
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
                              label="Fecha de Egreso *"
                              hint="DD/MM/YYYY format"
                              prepend-icon="event"
                              readonly
                              v-on="on"
                            ></v-text-field>
                          </template>
                          <v-date-picker 
                            color="red darken-3" 
                            v-model="expense.date" 
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
                          v-model="expense.note"
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-checkbox
                          v-model="checkMaterial"
                          label="Agregar materiales?"
                          color="grey darken-3"
                          @change="cleanData"
                        ></v-checkbox>
                        <v-autocomplete
                          v-if="checkMaterial"
                          box
                          prepend-icon="search"
                          color="grey darken-2"
                          v-model="selectMaterial"
                          :loading="comboMaterial"
                          :items="itemsMaterial"
                          :search-input.sync="searchMaterial"
                          cache-items
                          hide-no-data
                          hide-details
                          label="Buscar materiales"
                          item-text="name"
                          return-object
                        >
                          <template v-slot:append-outer>
                            <v-btn @click="addMaterial" flat icon color="red darken-3">
                              <v-icon>add_circle</v-icon>
                            </v-btn>
                          </template>
                        </v-autocomplete>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-checkbox
                          v-model="checkPeople"
                          label="Agregar Personas?"
                          color="grey darken-3"
                        ></v-checkbox>
                        <v-autocomplete
                          v-if="checkPeople"
                          box
                          prepend-icon="search"
                          color="grey darken-2"
                          v-model="selectPeople"
                          :loading="comboPeople"
                          :items="itemsPeople"
                          :search-input.sync="searchPeople"
                          cache-items
                          hide-no-data
                          hide-details
                          label="Buscar personas"
                        >
                          <template v-slot:append-outer>
                            <v-btn @click="" flat icon color="red darken-3">
                              <v-icon>add_circle</v-icon>
                            </v-btn>
                          </template>
                        </v-autocomplete>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md12 lg12>
                        <table-material v-if="checkMaterial" :data="materials" @removeIt="remove"></table-material>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 offset-md6 offset-lg6>
                        <v-currency-field :disabled="checkMaterial" label="Monto *" v-bind="currency_config" :error-messages="errors.price" v-model="expense.amount" box color="grey darken-2" reverse>
                        </v-currency-field>
                        <v-btn @click="test">
                         show
                        </v-btn>
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
                    <v-btn :disabled="loading" to="/expenses">
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
  import TableMaterials from '../../components/Materials.vue'
  import Expense from '../../models/Expense'
  import ExpenseTypeService from '../../services/expense.type.service'
  import ExpenseService from '../../services/expense.service'
  import MaterialService from '../../services/material.service'
  import ProjectService from '../../services/project.service'

  export default {
    name: 'form-expense',
    data() {
      return {
        checkMaterial: false,
        comboMaterial: false,
        itemsMaterial: [],
        searchMaterial: null,
        selectMaterial: null,

        checkPeople: false,
        comboPeople: false,
        itemsPeople: [],
        searchPeople: null,
        selectPeople: null,

        materials: [],
        people: [],

        success: false,
        loading: false,
        errors: {},
        currency_config: {
          decimal: '.',
          thousands: ',',
          prefix: ' Bs',
          suffix: '',
          precision: 2,
          masked: false,
          allowBlank: false,
          min: Number.MIN_SAFE_INTEGER,
          max: Number.MAX_SAFE_INTEGER
        },
        picker: false,
        expense_types: [],
        projects: [],
        payment: ['Tarjeta', 'Efectivo', 'Cheque', 'Credito', 'Transferencia'],
        expense: new Expense(),
        dateFormatted: '',
        id: this.$route.params.id,
        retry: false
      }
    },

    components: {
      'table-material' : TableMaterials
    },

    computed: {
      addSubtitle () {
        if(this.id) {
          return 'Editar Egreso'
        }
        return 'Registrar Egreso'
      }
    },

    watch: {
      expense: {
        handler (val) {
          this.dateFormatted = this.formatDate(this.expense.date)
        },
        deep: true
      },

      materials: {
        handler (val) {
          let t = 0
          this.materials.forEach( material => {
            t += (material.quantity * material.price)
          })
          this.expense.amount = t
        },
        deep: true
      },

      searchMaterial (val) {
        val && val !== this.selectMaterial && this.querySelections(val)
      }
    },

    created() {
      if (this.id) {
        this.showExpense();
      }

      Promise.all([this.listExpenseTypes(), this.listProjects()])
      .then(() =>{
        this.success = true
      })
    },

    methods: {
      test() {
        console.log(this.materials)
      },

      remove(id){
        const index = this.materials.findIndex(x => x.id == id)
        if (index > -1) this.materials.splice(index, 1)
      },

      cleanData() {
        if (!this.checkMaterial) {
          this.itemsMaterial = []
          this.materials = []
        }
      },

      querySelections: async function(v) {
        this.comboMaterial = true
        const material = await MaterialService.getMaterials(`search-material/${v}`)
        if (material.status === 200) {
          this.itemsMaterial = material.data;
          this.comboMaterial = false
        }
      },

      addMaterial() {
        if (this.selectMaterial) {
          let obj = { id: this.selectMaterial.id, name: this.selectMaterial.name, quantity: 0, price: 0 }
          const flag = this.materials.some(item => item.id === obj.id)
          if (!flag) this.materials.push(obj)
        }
      },

      formatDate (date) {
        if (!date) return null

        const [year, month, day] = date.split('-')
        return `${day}/${month}/${year}`
      },

      listExpenseTypes: async function() {
        const types = await ExpenseTypeService.getExpenseTypes('expense-types/listing')
        if (types.status === 200) {
          this.expense_types = types.data;
        }
      },

      listProjects: async function() {
        const projects = await ProjectService.getProjects('projects/listing')
        if (projects.status === 200) {
          this.projects = projects.data;
        }
      },

      showExpense:async function() {
        const response = await ExpenseService.getExpenses(`expenses/${this.id}`)
        if (response.status === 200) {
          this.expense = response.data.data;
          this.success = true
        }
      },

      submit: async function() {
        const vm = this
        vm.loading = true
        if(vm.id) {
          vm._save = await ExpenseService.updateExpense(vm.id, vm.expense)
        } else {
          vm._save = await ExpenseService.storeExpense(vm.expense)
        }
        if (vm._save.status === 201 || vm._save.status === 200) {
          vm.$snotify.simple(vm._save.data.message, 'Felicidades')
          vm.loading = false
          if (vm.retry) {
            vm.expense = new Expense()
          } else {
            vm.$router.push('/expenses')
          }
        }
      }
    }
  }
</script>



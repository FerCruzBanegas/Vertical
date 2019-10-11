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
                  <v-alert 
                    v-if="flag" 
                    color="error"
                    icon="warning" 
                    outline 
                    :value="true"
                  >
                    {{ message }}
                  </v-alert>
                  <v-card-text>
                    <small>Los campos con (*) son obligatorios.</small>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-text-field
                          box
                          color="grey darken-2"
                          label="Título *"
                          v-model="expense.title"
                          data-vv-name="expense.title"
                          data-vv-as="título"
                          v-validate="'required|min:3|max:60'"
                          :error-messages="errors.collect('expense.title')"
                          clearable
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-autocomplete
                          box
                          color="grey darken-2"
                          :items="expense_types"
                          v-model="expense.expense_type_id"
                          label="Tipo de Egreso *"
                          data-vv-name="expense.expense_type_id"
                          data-vv-as="tipo de egreso"
                          v-validate="'required'"
                          :error-messages="errors.collect('expense.expense_type_id')"
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
                          data-vv-name="expense.project_id"
                          data-vv-as="proyecto"
                          v-validate="'required'"
                          :error-messages="errors.collect('expense.project_id')"
                          item-text="name"
                          item-value="id"
                        ></v-autocomplete>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-autocomplete
                          disabled
                          box
                          color="grey darken-2"
                          :items="accounts"
                          v-model="expense.account_id"
                          label="Cuenta *"
                          data-vv-name="expense.account_id"
                          data-vv-as="cuenta"
                          v-validate="'required'"
                          :error-messages="errors.collect('expense.account_id')"
                          item-text="title"
                          item-value="id"
                        ></v-autocomplete>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-autocomplete
                          box
                          color="grey darken-2"
                          :items="payment"
                          v-model="expense.payment"
                          label="Método de Pago *"
                          data-vv-name="expense.payment"
                          data-vv-as="pago"
                          v-validate="'required'"
                          :error-messages="errors.collect('expense.payment')"
                        ></v-autocomplete>
                      </v-flex>
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
                              data-vv-name="expense.date"
                              data-vv-as="fecha"
                              v-validate="'required'"
                              :error-messages="errors.collect('expense.date')"
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
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md12 lg12>
                        <v-text-field
                          box
                          color="grey darken-2"
                          label="Nota"
                          v-model="expense.note"
                          data-vv-name="expense.note"
                          data-vv-as="nota"
                          v-validate="'min:5|max:120'"
                          :error-messages="errors.collect('expense.note')"
                          clearable
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
                          item-text="name"
                          return-object
                        >
                          <template v-slot:append-outer>
                            <v-btn @click="addPeople" flat icon color="red darken-3">
                              <v-icon>add_circle</v-icon>
                            </v-btn>
                          </template>
                        </v-autocomplete>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md12 lg12>
                        <table-people v-if="checkPeople" :data="people" @removeIt="removePeople"></table-people>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md12 lg12>
                        <table-material v-if="checkMaterial" :data="materials" @removeIt="removeMaterial"></table-material>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 offset-md6 offset-lg6>
                        <v-currency-field 
                          :disabled="checkMaterial"
                          box 
                          color="grey darken-2"
                          label="Monto *" 
                          v-bind="currency_config" 
                          v-model="expense.amount"
                          data-vv-name="expense.amount"
                          data-vv-as="monto"
                          v-validate="'required|max:9|decimal:2'"
                          :error-messages="errors.collect('expense.amount')" 
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
                    <v-btn :disabled="loading" to="/expenses">
                      Cancelar
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn @click="submit" :loading="loading" v-if="!flag">
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
  import TableMaterials from '../../components/Materials.vue'
  import TablePeople from '../../components/People.vue'
  import Expense from '../../models/Expense'
  import ExpenseTypeService from '../../services/expense.type.service'
  import ExpenseService from '../../services/expense.service'
  import MaterialService from '../../services/material.service'
  import ProjectService from '../../services/project.service'
  import AccountService from '../../services/account.service'
  import PeopleService from '../../services/people.service'
  import SmallBoxService from '../../services/small.box.service'

  export default {
    $_veeValidate: {
      validator: 'new'
    },

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
        accounts: [],
        payment: ['Tarjeta', 'Efectivo', 'Cheque', 'Credito', 'Transferencia'],
        expense: new Expense(),
        dateFormatted: '',
        id: this.$route.params.id,
        retry: false,
        flag: false,
        message: ''
      }
    },

    components: {
      'table-material' : TableMaterials,
      'table-people' : TablePeople
    },

    computed: {
      bread() {
        let bread = [
          { text: 'Inicio',disabled: false,href: '/dashboard' },
          { text: 'Egresos',disabled: false,href: '/expenses' }
        ];
        if(this.id) {
          bread.push({text: 'Modificar Egreso', disabled: true})
          return bread
        } else {
          bread.push({text: 'Nuevo Egreso', disabled: true})
          return bread
        }
      },

      addSubtitle () {
        if(this.id) {
          return 'Editar Egreso'
        }
        return 'Registrar Egreso'
      },

      ...mapGetters([
        'currentUser'
      ])
    },

    watch: {
      'expense.date': function (newVal, oldVal){
        this.dateFormatted = this.formatDate(this.expense.date)
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
        val && val !== this.selectMaterial && this.queryMaterial(val)
      },

      searchPeople (val) {
        val && val !== this.selectPeople && this.queryPeople(val)
      }
    },

    created() {
      if (this.id) {
        this.showExpense();
      } 

      Promise.all([this.active(), this.listExpenseTypes(), this.listProjects(), this.listAccounts()])
      .then(() =>{
        this.success = true
      })
    },

    mounted() {
      if (this.$route.query.q) this.expense.project_id = parseInt(this.$route.query.q)
    },

    methods: {
      removeMaterial(id){
        const index = this.materials.findIndex(x => x.id == id)
        if (index > -1) this.materials.splice(index, 1)
      },

      removePeople(id){
        const index = this.people.findIndex(x => x.id == id)
        if (index > -1) this.people.splice(index, 1)
      },

      cleanData() {
        if (!this.checkMaterial) {
          if (this.materials.length > 0) this.materials = []
          this.itemsMaterial = []
        }
      },

      queryMaterial: async function(v) {
        this.comboMaterial = true
        const material = await MaterialService.getMaterials(`search-material/${v}`)
        if (material.status === 200) {
          this.itemsMaterial = material.data;
          this.comboMaterial = false
        }
      },

      queryPeople: async function(v) {
        this.comboPeople = true
        const people = await PeopleService.getPeople(`search-person/${v}`)
        if (people.status === 200) {
          this.itemsPeople = people.data;
          this.comboPeople = false
        }
      },

      addMaterial() {
        if (this.selectMaterial) {
          let obj = { id: this.selectMaterial.id, name: this.selectMaterial.name, quantity: 0, price: 0 }
          const flag = this.materials.some(item => item.id === obj.id)
          if (!flag) this.materials.push(obj)
        }
      },

      addPeople() {
        if (this.selectPeople) {
          let obj = { id: this.selectPeople.id, name: this.selectPeople.name, surnames: this.selectPeople.surnames, phone: this.selectPeople.phone }
          const flag = this.people.some(item => item.id === obj.id)
          if (!flag) this.people.push(obj)
        }
      },

      formatDate (date) {
        if (!date) return null

        const [year, month, day] = date.split('-')
        return `${day}/${month}/${year}`
      },

      active: async function() {
        const active = await SmallBoxService.getSmallBoxes(`small-boxes/active/${this.currentUser.id}`)
        if (active.status === 200 && !this.id) {
          if (active.data.flag) {
            this.flag = active.data.flag;
            this.message = active.data.message;
          } else {
            this.expense.account_id = active.data.account
          }
        }
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

      listAccounts: async function() {
        const accounts = await AccountService.getAccounts('accounts/listing')
        if (accounts.status === 200) {
          this.accounts = accounts.data;
        }
      },

      showExpense:async function() {
        const response = await ExpenseService.getExpenses(`expenses/${this.id}`)
        if (response.status === 200) {
          if (response.data.data.materials.length > 0) {
            this.checkMaterial = true
            this.materials = response.data.data.materials;
          }
          if (response.data.data.people.length > 0) {
            this.checkPeople = true
            this.people = response.data.data.people;
          }
          this.expense = response.data.data;
          this.success = true
        }
      },

      submit: async function() {
        this.$validator.errors.clear();
        const vm = this
        vm.expense.user_id = this.currentUser.id
        const data = {expense: vm.expense, materials: vm.materials, people: vm.people}
        vm.loading = true
        try {
          if(vm.id) {
            vm._save = await ExpenseService.updateExpense(vm.id, data)
          } else {
            vm._save = await ExpenseService.storeExpense(data)
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
        } catch (err) {
          if(err.response.status === 422) {
            vm.flag = true
            vm.message = err.response.data.message
            vm.$setErrorsFromResponse(err.response.data);
          }
          vm.loading = false
        }
      }
    }
  }
</script>



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
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-text-field
                              box
                              color="grey darken-2"
                              label="Nombre *"
                              v-model="expense_type.name"
                              data-vv-name="name"
                              data-vv-as="nombre"
                              v-validate="'required|min:3|max:60'"
                              :error-messages="errors.collect('name')"
                              clearable
                            ></v-text-field>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-textarea
                              box
                              color="grey darken-2"
                              label="Descripción"
                              v-model="expense_type.description"
                              data-vv-name="description"
                              data-vv-as="descripción"
                              v-validate="'min:5|max:120'"
                              :error-messages="errors.collect('description')"
                            ></v-textarea>
                          </v-flex>
                        </v-layout>
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
                    <v-btn :disabled="loading" to="/expense-types">
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
  import ExpenseType from '../../models/ExpenseType'
  import ExpenseTypeService from '../../services/expense.type.service'

  export default {
    $_veeValidate: {
      validator: 'new'
    },

    name: 'form-expense-type',
    data() {
      return {
        success: false,
        loading: false,
        expense_type: new ExpenseType(),
        id: this.$route.params.id,
        retry: false
      }
    },

    computed: {
      addSubtitle () {
        if(this.id) {
          return 'Editar Tipo de Egreso'
        }
        return 'Registrar Tipo de Egreso'
      }
    },

    created() {
      if (this.id) {
        this.showExpenseType()
      }else{
        this.success = true
      }
    },

    methods: {
      showExpenseType:async function() {
        const response = await ExpenseTypeService.getExpenseTypes(`expense-types/${this.id}`)
        if (response.status === 200) {
          this.expense_type = response.data.data
          this.success = true
        }
      },

      submit: async function() {
        this.$validator.errors.clear();
        const vm = this
        vm.loading = true
        try {
          if(vm.id) {
            vm._save = await ExpenseTypeService.updateExpenseType(vm.id, vm.expense_type)
          } else {
            vm._save = await ExpenseTypeService.storeExpenseType(vm.expense_type)
          }
          if (vm._save.status === 201 || vm._save.status === 200) {
            vm.$snotify.simple(vm._save.data.message, 'Felicidades')
            vm.loading = false
            if (vm.retry) {
              vm.expense_type = new ExpenseType()
            } else {
              vm.$router.push('/expense-types')
            }
          }
        } catch (err) {
          this.$setErrorsFromResponse(err.response.data);
          vm.loading = false
        }
      }
    }
  }
</script>



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
                              v-model="income_type.name"
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
                              v-model="income_type.description"
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
                    <v-btn :disabled="loading" to="/income-types">
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
  import IncomeType from '../../models/IncomeType'
  import IncomeTypeService from '../../services/income.type.service'

  export default {
    $_veeValidate: {
      validator: 'new'
    },

    name: 'form-income-type',
    data() {
      return {
        success: false,
        loading: false,
        income_type: new IncomeType(),
        id: this.$route.params.id,
        retry: false
      }
    },

    computed: {
      addSubtitle () {
        if(this.id) {
          return 'Editar Tipo de Ingreso'
        }
        return 'Registrar Tipo de Ingreso'
      }
    },

    created() {
      if (this.id) {
        this.showIncomeType()
      } else{
        this.success = true
      }
    },

    methods: {
      showIncomeType:async function() {
        const response = await IncomeTypeService.getIncomeTypes(`income-types/${this.id}/edit`)
        if (response.status === 200) {
          this.income_type = response.data.data
          this.success = true
        }
      },

      submit: async function() {
        this.$validator.errors.clear();
        const vm = this
        vm.loading = true
        try {
          if(vm.id) {
            vm._save = await IncomeTypeService.updateIncomeType(vm.id, vm.income_type)
          } else {
            vm._save = await IncomeTypeService.storeIncomeType(vm.income_type)
          }
          if (vm._save.status === 201 || vm._save.status === 200) {
            vm.$snotify.simple(vm._save.data.message, 'Felicidades')
            vm.loading = false
            if (vm.retry) {
              vm.income_type = new IncomeType()
            } else {
              vm.$router.push('/income-types')
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



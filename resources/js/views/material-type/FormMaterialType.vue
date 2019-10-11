<template>
  <v-container fluid grid-list-xl>
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
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-text-field
                              box
                              color="grey darken-2"
                              label="Nombre *"
                              v-model="material_type.name"
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
                              v-model="material_type.description"
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
                    <v-btn :disabled="loading" to="/material-types">
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
  import MaterialType from '../../models/MaterialType'
  import MaterialTypeService from '../../services/material.type.service'

  export default {
    $_veeValidate: {
      validator: 'new'
    },

    name: 'form-material-type',
    data() {
      return {
        success: false,
        loading: false,
        material_type: new MaterialType(),
        id: this.$route.params.id,
        retry: false
      }
    },

    computed: {
      bread() {
        let bread = [
          { text: 'Inicio',disabled: false,href: '/dashboard' },
          { text: 'Tipos de Material',disabled: false,href: '/material-types' }
        ];
        if(this.id) {
          bread.push({text: 'Modificar Tipo', disabled: true})
          return bread
        } else {
          bread.push({text: 'Nuevo Tipo', disabled: true})
          return bread
        }
      },
      addSubtitle () {
        if(this.id) {
          return 'Editar Tipo de Material'
        }
        return 'Registrar Tipo de Material'
      }
    },

    created() {
      if (this.id) {
        this.showMaterialType()
      } else{
        this.success = true
      }
    },

    methods: {
      showMaterialType:async function() {
        const response = await MaterialTypeService.getMaterialTypes(`material-types/${this.id}`)
        if (response.status === 200) {
          this.material_type = response.data.data
          this.success = true
        }
      },

      submit: async function() {
        this.$validator.errors.clear();
        const vm = this
        vm.loading = true
        try {
          if(vm.id) {
            vm._save = await MaterialTypeService.updateMaterialType(vm.id, vm.material_type)
          } else {
            vm._save = await MaterialTypeService.storeMaterialType(vm.material_type)
          }
          if (vm._save.status === 201 || vm._save.status === 200) {
            vm.$snotify.simple(vm._save.data.message, 'Felicidades')
            vm.loading = false
            if (vm.retry) {
              vm.material_type = new MaterialType()
            } else {
              vm.$router.push('/material-types')
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



<template>
  <v-container fluid grid-list-md id="theme">
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
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-autocomplete
                              box
                              color="grey darken-2"
                              :items="material_types"
                              v-model="material.material_type_id"
                              label="Tipo de Material *"
                              item-text="name"
                              item-value="id"
                            ></v-autocomplete>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-text-field
                              box
                              color="grey darken-2"
                              label="Nombre *"
                              v-model="material.name"
                            ></v-text-field>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-autocomplete
                              box
                              color="grey darken-2"
                              :items="units"
                              v-model="material.unity"
                              label="Unidad de medida *"
                            ></v-autocomplete>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-currency-field label="Precio de Referencia" v-bind="currency_config" :error-messages="errors.price" v-model="material.price" box color="grey darken-2"></v-currency-field>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-textarea
                              box
                              color="grey darken-2"
                              label="Descripción"
                              v-model="material.description"
                            ></v-textarea>
                          </v-flex>
                        </v-layout>
                      </v-flex>
                    </v-layout>
                    <small>Los campos con (*) son obligatorios.</small>
                    <v-switch
                      v-if="!id"
                      color="red"
                      v-model="retry"
                      label="Quedarme en la página después de registrar los datos."
                    ></v-switch>
                  </v-card-text>
                  <v-divider class="mt-5"></v-divider>
                  <v-card-actions>
                    <v-btn :disabled="loading" to="/materials">
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
  import Material from '../../models/Material'
  import MaterialTypeService from '../../services/material.type.service'
  import MaterialService from '../../services/material.service'

  export default {
    name: 'form-material',
    data() {
      return {
        errors: {},
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
        units: ['amarro', 'barra', 'bolsa', 'caja', 'cajón', 'carga', 'dm³', 'fajo', 'fardo', 'g', 'galón', 'glb', 'ha', 'juego', 'kg', 'l', 'lata', 'lb', 'm', 'm²', 'm³', 'mm', 'perfil', 'pie', 'pie²', 'placa', 'plomo', 'pqte', 'pto', 'pza', 'resma', 'rollo', 't', 'tubo', 'turril', 'unds'],
        success: false,
        loading: false,
        material_types: [],
        material: new Material(),
        id: this.$route.params.id,
        retry: false
      }
    },

    computed: {
      addSubtitle () {
        if(this.id) {
          return 'Editar Material'
        }
        return 'Registrar Material'
      }
    },

    created() {
      this.listMaterialTypes();

      if (this.id) {
        this.showMaterial();
      }else{
        this.success = true
      }
    },

    methods: {
      listMaterialTypes: async function() {
        const types = await MaterialTypeService.getMaterialTypes('material-types/listing')
        if (types.status === 200) {
          this.material_types = types.data;
        }
      },

      showMaterial:async function() {
        const response = await MaterialService.getMaterials(`materials/${this.id}`)
        if (response.status === 200) {
          this.material = response.data.data;
          this.success = true
        }
      },

      submit: async function() {
        const vm = this
        vm.loading = true
        if(vm.id) {
          vm._save = await MaterialService.updateMaterial(vm.id, vm.material)
        } else {
          vm._save = await MaterialService.storeMaterial(vm.material)
        }
        if (vm._save.status === 201 || vm._save.status === 200) {
          vm.$snotify.simple(vm._save.data.message, 'Felicidades')
          vm.loading = false
          if (vm.retry) {
            vm.material = new Material()
          } else {
            vm.$router.push('/materials')
          }
        }
      }
    }
  }
</script>



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
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-datetime-picker 
                              v-model="small_box.date_init"
                              data-vv-name="date_init"
                              data-vv-as="fecha apertura"
                              v-validate="'required'"
                              :error-messages="errors.collect('date_init')"
                              label="Fecha de Apertura *"
                            ></v-datetime-picker>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-checkbox
                              v-model="check"
                              label="Agregar un usuario diferente"
                              color="grey darken-3"
                            ></v-checkbox>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap v-show="check">
                          <v-flex xs12 sm12 md12 lg12>
                            <v-autocomplete
                              box
                              color="grey darken-2"
                              :items="users"
                              v-model="small_box.user_id"
                              data-vv-name="user_id"
                              data-vv-as="usuario"
                              v-validate="'required'"
                              :error-messages="errors.collect('user_id')"
                              label="Usuario *"
                              item-text="name"
                              item-value="id"
                            ></v-autocomplete>
                          </v-flex>
                        </v-layout>
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
  import UserService from '../../services/user.service'
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
        check: false,
        success: false,
        loading: false,
        users: [],
        small_box: new SmallBox(),
        id: this.$route.params.id,
      }
    },

    computed: {
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

    watch: {
      check: function (newVal, oldVal) {
        if (newVal) {
          this.small_box.user_id = null
        }
      }
    },

    created() {
      this.listUsers();

      if (this.id) {
        this.showSmallBox();
      }
    },

    mounted() {
      this.small_box.user_id = this.currentUser.id
    },

    methods: {
      listUsers: async function() {
        const types = await UserService.getUsers('users/listing')
        if (types.status === 200) {
          this.users = types.data;
          this.success = true
        }
      },

      showSmallBox:async function() {
        const response = await SmallBoxService.getSmallBoxes(`small-boxes/${this.id}`)
        if (response.status === 200) {
          this.small_box = response.data.data;
          this.success = true
        }
      },

      submit: async function() {
        this.small_box.date_init = moment(this.small_box.date_init).format('YYYY-MM-DD HH:mm:ss')
        this.$validator.errors.clear();
        const vm = this
        console.log(this.small_box.date_init)
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
            if (vm.retry) {
              vm.small_box = new SmallBox()
            } else {
              vm.$router.push('/small-boxes')
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



<template>
  <v-container fluid grid-list-md>
    <v-layout>
      <v-flex d-flex xs12 sm12 md12 lg12 xl12>
        <v-card>
          <v-card-title primary-title>
            <h3 class="headline mb-0">Actualizar Contraseña</h3>
          </v-card-title>
          <v-card-text>
            <small>Los campos con (*) son obligatorios.</small>
            <v-layout row wrap>
              <v-flex xs12 sm12 md6 lg6 xl6>
                <v-text-field
                  box
                  color="grey darken-2"
                  label="Contraseña Actual *"
                  v-model="user.password_current"
                  prepend-icon="lock"
                  :append-icon="isPassVisible ? 'visibility' : 'visibility_off'"
                  @click:append="isPassVisible = !isPassVisible"
                  :type="isPassVisible ? 'text' : 'password'"
                  data-vv-name="password_current"
                  data-vv-as="contraseña actual"
                  v-validate="'required'"
                  :error-messages="errors.collect('password_current')"
                  clearable
                ></v-text-field>
              </v-flex>
            </v-layout>
            <v-layout row wrap>
              <v-flex xs12 sm12 md6 lg6 xl6>
                <v-text-field
                  box
                  color="grey darken-2"
                  ref="password"
                  name="password"
                  label="Contraseña *"
                  v-model="user.password"
                  prepend-icon="lock"
                  :append-icon="isPasswordVisible ? 'visibility' : 'visibility_off'"
                  @click:append="isPasswordVisible = !isPasswordVisible"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  data-vv-name="password"
                  data-vv-as="contraseña"
                  v-validate="'required|min:5'"
                  :error-messages="errors.collect('password')"
                  clearable
                ></v-text-field>
              </v-flex>
            </v-layout>
            <v-layout row wrap>
              <v-flex xs12 sm12 md6 lg6 xl6>
                <v-text-field
                  box
                  color="grey darken-2"
                  label="Confirmación de contraseña *"
                  target= "password"
                  v-model="user.password_confirmation"
                  prepend-icon="lock"
                  :append-icon="isPasswordVisible2 ? 'visibility' : 'visibility_off'"
                  @click:append="isPasswordVisible2 = !isPasswordVisible2"
                  :type="isPasswordVisible2 ? 'text' : 'password'"
                  data-vv-name="password_confirmation"
                  data-vv-as="confirmación de la contraseña"
                  v-validate="'required|min:5|confirmed:password'"
                  :error-messages="errors.collect('password_confirmation')"
                  clearable
                ></v-text-field>
              </v-flex>
            </v-layout>
          </v-card-text>
          <v-divider class="mt-5"></v-divider>
          <v-card-actions>
            <v-btn :disabled="loading" to="/users/profile">
              Cancelar
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn @click="submit" :loading="loading">
              Actualizar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import { mapGetters } from 'vuex'
  import User from '../../models/User'
  import UserService from '../../services/user.service'

  export default {
    $_veeValidate: {
      validator: 'new'
    },

    name: 'password',
    data() {
      return {
        user: new User(),
        success: false,
        loading: false,
        isPassVisible: false,
        isPasswordVisible: false,
        isPasswordVisible2: false,
        dictionary: {
          custom: {
            password_confirmation: {
              confirmed: 'confirmación de la contraseña y contraseña deben coincidir.'
            }
          }
        }
      }
    },

    computed: {
      ...mapGetters([
        'currentUser'
      ])
    },

    mounted () {
      this.$validator.localize('es', this.dictionary)
    }, 

    methods: {
      submit: async function() {
        this.$validator.errors.clear();
        const vm = this
        vm.loading = true
        try {
          const response = await UserService.changePassword(vm.currentUser.id, vm.user)
          if (response.status === 200) {
            vm.$snotify.simple(response.data.message, 'Felicidades')
            vm.loading = false
            vm.$router.push('/users/profile')
          }
        } catch (err) {
          if(err.response.status === 422) this.$setErrorsFromResponse(err.response.data);
          vm.loading = false
        }
      }
    } 
  }
</script>


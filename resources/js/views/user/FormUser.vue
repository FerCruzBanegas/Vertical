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
                            <v-text-field
                              box
                              color="grey darken-2"
                              label="Nombre De Usuario *"
                              v-model="user.name"
                            ></v-text-field>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-text-field
                              box
                              color="grey darken-2"
                              label="Correo Electronico *"
                              v-model="user.email"
                            ></v-text-field>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-autocomplete
                              box
                              color="grey darken-2"
                              :items="states"
                              v-model="user.active"
                              label="Estado *"
                            ></v-autocomplete>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-autocomplete
                              box
                              color="grey darken-2"
                              :items="profiles"
                              v-model="user.profile_id"
                              label="Perfil *"
                              item-text="description"
                              item-value="id"
                            ></v-autocomplete>
                          </v-flex>
                        </v-layout>
                        <div v-if="!id">
                          <v-layout row wrap>
                            <v-flex xs12 sm12 md12 lg12>
                              <v-text-field
                                box
                                color="grey darken-2"
                                ref="password"
                                name="password"
                                label="Contraseña *"
                                v-model="user.password"
                                hint="Debe tener un mínimo de 6 caracteres"
                                prepend-icon="lock"
                                :append-icon="isPasswordVisible ? 'visibility' : 'visibility_off'"
                                @click:append="isPasswordVisible = !isPasswordVisible"
                                :type="isPasswordVisible ? 'text' : 'password'"
                              ></v-text-field>
                            </v-flex>
                          </v-layout>
                          <v-layout row wrap>
                            <v-flex xs12 sm12 md12 lg12>
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
                              ></v-text-field>
                            </v-flex>
                          </v-layout>
                        </div>
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
                    <v-btn :disabled="loading" to="/users">
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
  import ProfileService from '../../services/profile.service'
  import UserService from '../../services/user.service'
  import User from '../../models/User'

  export default {
    name: 'form-user',
    data() {
      return {
        user: new User(),
        success: false,
        loading: false,
        profiles: [],
        id: this.$route.params.id,
        isPasswordVisible: false,
        isPasswordVisible2: false,
        states: [
          { text: 'Activo', value: 1},
          { text: 'Inactivo', value: 0}
        ],
        retry: false
      }
    },

    computed: {
      addSubtitle () {
        if(this.id) {
          return 'Editar Usuario'
        }
        return 'Nuevo Usuario'
      }
    },

    created(){
      this.listProfiles();

      if (this.id) {
        this.showUser()
      }else{
        this.success = true
      }
    },  

    methods: {
      listProfiles: async function() {
        const profiles = await ProfileService.getProfiles('profiles/listing')
        if (profiles.status === 200) {
          this.profiles = profiles.data;
        }
      },

      showUser:async function() {
        const response = await UserService.getUsers(`users/${this.id}`)
        if (response.status === 200) {
          this.user = response.data.data;
          this.success = true
        }
      },

      submit: async function() {
        const vm = this
        vm.loading = true
        if(vm.id) {
          vm._save = await UserService.updateUser(vm.id, vm.user)
        } else {
          vm._save = await UserService.storeUser(vm.user)
        }
        if (vm._save.status === 201 || vm._save.status === 200) {
          vm.$snotify.simple(vm._save.data.message, 'Felicidades')
          vm.loading = false
          if (vm.retry) {
            vm.user = new User()
          } else {
            vm.$router.push('/users')
          }
        }
      }
    } 
  }
</script>


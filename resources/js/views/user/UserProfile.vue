<template>
  <v-container fluid grid-list-md>
    <v-layout row wrap>
      <v-flex d-flex xs12 sm12 md12>
        <v-card>
          <v-card-title primary-title>
            <h3 class="headline mb-0">Mi Perfil</h3>
            <v-spacer></v-spacer>
            <div>
              <span class="title mb-3">Registrado:</span>
              <span class="subheading">{{ currentUser.created | formatDate('DD/MM/YYYY') }}</span>
            </div>
          </v-card-title>
          <v-container fluid>
            <v-layout>
              <v-flex xs12 sm12 md12 lg12>
                <v-card>
                  <v-card-text>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-text-field
                          box
                          color="grey darken-2"
                          label="Nombre De Usuario"
                          v-model="user.name"
                          data-vv-name="name"
                          data-vv-as="nombre"
                          v-validate="'required|min:3|max:60'"
                          :error-messages="errors.collect('name')"
                          clearable
                        ></v-text-field>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-text-field
                          box
                          color="grey darken-2"
                          label="Correo Electronico"
                          v-model="user.email"
                          data-vv-name="email"
                          data-vv-as="correo electrónico"
                          v-validate="'required|max:60'"
                          :error-messages="errors.collect('email')"
                          clearable
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <router-link to="password">Cambiar Contraseña</router-link>
                    </v-layout>
                  </v-card-text>
                  <v-divider class="mt-5"></v-divider>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="submit" :loading="loading">Actualizar</v-btn>
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
  import UserService from '../../services/user.service'
  import User from '../../models/User'

  export default {
    $_veeValidate: {
      validator: 'new'
    },

    name: 'form-user',
    data() {
      return {
        user: new User(),
        success: false,
        loading: false,
      }
    },

    computed: {
      ...mapGetters([
        'currentUser'
      ])
    },

    created(){
      this.user.name = this.currentUser.name
      this.user.email = this.currentUser.email
    }, 

    methods: {
      submit: async function() {
        this.$validator.errors.clear();
        this.loading = true
        try {
          const response = await UserService.updateUser(this.currentUser.id, this.user)
          if (response.status === 200) {
            this.$store.dispatch('updateUser', this.user)
            this.$snotify.simple(response.data.message, 'Felicidades')
            this.loading = false
          } 
        } catch (err) {
          if(err.response.status === 422) this.$setErrorsFromResponse(err.response.data);
          this.loading = false
        }
      }
    } 
  }
</script>


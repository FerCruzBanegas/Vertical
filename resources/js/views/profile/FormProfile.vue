<template>
  <v-container fluid grid-list-md>
    <v-layout>
      <v-flex d-flex xs12 sm12 md12>
        <v-card v-show="success">
          <v-card-title primary-title>
            <h3 class="headline mb-0">{{ addSubtitle }}</h3>
          </v-card-title>
          <v-container fluid>
            <v-layout row wrap>
              <v-flex xs12 sm12 md5 lg5>
                <v-layout row wrap>
                  <v-flex xs12 sm12 md12 lg12>
                    <v-text-field
                      box
                      color="grey darken-2"
                      label="Descripción *"
                      v-model="profile.description"
                    ></v-text-field>
                  </v-flex>
                </v-layout>
              </v-flex>
            </v-layout>
            <v-layout>
              <v-flex xs12 sm12 md12 lg12>
                <v-card>
                  <v-card-title>
                    <div class="title font-weight-bold">PERMISOS DE ACCESO</div>
                    <v-spacer></v-spacer>
                    <v-icon x-large>https</v-icon>
                  </v-card-title>
                  <v-card-text>
                    <small>Por favor, seleccione uno o más permisos a los que tendrá acceso este perfil.</small>
                    <v-layout row wrap v-for="(action,index) in actions" :key="index">
                      <v-flex xs12 sm12 md12 lg12>
                        <v-toolbar color="grey darken-2" dark dense>
                          <v-toolbar-title>{{ action.title.title }}</v-toolbar-title>
                          <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-card>
                          <v-container>
                            <v-layout row wrap>
                              <v-flex xs12 sm4 md3 lg3 v-for="(a,index) in action.permissions" :key="a.id">
                                <v-checkbox
                                  color="red darken-3"
                                  :key="index"
                                  v-model="profile.action_list"
                                  :value="a.id"
                                  :label="a.name"
                                  :hide-details="index !== (actions.length - 1)"
                                ></v-checkbox>
                              </v-flex>          
                            </v-layout>
                          </v-container>
                        </v-card>  
                      </v-flex>
                    </v-layout>
                  </v-card-text>
                  <v-divider class="mt-5"></v-divider>
                  <v-card-actions>
                    <v-btn :disabled="loading" to="/profiles">
                      Cancelar
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn 
                      @click="submit" 
                      v-if="profile.description && profile.action_list.length > 0" 
                      :loading="loading"
                    >
                      Aceptar
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
  import Profile from '../../models/Profile'
  import ProfileService from '../../services/profile.service'
  import ActionsService from '../../services/action.service'

  export default {
    name: 'form-profile',
    data () {
      return {
        success: false,
        loading: false,
        profile: new Profile(),
        actions: [],
        id: this.$route.params.id,
      }
    },

    computed: {
      addSubtitle () {
        if(this.id) {
          return 'Editar Perfil'
        }
        return 'Registrar Nuevo Perfil'
      }
    },

    created(){
      this.listActions();

      if (this.id) {
        this.showProfile()
      }else{
        this.success = true
      }
    },

    methods: {
      listActions: async function() {
        const actions = await ActionsService.getActions('actions/listing')
        if (actions.status === 200) {
          this.actions = actions.data;
        }
      },

      showProfile:async function() {
        const response = await ProfileService.getProfiles(`profiles/${this.id}`)
        if (response.status === 200) {
          this.profile = response.data.data;
          this.success = true
        }
      },

      submit: async function() {
        const vm = this
        vm.loading = true
        if(vm.id) {
          vm._save = await ProfileService.updateProfile(vm.id, vm.profile)
        } else {
          vm._save = await ProfileService.storeProfile(vm.profile)
        }
        if (vm._save.status === 201 || vm._save.status === 200) {
          vm.$snotify.simple(vm._save.data.message, 'Felicidades')
          vm.loading = false
          if (vm.retry) {
            vm.profile = new Profile()
          } else {
            vm.$router.push('/profiles')
          }
        }
      }
    }
  }
</script>


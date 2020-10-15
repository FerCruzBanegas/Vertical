<template>
  <v-container fluid grid-list-md>
    <v-dialog v-model="dialog" persistent max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Nuevo Cargo</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12>
                <v-text-field
                  box
                  color="grey darken-2"
                  label="Descripción *"
                  v-model="position.description"
                  data-vv-name="description"
                  data-vv-as="descripcion"
                  v-validate="'required|min:5|max:64'"
                  :error-messages="errors.collect('description')"
                ></v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
          <small>Los campos con (*) son obligatorios.</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn :disabled="loadingPosition" @click="dialog = false">Cancelar</v-btn>
          <v-btn :loading="loadingPosition" @click="submitPosition">Registrar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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
                              v-model="people.name"
                              data-vv-name="name"
                              data-vv-as="nombre"
                              v-validate="'required|max:32'"
                              :error-messages="errors.collect('name')"
                            ></v-text-field>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-text-field
                              box
                              color="grey darken-2"
                              label="Apellidos"
                              v-model="people.surnames"
                              data-vv-name="surnames"
                              data-vv-as="apellidos"
                              v-validate="'max:32'"
                              :error-messages="errors.collect('surnames')"
                            ></v-text-field>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-text-field
                              box
                              color="grey darken-2"
                              label="Teléfono *"
                              v-model="people.phone"
                              data-vv-name="phone"
                              data-vv-as="teléfono"
                              v-validate="'required|max:10'"
                              :error-messages="errors.collect('phone')"
                            ></v-text-field>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <!-- :items="projects" -->
                            <!-- return-object -->
                            <v-autocomplete
                              box
                              color="grey darken-2"
                              v-model="people.position_id"
                              :items="positions"
                              label="Cargo *"
                              data-vv-name="people.position_id"
                              data-vv-as="cargo"
                              v-validate="'required'"
                              :error-messages="errors.collect('people.position_id')"
                              item-text="description"
                              item-value="id"
                            >
                              <template v-slot:append-outer>
                                <v-btn @click="openForm" flat icon color="red darken-3">
                                  <v-icon>add_circle</v-icon>
                                </v-btn>
                              </template>
                            </v-autocomplete>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-textarea
                              box
                              color="grey darken-2"
                              label="Nota"
                              v-model="people.note"
                              data-vv-name="note"
                              data-vv-as="nota"
                              v-validate="'max:64'"
                              :error-messages="errors.collect('note')"
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
                    <v-btn :disabled="loading" to="/people">
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
  import People from '../../models/People'
  import Position from '../../models/Position'
  import PositionService from '../../services/position.service'
  import PeopleService from '../../services/people.service'

  export default {
    $_veeValidate: {
      validator: 'new'
    },

    name: 'form-people',
    data() {
      return {
        success: false,
        loading: false,
        loadingPosition: false,
        dialog: false,
        people: new People(),
        position: new Position(),
        positions: [],
        id: this.$route.params.id,
        retry: false
      }
    },

    computed: {
      bread() {
        let bread = [
          { text: 'Inicio',disabled: false,href: '/dashboard' },
          { text: 'Contratistas',disabled: false,href: '/people' }
        ];
        if(this.id) {
          bread.push({text: 'Modificar Contratista', disabled: true})
          return bread
        } else {
          bread.push({text: 'Nuevo Contratista', disabled: true})
          return bread
        }
      },
      addSubtitle () {
        if(this.id) {
          return 'Editar Contratista'
        }
        return 'Registrar Contratista'
      }
    },

    created() {
      if (this.id) {
        this.showPeople()
      } 

      Promise.all([this.listPositions()])
      .then(() =>{
        this.success = true
      })
    },

    methods: {
      openForm(){
        this.dialog = true
      },

      listPositions: async function() {
        const positions = await PositionService.getPositions('position/listing')
        if (positions.status === 200) {
          this.positions = positions.data;
        }
      },

      showPeople:async function() {
        const response = await PeopleService.getPeople(`people/${this.id}/edit`)
        if (response.status === 200) {
          this.people = response.data.data;
        }
      },

      submitPosition: async function() {
        this.$validator.errors.clear()
        this.loadingPosition = true
        try {
          const response = await PositionService.storePosition(this.position)
          if (response.status === 201) {
            this.listPositions()
            .then(() =>{
              this.loadingPosition = false
              this.dialog = false
              this.position = new Position()
            })
          }
        } catch (err) {
          if(err.response.status === 422) this.$setErrorsFromResponse(err.response.data);
          this.loadingPosition = false
        }
      },

      submit: async function() {
        this.$validator.errors.clear();
        const vm = this
        vm.loading = true
        try {
          if(vm.id) {
            vm._save = await PeopleService.updatePeople(vm.id, vm.people)
          } else {
            vm._save = await PeopleService.storePeople(vm.people)
          }
          if (vm._save.status === 201 || vm._save.status === 200) {
            vm.$snotify.simple(vm._save.data.message, 'Felicidades')
            vm.loading = false
            if (vm.retry) {
              vm.people = new People()
            } else {
              vm.$router.push('/people')
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



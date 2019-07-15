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
                        <v-autocomplete
                          box
                          color="grey darken-2"
                          :items="project_types"
                          v-model="project.project_type_id"
                          label="Tipo de Proyecto *"
                          item-text="name"
                          item-value="id"
                        ></v-autocomplete>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-text-field
                          box
                          color="grey darken-2"
                          label="Nombre *"
                          v-model="project.name"
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-text-field
                          box
                          color="grey darken-2"
                          label="Dirección *"
                          v-model="project.location"
                        ></v-text-field>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-menu
                          v-model="picker"
                          :close-on-content-click="false"
                          :nudge-right="40"
                          lazy
                          transition="scale-transition"
                          offset-y
                          full-width
                          min-width="290px"
                        >
                          <template v-slot:activator="{ on }">
                            <v-text-field
                              box
                              color="grey darken-2"
                              v-model="dateFormatted"
                              label="Fecha de Inicio *"
                              hint="DD/MM/YYYY format"
                              prepend-icon="event"
                              readonly
                              v-on="on"
                            ></v-text-field>
                          </template>
                          <v-date-picker 
                            color="red darken-3" 
                            v-model="project.start_date" 
                            @input="picker = false"
                            :first-day-of-week="0"
                            locale="es-es"
                          ></v-date-picker>
                        </v-menu>
                      </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md6 lg6>
                        <v-textarea
                          box
                          color="grey darken-2"
                          label="Comentarios"
                          v-model="project.comments"
                        ></v-textarea>
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
                    <v-btn :disabled="loading" to="/projects">
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
  import Project from '../../models/Project'
  import ProjectTypeService from '../../services/project.type.service'
  import ProjectService from '../../services/project.service'

  export default {
    name: 'form-project',
    data() {
      return {
        success: false,
        loading: false,
        picker: false,
        project_types: [],
        project: new Project(),
        dateFormatted: '',
        id: this.$route.params.id,
        retry: false
      }
    },

    computed: {
      addSubtitle () {
        if(this.id) {
          return 'Editar Proyecto'
        }
        return 'Registrar Proyecto'
      }
    },

    watch: {
      project: {
        handler (val) {
          this.dateFormatted = this.formatDate(this.project.start_date)
        },
        deep: true
      }
    },

    created() {
      this.listProjectTypes();

      if (this.id) {
        this.showProject();
      }else{
        this.success = true
      }
    },

    methods: {
      formatDate (date) {
        if (!date) return null

        const [year, month, day] = date.split('-')
        return `${day}/${month}/${year}`
      },

      listProjectTypes: async function() {
        const types = await ProjectTypeService.getProjectTypes('project-types/listing')
        if (types.status === 200) {
          this.project_types = types.data;
        }
      },

      showProject:async function() {
        const response = await ProjectService.getProjects(`projects/${this.id}`)
        if (response.status === 200) {
          this.project = response.data.data;
          this.success = true
        }
      },

      submit: async function() {
        const vm = this
        vm.loading = true
        if(vm.id) {
          vm._save = await ProjectService.updateProject(vm.id, vm.project)
        } else {
          vm._save = await ProjectService.storeProject(vm.project)
        }
        if (vm._save.status === 201 || vm._save.status === 200) {
          vm.$snotify.simple(vm._save.data.message, 'Felicidades')
          vm.loading = false
          if (vm.retry) {
            vm.project = new Project()
          } else {
            vm.$router.push('/projects')
          }
        }
      }
    }
  }
</script>



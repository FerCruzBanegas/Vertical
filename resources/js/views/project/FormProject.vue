<template>
  <v-container fluid grid-list-md>
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
                        <v-autocomplete
                          box
                          color="grey darken-2"
                          :items="project_types"
                          v-model="project.project_type_id"
                          data-vv-name="project_type_id"
                          data-vv-as="tipo de proyecto"
                          v-validate="'required'"
                          :error-messages="errors.collect('project_type_id')"
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
                          data-vv-name="name"
                          data-vv-as="nombre"
                          v-validate="'required|min:3|max:60'"
                          :error-messages="errors.collect('name')"
                          clearable
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
                          data-vv-name="location"
                          data-vv-as="dirección"
                          v-validate="'required|min:5|max:100'"
                          :error-messages="errors.collect('location')"
                          clearable
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
                              data-vv-name="start_date"
                              data-vv-as="fecha inicio"
                              v-validate="'required'"
                              :error-messages="errors.collect('start_date')"
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
                          data-vv-name="comments"
                          data-vv-as="comentarios"
                          v-validate="'min:5|max:120'"
                          :error-messages="errors.collect('comments')"
                        ></v-textarea>
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
    $_veeValidate: {
      validator: 'new'
    },

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
      bread() {
        let bread = [
          { text: 'Inicio',disabled: false,href: '/dashboard' },
          { text: 'Proyectos',disabled: false,href: '/projects' }
        ];
        if(this.id) {
          bread.push({text: 'Modificar Proyecto', disabled: true})
          return bread
        } else {
          bread.push({text: 'Nuevo Proyecto', disabled: true})
          return bread
        }
      },
      addSubtitle () {
        if(this.id) {
          return 'Editar Proyecto'
        }
        return 'Registrar Proyecto'
      }
    },

    watch: {
      'project.start_date': function (newVal, oldVal){
        this.dateFormatted = this.formatDate(this.project.start_date)
      }
    },

    created() {
      this.listProjectTypes();

      if (this.id) {
        this.showProject();
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
          this.success = true
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
        this.$validator.errors.clear();
        const vm = this
        vm.loading = true
        try {
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
        } catch (err) {
          if(err.response.status === 422) this.$setErrorsFromResponse(err.response.data);
          vm.loading = false
        }
      }
    }
  }
</script>



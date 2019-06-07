<template>
  <v-container fluid grid-list-md id="theme">
    <v-layout row wrap>
      <v-flex d-flex xs12 sm12 md12>
        <v-card>
          <v-card-title primary-title>
            <h3 class="headline mb-0">{{ addSubtitle }}</h3>
          </v-card-title>
          <v-container fluid>
            <v-layout>
              <v-flex xs12 sm12 md12 lg12>
                <v-card>
                  <v-card-text>
                    <v-layout row wrap>
                      <v-flex xs12 sm12 md5 lg5>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-autocomplete
                              box
                              color="grey darken-2"
                              :items="project_types"
                              v-model="project.project_type"
                              label="Tipo de Proyecto *"
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
                              v-model="project.name"
                            ></v-text-field>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-currency-field label="Value" v-bind="currency_config" :error-messages="errors.price" v-model="price" box color="grey darken-2"></v-currency-field>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
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
                          <v-flex xs12 sm12 md12 lg12>
                            <v-textarea
                              box
                              color="grey darken-2"
                              label="Comentarios"
                              v-model="project.comments"
                            ></v-textarea>
                          </v-flex>
                        </v-layout>
                      </v-flex>
                    </v-layout>
                    <small>Los campos con (*) son obligatorios.</small>
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
        errors: {},
        price: 0,
        currency_config: {
          decimal: '.',
          thousands: ',',
          prefix: '$ ',
          suffix: '',
          precision: 2,
          masked: false,
          allowBlank: false,
          min: Number.MIN_SAFE_INTEGER,
          max: Number.MAX_SAFE_INTEGER
        },
        succes: false,
        loading: false,
        picker: false,
        project_types: [],
        project: new Project(),
        dateFormatted: '',
        id: this.$route.params.id
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
        }
      },

      submit() {
        this.loading = true
        if(this.id) {
          this._save = axios.put(`/api/category/${this.id}`, this.category)
        } else {
          this._save = axios.post('/api/create-category', this.category)
        }
        this._save
        .then(response => {
          if(response.data.success) {
            this.$router.push('/categories')
          }
          this.loading = false
        })
        .catch(error =>{
          this.loading = false
        })
      }
    }
  }
</script>



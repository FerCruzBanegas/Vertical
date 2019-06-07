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
                            <v-text-field
                              label="Nombre *"
                              v-model="project_type.name"
                            ></v-text-field>
                          </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                          <v-flex xs12 sm12 md12 lg12>
                            <v-textarea
                              label="Descripción"
                              v-model="project_type.description"
                            ></v-textarea>
                          </v-flex>
                        </v-layout>
                      </v-flex>
                    </v-layout>
                    <small>Los campos con (*) son obligatorios.</small>
                  </v-card-text>
                  <v-divider class="mt-5"></v-divider>
                  <v-card-actions>
                    <v-btn :disabled="loading" to="/project-types">
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
  import ProjectType from '../../models/ProjectType'
  import ProjectTypeService from '../../services/project.type.service'

  export default {
    name: 'form-project-type',
    data() {
      return {
        succes: false,
        loading: false,
        project_type: new ProjectType(),
        id: this.$route.params.id
      }
    },

    computed: {
      addSubtitle () {
        if(this.id) {
          return 'Editar Tipo de Proyecto'
        }
        return 'Registrar Tipo de Proyecto'
      }
    },

    created() {
      if (this.id) {
        this.showProjectType()
      }else{
        this.success = true
      }
    },

    methods: {
      showProjectType:async function() {
        const response = await ProjectTypeService.getProjectTypes(`project-types/${this.id}`)
        if (response.status === 200) {
          this.project_type = response.data.data
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



<template>
  <v-layout row wrap>
    <v-flex xs12 sm12 md12 lg12>
      <fieldset>
        <legend>Filtros:</legend>
        <v-container fluid>
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
                    label="Fecha"
                    hint="DD/MM/YYYY format"
                    prepend-icon="event"
                    readonly
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker 
                  v-model="date"
                  color="red darken-3" 
                  @input="picker = false"
                  :first-day-of-week="0"
                  locale="es-es"
                ></v-date-picker>
              </v-menu>
            </v-flex>
            <v-flex xs12 sm12 md6 lg6>
              <v-autocomplete
                box
                color="grey darken-2"
                :items="projects"
                v-model="selected"
                label="Proyecto"
                item-text="name"
                item-value="id"
                @change="selectProject"
              ></v-autocomplete>
            </v-flex>
          </v-layout>
        </v-container>
       </fieldset>
    </v-flex>
  </v-layout>
</template>
<script>
  import ProjectService from '../services/project.service'

  export default {
    props: {
      // date: {
      //   type: String
      // },

      // icon: {
      //   type: String
      // }
    },

    data() {
      return {
        date: '',
        picker: false,
        dateFormatted: '',
        projects: [],
        selected: null,
      }
    },

    watch: {
      date (val) {
        this.dateFormatted = this.formatDate(this.date)
      }
    },

    created () {
      this.listProjects()
      this.$bus.$on('updatingData', () => {
        this.date = ''
        this.selected = null
      })
    },

    methods: {
      listProjects: async function() {
        const projects = await ProjectService.getProjects('projects/listing')
        if (projects.status === 200) {
          this.projects = projects.data;
        }
      },

      formatDate(date) {
        this.$emit('changeDate', date)
        if (!date) return null

        const [year, month, day] = date.split('-')
        return `${day}/${month}/${year}`
      },

      selectProject() {
        this.$emit('selectProject', this.selected)
      }
    }
  }
</script>
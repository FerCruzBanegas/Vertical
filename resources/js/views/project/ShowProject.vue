<template>
  <v-container fluid grid-list-md>
    <v-layout>
      <v-flex d-flex xs12 sm12 md12>
        <v-data-table
          :headers="headers"
          :items="events"
          :loading="progress"
          :pagination.sync="pagination"
          :total-items="totalItems"
          class="elevation-1"
          rows-per-page-text="Items por página"
        >
          <v-progress-linear height="3" slot="progress" color="red darken-3" indeterminate></v-progress-linear>
          <template v-slot:items="props">
            <tr :class="props.item.type" :key="props.item.id">
              <td>{{ props.item.title }}</td>
              <td class="text-xs-right">{{ props.item.date }}</td>
              <td class="text-xs-right">{{ props.item.amount }}</td>
            </tr>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import ProjectService from '../../services/project.service'

  export default {
    name: 'show-project',
    data () {
      return {
        progress: false,
        events: [],
        id: this.$route.params.id,
        headers: [
          {
            text: 'Titulo',
            align: 'left',
            sortable: false,
            value: 'titulo'
          },
          { text: 'Fecha', value: 'fecha' },
          { text: 'Monto', value: 'monto' },
        ],
        totalItems: 0,
        pagination: {
          rowsPerPage: 3
        }
      }
    },

    watch: {
      pagination: {
        handler () {
          this.getDataFromApi()
          .then(data => {
            this.events = data.items
          })
        },
        deep: true
      }
    },

    methods: {
      getDataFromApi() {
        this.progress = true
        return new Promise((resolve, reject) => {
          const { sortBy, descending, page } = this.pagination
          ProjectService.getProjects(this.buildURL())
          .then((response) => {
            this.totalItems = response.data.meta.total
            let items = response.data.data
            resolve({
              items
            })
            this.progress = false
          })
        })
      },

      buildURL() {
        let page = `?page=${this.pagination.page}`
        let rowsPerPage = `&rowsPerPage=${this.pagination.rowsPerPage}`
        return `projects/${this.id}/events${page}${rowsPerPage}`
      }
    }
  }
</script>

<style scoped>
  .expense {
    background-color: #FFF0F0;
  }

  .income {
    background-color: #F0FFF0;
  }
</style>
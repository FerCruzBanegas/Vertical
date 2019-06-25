<template>
  <v-container fluid grid-list-md>
    <v-layout>
      <v-flex d-flex xs12 sm12 md12>
        <div id="wdr-component"></div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import traslate from '../../libraries/es.json'
  export default {
    name: 'show-project',
    data () {
      return {
      }
    },

    mounted() {
      let pivot = new WebDataRocks({
        container: "#wdr-component",
        toolbar: true,
        report: {
          dataSource: {
              filename: "https://cdn.webdatarocks.com/data/data.csv"
          }
        },
        global: {
          localization: traslate
        }
      });
    },

    methods: {

    }
  }
</script>

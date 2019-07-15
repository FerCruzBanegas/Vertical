<template>
  <v-layout row child-flex wrap>
    <v-flex d-flex xs12 sm12 md4 lg4 xl4>
      <v-card class="mx-auto" color="grey" dark>
        <v-card-title>
          <v-icon x-large left>trending_up</v-icon>
          <span class="title font-weight-light">Este Mes</span>
        </v-card-title>
        <v-divider dark></v-divider>
        <v-card-text class="headline font-weight-bold text-md-center">
          Bs. {{ data.month | currency }}
        </v-card-text>
      </v-card>
    </v-flex>
    <v-flex d-flex xs12 sm12 md4 lg4 xl4>
      <v-card class="mx-auto" color="grey" dark>
        <v-card-title>
          <v-icon x-large left>trending_up</v-icon>
          <span class="title font-weight-light">Esta Semana</span>
        </v-card-title>
        <v-divider dark></v-divider>
        <v-card-text class="headline font-weight-bold text-md-center">
          Bs. {{ data.week | currency }}
        </v-card-text>
      </v-card>
    </v-flex>
    <v-flex d-flex xs12 sm12 md4 lg4 xl4>
      <v-card class="mx-auto" color="grey" dark>
        <v-card-title>
          <v-icon x-large left>trending_up</v-icon>
          <span class="title font-weight-light">Hoy</span>
        </v-card-title>
        <v-divider dark></v-divider>
        <v-card-text class="headline font-weight-bold text-md-center">
          Bs. {{ data.day | currency }}
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</template>
<script>
  export default {
    props: {
      data: {
        type: Object
      }
    },

    methods: {
      hide () {
        this.$emit('hide')      
      }
    }
  }
</script>
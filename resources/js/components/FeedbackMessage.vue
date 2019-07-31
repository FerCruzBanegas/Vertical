<template>
  <v-layout row justify-center>
    <v-dialog v-model="responseMessage.modal" :value.sync="responseMessage.show" persistent>
      <v-card>
        <v-card-title class="headline white--text" :class="responseMessage.type">
          <h2>{{ responseMessage.title }}</h2>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text><h3>{{ responseMessage.text }}</h3></v-card-text>
        <v-layout row justify-center>
          <v-btn :color="responseMessage.type" flat="flat" @click.native="close">OK</v-btn>
        </v-layout>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'feedback-message',
  computed: mapGetters([
    'responseMessage'
  ]),
  methods: {
    close () {
      this.$store.dispatch('clearMessage')
    }
  }
}
</script>

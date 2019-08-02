<template>
  <main>
    <v-content>
      <v-container fluid>
        <v-layout column align-center>
          <div class="display-3 grey--text mt-5">Página no encontrada!</div>
          <div class="body-2 my-3">
            <router-link :to="{ name: 'Home' }">
              volver al inicio
            </router-link>
          </div>
        </v-layout>
      </v-container>
    </v-content>
  </main>
</template>

<script>
  export default {
    name: 'not-found'
  }
</script>
<template>
  <v-footer :fixed="fixed" app>
    <v-spacer></v-spacer>
    <div>&copy; {{ new Date().getFullYear() }}</div>
  </v-footer>
</template>

<script>
  export default {
    name: 'appfooter',
    data () {
      return {
        fixed: false,
      }
    }
  } 
</script>

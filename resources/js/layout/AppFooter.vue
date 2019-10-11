<template>
  <v-footer :fixed="fixed" app class="pa-3">
    <v-spacer></v-spacer>
    <div><strong>Vertical S.R.L</strong> &copy; {{ new Date().getFullYear() }}</div>
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

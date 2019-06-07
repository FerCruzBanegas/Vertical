<template>
  <v-toolbar
    color="red darken-3" fixed clipped-left app
    app
    :clipped-left="clipped"
  >
    <v-toolbar-side-icon dark @click.stop="toggleDrawer"></v-toolbar-side-icon>
    <v-btn dark icon @click.stop="toggleMiniVariant">
      <v-icon v-html="miniVariant ? 'chevron_right' : 'chevron_left'"></v-icon>
    </v-btn>
    
    <v-spacer></v-spacer>
    <v-toolbar-title class="white--text"></v-toolbar-title>
    <v-menu offset-y>
      <v-btn dark icon slot="activator"><v-icon>menu</v-icon></v-btn>
      <v-list>
        <v-list-tile @click="">
          <v-list-tile-action>
            <v-icon>exit_to_app</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>
              Cerrar sesión
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-menu>
  </v-toolbar>
</template>

<script>
  export default {
    name: 'apptoolbar',

    props: {
      drawer: {
        type: Boolean,
        required: true
      },
      miniVariant: {
        type: Boolean,
        required: true
      }
    },

    data () {
      return {
        clipped: false,
        loader: false,
        menu: false,
        flat: false,
        empty: false,
        items: []
      }
    },

    methods: {
      toggleDrawer () {
        this.$emit('toggleDrawer')
      },

      toggleMiniVariant () {
        this.$emit('toggleMiniVariant')
      }
    }
  }
</script>

<style scoped>
  >>>.v-badge__badge {
    top: -20px;
    right: -15px;
  }
</style>
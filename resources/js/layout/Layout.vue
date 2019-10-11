<template>
  <div>
    <v-navigation-drawer
      persistent
      :mini-variant="miniVariant"
      :clipped="clipped"
      v-model="drawer"
      :width="width"
      enable-resize-watcher
      fixed
      app
    >
      <v-toolbar flat>
        <v-list>
          <v-list-tile>
            <img src="/img/logo2.png" width="45px">
          </v-list-tile>
        </v-list>
      </v-toolbar>
      <v-divider></v-divider>
      <v-list>
        <v-list-tile router to="/dashboard">
          <v-list-tile-action>
            <v-icon>home</v-icon>
          </v-list-tile-action>
        </v-list-tile>
        <v-list-tile router to="/reports" v-show="permission('reports.index')">
          <v-list-tile-action>
            <v-icon>find_in_page</v-icon>
          </v-list-tile-action>
        </v-list-tile>
        <v-list-tile router to="/projects" v-show="permission('projects.index')">
          <v-list-tile-action>
            <v-icon>domain</v-icon>
          </v-list-tile-action>
        </v-list-tile>
        <v-list-tile @click="openModalIncome" v-show="permission('incomes.index')">
          <v-list-tile-action>
            <v-icon>attach_money</v-icon>
          </v-list-tile-action>
        </v-list-tile>
        <v-list-tile @click="openModalExpense" v-show="permission('expenses.index')">
          <v-list-tile-action>
            <v-icon>money_off</v-icon>
          </v-list-tile-action>
        </v-list-tile>
        <v-list-tile @click="openModalSmallBox" v-show="permission('small-boxes.index')">
          <v-list-tile-action>
            <!-- <v-badge color="red">
              <template v-slot:badge>
                <span>!</span>
              </template>
              <v-icon>local_atm</v-icon>
            </v-badge> -->
            <v-icon>local_atm</v-icon>
          </v-list-tile-action>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
    <app-bar></app-bar>
    <app-toolbar 
      v-on:toggleDrawer="drawer = !drawer" :drawer="drawer" 
      v-on:toggleMiniVariant="miniVariant = !miniVariant" :miniVariant="miniVariant"
    >
    </app-toolbar>
    <v-content>
      <transition name="fade">
        <router-view></router-view>
      </transition>
    </v-content>
    <app-footer/>
  </div>
</template>

<script>
  import permission from '../mixins/permission'
  import AppFooter from './AppFooter.vue'
  import AppToolbar from './AppToolbar.vue'
  import AppBar from './AppBar.vue'

  export default {
    name: 'layout',

    mixins: [permission],

    components: {
      'app-footer': AppFooter,
      'app-toolbar': AppToolbar,
      'app-bar': AppBar
    },

    data () {
      return {
        clipped: false,
        drawer: true,
        miniVariant: true,
        width: 260
      }
    },

    methods: {
      openModalIncome() {
        this.$store.dispatch('openLastIncome')
      },

      openModalExpense() {
        this.$store.dispatch('openLastExpense')
      },

      openModalSmallBox() {
        this.$store.dispatch('getSmallBoxesActives')
      }
    }
  }
</script>

<style>
  .fade-enter-active, .fade-leave-active {
    transition-property: opacity;
    transition-duration: .25s;
  }

  .fade-enter-active {
    transition-delay: .25s;
  }

  .fade-enter, .fade-leave-active {
    opacity: 0
  }
</style>
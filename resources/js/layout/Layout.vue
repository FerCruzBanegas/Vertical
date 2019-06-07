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
      <v-toolbar flat color="">
        <v-list>
          <v-list-tile>
              <img src="/img/logo.png" width="210px" v-if="!miniVariant">
              <img src="/img/logo2.png" width="45px" v-else="miniVariant">
          </v-list-tile>
        </v-list>
      </v-toolbar>
      <v-divider></v-divider>
      <v-list dense>
        <template v-for="item in items">
          <v-layout
            row
            v-if="item.heading"
            align-center
            :key="item.heading"
          >
          </v-layout>
          <v-list-group
            v-else-if="item.children"
            v-model="item.model"
            :key="item.text"
            :prepend-icon="item.model ? item.icon : item['icon-alt']"
            append-icon=""
          >
            <v-list-tile slot="activator">
              <v-list-tile-content>
                <v-list-tile-title>
                  {{ item.text }}
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
            <v-list-tile
              v-for="(child, i) in item.children"
              :key="i"
              router :to="child.url"
            >
              <v-list-tile-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title>
                  {{ child.text }}
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
          </v-list-group>
          <v-list-tile v-else :key="item.text" router :to="item.url">
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                {{ item.text }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
      </v-list>
    </v-navigation-drawer>
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
  import AppFooter from './AppFooter.vue'
  import AppToolbar from './AppToolbar.vue'

  export default {
    name: 'layout',
    components: {
      'app-footer': AppFooter,
      'app-toolbar': AppToolbar
    },
    data () {
      return {
        clipped: false,
        drawer: true,
        miniVariant: false,
        items: [
        { icon: 'home', text: 'Inicio', url: '/dashboard', name: 'home' },
        { icon: 'show_chart', text: 'Gráficas', url: '/graphics', name: 'graphics' },
        { icon: 'public', text: 'Espacios', url: '/billboards', name: 'billboards' },
        { icon: 'assignment', text: 'Reportes', url: '/reports', name: 'reports' },
        {
          icon: 'settings',
          'icon-alt': 'settings',
          text: 'Configuración',
          model: false,
          children: [
            { icon: 'person', text: 'Perfil', url: '/profile', name: 'profile' },
            { icon: 'notifications_active', text: 'Alerta', url: '/alert/edit', name: 'alert' }
          ]
        },
        {
          icon: 'build',
          'icon-alt': 'build',
          text: 'Administración',
          model: false,
          children: [
            { icon: 'group', text: 'Usuarios', url: '/users', name: 'users' },
            { icon: 'create', text: 'Espacios', url: '/administration', name: 'admin' }
          ]
        }
      ],
        width: 220
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
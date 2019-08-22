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
            <img src="/img/logo.png" width="200px" v-if="!miniVariant">
            <img src="/img/logo2.png" width="45px" v-else>
          </v-list-tile>
        </v-list>
      </v-toolbar>
      <v-divider></v-divider>
      <v-list>
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
              v-show="permission(child.permission) || child.permission ==''"
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
          <v-list-tile v-else :key="item.text" router :to="item.url" v-show="permission(item.permission) || item.permission ==''">
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
  import permission from '../mixins/permission'
  import AppFooter from './AppFooter.vue'
  import AppToolbar from './AppToolbar.vue'

  export default {
    name: 'layout',

    mixins: [permission],

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
        { icon: 'home', text: 'Inicio', url: '/dashboard', permission: '' },
        { icon: 'find_in_page', text: 'Informes', url: '/reports', permission: 'reports.index' },
        {
          icon: 'domain',
          'icon-alt': 'domain',
          text: 'Proyectos',
          model: false,
          children: [
            { icon: 'create', text: 'Registrar Nuevo', url: '/projects/create', permission: 'projects.create' },
            { icon: 'list', text: 'Ver Lista', url: '/projects', permission: 'projects.index' }
          ]
        },
        {
          icon: 'build',
          'icon-alt': 'build',
          text: 'Materiales',
          model: false,
          children: [
            { icon: 'create', text: 'Registrar Nuevo', url: '/materials/create', permission: 'materials.create' },
            { icon: 'list', text: 'Ver Lista', url: '/materials', permission: 'materials.index' }
          ]
        },
        {
          icon: 'credit_card',
          'icon-alt': 'credit_card',
          text: 'Cuentas',
          model: false,
          children: [
            { icon: 'create', text: 'Registrar Nuevo', url: '/accounts/create', permission: 'accounts.create' },
            { icon: 'list', text: 'Ver Lista', url: '/accounts', permission: 'accounts.index' }
          ]
        },
        {
          icon: 'attach_money',
          'icon-alt': 'attach_money',
          text: 'Ingresos',
          model: false,
          children: [
            { icon: 'create', text: 'Registrar Nuevo', url: '/incomes/create', permission: 'incomes.create' },
            { icon: 'list', text: 'Ver Lista', url: '/incomes', permission: 'incomes.index' }
          ]
        },
        {
          icon: 'money_off',
          'icon-alt': 'money_off',
          text: 'Egresos',
          model: false,
          children: [
            { icon: 'create', text: 'Registrar Nuevo', url: '/expenses/create', permission: 'expenses.create' },
            { icon: 'list', text: 'Ver Lista', url: '/expenses', permission: 'expenses.index' }
          ]
        },
        {
          icon: 'local_atm',
          'icon-alt': 'local_atm',
          text: 'Arqueos de Caja',
          model: false,
          children: [
            { icon: 'create', text: 'Registrar Nuevo', url: '/boxes/create', permission: 'boxes.create' },
            { icon: 'list', text: 'Ver Lista', url: '/boxes', permission: 'boxes.index' }
          ]
        },
        {
          icon: 'style',
          'icon-alt': 'style',
          text: 'Categorías',
          model: false,
          children: [
            { icon: 'remove', text: 'Tipos de Proyecto', url: '/project-types', permission: 'project-types.index' },
            { icon: 'remove', text: 'Tipos de Material', url: '/material-types', permission: 'material-types.index' },
            { icon: 'remove', text: 'Tipos de Ingreso', url: '/income-types', permission: 'income-types.index' },
            { icon: 'remove', text: 'Tipos de Egreso', url: '/expense-types', permission: 'expense-types.index' }
          ]
        },
        {
          icon: 'settings',
          'icon-alt': 'settings',
          text: 'Configuración',
          model: false,
          children: [
            { icon: 'remove', text: 'Personas', url: '/people', permission: 'people.index' },
            { icon: 'remove', text: 'Usuarios', url: '/users', permission: 'users.index' },
            { icon: 'remove', text: 'Perfil y Permisos', url: '/profiles', permission: 'profiles.index' }
          ]
        }
      ],
        width: 260
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
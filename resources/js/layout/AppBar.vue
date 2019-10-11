<template>
  <v-system-bar app status color="grey lighten-1">
    <v-toolbar-items class="hidden-sm-and-down">
      <v-menu
        transition="scale-transition" 
        offset-y
        open-on-hover
      >
        <template v-slot:activator="{ on }">
          <v-btn
            flat
            v-on="on"
          >
            <span class="caption">Proyectos</span>
          </v-btn>
        </template>

        <v-list dense>
          <v-list-tile router to="/projects/create">
            <v-list-tile-action>
              <v-icon>create</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Registrar Nuevo
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile router to="/projects">
            <v-list-tile-action>
              <v-icon>list_alt</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Ver Lista
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile router to="/project-types">
            <v-list-tile-action>
              <v-icon>dynamic_feed</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Tipos de Proyecto
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-menu>
      <v-menu
        transition="scale-transition" 
        offset-y
        open-on-hover
      >
        <template v-slot:activator="{ on }">
          <v-btn
            flat
            v-on="on"
          >
            <span class="caption">Materiales</span>
          </v-btn>
        </template>

        <v-list dense>
          <v-list-tile router to="/materials/create">
            <v-list-tile-action>
              <v-icon>create</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Registrar Nuevo
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile router to="/materials">
            <v-list-tile-action>
              <v-icon>list_alt</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Ver Lista
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile router to="/material-types">
            <v-list-tile-action>
              <v-icon>dynamic_feed</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Tipos de Material
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-menu>
      <v-menu
        transition="scale-transition" 
        offset-y
        open-on-hover
      >
        <template v-slot:activator="{ on }">
          <v-btn
            flat
            v-on="on"
          >
            <span class="caption">Cuentas</span>
          </v-btn>
        </template>

        <v-list dense>
          <v-list-tile router to="/accounts/create">
            <v-list-tile-action>
              <v-icon>create</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Registrar Nuevo
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile router to="/accounts">
            <v-list-tile-action>
              <v-icon>list_alt</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Ver Lista
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-menu>
      <v-menu
        transition="scale-transition" 
        offset-y
        open-on-hover
      >
        <template v-slot:activator="{ on }">
          <v-btn
            flat
            v-on="on"
          >
            <span class="caption">Ingresos</span>
          </v-btn>
        </template>

        <v-list dense>
          <v-list-tile router to="/incomes/create">
            <v-list-tile-action>
              <v-icon>create</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Registrar Nuevo
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile router to="/incomes">
            <v-list-tile-action>
              <v-icon>list_alt</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Ver Lista
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile router to="/income-types">
            <v-list-tile-action>
              <v-icon>dynamic_feed</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Tipos de Ingreso
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-menu>
      <v-menu
        transition="scale-transition" 
        offset-y
        open-on-hover
      >
        <template v-slot:activator="{ on }">
          <v-btn
            flat
            v-on="on"
          >
            <span class="caption">Egresos</span>
          </v-btn>
        </template>

        <v-list dense>
          <v-list-tile router to="/expenses/create">
            <v-list-tile-action>
              <v-icon>create</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Registrar Nuevo
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile router to="/expenses">
            <v-list-tile-action>
              <v-icon>list_alt</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Ver Lista
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile router to="/expense-types">
            <v-list-tile-action>
              <v-icon>dynamic_feed</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Tipos de Egreso
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-menu>
      <v-menu
        transition="scale-transition" 
        offset-y
        open-on-hover
      >
        <template v-slot:activator="{ on }">
          <v-btn
            flat
            v-on="on"
          >
            <span class="caption">Cajas</span>
          </v-btn>
        </template>

        <v-list dense>
          <v-list-tile router to="/boxes">
            <v-list-tile-action>
              <v-icon>money</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Caja General
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile router to="/small-boxes">
            <v-list-tile-action>
              <v-icon>money</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Caja Chica
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-menu>
      <v-btn
        flat
        router to="/reports"
      >
        <span class="caption">Reportes</span>
      </v-btn>
      <v-menu
        transition="scale-transition" 
        offset-y
        open-on-hover
      >
        <template v-slot:activator="{ on }">
          <v-btn
            flat
            v-on="on"
          >
            <span class="caption">Configuración</span>
          </v-btn>
        </template>

        <v-list dense>
          <v-list-tile router to="/people">
            <v-list-tile-action>
              <v-icon>people</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Contratistas 
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile router to="/profiles">
            <v-list-tile-action>
              <v-icon>security</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Perfiles
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-list-tile router to="/users">
            <v-list-tile-action>
              <v-icon>lock</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>
                Usuarios
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-menu>
    </v-toolbar-items>
  </v-system-bar>
</template>

<script>
  export default {
    name: 'appbar',

    data() {
      return {
      }
    },

    methods: {
    }
  }
</script>

<style scoped>
  .v-list__tile__action, .v-list__tile__avatar {
    display: flex;
    justify-content: flex-start;
    min-width: 36px;
  }
</style>
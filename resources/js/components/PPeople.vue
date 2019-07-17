<template>
  <v-layout wrap>
    <v-flex xs12 sm12 md12 lg12>
      <v-toolbar dense dark color="grey darken-1">
        <div class="title font-weight-light">PERSONAS</div>
      </v-toolbar>
      <v-data-table
        :headers="headerPeople"
        :items="people"
        :rows-per-page-items="[3,5,10]"
        class="elevation-1"
        rows-per-page-text="Items por página"
      >
        <template v-slot:items="props">
          <td>{{ props.item.name }}</td>
          <td>{{ props.item.unity }}</td>
          <td>{{ props.item.price }}</td>
        </template>
        <template slot="no-data">
          <center>Sin Datos</center>
        </template>
        <template v-slot:pageText="props">
          {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
        </template>
      </v-data-table>
    </v-flex>
  </v-layout>
</template>
<script>
  export default {
    props: {
      people: {
        type: Array
      },
    },

    data () {
      return {
        headerPeople: [
          { text: 'Nombre', value: 'nombre' },
          { text: 'Unidad', value: 'unidad' },
          { text: 'Precio', value: 'precio' },
        ]
      }
    }
  }
</script>


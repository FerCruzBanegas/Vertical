<template>
  <v-data-table
    :headers="headers"
    :items="data"
    class="elevation-1"
    rows-per-page-text="Items por página"
  >
    <template v-slot:items="props">
      <td>{{ props.item.name }}</td>
      <td>{{ props.item.surnames }}</td>
      <td>{{ props.item.phone }}</td>
      <td>
        <v-btn 
          small
          flat 
          icon class="mx-0" 
          color="red"
          @click="removeItem(props.item.id)"
        >
          <v-icon small color="red">delete</v-icon>
        </v-btn>
      </td>
    </template>
    <template slot="no-data">
      <center>Sin Datos</center>
    </template>
    <template v-slot:pageText="props">
      {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }}
    </template>
  </v-data-table>
</template>
<script>
  export default {
    props: {
      data: {
        type: Array
      }
    },

    data() {
      return {
        headers: [
          { text: 'Nombre', value: 'nombre', sortable: false },
          { text: 'Apellidos', value: 'apellidos', sortable: false },
          { text: 'Teléfono', value: 'telefono', sortable: false },
          { text: '', value: '', sortable: false, align: 'center', width: "50"}
        ]
      }
    },

    methods: {
      removeItem(id) {
        this.$emit('removeIt', id)      
      }
    }
  }
</script>
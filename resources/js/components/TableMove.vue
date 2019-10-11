<template>
  <table>
    <thead>
      <tr>
        <th scope="col">Título</th>
        <th scope="col">Fecha</th>
        <th scope="col">Pago</th>
        <th scope="col">Proyecto</th>
        <th scope="col">Monto</th>
        <th scope="col">Encargado</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(item, index) in items" :key="index">
        <td data-label="Título">{{ item.title }}</td>
        <td data-label="Fecha">{{ item.date | formatDate('DD/MM/YYYY') }}</td>
        <td data-label="Pago">{{ item.payment }}</td>
        <td data-label="Proyecto">{{ item.project }}</td>
        <td data-label="Monto">{{ item.amount | currency }}</td>
        <td data-label="Encargado">{{ item.causer.causer }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    name: 'table-move',

    props: {
      items: {
        type: Array
      }
    },

    methods: {
      close () {
        this.$store.dispatch('closeModal')
      }
    }
  }
</script>
<style scoped>
  table {
    border: 1px solid #ccc;
    border-collapse: collapse;
    margin: 0;
    padding: 0;
    width: 100%;
    table-layout: fixed;
  }

  table tr {
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    padding: .35em;
  }

  table th,
  table td {
    padding: .625em;
    text-align: center;
  }

  table th {
    font-size: .85em;
    letter-spacing: .1em;
    text-transform: uppercase;
  }

  @media screen and (max-width: 600px) {
    table {
      border: 0;
    }

    table thead {
      border: none;
      clip: rect(0 0 0 0);
      height: 1px;
      margin: -1px;
      overflow: hidden;
      padding: 0;
      position: absolute;
      width: 1px;
    }
    
    table tr {
      border-bottom: 3px solid #ddd;
      display: block;
      margin-bottom: .625em;
    }
    
    table td {
      border-bottom: 1px solid #ddd;
      display: block;
      font-size: .8em;
      text-align: right;
    }
    
    table td::before {
      content: attr(data-label);
      float: left;
      font-weight: bold;
      text-transform: uppercase;
    }
    
    table td:last-child {
      border-bottom: 0;
    }
  }
</style>
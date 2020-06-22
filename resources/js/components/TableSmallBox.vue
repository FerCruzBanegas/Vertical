<template>
  <table>
    <thead>
      <tr>
        <th scope="col">Usuario</th>
        <th scope="col">Total Monto Asignado</th>
        <th scope="col">Total Monto Gastado</th>
        <th scope="col">Saldo</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(item, index) in items" :key="index">
        <td data-label="Usuario">{{ item.user }}</td>
        <td data-label="Total Monto Asignado">{{ item.total_amount | currency }}</td>
        <td data-label="Total Monto Gastado">{{ item.used_amount | currency }}</td>
        <td data-label="Saldo">{{ (item.total_amount - item.used_amount) | currency }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    name: 'table-smallbox',

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

  table thead tr {
    background-color: #545454;
    color: #FFFFFF;
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
<template>
  <table>
    <caption>Lista de Cuentas y Montos</caption>
    <thead>
      <tr id="tr1">
        <th class="blank"></th>
        <th class="amount" colspan="2">Monto Estimado</th>
        <th class="total">Total</th>
      </tr>
      <tr id="tr2">
        <th scope="col">Cuenta</th>
        <th scope="col">Ingresos</th>
        <th scope="col">Egresos</th>
        <th scope="col">Diferencia</th>
        <th scope="col">Monto Real</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(account, index) in accounts" :key="index">
        <td class="body-2" data-label="Cuenta">{{ account.title }}</td>
        <td class="body-2" data-label="Ingresos">{{ account.incomes | currency }}</td>
        <td class="body-2" data-label="Egresos">{{ account.expenses | currency }}</td>
        <td class="body-2" data-label="Total">{{ (account.incomes - account.expenses) | currency }}</td>
        <td v-if="!show">
          <v-currency-field 
            color="grey darken-2"
            v-bind="currency_config" 
            v-model="account.cash"
          ></v-currency-field>
        </td>
        <td v-else class="body-2" data-label="Monto Real">{{ account.cash | currency }}</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <th></th>
        <th>{{ totalIncome | currency }}</th>
        <th>{{ totalExpense | currency }}</th>
        <th></th>
      </tr>
    </tfoot>
  </table>
</template>

<script>
  export default {
    props: {
      accounts: {
        type: Array
      },

      show: {
        type: Boolean
      }
    },

    data() {
      return {
        currency_config: {
          decimal: '.',
          thousands: ',',
          prefix: 'Bs ',
          suffix: '',
          precision: 2,
          masked: false,
          allowBlank: false,
          min: Number.MIN_SAFE_INTEGER,
          max: Number.MAX_SAFE_INTEGER
        }
      }
    },

    computed: {
      totalExpense () {
        let total = 0;
        this.accounts.forEach(item => {
          total = total + item.expenses
        })
        return total;
      },

      totalIncome () {
        let total = 0;
        this.accounts.forEach(item => {
          total = total + item.incomes
        })
        return total;
      }
    }
  }
</script>
<style scoped>
  table {
    border-collapse: separate;
    border-spacing: 0;
    margin: 0;
    padding: 0;
    width: 100%;
    table-layout: fixed;
  }

  table caption {
    font-size: 1.5em;
    margin: .5em 0 .75em;
  }

  tbody tr:hover {
    background-color: #F3F3F3;
  }

  th, td {
    border-right:none;
    border-bottom: 2px solid #ddd;
    background-color: #FFFFF;
    padding: .35em;
  }

  #tr1 th:last-child {
    border-top: 2px solid #ddd;
    border-right: 2px solid #ddd;
    color: #FFFFFF;
    background-color: #636363;
  }

  #tr1 th:nth-child(2) {
    border-left: 2px solid #ddd;
    border-top: 2px solid #ddd;
    color: #FFFFFF;
    background-color: #636363;
  }

  #tr2 {
    color: #FFFFFF;
    background-color: #2F426E;
  }

  #tr2 th:first-child{
    border-top: 2px solid #ddd;
    border-left: 2px solid #ddd;
  }

  #tr2 th:last-child{
    border-top: 2px solid #ddd;
    border-right: 2px solid #ddd;
  }

  tr td:first-child{
    border-left: 2px solid #ddd;
  }

  tr td:last-child{
    border-right: 2px solid #ddd;
  }

  tr td:nth-child(2){
    background-color: #CDE6FF;
  }

  tr td:nth-child(3){
    background-color: #FFF083;
  }

  tfoot tr th {
    border-bottom: none;
  }

  tfoot tr th:nth-child(2){
    color: #FFFFFF;
    background-color: #017EE7;
  }

  tfoot tr th:nth-child(3){
    color: #FFFFFF;
    background-color: #D8A504;
  }

  .blank {
    background-color: #FFFFFF;
    border: none;
  }

  .amount {
     border-top-left-radius: 25px;
  }

  .total {
     border-top-right-radius: 25px;
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

    table caption {
      font-size: 1.3em;
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
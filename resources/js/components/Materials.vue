<template>
  <v-data-table
    :headers="headers"
    :items="data"
    class="elevation-1"
    rows-per-page-text="Items por página"
  >
    <template v-slot:items="props">
      <td>{{ props.item.name }}</td>
      <td>{{ props.item.unity }}</td>
      <td class="text-xs-right">
        <v-text-field
          v-model="props.item.quantity"
          :rules="max25chars"
          @focus ="$event.target.select()"
          @keyup="isEmpty(props.item)"
          @keypress="isNumber($event)"
          single-line
          color="grey darken-2"
          reverse
        ></v-text-field>
      </td>
      <td class="text-xs-right">
        <v-currency-field 
          v-bind="currency_config" 
          v-model="props.item.price"
          :rules="max25chars"
          single-line 
          color="grey darken-2"
          reverse
        ></v-currency-field>
      </td>
      <td class="text-xs-right">{{ props.item.quantity * props.item.price | currency }}</td>
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
        max25chars: [
          v => !!v || 'Este campo es requerido',
          v => v.length <= 10 || 'Máximo 10 caracteres'
        ],
        headers: [
          { text: 'Producto', value: 'producto', sortable: false, width: "250"},
          { text: 'Unidad', value: 'unidad', sortable: false},
          { text: 'Cantidad', value: 'cantidad', sortable: false},
          { text: 'Precio Unitario', value: 'unitario', sortable: false},
          { text: 'Sub Total', value: 'total', sortable: false, align: 'center'},
          { text: '', value: '', sortable: false, align: 'center', width: "50"}
        ],
        currency_config: {
          decimal: '.',
          thousands: ',',
          prefix: '',
          suffix: '',
          precision: 2,
          masked: false,
          allowBlank: false,
          min: Number.MIN_SAFE_INTEGER,
          max: Number.MAX_SAFE_INTEGER
        }
      }
    },

    methods: {
      removeItem(id) {
        this.$emit('removeIt', id)      
      },

      isNumber(evt) {
        evt = (evt) ? evt : window.event
        let charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
          evt.preventDefault()
        } else {
          return true
        }
      },

      isEmpty(item) {
        item.quantity === "" ? item.quantity = 0 : ''
      }
    }
  }
</script>
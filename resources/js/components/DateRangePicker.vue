<template>
  <v-date-picker
    class="date-range-picker" :value="value" @input="onInput"
    color="red darken-3" event-color="red lighten-4 date-in-range" :events="selectedRange"
    :allowed-dates="allowedDates" no-title multiple locale="es-es"
  >
    <slot></slot>
  </v-date-picker>
</template>

<script>
import moment from 'moment'
export default {
  props: {
    value: {
      type: Array,
      default: () => []
    },
    allowedDates: Function
  },
  data () {
    return {
      dates: []
    }
  },
  created () {
    this.dates = this.value
  },
  watch: {
    value (val) {
      this.dates = val
    }
  },
  methods: {
    diff (a, b) {
      return a.filter(v => !b.includes(v))
    },
    onInput (val) {
      let newRange
      if (val.length > 2) {
        let newDate = this.diff(val, this.dates)[0]
        let currentRange = this.dates.sort()
        newRange = [currentRange[0], newDate]
      } else {
        newRange = val
      }
      this.dates = newRange.sort()
      this.$emit('input', this.dates)
    },
    selectedRange (date) {
      if (this.dates.length == 2) {
        return moment(date).isBetween(...this.dates)
      }
    }
  }
}
</script>

<style lang="css" scoped>
.date-range-picker >>> .v-date-picker-table__events {
  height: 32px;
  width: 32px;
  z-index: 0;
  left: -2px;
  top: -1px;
}

.date-range-picker >>> .date-in-range {
  height: 32px;
  width: 32px;
}

.date-range-picker >>> .v-btn__content {
  z-index: 1;
}
</style>
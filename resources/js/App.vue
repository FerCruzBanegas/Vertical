<template>
  <v-app light>
    <vue-snotify/>
    <router-view :key="$route.fullPath"></router-view>
    <feedback-message></feedback-message>
    <modal-income></modal-income>
    <modal-expense></modal-expense>
    <modal-smallbox></modal-smallbox>
  </v-app>
</template>

<script>
  import FeedbackMessage from './components/FeedbackMessage.vue'
  import ModalIncome from './components/ModalIncome.vue'
  import ModalExpense from './components/ModalExpense.vue'
  import ModalSmallBox from './components/ModalSmallBox.vue'
  export default {
    name: 'App',
    components: {
      'feedback-message': FeedbackMessage,
      'modal-income': ModalIncome,
      'modal-expense': ModalExpense,
      'modal-smallbox': ModalSmallBox
    }
  } 
</script>

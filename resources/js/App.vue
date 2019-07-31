<template>
  <v-app light>
  	<vue-snotify/>
    <router-view></router-view>
    <feedback-message></feedback-message>
  </v-app>
</template>

<script>
  import FeedbackMessage from './components/FeedbackMessage.vue'
  export default {
    name: 'App',
    components: {
      'feedback-message': FeedbackMessage
    }
  } 
</script>

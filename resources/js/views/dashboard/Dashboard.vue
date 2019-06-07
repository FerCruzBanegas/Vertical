<template>
  <v-content>
    <v-container fluid fill-height>
      <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4>
          <v-card class="elevation-12">
            <v-btn block large color="error" @click="getUsers">
              <v-icon>input</v-icon> INGRESAR
            </v-btn>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </v-content>
</template>

<script>
  import { UserService } from '../../services/user.service'

  export default {
    name: 'Login',
    data () {
      return {
        users: [] 
      }
    },
    methods: {
      async getUsers () {
        const users = await UserService.getUsers()
        console.log(users)
      }
    }
  }
</script>

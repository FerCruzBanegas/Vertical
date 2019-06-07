<template>
  <v-content>
    <v-container fluid fill-height>
      <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4>
          <v-card class="elevation-12">
            <v-toolbar color="grey lighten-2">
              <v-toolbar-title>Iniciar Sesión</v-toolbar-title>
              <v-spacer></v-spacer>
              <img src="/img/img.png" width="180px">
            </v-toolbar>
            <v-card-text @keyup.enter="loginSubmit">
              <v-alert 
                v-if="alert" 
                color="error"
                icon="warning" 
                outline 
                :value="true"
              >
                {{ message }}
              </v-alert>
              <v-form ref="form" lazy-validation>
                <v-text-field 
                  label="Usuario / Correo Electrónico"
                  prepend-icon="person" 
                  name="username"  
                  type="text"
                  :rules="nameRules"
                  v-model="form.username"
                ></v-text-field>
                <v-text-field 
                  label="Contraseña" 
                  prepend-icon="lock" 
                  name="password" 
                  :counter="30"
                  :append-icon="visible ? 'visibility' : 'visibility_off'"
                  @click:append="visible = !visible"
                  :type="visible ? 'password' : 'text'"
                  :rules="passwordRules"
                  v-model="form.password"
                ></v-text-field>
                <v-checkbox
                  label="Recuérdame"
                  color="error"
                  type="checkbox"
                  v-model="remember"
                  value="true"
                ></v-checkbox>
                <v-btn block large color="error" @click="loginSubmit" :disabled="!busy">
                  <div v-show="busy"><v-icon>input</v-icon> INGRESAR</div>
                  <v-progress-circular v-show="!busy" indeterminate :width="5"></v-progress-circular> 
                </v-btn>
              </v-form>
            </v-card-text>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </v-content>
</template>

<script>
  export default {
    name: 'Login',
    data () {
      return {
        form: {
          username: '',
          password: ''
        },
        visible: true,
        remember: false,
        busy: true,
        alert: false,
        nameRules: [
          (v) => !!v || 'El usuario es requerido',
          (v) => v && v.length <= 50 || 'usuario debe tener menos de 10 caracteres'
        ],
        passwordRules: [
          (v) => !!v || 'La contraseña es requerida',
          (v) => v && v.length <= 30 || 'contraseña debe tener menos de 30 caracteres'
        ],
        message: ''
      }
    },
    methods: {
      async loginSubmit () {
        const auth = await this.$store.dispatch('login', this.form)
        if (auth) {
          this.$router.push({ name: 'home' })
        }
      }
    }
  }
</script>

<template>
  <v-content>
    <v-container fluid fill-height>
      <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4>
          <v-card class="elevation-12">
            <v-toolbar color="grey lighten-2">
              <v-toolbar-title>Iniciar Sesión</v-toolbar-title>
              <v-spacer></v-spacer>
              <img src="/img/logo2.png" width="40px">
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
              <v-form ref="form">
                <v-text-field
                  color="grey darken-2"
                  label="Usuario / Correo Electrónico"
                  prepend-icon="person" 
                  name="username"  
                  v-model="form.username"
                  data-vv-name="username"
                  data-vv-as="usuario"
                  v-validate="'required'"
                  :error-messages="errors.collect('username')"
                  clearable
                ></v-text-field>
                <v-text-field 
                  color="grey darken-2"
                  label="Contraseña" 
                  prepend-icon="lock" 
                  name="password" 
                  :append-icon="visible ? 'visibility' : 'visibility_off'"
                  @click:append="visible = !visible"
                  :type="visible ? 'password' : 'text'"
                  v-model="form.password"
                  data-vv-name="password"
                  data-vv-as="contraseña"
                  v-validate="'required'"
                  :error-messages="errors.collect('password')"
                  clearable
                ></v-text-field>
                <v-checkbox
                  label="Recuérdame"
                  color="error"
                  type="checkbox"
                  v-model="remember"
                  value="true"
                ></v-checkbox>
                <v-btn block large color="error" @click="loginSubmit" :disabled="busy">
                  <div v-show="!busy"><v-icon>input</v-icon> INGRESAR</div>
                  <v-progress-circular v-show="busy" indeterminate :width="5"></v-progress-circular>
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
    $_veeValidate: {
      validator: 'new'
    },

    name: 'Login',
    data () {
      return {
        form: {
          username: '',
          password: ''
        },
        visible: true,
        remember: false,
        busy: false,
        alert: false,
        message: ''
      }
    },
    methods: {
      async loginSubmit () {
        this.$validator.errors.clear();
        this.alert = false
        this.busy = true
        try {
          const auth = await this.$store.dispatch('login', this.form)
          if (auth) {
            this.$router.push({ name: 'Home' })
          }
        } catch (err) {
          this.alert = true
          this.message = err.response.data.message
          this.$setErrorsFromResponse(err.response.data);
          this.busy = false
        }
      }
    }
  }
</script>

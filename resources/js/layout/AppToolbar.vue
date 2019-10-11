<template>
  <v-toolbar
    color="grey lighten-5"  
    clipped-left 
    app
    dense
    :clipped-left="clipped"
  >
    <v-toolbar-side-icon @click.stop="toggleDrawer"></v-toolbar-side-icon>
    
    <v-spacer></v-spacer>
      <div id="clock">
        <div class="font-weight-bold">{{ date }}</div>
        <div class="title">{{ time }}</div>
      </div>
    <!-- <v-toolbar-title class="white--text" v-if="currentUser" v-text="currentUser.name"></v-toolbar-title> -->
    <v-menu transition="scale-transition" offset-y>
      <v-btn outline slot="activator" v-if="currentUser"><v-icon left>perm_identity</v-icon>{{ currentUser.name }}</v-btn>
      <v-list dense>
        <v-list-tile @click="redirect">
          <v-list-tile-action>
            <v-icon>account_box</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>
              Perfil
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile @click="logout">
          <v-list-tile-action>
            <v-icon>exit_to_app</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>
              Cerrar sesión
            </v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-menu>
  </v-toolbar>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    name: 'apptoolbar',

    props: {
      drawer: {
        type: Boolean,
        required: true
      },
      miniVariant: {
        type: Boolean,
        required: true
      }
    },

    data() {
      return {
        clipped: false,
        loader: false,
        menu: false,
        flat: false,
        empty: false,
        items: [],
        time: '',
        date: '',
        week: ['DOM', 'LUN', 'MAR', 'MIÉ', 'JUE', 'VIE', 'SAB']
      }
    },

    computed: {
      ...mapGetters([
        'currentUser',
        'authenticated'
      ])
    },

    mounted() {
      let timerID = setInterval(this.updateTime, 1000);
      this.updateTime();
    },

    methods: {
      updateTime() {
          let cd = new Date();
          this.time = this.zeroPadding(cd.getHours(), 2) + ':' + this.zeroPadding(cd.getMinutes(), 2) + ':' + this.zeroPadding(cd.getSeconds(), 2);
          this.date =  this.zeroPadding(cd.getDate(), 2) + '/' + this.zeroPadding(cd.getMonth()+1, 2) + '/' + this.zeroPadding(cd.getFullYear(), 4) + ' ' + this.week[cd.getDay()];
      },

      zeroPadding(num, digit) {
          let zero = '';
          for(let i = 0; i < digit; i++) {
              zero += '0';
          }
          return (zero + num).slice(-digit);
      },

      redirect() {
        this.$router.push({ name: 'UserProfile' })
      },

      async logout() {
        const response = await this.$store.dispatch('logout')
        if (response) this.$router.push({ name: 'Login' })
      },

      toggleDrawer () {
        this.$emit('toggleDrawer')
      },

      toggleMiniVariant () {
        this.$emit('toggleMiniVariant')
      }
    }
  }
</script>

<style scoped>
  >>>.v-badge__badge {
    top: -20px;
    right: -15px;
  }

  .v-list__tile__action, .v-list__tile__avatar {
    display: flex;
    justify-content: flex-start;
    min-width: 36px;
  }

  #clock {
    text-align: center;
    margin-right: 2em;
  }
</style>
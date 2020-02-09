<template>
   <div class="bg">
  <b-container>
    <b-form-row class="text-center">
      <b-col cols="4" offset="4" class="box" style="margin-top: 70px;">
        <b-form-input v-model="username"  style="margin-top: 30px;"  placeholder="Unesite korisnicko ime"></b-form-input>
        <b-form-input type="password" v-model="password" style="margin-top: 30px;"  placeholder="Unesite sifru"></b-form-input>
        <b-button @click="onLogin()" variant="success" style="margin-top: 10px;">Login</b-button>
      </b-col>
    </b-form-row>
  </b-container>
   </div>
</template>

<style>
.box {
  border-style: solid;
  padding-top: 30px;
  background-color: #2e86c1;
  border-width: 4px;
  padding-bottom: 50px;
}
body, html {
    height: 100%;
  }
.bg {
     /* The image used */
    background-image: url("https://i.ibb.co/yV7YFM5/pozadina2.jpg");

    /* Full height */
    height: 100%;

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    margin-top: -3px;
    padding-bottom: 290px;
    padding-bottom: 290px;
  }
</style>

<script>
export default {
  props: {
    data: Object
  },
  data () {
    return {
      username: '',
      password: ''
    }
  },
  methods: {
    onLogin () {
      // eslint-disable-next-line camelcase
      const json_podaci = { username: this.username, password: this.password }
      this.$http.post(`http://localhost:80/backend/login`,
        json_podaci, { withCredentials: false }).then(response => {
        console.log(response)
        // alert(response.data.poruka)
        if (response.data.poruka === 'Pogrešno korisničko ime ili lozinka!') {
          alert(response.data.poruka)
        } else {
          window.user = response.data.poruka
          this.$router.push('/home')
        }
      })
    }
  }
}
</script>

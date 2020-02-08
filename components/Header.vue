<template>
<div id="nav">
  <b-navbar type="dark" variant="dark">
    <b-navbar-nav>
      <b-nav-item to="/home">Početna</b-nav-item>
      <b-nav-item to="/reservation">Moje rezervacije</b-nav-item>
      <b-nav-item to="/add">Dodaj film</b-nav-item>
       <b-nav-item @click="onLogout()" style="margin-left: 950px;">Logout</b-nav-item>
    </b-navbar-nav>
  </b-navbar>
    </div>
</template>

<script>
export default {
  data () {
    return {
      role: ''
    }
  },
  methods: {
    onLogout () {
      this.$router.push('/login')
      window.user = null
    }
  }
}
</script>

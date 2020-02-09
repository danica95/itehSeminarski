<template>
  <div class="page">
    <Header></Header>
     <div>
    <b-table  striped hover :items="items"></b-table>
    <b-button @click="onSort()" variant="primary" >Sortiraj</b-button>
  </div>
  </div>
</template>

<style>
  .page {
    background-color:#99a3a4;
     padding-bottom: 306px;
  }
</style>

<script>
import Header from '../components/Header.vue'
export default {
  components: {
    Header
  },
  data () {
    return {
      reservations: [],
      items: []
    }
  },
  mounted: function () {
    this.$http.get(`http://localhost:80/backend/getReservations/${window.user.id}`, { withCredentials: false }).then(
      (response) => {
        console.log(response.data)
        this.reservations = response.data
        for (let i = 0; i < this.reservations.length; i++) {
          this.items.push({ naziv_filma: this.reservations[i].naziv, datum: this.reservations[i].datum, broj_karata: this.reservations[i].brojKarata })
        }
      })
  },
  methods: {
    onSort () {
      this.$http.get(`http://localhost:80/backend/reservationSort/${window.user.id}`, { withCredentials: false }).then(
        (response) => {
          console.log(response.data)
          this.items = []
          this.reservations = response.data
          for (let i = 0; i < this.reservations.length; i++) {
            this.items.push({ naziv_filma: this.reservations[i].naziv, datum: this.reservations[i].datum, broj_karata: this.reservations[i].brojKarata })
          }
        })
    }
  }
}
</script>

<template>
<div class="movies">
  <b-card no-body class="overflow-hidden" style="max-width: 250px;max-height:550px;">
    <b-row no-gutters style="background-color:#353A40 ">
      <b-col md="12">
        <b-card-img :src="movie.url" class="rounded-0"></b-card-img>
      </b-col>
         <b-col md="12">
        <b-card-body >
          <b-card-text>
              <span style="color:#868D93"><h4>{{movie.naziv}}</h4> </span>
              <span style="color:#868D93">Datum: {{movie.datum}}</span>
              <br>
               <span style="color:#868D93">Vreme: {{movie.vreme}}h</span>
          </b-card-text>
          <b-button @click="reservationTicket()" href="#" variant="primary" style="margin-left: 5px; margin-top:10px;">Više informacija</b-button>
        </b-card-body>
      </b-col>
    </b-row>
  </b-card>
</div>
</template>

<style>
.movies{
    padding-top: 5px; padding-right:10px; margin-right:10px;
}
</style>

<script>
export default {
  props: {
    movie: Object
  },
  methods: {
    reservationTicket () {
      this.$router.push({ path: 'ticket', query: { id: this.movie.id } })
    }
  }
}
</script>

<template>
    <div class="bg2">
        <Header></Header>
        <h1 class="title">{{movie.naziv}}</h1>
        <b-row>
            <b-col cols="4" offset="1">
             <div>
        <b-card no-body class="overflow-hidden" style="max-width: 540px;background-color: #99a3a4;  border-width: 0px;">
            <b-row no-gutters>
            <b-col md="6">
                     <b-card-img v-if="movie.url != null" :src="movie.url"></b-card-img>
                       <h5>Broj karata: </h5>
                       <h5 style="margin-top:3px;">{{movie.brojKarata}}</h5>
                     <b-input v-model="cards"  style="margin-top:10px;margin-left:60px; max-width:99px;"></b-input>
                     <b-button @click="onReservation()" style="margin-top:10px;" variant="primary">Rezerviši</b-button>
            </b-col>
            <b-col md="6">
                 <b-card-body>
                    <b-card-text>
                        <h5>Žanr: {{movie.zanr}}</h5>
                        <h5>Godina: {{movie.godina}}</h5>
                        <h5>Reziser: {{movie.ime}} {{movie.prezime}}</h5>
                        <h5>Trajanje: {{movie.trajanje}} min</h5>
                    </b-card-text>
        </b-card-body>
            </b-col>
            </b-row>
        </b-card>
</div>
            </b-col>
            <b-col cols="4" offset="2">
                    <h4>Opis: </h4>
                    <span>{{movie.opis}}</span>
                    <br>
                    <b-button  variant="primary"  @click="onTrailer()">Trailer</b-button>
            </b-col>
        </b-row>
    </div>
</template>

<style>
.bg2 {
     /* The image used */
   background-color: #99a3a4;

    /* Full height */
    height: 100%;

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    margin-top: -1px;
    padding-bottom: 29px;
  }
.bg3{
    margin-top: -20px;
  }
 .title{
     background-color: #2980B9;
     margin: 40px 80px 15px 80px ;
 }
 .image{
     margin-top: 0%;

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
      movie: Object,
      cards: '',
      numberOfCards: HTMLElement
    }
  },
  created: function () {
    console.log(this.$route.query.id)
    const id = this.$route.query.id
    const url = `http://localhost:80/backend/movie/${id}`
    console.log(url)
    this.$http.get(url, { withCredentials: false }).then(
      (response) => {
        // console.log(response.data)
        this.movie = response.data
      })
  },
  methods: {
    onTrailer () {
      window.open(`${this.movie.trailer}`, '_blank')
    },
    onReservation () {
      if ((this.movie.brojKarata - this.cards) >= 0) {
        // eslint-disable-next-line camelcase
        const json_podaci = { cards: this.movie.brojKarata - this.cards, userId: window.user.id, date: this.movie.datum, resCards: this.cards }
        this.$http.post(`http://localhost:80/backend/reservation/${this.movie.id}`,
          json_podaci, { withCredentials: false }).then(response => {
          console.log(response)
          alert(response.data.poruka)
          this.movie.brojKarata -= this.cards
          this.cards = ''
        })
      } else {
        alert('Nema dovoljno karata. Pokusajte ponovo!')
      }
    }
  }
}
</script>

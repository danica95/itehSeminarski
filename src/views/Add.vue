<template >
<form id="form">
     <div class="bg3">
        <Header></Header>
          <b-container fluid class="cont">
          <b-row class="my-1">
            <b-col cols="2">
              <label style="margin-left:115px;" for="naziv">Naziv: </label>
            </b-col>
            <b-col cols="6" offset="0">
              <b-form-input v-model="naziv"  style="background-color: #353A40; -webkit-text-fill-color: yellow;margin-left:112px;" id="naziv" type="text"></b-form-input>
              </b-col>
             <b-col cols="2">
               <b-button @click="onGetMovie()" style="margin-left:70px;" variant="primary">Pretraži</b-button>
            </b-col>
            <b-col cols="2">
               <b-button  style="margin-left:-180px;" variant="success">Resetuj</b-button>
            </b-col>
          </b-row>
            <b-row class="my-1">
            <b-col sm="3">
              <label  for="zanr">Zanr: </label>
            </b-col>
            <b-col cols="6" offset="0">
              <b-form-input v-model="zanr" style="background-color: #353A40; -webkit-text-fill-color: yellow" id="zanr" type="text"></b-form-input>
            </b-col>
          </b-row>
            <b-row class="my-1">
            <b-col sm="3">
              <label  for="godina">Godina: </label>
            </b-col>
            <b-col cols="6" offset="0">
              <b-form-input v-model="godina" style="background-color: #353A40; -webkit-text-fill-color: yellow" id="godina" type="number"></b-form-input>
            </b-col>
          </b-row>
            <b-row class="my-1">
            <b-col sm="3">
              <label  for="trajanje">Trajanje: </label>
            </b-col>
            <b-col cols="6" offset="0">
              <b-form-input v-model="trajanje" style="background-color: #353A40; -webkit-text-fill-color: yellow" id="trajanje" type="number"></b-form-input>
            </b-col>
          </b-row>
            <b-row class="my-1">
            <b-col sm="3">
              <label  for="trailer">Trailer: </label>
            </b-col>
            <b-col cols="6" offset="0">
              <b-form-input v-model="trailer" style="background-color: #353A40; -webkit-text-fill-color: yellow" id="trailer" type="text"></b-form-input>
            </b-col>
          </b-row>
            <b-row class="my-1">
            <b-col sm="3">
              <label  for="datum">Datum: </label>
            </b-col>
            <b-col cols="6" offset="0">
              <b-form-input v-model="datum" style="background-color: #353A40; -webkit-text-fill-color: yellow" id="datum" type="date"></b-form-input>
            </b-col>
          </b-row>
            <b-row class="my-1">
            <b-col sm="3">
              <label  for="vreme">Vreme: </label>
            </b-col>
            <b-col cols="6" offset="0">
              <b-form-input v-model="vreme" style="background-color: #353A40; -webkit-text-fill-color: yellow" id="vreme" type="text"></b-form-input>
            </b-col>
          </b-row>
            <b-row class="my-1">
            <b-col sm="3">
              <label  for="reziser">Reziser: </label>
            </b-col>
            <b-col cols="6" offset="0">
              <b-form-input v-model="reziser" style="background-color: #353A40; -webkit-text-fill-color: yellow" id="reziser" type="number"></b-form-input>
            </b-col>
          </b-row>
            <b-row class="my-1">
            <b-col sm="3">
              <label  for="brojKarata">Broj karata</label>
            </b-col>
            <b-col cols="6" offset="0">
              <b-form-input v-model="brojKarata" style="background-color: #353A40; -webkit-text-fill-color: yellow" id="brojKarata" type="number"></b-form-input>
            </b-col>
          </b-row>
            <b-row class="my-1">
            <b-col sm="3">
              <label  for="url">URL: </label>
            </b-col>
            <b-col cols="6" offset="0">
              <b-form-input v-model="url" style="background-color: #353A40; -webkit-text-fill-color: yellow" id="url" type="text"></b-form-input>
            </b-col>
          </b-row>
          <b-row>
             <b-col sm="3">
              <label for="textarea-row">Opis:</label>
            </b-col>
            <b-col cols="6" offset="0">
              <div>
                <b-form-textarea v-model="opis"
                style="background-color: #353A40;-webkit-text-fill-color: yellow"
                  id="textarea-rows"
                ></b-form-textarea>
              </div>
            </b-col>
          </b-row>
          <b-row>
             <b-col cols="3" offset="5">
                <b-button @click="onDeleteMovie()" v-if="obrisiVisible" style="margin-top:20px;margin-right:-250px;" variant="danger">Obriši</b-button>
            </b-col>
            <b-col cols="3" offset="0" >
                <b-button @click="onAddMovie()" style="margin-top:20px;margin-left:-220px;" variant="primary">Potvrdi</b-button>
            </b-col>
          </b-row>
  </b-container>
     </div>
</form>
</template>

<style>
.bg3 {
     /* The image used */
   background-color: #99a3a4;

    /* Full height */
    height: 100%;

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    margin-top: -1px;
    padding-bottom: 22px;
    padding-right: -300px;
  }
  .cont {
    margin-top: 50px;
    margin-right:-300px;
    margin-left:300px;
  }
  .input[type="text"]{

  background-color : white;

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
      id: '',
      naziv: '',
      url: '',
      zanr: '',
      godina: '',
      zemlja: '',
      trajanje: '',
      trailer: '',
      datum: '',
      vreme: '',
      opis: '',
      reziser: '',
      brojKarata: '',
      obrisiVisible: false
    }
  },
  methods: {
    onAddMovie () {
      // eslint-disable-next-line camelcase
      const json_podaci = { naziv: this.naziv, zanr: this.zanr, godina: this.godina, trajanje: this.trajanje, trailer: this.trailer, datum: this.datum, vreme: this.vreme, opis: this.opis, reziser: this.reziser, brojKarata: this.brojKarata, url: this.url }
      if (this.id === '') {
        this.$http.post(`http://localhost:80/backend/addMovie`,
          json_podaci, { withCredentials: false }).then(response => {
          console.log(response)
        })
      } else {
        console.log('uslo2')
        this.$http.put(`http://localhost:80/backend/updateMovie/${this.id}`,
          json_podaci, { withCredentials: false }).then(response => {
          alert(response.data.poruka)
        })
      }
      let form = document.querySelector('form')
      form.reset()
    },
    onGetMovie () {
      this.$http.get(`http://localhost:80/backend/getMovie/${this.naziv}`, { withCredentials: false }).then(
        (response) => {
          if (!Object.keys(response.data).includes('poruka')) {
            console.log(response.data)
            this.id = response.data.id
            this.naziv = response.data.naziv
            this.url = response.data.url
            this.zanr = response.data.zanr
            this.godina = response.data.godina
            this.zemlja = response.data.zemlja
            this.trajanje = response.data.trajanje
            this.trailer = response.data.trailer
            this.datum = response.data.datum
            this.vreme = response.data.vreme
            this.opis = response.data.opis
            this.reziser = response.data.reziser
            this.brojKarata = response.data.brojKarata
            this.obrisiVisible = true
            this.resetujVisible = true
          } else {
            alert('Traženi film nije pronađen!')
          }
        })
    },
    onDeleteMovie () {
      this.$http.delete(`http://localhost:80/backend/deleteMovie/${this.id}`, { withCredentials: false }).then(
        (response) => {
          alert(response.data.poruka)
          console.log(response.data)
          let form = document.querySelector('form')
          form.reset()
          this.obrisiVisible = false
        })
    }
  }
}
</script>

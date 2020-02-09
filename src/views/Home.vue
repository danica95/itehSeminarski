<template>
  <div style="background-color:#99a3a4">
    <Header></Header>
    <div>
      <b-row>
        <b-col cols="3" offset="0" v-for="movie in movies" v-bind:key="movie.id">
            <Movie :movie="movie"></Movie>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import Movie from '../components/Movie.vue'
import Header from '../components/Header.vue'

export default {
  name: 'home',
  components: {
    Movie,
    Header
  },
  data () {
    return {
      movies: []
    }
  },
  mounted: function () {
    this.$http.get('http://localhost:80/backend/movies.json', { withCredentials: false }).then(
      (response) => {
        console.log(response.data)
        this.movies = response.data
      })
  }

}
</script>

<template>
  <div class="row">
    <div class="col s12 m6 offset-m3">
      <h3>Movie App</h3>
    </div>
    <MovieCreate :movieId="movieId" v-on:reloadMovies="reloadMovieComponent"></MovieCreate>
    <MovieList :reloadMovies="reloadMovies" v-on:updateMovie="getMovie"></MovieList>
  </div>
</template>

<script>
import MovieList from "./movie/MovieList";
import MovieCreate from "./movie/MovieCreate";

export default {
  data() {
    return {
      movieId: 0,
      reloadMovies: false,
    };
  },
  components: {
    MovieList,
    MovieCreate,
  },
  methods: {
    getMovie(id) {
      this.movieId = id;
    },
    reloadMovieComponent(val) {
      this.reloadMovies = val;
    },
  },
};
</script>

<style lang="scss">
</style>

<template>
  <div class="col s12">
    <div class="card blue-grey darken-1">
      <div class="card-content white-text">
        <span class="card-title">
          <h5>Movie List</h5>
        </span>
        <table>
          <thead>
            <tr>
              <th>Title</th>
              <th>Release Date</th>
              <th>Duration</th>
              <th>Genre</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="movie in movies" :key="movie.id">
              <td>{{ movie.title }}</td>
              <td>{{ movie.release_date }}</td>
              <td>{{ movie.duration }}h</td>
              <td>{{ movie.genre }}</td>
              <td>
                <button @click="updateMovie(movie.id)" class="btn">
                  <i class="material-icons">edit</i>
                </button>
                <button @click="deleteMovie(movie.id)" class="btn red">
                  <i class="material-icons">delete</i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="card-action">
        <button
          class="btn"
          @click="loadMovies(pagination.prev_page_url)"
          :class="[{disabled: !pagination.prev_page_url}]"
        >Prev</button>
        <button class="btn" disabled>Page {{ pagination.current_page}} of {{ pagination.last_page}}</button>
        <button
          class="btn"
          @click="loadMovies(pagination.next_page_url)"
          :class="[{disabled: !pagination.next_page_url}]"
        >Next</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    reloadMovies: Boolean,
  },
  data() {
    return {
      movies: [],
      pagination: {},
      movie_id: "",
      edit: false,
    };
  },
  watch: {
    reloadMovies: function (id) {
      if (id !== 0) {
        this.loadMovies();

        this.$emit("reloadMovies", false);
      }
    },
  },
  created() {
    this.loadMovies();
  },
  methods: {
    loadMovies(page_url) {
      let vm = this;

      page_url = page_url || "/api/movies";

      fetch(page_url)
        .then((res) => res.json())
        .then((res) => {
          this.movies = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch((err) => console.log(err));
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev,
      };

      this.pagination = pagination;
    },
    deleteMovie(id) {
      if (confirm("Are you sure?")) {
        fetch(`api/movie/${id}`, {
          method: "delete",
        })
          .then((res) => res.json())
          .then((data) => {
            alert("Movie removed.");
            this.loadMovies();
          })
          .catch((err) => console.log(error));
      }
    },
    updateMovie(id) {
      this.$emit("updateMovie", id);
    },
  },
};
</script>

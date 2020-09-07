<template>
  <div class="col s12">
    <div class="card blue-grey darken-1 white-text">
      <div class="card-content">
        <span class="card-title">
          <h5>Movie Information</h5>
        </span>
        <form action>
          <div class="row">
            <div class="input-field col s12">
              <input type="text" hidden v-model="movie.id" />
              <input placeholder="Title" type="text" id="title" v-model="movie.title" />
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <datepicker
                placeholder="Relase Date"
                style="color: #000000"
                name="release_date"
                :format="date_format"
                :value="movie.release_date"
                v-model="movie.release_date"
              ></datepicker>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input
                placeholder="Movie Duration"
                type="text"
                id="duration"
                v-model="movie.duration"
              />
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input placeholder="Movie Genre" type="text" id="genre" v-model="movie.genre" />
            </div>
          </div>
        </form>
      </div>
      <div class="card-action">
        <a href="#" v-if="btnAdd" class="btn" @click="addMovie()">Add Movie Info</a>
        <a href="#" v-if="btnUpdate" class="btn" @click="udpateMovie(movie.id)">Update Movie Info</a>
        <a href="#" v-if="btnCancel" class="btn" @click="cancelled()">Cancel</a>
      </div>
    </div>
  </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";

export default {
  components: {
    Datepicker,
  },
  props: {
    movieId: Number,
  },
  data() {
    return {
      movie: {
        id: "",
        title: "",
        release_date: "",
        duration: "",
        genre: "",
      },
      date_format: "M/d/yyyy",
      btnAdd: true,
      btnUpdate: false,
      btnCancel: false,
    };
  },
  watch: {
    movieId: function (id) {
      if (id.length !== 0) {
        this.fetchMovie(id);
      }
    },
    "movie.release_date": function (date) {
      if (date instanceof Date) {
        console.log(date);
        let dd = String(date.getDate()).padStart(1);
        let mm = String(date.getMonth() + 1).padStart(2, "0"); //January is 0!
        let yyyy = date.getFullYear();

        let formattedDate = mm + "/" + dd + "/" + yyyy;
        this.movie.release_date = formattedDate;
      }
    },
    "movie.duration": function (data) {
      if (isNaN(data)) {
        confirm("Duration can only be a number or decimal");
        this.movie.duration = "";
      }
    },
  },
  methods: {
    fetchMovie(id) {
      fetch(`api/movie/${id}`)
        .then((res) => res.json())
        .then((res) => {
          console.log(res.data);
          this.movie.id = res.data.id;
          this.movie.title = res.data.title;
          this.movie.duration = res.data.duration;
          this.movie.release_date = res.data.release_date;
          this.movie.genre = res.data.genre;

          this.btnUpdate = true;
          this.btnAdd = false;
          this.btnCancel = true;
        })
        .catch((err) => console.log(err));
    },
    cancelled() {
      this.movie.id = "";
      this.movie.title = "";
      this.movie.duration = "";
      this.movie.release_date = "";
      this.movie.genre = "";

      this.btnUpdate = false;
      this.btnAdd = true;
      this.btnCancel = false;
    },
    udpateMovie(id) {
      let self = this;
      fetch("api/movie", {
        method: "PUT",
        body: JSON.stringify(this.movie),
        headers: {
          "content-type": "application/json",
        },
      })
        .then((res) => res.json())
        .then((data) => {
          if (confirm("Successfully Updated Movie Information.")) {
            self.$emit("reloadMovies", true);
            self.cancelled();
          }

          // location.reload();
        })
        .catch((err) => console.log(err));
    },
    addMovie() {
      console.log(this.checkProperties(this.movie));
      //   fetch("api/movie", {
      //     method: "POST",
      //     body: JSON.stringify(this.movie),
      //     headers: {
      //       "content-type": "application/json",
      //     },
      //   })
      //     .then((res) => res.json())
      //     .then((data) => {
      //       if (confirm("Successfully Added Movie Information.")) {
      //         self.$emit("reloadMovies", true);
      //         self.cancelled();
      //       }
      //     })
      //     .catch((err) => console.log(err));
    },
  },
};
</script>

<style lang="scss">
input {
  background: #fff !important;
  padding: 0 10px !important;
  color: rgba(0, 0, 0, 0.42);
}

input::placeholder {
  color: #ccc !important;
}
</style>

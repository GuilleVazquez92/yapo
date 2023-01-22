<template>

  <Head title="Search" />

  <breeze-authenticated-layout>
    <div class="card my-4 shadow-sm">
      <div class="card-body container">
        <h4 v-if="favourite.artistName"> <b>Su musica Favorita es : </b> {{ favourite.trackName }} <br> <b>Artista :</b> {{
          favourite.artistName
        }}</h4>
        <h4 v-else>No selecciono su Música favorita</h4>
      </div>
    </div>
    <template #header>
      <h2 class="h4 font-weight-bold">
        Search
      </h2>
    </template>

    <div class="card my-4 shadow-sm">
      <div class="card-body container">
        <div class="input-group row ">
          <form @submit.prevent="submit">
            <div class="col-md-5">
              <input type="search" class="form-control rounded" placeholder="Band" aria-label="Search"
                aria-describedby="search-addon" id="band" v-model="form.band" />
            </div><br>
            <div class="col-md-5">
              <button type="button" class="btn btn-primary" v-on:click="search()">Search</button>
            </div>
          </form>
        </div> <br>

        <div class="row col-md-12 table-responsive  " align="center">
          <table class="table">
            <thead class="table-primary">
              <tr>
                <th scope="col">Artista</th>
                <th scope="col">Canción</th>
                <th scope="col">Album</th>
                <th scope="col">Preview</th>
                <th scope="col">Precio</th>
                <th scope="col">Fecha</th>
                <th scope="col">Favorito</th>
              </tr>
            </thead>
            <tbody>
              {{ infos.data }}
              <tr v-for="info in infos" :key="info.trackId" class="col-md-12">
                <th>{{ info.artistName }}</th>
                <th>{{ info.trackName }}</th>
                <td><img :src="info.image" alt=""> {{ info.collectionName }} </td>
                <td><audio :src="info.previewUrl" controls="controls" preload="none"></audio></td>
                <td>{{ info.price.amount }} - {{ info.price.currency }}</td>
                <td>{{ info.releaseDate }}</td>
                <td v-if="favourite.trackId === info.trackId"><button type="button" class="btn btn-primary"
                    v-on:click="fav(info.artistName, info.trackId, $page.props.auth.user.name, info.trackName)">Si</button>
                </td>
                <td v-else><button type="button" class="btn btn-warning"
                    v-on:click="fav(info.artistName, info.trackId, $page.props.auth.user.name, info.trackName)">No</button>
                </td>

              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>


  </breeze-authenticated-layout>
</template>

<script>

import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
  },

  data() {
    return {
      form: this.$inertia.form({
        band: '',
      }),
      infos: '',
      favourite: '',
    }

  },
  methods: {
    search() {
      axios.get('http://127.0.0.1:8000/api/search_tracks?name=' + band.value)
        .then((res) => {
          this.infos = res.data.track

        })
        .catch((error) => {
          console.error(error)
        })
    },

    fav(artistName, trackId, user, trackName) {
      axios.post('http://127.0.0.1:8000/api/fav', {
        "artistName": artistName,
        "trackId": trackId,
        "trackName": trackName,
        "user": user,
      })
        .then((res) => {
          this.favourite = res.data;
        })
        .catch((error) => {
          console.error(error)
        })

    }


  },

  mounted() {

  }
}
</script>
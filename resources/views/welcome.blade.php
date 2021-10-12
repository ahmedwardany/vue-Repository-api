<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Repositories</title>

        <!-- Fonts -->
        <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap/dist/css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.22/vue.js"></script>
<script src="//unpkg.com/babel-polyfill@latest/dist/polyfill.min.js"></script>
<script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.js"></script>


        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }


        </style>
    </head>
    <body>
        <div id="app">
            <div style="text-align: center">
                <b-button v-on:click="ten" variant="primary">10</b-button>
                <b-button v-on:click="fifty" variant="primary">50</b-button>
                <b-button v-on:click="hundred" variant="primary">100</b-button>
            </div>
            <div class="row" style="margin: auto;width: 500px;padding: 10px 0">
                <p class="col-sm-6">Search by language :</p>
                <input style="width: 200px;margin: auto" type="text" @input="searchLanguage($event)" class="form-control col-sm-6" >
            </div>
            <b-table striped hover :items="items" :fields="fields" :current-page="currentPage" :per-page="0"></b-table>
            <b-pagination size="md" :total-rows="totalItems" v-model="currentPage" :per-page="perPage"></b-pagination>
        </div>
    </body>
</html>



<script>
    new Vue({
  el: '#app',
  data() {
    return {
      items: [],
      fields: [
        {
          key: 'id',
          label: 'ID'
        },
        {
          key: 'name',
          label: 'Name'
        },
        {
          key: 'full_name',
          label: 'Full Name'
        },
        {
          key: 'created_at',
          label: 'Created At'
        },
        {
          key: 'language',
          label: 'Language'
        },
        {
          key: 'node_id',
          label: 'Node ID'
        }
      ],
      currentPage: 0,
      perPage: 10,
      totalItems: 0,
      attribute: 'created',
      search: '>2019-01-10',
    }
  },
  mounted() {
    this.fetchData().catch(error => {
      console.error(error)
    })
  },
  methods: {
    async fetchData() {
      this.items = await fetch(`https://api.github.com/search/repositories?q=${this.attribute}:${this.search}&sort=stars&order=desc&page=${this.currentPage}&per_page=${this.perPage}`, {
  method: 'GET',
  headers: {
    'User-Agent': 'request'
  },
  })
        .then(res => {
            if (res.status == 403) {
                alert("reached requests limit for the api kindly check in a seconds");
            }
          this.totalItems = 28332524 ;
          return res.json()
        })
        .then(items => items.items)
    },
    ten: function (event) {
        this.perPage = 10;
        this.fetchData();
    },
    fifty: function (event) {
        this.perPage = 50;
        this.fetchData();
    },
    hundred: function (event) {
        this.perPage = 100;
        this.fetchData();
    },
    searchLanguage: function (event) {
        this.attribute = 'language';
        this.search = event.target.value;
        if (event.target.value === "") {
            this.attribute = 'created';
            this.search = '>2019-01-10';
        }
        this.fetchData();
    },

  },
  watch: {
    currentPage: {
      handler: function(value) {
        this.fetchData().catch(error => {
          console.error(error)
        })
      }
    }
  }
})


</script>

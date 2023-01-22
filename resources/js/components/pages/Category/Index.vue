<template>
    <div>
      <v-data-table
        :headers="headers"
        :items="category"
        :items-per-page="5"
        class="mt-10"
      ></v-data-table>

      <snackbar 
        :show="snackbarShow"
        :message="message"
      />
    </div>
  </template>
  
  <script>
  import Snackbar from '../../templates/Snackbar.vue'

  export default {
    name: "Category",
    components: {
      Snackbar,
    },
    data () {
      return {
        toggle_exclusive: 1,
        headers: [
          {
            text: 'Category',
            align: 'start',
            sortable: false,
            value: 'category',
          },
        ],
        category: [],
        message: '',
        snackbarShow: false,
      }
    },
    mounted() {
      this.fetchCategory()
    },
    methods: {
      fetchCategory() {
        axios.get(`/api/category`)
          .then(response => {
            this.category = response.data.data
          })
          .catch(error => console.log(error.response.data.message))
      },
    },
  }
</script>
  
<style>
.space{
    margin-left: 0;
    margin-right: -100px;
}
</style>
<template>
    <div>
      <v-toolbar flat class="mt-5 mb-10">
        <v-toolbar-title>Sales</v-toolbar-title>
     </v-toolbar>
      <v-divider></v-divider>
      <v-data-table
        :headers="headers"
        :items="sales"
        :items-per-page="5"
        class="elevation-1 mt-10 ml-5"
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
      name: "Sales",
      components: {
        Snackbar,
      },
      data () {
        return {
          toggle_exclusive: 1,
          headers: [
            {
              text: 'ID #',
              align: 'start',
              sortable: false,
              value: 'id',
            },
            { text: 'Destination', value: 'destination' },
            { text: 'Driver', value: 'vehicle.driver' },
            { text: 'Vehicle Plate #', value: 'vehicle.plate_no' },
            { text: 'Status', value: 'status' },
            { text: 'Date Created', value: 'created_at' },
            { text: 'Last Update', value: 'updated_at' },
          ],
          sales: [],
          snackbarShow: false,
          message: '',
        }
      },
      mounted() {
        this.fetchSales()
      },
      methods: {
        fetchSales() {
          axios.get(`/api/sales`)
            .then(response => {
              this.sales = response.data.data
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
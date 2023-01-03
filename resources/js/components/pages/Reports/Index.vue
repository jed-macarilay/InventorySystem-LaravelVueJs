<template>
  <div>
    <v-card class="pa-4 ml-5 elavation-0">
      <v-card-title>
          <v-toolbar-title class="ml-3">
          <strong>Reports</strong>
          </v-toolbar-title>
      </v-card-title>
      <v-divider></v-divider>
      <v-row>
        <v-col cols="12" md="6">
          <date-picker 
            v-model="date_range" 
            range
            :valueType="format"
          ></date-picker>
          <v-btn
            small
            dark
            color="#218c74"
            @click="filter"
          >Filter</v-btn>
          <v-btn
            small
            @click="clear"
          >Clear</v-btn>
        </v-col>
      </v-row>
      <v-data-table
        :search="search"
        :headers="headers"
        :items="reports"
        :items-per-page="5"
        class="mt-10 ml-5"
      ></v-data-table>
    </v-card>

    <snackbar 
      :show="snackbarShow"
      :message="message"
    />
  </div>
</template>
  
  <script>
  import Snackbar from '../../templates/Snackbar.vue'
  import Category from '../Category/Index.vue'
  import DatePicker from 'vue2-datepicker';
  import 'vue2-datepicker/index.css';

  export default {
    name: "Inventory",
    components: {
      Snackbar,
      Category,
      DatePicker,
    },
    data () {
      return {
        toggle_exclusive: 1,
        search: '',
        headers: [
          {
            text: 'ID #',
            align: 'start',
            sortable: false,
            value: 'id',
          },
          { text: 'Order #', value: 'order_code' },
          { text: 'Customer', value: 'receiver' },
          { text: 'Vehicle', value: 'vehicle.vehicle_type' },
          { text: 'Vehicle Plate #', value: 'vehicle.plate_no' },
          { text: 'Status', value: 'status' },
          { text: 'Date Created', value: 'created_at' },
          { text: 'Last Update', value: 'updated_at' },
        ],
        reports: [],
        message: '',
        snackbarShow: false,
        date_range: null,
        format: 'YYYY-MM-DD',
      }
    },
    mounted() {
      this.fetchReports()
    },
    methods: {
      fetchReports() {
        axios.get(`/api/sales`)
          .then(response => {
            this.reports = response.data.data
          })
          .catch(error => console.log(error.response.data.message))
      },
      filter() {
        axios.get(`/api/reports?start_date=${this.date_range[0]}&end_date=${this.date_range[1]}`)
          .then(response => {
            this.reports = response.data.data
          })
          .catch(error => console.log(error.response.data.message))
      },
      clear() {
        this.fetchReports()
        this.date_range = null
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
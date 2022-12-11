<template>
  <div>
    <v-toolbar flat class="mt-n5">
      <v-toolbar-title>Overview</v-toolbar-title>
   </v-toolbar>
   <div class="py-5 ml-4 mb-10">
      <h2>
          <strong>Welcome Back, {{ user.name }}!</strong>
      </h2>
    </div>
    <v-item-group mandatory class="mt-n4">
      <v-container>
        <v-row justify="start" class="space">
          <v-col
            cols="4"
            md="2"
          >
            <v-item>
            <v-card
                color="#218c74"
                class="d-flex align-center rounded-xl"
                dark
                height="200"
              >
                <v-row>
                  <v-col cols="12" sm="12">
                    <v-list-item 
                      three-line  
                      class="mt-10"
                      href="/inventory"
                    >
                      <v-list-item-content>
                        <div class="mb-4">
                            <v-icon  x-large color="white">fa fa-archive</v-icon>
                        </div>
                        <v-list-item-subtitle class="white--text">Inventory</v-list-item-subtitle>
                        <v-list-item-title class="headline mb-1 white--text">
                          <strong>{{ counts.inventory_count }}</strong>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-col>
                </v-row>
              </v-card>
            </v-item>
          </v-col>
          <v-col
            cols="12"
            md="2"
          >
            <v-item>
              <v-card
                color="#218c74"
                class="d-flex align-center rounded-xl"
                dark
                height="200"
                href="/vehicle"
              >
                <v-row>
                  <v-col cols="12" sm="12">
                    <v-list-item three-line  class="mt-10">
                      <v-list-item-content>
                        <div class="mb-4">
                        
                            <v-icon  x-large color="white">fa fa-truck</v-icon>
                        
                        </div>
                        <v-list-item-subtitle class="white--text">Total Vehicle</v-list-item-subtitle>
                        <v-list-item-title class="headline mb-1 white--text">
                          <strong>{{ counts.vehicle_count }}</strong>
                        </v-list-item-title>
                        
                      </v-list-item-content>
                    </v-list-item>
                  </v-col>
                </v-row>
                
              </v-card>
            </v-item>
          </v-col>
          <v-col
            cols="12"
            md="2"
          >
            <v-item> 
            <v-card
              color="#218c74"
              class="d-flex align-center rounded-xl"
              dark
              height="200"
            >
                <v-row>
                  <v-col cols="12" sm="12">
                    <v-list-item 
                      three-line  
                      class="mt-10"
                      href="/sales"
                    >
                      <v-list-item-content>
                        <div class="mb-4">
                            <v-icon  x-large color="white">fa fa-dollar</v-icon>
                        </div>
                        <v-list-item-subtitle class="white--text">Sales</v-list-item-subtitle>
                        <v-list-item-title class="headline mb-1 white--text">
                          <strong>{{ counts.shipping_count }}</strong>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-col>
                </v-row>
              </v-card>
            </v-item>
          </v-col>
          <v-col
            cols="12"
            md="2"
          >
            <v-item> 
            <v-card
              color="#218c74"
              class="d-flex align-center rounded-xl"
              dark
              height="200"
            >
                <v-row>
                  <v-col cols="12" sm="12">
                    <v-list-item 
                      three-line  
                      class="mt-10"
                      href="/settings"
                    >
                      <v-list-item-content>
                        <div class="mb-4">
                            <v-icon  x-large color="white">fa fa-users</v-icon>
                        </div>
                        <v-list-item-subtitle class="white--text">Total Users</v-list-item-subtitle>
                        <v-list-item-title class="headline mb-1 white--text">
                          <strong>{{ counts.user_count }}</strong>
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </v-col>
                </v-row>
              </v-card>
            </v-item>
          </v-col>
        </v-row>
      </v-container>
    </v-item-group>
    <div class="mt-10">
      <h4>Inventory Summary</h4>
      <LineChartGenerator
        :chart-options="chartOptions"
        :chart-data="chartData"
        :chart-id="chartId"
        :dataset-id-key="datasetIdKey"
        :plugins="plugins"
        :css-classes="cssClasses"
        :styles="styles"
        :width="width"
        :height="height"
      />
    </div>
  </div>
</template>

<script>
  import { Line as LineChartGenerator } from 'vue-chartjs/legacy'

  import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    CategoryScale,
    PointElement
  } from 'chart.js'

  ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    LinearScale,
    CategoryScale,
    PointElement
  )

  export default {
    components: {
      LineChartGenerator,
    },
    props: {
      user: {
        type: Object,
        default: [],
      },
      chartId: {
        type: String,
        default: 'line-chart'
      },
      datasetIdKey: {
        type: String,
        default: 'label'
      },
      width: {
        type: Number,
        default: 400
      },
      height: {
        type: Number,
        default: 400
      },
      cssClasses: {
        default: '',
        type: String
      },
      styles: {
        type: Object,
        default: () => {}
      },
      plugins: {
        type: Array,
        default: () => []
      }
    },
    data () {
      return {
        toggle_exclusive: 1,
        counts: [],
        category_product_counts: [],
        chartData: {
          labels: [],
          datasets: [
            {
              label: 'All Product in Category',
              backgroundColor: '#218c74',
              data: []
            }
          ]
        },
        chartOptions: {
          responsive: true,
          maintainAspectRatio: false
        },
      }
    },
    mounted() {
      this.fetchCountAll()
      this.fetchProduct()
    },
    methods: {
      fetchCountAll() {
        axios.get('/api/view/all')
          .then(response => {
            this.counts = response.data
          })
          .catch(error => console.log(error))
      },
      fetchProduct() {
        axios.get(`/api/category/show`)
          .then(response => {
            this.category_product_counts = response.data.data

            this.category_product_counts.forEach(element => {
              this.chartData.labels.push(element.category)
              this.chartData.datasets[0].data.push(element.products_count)
            });
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
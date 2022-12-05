<template>
  <div>
    <v-toolbar flat class="mt-n5">
      <v-toolbar-title>Overview</v-toolbar-title>
   </v-toolbar>
    <v-item-group mandatory class="mt-n4">
      <v-container>
        <v-row justify="start" class="space">
          <v-col
            cols="4"
            md="2"
          >
            <v-item>
            <v-card
                color="#49D9A0"
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
                color="#49D9A0"
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
              color="#49D9A0"
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
                            <v-icon  x-large color="white">fa fa-truck</v-icon>
                        </div>
                        <v-list-item-subtitle class="white--text">Shipping now</v-list-item-subtitle>
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
              color="#49D9A0"
              class="d-flex align-center rounded-xl"
              dark
              height="200"
            >
                <v-row>
                  <v-col cols="12" sm="12">
                    <v-list-item 
                      three-line  
                      class="mt-10"
                      href="/user/create"
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
      <Bar
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
  import { Bar } from 'vue-chartjs/legacy'

  import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
  } from 'chart.js'

  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

  export default {
    components: {
      Bar,
    },
    props: {
      chartId: {
        type: String,
        default: 'bar-chart'
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
        chartData: {
          labels: [],
          datasets: [
            {
              label: 'Product',
              backgroundColor: '#49D9A0',
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
        axios.get(`/api/inventory/product`)
          .then(response => {
            let products = response.data.data

            let labels = []
            let datasets = []

            products.forEach(element => {
              labels.push(element.product_name)
              datasets.push(element.quantity)
            });

            this.chartData.labels = labels
            this.chartData.datasets[0].data = datasets
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
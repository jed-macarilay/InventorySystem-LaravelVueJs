<template>
  <div>
    <v-toolbar flat class="mt-5 mb-10">
      <v-toolbar-title>Sales</v-toolbar-title>
    </v-toolbar>
    <v-item-group mandatory class="mt-n4">
      <v-container>
        <v-row justify="start" class="space">
          <v-col
            cols="12"
            md="2"
          >
            <v-item v-slot="{ active, toggle }" > 
            <v-card
                :color="active ? '#218c74' : 'white'"
                class="d-flex align-center rounded-xl"
                dark
                height="200"
                @click="toggle"
                
              >
                <v-row>
                  <v-col cols="12" sm="12">
                    <v-list-item 
                      three-line  
                      class="mt-10"
                      href="/order/create"
                    >
                      <v-list-item-content>
                        <div class="mb-4">
                            <v-icon  x-large :color="active ? 'white' : '#218c74'">fa fa-plus-square</v-icon>
                        </div>
                        <v-list-item-subtitle :class="active ? 'white--text' : 'black--text'">Add Order</v-list-item-subtitle>
                        <v-list-item-title class="headline mb-1" :class="active ? 'white--text' : 'black--text'">
                          <strong>{{ sales.length }}</strong>
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
    <v-divider></v-divider>
    <v-data-table
      :headers="headers"
      :items="sales"
      :items-per-page="5"
      class="elevation-1 mt-10 ml-5"
    >
      <template v-slot:item.order_code="{ item }">
        <a :href="`/vehicle/shippings/${item.id}/map`" target="_blank">{{ item.order_code }}</a>
      </template>
    </v-data-table>

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
            { text: 'Order #', value: 'order_code' },
            { text: 'Customer', value: 'receiver' },
            { text: 'Vehicle', value: 'vehicle.vehicle_type' },
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
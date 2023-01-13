<template>
    <div>
      <v-toolbar flat class="mt-n5">
        <v-toolbar-title>Vehicle</v-toolbar-title>
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
                        href="/vehicle/create"
                      >
                        <v-list-item-content>
                          <div class="mb-4">
                              <v-icon  x-large :color="active ? 'white' : '#218c74'">fa fa-plus-square</v-icon>
                          </div>
                          <v-list-item-subtitle :class="active ? 'white--text' : 'black--text'">Add Vehicle</v-list-item-subtitle>
                          <v-list-item-title class="headline mb-1" :class="active ? 'white--text' : 'black--text'">
                            <strong>{{ vehicles.length }}</strong>
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
        :items="vehicles"
        :items-per-page="5"
        class="elevation-1 mt-10 ml-5"
      >
        <template v-slot:item.delivery="{ item }">
          <a :href="`/vehicle/shippings/${item.id}`">View Delivery</a>
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
            small
            class="mr-2"
            @click="editVehicle(item)"
          >
            fa fa-pencil
          </v-icon>
          <v-icon
            small
            @click="deleteVehicle(item)"
          >
            fa fa-trash
          </v-icon>
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
      name: "Vehicles",
      components: {
        Snackbar,
      },
      data () {
        return {
          toggle_exclusive: 1,
          headers: [
            {
              text: 'Plate #',
              align: 'start',
              sortable: false,
              value: 'plate_no',
            },
            { text: 'Vehicle', value: 'vehicle_type' },
            { text: 'Driver', value: 'user.name' },
            { text: 'Last Update', value: 'updated_at' },
            { text: 'Delivery', value: 'delivery' },
            { text: 'Actions', value: 'actions' },
          ],
          vehicles: [],
          snackbarShow: false,
          message: '',
        }
      },
      mounted() {
        this.fetchVehicles()
      },
      methods: {
        fetchVehicles() {
          axios.get('/api/vehicle')
            .then(response => {
              this.vehicles = response.data.data
            })
            .catch(error => console.log(error))
        },
        editVehicle(vehicle) {
          window.location.href = `/vehicle/edit/${vehicle.id}`
        },
        deleteVehicle(vehicle) {
          if (confirm('Are you sure to delete this data?')) {
            axios.delete(`/api/vehicle/delete/${vehicle.id}`)
              .then(response => {
                this.snackbarShow = true
                this.message = response.data.message
                this.fetchVehicles()
              })
              .catch(error => {
                this.snackbarShow = true
                this.message = error.response.data.message
              })
          }
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
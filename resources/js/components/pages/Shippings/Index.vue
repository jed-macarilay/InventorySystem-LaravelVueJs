<template>
    <div>
      <v-toolbar flat class="mt-5 mb-10">
        <v-toolbar-title>
          List of Deliveries <br />
          Vehicle Plate Number <strong>{{ vehicle.plate_no }}
        </strong></v-toolbar-title>
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
                        :href="`/vehicle/shippings/${vehicle.id}/create`"
                      >
                        <v-list-item-content>
                          <div class="mb-4">
                              <v-icon  x-large :color="active ? 'white' : '#218c74'">fa fa-plus-square</v-icon>
                          </div>
                          <v-list-item-subtitle :class="active ? 'white--text' : 'black--text'">Add new Delivery</v-list-item-subtitle>
                          <v-list-item-title class="headline mb-1" :class="active ? 'white--text' : 'black--text'">
                            <strong>{{ shippings.length }}</strong>
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
        :items="shippings"
        :items-per-page="5"
        class="elevation-1 mt-10 ml-5"
      >
        <template v-slot:item.location="{ item }">
          <a :href="`/vehicle/shippings/${item.id}/map`">View here</a>
        </template>
        <template v-slot:item.download="{ item }">
          <a :href="`/api/download-delivery-receipt?shipping_id=${item.id}`">DOWNLOAD RECEIPT</a>
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
            small
            class="mr-2"
            @click="editShipping(item.id)"
          >
            fa fa-pencil
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
    name: "Shippings",
    props: {
      vehicle: {
        type: [Array, Object],
        required: true,
      }
    },
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
          { text: 'Receiver', value: 'receiver' },
          { text: 'Contact #', value: 'contact_number' },
          { text: 'Status', value: 'status' },
          { text: 'Location', value: 'location' },
          { text: 'Date Created', value: 'created_at' },
          { text: 'Last Update', value: 'updated_at' },
          { text: '', value: 'download' },
          { text: 'Actions', value: 'actions' },
        ],
        vehicles: [],
        shippings: [],
        snackbarShow: false,
        message: '',
      }
    },
    mounted() {
      this.fetchShippings()
    },
    methods: {
      fetchShippings() {
        axios.get(`/api/vehicle/shippings/${this.vehicle.id}`)
          .then(response => {
            this.shippings = response.data.data
          })
          .catch(error => console.log(error.response.data.message))
      },
      editShipping(id) {
        window.location.href = `/vehicle/shippings/${id}/edit`
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
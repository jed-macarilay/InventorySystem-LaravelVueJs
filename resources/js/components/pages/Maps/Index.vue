<template>
    <div class="pa-4">
      <v-toolbar flat class="">
        <v-toolbar-title>View Location</v-toolbar-title>
     </v-toolbar>
      <gmap-map
        :center="google && new google.maps.LatLng(shipping.origin_latitude, shipping.origin_longtitude)"
        :zoom="13.5"
        :options="{
          zoomControl: false,
          mapTypeControl: false,
          scaleControl: false,
          streetViewControl: false,
          rotateControl: false,
          fullscreenControl: false,
          disableDefaultUi: false
        }"
        style="width:100%;  height: 555px;">
          <gmap-marker
            :position="google && new google.maps.LatLng(shipping.origin_latitude, shipping.origin_longtitude)"
          ></gmap-marker>
        <gmap-marker
          :position="google && new google.maps.LatLng(shipping.destination_latitude, shipping.destination_longtitude)"
        ></gmap-marker>
      </gmap-map>
      <v-card class="pa-4 mt-5">
        <v-toolbar-title>
            <strong>Delivery Information</strong>
        </v-toolbar-title>
        <v-list>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>
                <strong>Receiver: </strong> {{ shipping.receiver }}<br />
                <span>Contact Number: {{ shipping.receiver }}</span>
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>
                <strong>Destination: </strong> {{ shipping.destination }} <br />
                <strong>Current Location of Vehicle: </strong> {{ shipping.current_location }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>
                <strong>Driver: </strong> {{ driver }} <br />
                <strong>Status: </strong> {{ shipping.status }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <v-toolbar-title>
            <strong>Items</strong>
        </v-toolbar-title>
        <v-data-table
          :headers="headers"
          :items="items"
          sort-by="calories"
          class="elevation-1 my-4"
        >
          <template v-slot:item.retail_price="{ item }">
            {{ formatCurrency(item.retail_price) }}
          </template>
          <template v-slot:item.pivot.total="{ item }">
            <strong>{{ formatCurrency(item.pivot.total) }}</strong>
          </template>
        </v-data-table>
      </v-card>
    </div>
</template>

<script>
import {gmapApi} from 'vue2-google-maps'

export default {
  name: 'GoogleMap',
  props: {
    shipping: {
      type: [Array, Object],
      required: true,
    },
    driver: {
      type: String,
      required: true,
    }
  },
  computed: {
    google: gmapApi
  },
  data() {
    return {
      center: this.google && new this.google.maps.LatLng(shipping.origin_latitude, shipping.origin_longtitude),
      items: [],
      locations: [],
      headers: [
        {
          text: 'Serial Code',
          align: 'start',
          sortable: false,
          value: 'serial_code',
        },
        { text: 'Product Name', value: 'product_name' },
        { text: 'Quantity', value: 'pivot.quantity' },
        { text: 'Retail Price', value:'retail_price' },
        { text: 'Total Amount', value:'pivot.total' },
      ],
    }
  },

  mounted() {
    this.fetchOrder()
    this.setLocationLatLng()
  },
 
 methods: {
    fetchOrder() {
      axios.get(`/api/vehicle/shippings/${this.shipping.id}/order`)
        .then(response => {
          this.items = response.data.data
        })
        .catch(error => {
          this.snackbarShow = true
          this.message = error.response.data.message
          this.isLoading = false
        })
    },
    setPlace(loc) {
      this.currentLocation = loc;
    },
    setLocationLatLng: function() {
      navigator.geolocation.getCurrentPosition(geolocation => {
        this.center = {
          lat: geolocation.coords.latitude,
          lng: geolocation.coords.longitude
        };
      });
    },
    formatCurrency (value) {
      return '₱' + parseFloat(value)
    },
 }
}
</script>
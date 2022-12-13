<template>
    <div class="pa-4">
      <v-toolbar flat class="mb-5">
        <v-toolbar-title>
          <h2><strong>Order Details</strong></h2>
        </v-toolbar-title>
     </v-toolbar>
      <gmap-map
        ref="gmap"
        :center="{
          lat: parseFloat(shipping.current_location_latitude),
          lng: parseFloat(shipping.current_location_longtitude)
        }"
        :zoom="13.5"
        :options="{
          zoomControl: true,
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
            label="Origin"
          ></gmap-marker>
          <gmap-marker
            :position="google && new google.maps.LatLng(shipping.destination_latitude, shipping.destination_longtitude)"
            label="Destination"
          ></gmap-marker>
          <gmap-marker
            :position="google && new google.maps.LatLng(shipping.current_location_latitude, shipping.current_location_longtitude)"
            label="Driver"
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
                <strong>Origin: </strong> {{ shipping.origin }} <br />
                <strong>Destination: </strong> {{ shipping.destination }} <br />
                <v-divider></v-divider>
                <strong>Current Location of Vehicle: </strong> {{ current_location }}
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
        <div class="mt-5">
          <h3>
            <strong>Total: ₱{{ getTotal() }}</strong>
          </h3>
        </div>
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
      center: {},
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
      current_location: ''
    }
  },

  mounted() {
    this.fetchCurrentLocationFromMobile()
    this.fetchOrder()
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
    fetchCurrentLocationFromMobile(){
      this.$refs.gmap.$mapPromise.then(() => {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            location: {
              lat: parseFloat(this.shipping.current_location_latitude),
              lng: parseFloat(this.shipping.current_location_longtitude)
            }
          }, (results, status) => {
            if (status == google.maps.GeocoderStatus.OK) {
              this.shipping.currentLocation = results[0].formatted_address
              this.current_location = results[0].formatted_address
            } 
          });
      })

      axios.put(`/api/shippings/update/currentLocation/${this.shipping.id}`, {
        current_location: this.current_location
      });
    },
    setPlace(loc) {
      this.currentLocation = loc;
    },
    formatCurrency (value) {
      return '₱' + parseFloat(value)
    },
    getTotal() {
      const sum = this.items.reduce((accumulator, object) => {
        return accumulator + object.pivot.total;
      }, 0);
      return sum
    },
 }
}
</script>
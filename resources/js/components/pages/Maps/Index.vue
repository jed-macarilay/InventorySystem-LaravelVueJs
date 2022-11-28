<template>
    <div class="pa-4">
      <v-toolbar flat class="">
        <v-toolbar-title>View Location</v-toolbar-title>
     </v-toolbar>
      <gmap-map
        :center="center"
        :zoom="10"
        style="width:100%;  height: 555px;">
        <gmap-marker
          :position="gmp"
          @click="center=gmp"
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
                <strong>Current Location of Vehicle: </strong> {{ shipping.destination }}
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
  data() {
    return {
      items: [],
      center: { 
        lat: 39.7837304, 
        lng: -100.4458825 
      },
      locations: [],
      currentLocation: null,
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
    console.log(this.driver);
    this.fetchOrder()
    this.setLocationLatLng();
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
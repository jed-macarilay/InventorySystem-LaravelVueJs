<template>
    <div>
        <v-card class="pa-5 mt-4">
            <v-toolbar flat class="mt-n5">
                <v-toolbar-title>Add Delivery</v-toolbar-title>
            </v-toolbar>
            <v-divider class="mr-6"></v-divider>
            <v-card-text>
                <v-form ref="form">
                    <ItemCreate @get-item="collectItemCallBack" />
                    <v-divider></v-divider>
                    <v-col
                        cols="12"
                        md="7"
                    >
                        <div>
                            <label for="">
                                <strong>Receiver</strong>
                            </label>
                            <v-text-field
                                v-model="shipping.receiver"
                                placeholder="Enter Package Receiver"
                                outlined
                                dense
                                rounded
                                required
                                :rules="receiverRule"
                            ></v-text-field>
                        </div>
                        <div>
                            <label for="">
                                <strong>Contact Number</strong>
                            </label>
                            <v-text-field
                                v-model="shipping.contact_number"
                                placeholder="Enter Receiver Contact #"
                                outlined
                                dense
                                rounded
                                required
                                :rules="contactNumberRule"
                            ></v-text-field>
                        </div>
                        <!-- <div>
                            <label for="">
                                <strong>Origin</strong>
                            </label>
                            <v-text-field
                                v-model="shipping.origin"
                                placeholder="Enter Package Address Origin"
                                outlined
                                dense
                                rounded
                                required
                                :rules="originRule"
                                append-icon="fa fa-map-marker"
                            ></v-text-field>
                        </div>
                        <div>
                            <label for="">
                                <strong>Destination</strong>
                            </label>
                            <v-text-field
                                v-model="shipping.destination"
                                placeholder="Enter Package Address Destination"
                                outlined
                                dense
                                rounded
                                required
                                :rules="destinationRule"
                                append-icon="fa fa-map-marker"
                            ></v-text-field>
                        </div> -->
                        <div>
                            <label for="">
                                <strong>Origin</strong>
                            </label><br />
                            <gmap-autocomplete
                              class="g-map-input"
                              placeholder="Enter Package Address Start Point"
                              required
                              @place_changed="setOrigin"
                            ></gmap-autocomplete>
                        </div>
                        <div>
                            <label for="">
                                <strong>Destination</strong>
                            </label><br />
                            <gmap-autocomplete
                              class="g-map-input"
                              placeholder="Enter Package Address Destination"
                              required
                              @place_changed="setDestination"
                            ></gmap-autocomplete>
                        </div>
                    </v-col>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-btn
                            :loading="isLoading"
                            color="#49D9A0"
                            text
                            @click="addVehicleShipping"
                        >
                            Submit
                        </v-btn>
                    </v-card-actions>
                </v-form>
            </v-card-text>
        </v-card>

        <snackbar 
          :show="snackbarShow"
          :message="message"
        />
    </div>
</template>
<style scoped>
  .g-map-input {
    flex: 1 1 auto;
    line-height: 20px;
    padding: 8px 14px;
    max-width: 100%;
    min-width: 0;
    width: 100%;
    border: 1px solid grey;
    border-radius: 20px;
  }
</style>
<script>
import Snackbar from '../../templates/Snackbar.vue'
import ItemCreate from './Items/Create.vue'
export default {
    name: "ShippingsCreate",
    props: {
        vehicle: {
        type: [Array, Object],
        required: true,
        }
    },
    components: {
      Snackbar,
      ItemCreate,
    },
    data() {
        return {
            shipping: {
              receiver: '',
              contact_number: '',
              origin: '',
              origin_latitude: '',
              origin_longtitude: '',
              destination: '',
              destination_latitude: '',
              destination_longtitude: '',
              status: 'In Progress',
              items: [],
            },
            isLoading: false,
            snackbarShow: false,
            message: '',
            receiverRule: [
                v => !!v || 'Package Receiver is required',
            ],
            contactNumberRule: [
                v => !!v || 'Receiver Contact # is required',
            ],
            originRule: [
                v => !!v || 'Package Delivery Origin is required',
            ],
            destinationRule: [
                v => !!v || 'Package Delivery Destination is required',
            ],
            address: '',
        }
    },
    methods: {
      addVehicleShipping() {
        if (this.$refs.form.validate()) {
          axios.post(`/api/vehicle/shippings/${this.vehicle.id}/create`, this.shipping)
            .then(response => {
                this.snackbarShow = true
                this.message = response.data.message
                this.isLoading = false
                this.$refs.form.reset()
                window.location.href = `/vehicle/shippings/${this.vehicle.id}`
              })
              .catch(error => {
                this.snackbarShow = true
                this.message = error.response.data.message
                this.isLoading = false
              })
        }
      },
      collectItemCallBack(value) {
        this.shipping.items = value
      },
      setOrigin(v) {
        this.shipping.origin = v.formatted_address
        this.shipping.origin_latitude = v.geometry.location.lat()
        this.shipping.origin_longtitude = v.geometry.location.lng()
      },
      setDestination(v) {
        this.shipping.destination = v.formatted_address
        this.shipping.destination_latitude = v.geometry.location.lat()
        this.shipping.destination_longtitude = v.geometry.location.lng()
      },
    },
}
</script>
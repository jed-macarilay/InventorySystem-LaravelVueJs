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
                        <div>
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
                  destination: '',
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
        },
    }
</script>
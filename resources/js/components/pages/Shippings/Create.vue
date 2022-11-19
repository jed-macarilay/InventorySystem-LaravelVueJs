<template>
    <div>
        <v-card class="pa-5 mt-4">
            <v-toolbar flat class="mt-n5">
                <v-toolbar-title>Add Vehicle Shipping</v-toolbar-title>
            </v-toolbar>
            <v-divider class="mr-6"></v-divider>
            <v-card-text>
                <v-form ref="form">
                    <ItemCreate />
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
                                <strong>Address</strong>
                            </label>
                            <v-text-field
                                v-model="shipping.address"
                                placeholder="Enter Package Address Destination"
                                outlined
                                dense
                                rounded
                                required
                                :rules="addressRule"
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
                  address: '',
                  status: 'In Progress',
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
                addressRule: [
                    v => !!v || 'Package Delivery Address is required',
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
                        })
                        .catch(error => {
                            this.snackbarShow = true
                            this.message = error.response.data.message
                            this.isLoading = false
                        })
                }
            },
        },
    }
</script>
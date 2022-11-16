<template>
    <div>
        <v-card class="pa-5 mt-4">
            <v-toolbar flat class="mt-n5">
                <v-toolbar-title>Update Vehicle Shipping # {{ shipping.id }}</v-toolbar-title>
            </v-toolbar>
            <v-divider class="mr-6"></v-divider>
            <v-card-text>
                <v-form ref="form">
                    <v-col
                        cols="12"
                        md="7"
                    >
                        <div>
                            <label for="">
                                <strong>Receiver</strong>
                            </label>
                            <v-text-field
                                v-model="edit_shipping.receiver"
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
                                v-model="edit_shipping.contact_number"
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
                                v-model="edit_shipping.address"
                                placeholder="Enter Package Address Destination"
                                outlined
                                dense
                                rounded
                                required
                                :rules="addressRule"
                            ></v-text-field>
                        </div>
                        <div>
                            <label for="">
                                <strong>Status</strong>
                            </label>
                            <v-select
                              v-model="edit_shipping.status"
                              :items="['In Progress', 'To Ship', 'Delivered']"
                              outlined
                              dense
                              rounded
                              required
                            ></v-select>
                        </div>
                    </v-col>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-btn
                            :loading="isLoading"
                            color="#49D9A0"
                            text
                            @click="editVehicleShipping"
                        >
                            Update
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
import Snackbar from '../../templates/Snackbar.vue';

    export default {
        name: "ShippingsEdit",
        props: {
            shipping: {
                type: [Array, Object],
                required: true,
            }
        },
        components: {
          Snackbar,
        },
        data() {
            return {
                edit_shipping: this.shipping,
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
            editVehicleShipping() {
                if (this.$refs.form.validate()) {
                    axios.put(`/api/vehicle/shippings/${this.shipping.id}/edit`, this.edit_shipping)
                        .then(response => {
                            this.snackbarShow = true
                            this.message = response.data.message
                            this.isLoading = false
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
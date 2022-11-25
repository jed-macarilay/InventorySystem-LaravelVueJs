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
                items: [],
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
        mounted() {
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
            formatCurrency (value) {
              return '₱' + parseFloat(value)
            },
        },
    }
</script>
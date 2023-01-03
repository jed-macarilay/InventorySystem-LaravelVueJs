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
                                @keypress="filter(event)"
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
                                <strong>Destination</strong>
                            </label><br />
                            <gmap-autocomplete
                              class="g-map-input"
                              placeholder="Enter Package Address Destination"
                              required
                              :value="edit_shipping.destination"
                              @place_changed="setDestination"
                            ></gmap-autocomplete>
                        </div>
                        <div>
                            <label for="">
                                <strong>Status</strong>
                            </label>
                            <v-select
                              v-model="edit_shipping.status"
                              :items="['In Progress', 'To Ship', 'Completed Delivery']"
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
                      <template v-slot:item.unit_price="{ item }">
                        {{ formatCurrency(item.unit_price) }}
                      </template>
                      <template v-slot:item.pivot.total="{ item }">
                        <strong>{{ formatCurrency(item.pivot.total) }}</strong>
                      </template>
                    </v-data-table>
                    <div class="mt-5">
                        <h5>Subtotal: {{ formatCurrency(subtotal) }}</h5>
                        <h5>Including 12% tax: {{ formatCurrency(tax) }}</h5>
                        <v-divider></v-divider>
                        <h3>
                            <strong>Total: ₱{{ getTotal() }}</strong>
                        </h3>
                    </div>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-btn
                            :loading="isLoading"
                            color="#218c74"
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
                    text: 'SKU',
                    align: 'start',
                    sortable: false,
                    value: 'SKU',
                  },
                  { text: 'Product Name', value: 'product_name' },
                  { text: 'Quantity', value: 'pivot.quantity' },
                  { text: 'Unit Price', value:'unit_price' },
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
                subtotal: 0,
                tax: 0,
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
              return '₱ ' + (Math.round(value * 100) / 100).toFixed(2)
            },
            getTotal() {
                const sum = this.items.reduce((accumulator, object) => {
                    return accumulator + object.pivot.total
                }, 0);

                this.subtotal = sum
                this.tax = sum * .12

                let total = this.subtotal + this.tax

                return (Math.round(total * 100) / 100).toFixed(2)
            },
            setDestination(v) {
                this.shipping.destination = v.formatted_address
                this.shipping.destination_latitude = v.geometry.location.lat()
                this.shipping.destination_longtitude = v.geometry.location.lng()
            },
            filter: function(evt) {
                evt = (evt) ? evt : window.event;
                let expect = evt.target.value.toString() + evt.key.toString();
                
                if (!/^[-+]?[0-9]*\.?[0-9]*$/.test(expect)) {
                evt.preventDefault();
                } else {
                    return true;
                }
            },
        },
    }
</script>
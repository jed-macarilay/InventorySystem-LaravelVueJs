<template>
    <div>
        <v-card class="pa-5 mt-4">
            <v-toolbar flat class="mt-n5">
                <v-toolbar-title>Edit Vehicle</v-toolbar-title>
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
                                <strong>Plate No. *</strong>
                            </label>
                            <v-text-field
                                v-model="vehicle[0].plate_no"
                                placeholder="Enter Vehicle Plate No."
                                outlined
                                dense
                                rounded
                                reuired
                                :rules="plateNoFieldRules"
                            ></v-text-field>
                        </div>
                        <div>
                            <label for="">
                                <strong>Driver</strong>
                            </label>
                            <v-text-field
                                v-model="vehicle[0].driver"
                                placeholder="Enter Vehicle Driver"
                                outlined
                                dense
                                rounded
                                required
                                :rules="driverFieldRules"
                            ></v-text-field>
                        </div>
                    </v-col>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-btn
                            :loading="isLoading"
                            color="#49D9A0"
                            text
                            @click="updateVehicle(vehicle)"
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
        name: "VehicleCreate",
        props: {
            vehicle: {
                type: [Object, Array],
                required: true,
            }
        },
        components: {
          Snackbar,
        },
        data() {
            return {
                plateNoFieldRules: [
                    v => !!v || 'Plate No. is required',
                ],
                driverFieldRules: [
                    v => !!v || 'Vehicle Driver is required',
                ],
                isLoading: false,
                snackbarShow: false,
                message: '',
            }
        },
        methods: {
            addVehicle() {
                if (this.$refs.form.validate()) {
                    axios.post('/api/vehicle/store', this.vehicle)
                        .then(response => {
                            this.snackbarShow = true
                            this.message = response.data.message
                            this.isLoading = false
                            this.$refs.form.reset()
                        })
                        .catch(error => {
                            this.snackbarShow = true
                            this.message = error
                            this.isLoading = false
                        })
                }
            },
            updateVehicle(vehicle) {
                if (this.$refs.form.validate()) {
                    axios.put(`/api/vehicle/edit/${vehicle[0].id}`, vehicle[0])
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
<template>
    <div>
        <v-card class="pa-5 mt-4">
            <v-toolbar flat class="mt-n5">
                <v-toolbar-title>Add Vehicle</v-toolbar-title>
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
                                v-model="vehicle.plate_no"
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
                                v-model="vehicle.driver"
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
                            @click="addVehicle"
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
import Snackbar from '../../templates/Snackbar.vue';

    export default {
        name: "VehicleCreate",
        components: {
          Snackbar,
        },
        data() {
            return {
                vehicle: {},
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
                            this.message = error.response.data.message
                            this.isLoading = false
                        })
                }
            },
        },
    }
</script>
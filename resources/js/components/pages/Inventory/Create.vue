<template>
    <div>
        <v-card class="pa-5 mt-4">
            <v-toolbar flat class="mt-n5">
                <v-toolbar-title>Create Product</v-toolbar-title>
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
                            <strong>Product Name</strong>
                        </label>
                        <v-text-field
                          v-model="product.product_name"
                          outlined
                          dense
                          rounded
                          required
                          :rules="productNameRule"
                          placeholder="Enter Product name"
                        ></v-text-field>
                    </div>
                    <div>
                        <label for="">
                            <strong>Serial Code</strong>
                        </label>
                        <v-text-field
                          v-model="product.serial_code"
                          outlined
                          dense
                          rounded
                          required
                          :rules="serialCodeRule"
                          placeholder="Enter Serial code"
                        ></v-text-field>
                    </div>
                    <div>
                        <label for="">
                            <strong>Description</strong>
                        </label>
                        <v-textarea
                          v-model="product.description"
                          outlined
                          dense
                          rounded
                          placeholder="Enter Description"
                        ></v-textarea>
                    </div>
                    <div>
                        <label for="">
                            <strong>Retail Price</strong>
                        </label>
                        <v-text-field
                          v-model="product.retail_price"
                          type="number"
                          outlined
                          dense
                          rounded
                          required
                          :rules="retailPriceRule"
                          placeholder="Enter Retail price"
                          prefix="PHP"
                        ></v-text-field>
                    </div>
                    <div>
                        <label for="">
                            <strong>Quantity</strong>
                        </label>
                        <v-text-field
                          v-model="product.quantity"
                          type="number"
                          outlined
                          dense
                          rounded
                          required
                          :rules="quantityRule"
                          placeholder="Enter Product Quantity"
                        ></v-text-field>
                    </div>
                  </v-col>
                </v-form>
                <v-divider></v-divider>
                <v-card-actions>
                  <v-btn
                      color="#49D9A0"
                      text
                      :loading="isLoading"
                      @click="addProduct"
                  >
                      Submit
                  </v-btn>
                </v-card-actions>
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

  export default {
      name: "InventoryCreate",
      components: {
        Snackbar,
      },
      data() {
        return {
          product: {},
          snackbarShow: false,
          message: '',
          isLoading: false,
          productNameRule: [
            v => !!v || 'Product name is required',
          ],
          serialCodeRule: [
            v => !!v || 'Serial code is required',
          ],
          retailPriceRule: [
            v => !!v || 'Product price is required',
          ],
          quantityRule: [
            v => !!v || 'Product quantity is required',
          ],
        }
      },
      methods: {
          addProduct() {
            if (this.$refs.form.validate()) {
              axios.post(`/api/inventory/product/create`, this.product)
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
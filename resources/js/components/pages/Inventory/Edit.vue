<template>
    <div>
        <v-card class="pa-5 mt-4">
            <v-toolbar flat class="mt-n5">
                <v-toolbar-title>Edit Product <strong>{{ product.product_name }}</strong></v-toolbar-title>
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
                          v-model="edit_product.product_name"
                          outlined
                          dense
                          rounded
                          required
                          :rules="productNameRule"
                        ></v-text-field>
                    </div>
                    <div>
                        <label for="">
                            <strong>Serial Code</strong>
                        </label>
                        <v-text-field
                          v-model="edit_product.serial_code"
                          outlined
                          dense
                          rounded
                          required
                          :rules="serialCodeRule"
                          disabled
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
                          v-model="edit_product.quantity"
                          type="number"
                          outlined
                          dense
                          rounded
                          required
                          :rules="quantityRule"
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
                      @click="editProduct"
                  >
                      Update
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
      name: "InventoryEdit",
      props: {
        product: {
            type: [Array, Object],
            required: true,
        }
      },
      components: {
        Snackbar,
      },
      data() {
        return {
          edit_product: this.product,
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
          editProduct() {
            if (this.$refs.form.validate()) {
              axios.put(`/api/inventory/product/edit/${this.product.id}`, this.edit_product)
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
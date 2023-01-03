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
                            <strong>SKU</strong>
                        </label>
                        <v-text-field
                          outlined
                          dense
                          rounded
                          required
                          :rules="skuRule"
                          disabled
                          :value="product.SKU"
                        ></v-text-field>
                    </div>
                    <div>
                      <label for="">
                        <strong>Category</strong>
                      </label>
                      <v-autocomplete
                        v-model="edit_product.category_id"
                        placeholder="Enter Product Category"
                        outlined
                        rounded
                        required
                        item-text="category"
                        item-value="id"
                        :items="categories"
                        :rules="productCategoryRule"
                        :return-object="false"
                      ></v-autocomplete>
                    </div>
                    <div>
                        <label for="">
                            <strong>Description</strong>
                        </label>
                        <v-textarea
                          v-model="edit_product.description"
                          outlined
                          dense
                          rounded
                          placeholder="Enter Description"
                        ></v-textarea>
                    </div>
                    <div>
                        <label for="">
                            <strong>Unit Price</strong>
                        </label>
                        <v-text-field
                          v-model="edit_product.unit_price"
                          type="number"
                          outlined
                          dense
                          rounded
                          required
                          :rules="unitPriceRule"
                          placeholder="Enter Unit price"
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
                      color="#218c74"
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
          categories: [],
          snackbarShow: false,
          message: '',
          isLoading: false,
          productNameRule: [
            v => !!v || 'Product name is required',
          ],
          skuRule: [
            v => !!v || 'Serial code is required',
          ],
          unitPriceRule: [
            v => !!v || 'Product price is required',
          ],
          quantityRule: [
            v => !!v || 'Product quantity is required',
            v => (v > 0) || 'Product quantity cannot be 0 or less than 1',
          ],
          productCategoryRule: [
            v => !!v || 'Product category is required',
          ],
        }
      },
      mounted() {
        this.fetchCategory()
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
        fetchCategory() {
          axios.get(`/api/category`)
            .then(response => {
              this.categories = response.data.data
            })
            .catch(error => console.log(error.response.data.message))
        },
      },
  }
</script>
<template>
    <div>
        <v-col cols="12" md="7">
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
                            <strong>Product Category</strong>
                        </label>
                        <v-text-field
                          v-model="category"
                          outlined
                          dense
                          rounded
                          required
                          :rules="categoryRule"
                          placeholder="Enter Product name"
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
        </v-col>

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
          category: '',
          snackbarShow: false,
          message: '',
          isLoading: false,
          categoryRule: [
            v => !!v || 'Product category is required',
          ],
        }
      },
      methods: {
          addProduct() {
            if (this.$refs.form.validate()) {
              axios.post(`/api/category/create`, {
                category: this.category,
              })
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
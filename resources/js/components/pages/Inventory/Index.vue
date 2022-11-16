<template>
    <div>
      <v-toolbar flat class="mt-n5">
        <v-toolbar-title>Inventory</v-toolbar-title>
     </v-toolbar>
      <v-item-group mandatory class="mt-n4">
        <v-container>
          <v-row justify="start" class="space">
            <v-col
              cols="12"
              md="2"
            >
              <v-item v-slot="{ active, toggle }" > 
              <v-card
                  :color="active ? '#49D9A0' : 'white'"
                  class="d-flex align-center rounded-xl"
                  dark
                  height="200"
                  @click="toggle"
                  
                >
                  <v-row>
                    <v-col cols="12" sm="12">
                      <v-list-item 
                        three-line  
                        class="mt-10"
                        href="/inventory/create"
                      >
                        <v-list-item-content>
                          <div class="mb-4">
                              <v-icon  x-large :color="active ? 'white' : '#49D9A0'">fa fa-plus-square</v-icon>
                          </div>
                          <v-list-item-subtitle :class="active ? 'white--text' : 'black--text'">Add new product</v-list-item-subtitle>
                          <v-list-item-title class="headline mb-1" :class="active ? 'white--text' : 'black--text'">
                            <strong>{{ products.length }}</strong>
                          </v-list-item-title>
                          
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                  </v-row>
                </v-card>
              </v-item>
            </v-col>
          </v-row>
        </v-container>
      </v-item-group>
      <v-divider></v-divider>
      <v-data-table
        :headers="headers"
        :items="products"
        :items-per-page="5"
        class="elevation-1 mt-10 ml-5"
      >
        <template v-slot:item.actions="{ item }">
            <v-icon
              small
              class="mr-2"
              @click="editProduct(item)"
            >
              fa fa-pencil
            </v-icon>
            <v-icon
              small
              @click="deleteVehicle(item)"
            >
              fa fa-trash
            </v-icon>
          </template>
      </v-data-table>

      <snackbar 
        :show="snackbarShow"
        :message="message"
      />
    </div>
  </template>
  
  <script>
  import Snackbar from '../../templates/Snackbar.vue'

  export default {
    name: "Inventory",
    components: {
      Snackbar,
    },
    data () {
      return {
        toggle_exclusive: 1,
        headers: [
          {
            text: 'Serial Code',
            align: 'start',
            sortable: false,
            value: 'serial_code',
          },
          { text: 'Product Name', value: 'product_name' },
          { text: 'Retail Price', value: 'retail_price' },
          { text: 'Quantity', value: 'quantity' },
          { text: 'Last Quantity', value: 'last_quantity' },
          { text: 'Last Update', value: 'updated_at' },
          { text: 'Actions', value: 'actions' },
        ],
        products: [],
        message: '',
        snackbarShow: false,
      }
    },
    mounted() {
      this.fetchProduct()
    },
    methods: {
      fetchProduct() {
        axios.get(`/api/inventory/product`)
          .then(response => {
            this.products = response.data.data
          })
          .catch(error => console.log(error.response.data.message))
      },
      editProduct(product) {
        window.location.href = `/inventory/edit/${product.id}`
      },
      deleteVehicle(product) {
        if (confirm('Are you sure to delete this product?')) {
          axios.delete(`/api/inventory/product/delete/${product.id}`)
          .then(response => {
              this.snackbarShow = true
              this.message = response.data.message
              this.fetchProduct()
          })
          .catch(error => {
              this.snackbarShow = true
              this.message = error.response.data.message
          })
        }
    },
    },
  }
</script>
  
  <style>
    .space{
      margin-left: 0;
      margin-right: -100px;
    }
  </style>
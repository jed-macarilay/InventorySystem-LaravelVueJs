<template>
    <div>
      <v-toolbar flat class="mt-n5">
        <v-toolbar-title>Inventory</v-toolbar-title>
     </v-toolbar>
      <v-item-group mandatory class="mt-n4">
        <v-container>
          <v-row justify="start" class="space">
            <v-col
              cols="4"
              md="2"
            >
              <v-item v-slot="{ active, toggle }" > 
                <v-card
                  :color="active ? '#218c74' : 'white'"
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
                              <v-icon  x-large :color="active ? 'white' : '#218c74'">fa fa-plus-square</v-icon>
                          </div>
                          <v-list-item-subtitle :class="active ? 'white--text' : 'black--text'">Add new Product</v-list-item-subtitle>
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
            <v-col
              cols="4"
              md="2"
            >
              <v-item v-slot="{ active, toggle }" > 
                <v-card
                  :color="active ? '#218c74' : 'white'"
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
                        href="/category/create"
                      >
                        <v-list-item-content>
                          <div class="mb-4">
                              <v-icon  x-large :color="active ? 'white' : '#218c74'">fa fa-plus-square</v-icon>
                          </div>
                          <v-list-item-subtitle :class="active ? 'white--text' : 'black--text'">Add new Category</v-list-item-subtitle>
                          
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
      <v-row>
        <v-col
         cols="12"
         md="8"
        >
          <v-card class="pa-4 ml-5 elavation-0">
            <v-card-title>
              <v-toolbar-title class="ml-3">
                <strong>Product List</strong>
              </v-toolbar-title>
            </v-card-title>
            <v-divider></v-divider>
            <v-col cols="12" md="4">
              <v-text-field
                v-model="search"
                append-icon="fa fa-search"
                label="Search Product"
                outlined
                hide-details
                rounded
              ></v-text-field>
            </v-col>
            <v-data-table
              :search="search"
              :headers="headers"
              :items="products"
              :items-per-page="5"
              class="mt-10 ml-5"
            >
              <template v-slot:item.retail_price="{ item }">
                <strong>{{ formatCurrency(item.retail_price) }}</strong>
              </template>
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
          </v-card>
        </v-col>
        <v-col
         cols="12"
         md="4"
        >
          <v-card class="pa-4 ml-5">
            <v-card-title>
              <v-toolbar-title>
                <strong>Category List</strong>
              </v-toolbar-title>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
              <Category />
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>

      <snackbar 
        :show="snackbarShow"
        :message="message"
      />
    </div>
  </template>
  
  <script>
  import Snackbar from '../../templates/Snackbar.vue'
  import Category from '../Category/Index.vue'

  export default {
    name: "Inventory",
    components: {
      Snackbar,
      Category,
    },
    data () {
      return {
        toggle_exclusive: 1,
        search: '',
        headers: [
          {
            text: 'SKU',
            align: 'start',
            sortable: false,
            value: 'SKU',
          },
          { text: 'Product Name', value: 'product_name', sortable: true, },
          { text: 'Unit Price', value: 'unit_price' },
          { text: 'Category', value: 'category.category' },
          { text: 'Available Quantity', value: 'quantity' },
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
      formatCurrency (value) {
          return '₱' + parseFloat(value)
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
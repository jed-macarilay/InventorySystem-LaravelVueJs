<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="items"
      sort-by="calories"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar
          flat
        >
          <v-toolbar-title>ITEMS</v-toolbar-title>
          <v-divider
            class="mx-4"
            inset
            vertical
          ></v-divider>
          <v-spacer></v-spacer>

          <v-dialog
            v-model="dialog"
            max-width="500px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                color="primary"
                dark
                class="mb-2"
                v-bind="attrs"
                v-on="on"
              >
                Add Item
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-form ref="form">
                    <v-row>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-autocomplete
                          v-model="editedItem.id"
                          :items="products"
                          label="Select Product"
                          item-text="product_name"
                          item-value="id" 
                          :rules="[v => !!v || 'Select Product is required']"
                          required
                        ></v-autocomplete>
                      </v-col>
                      <v-col
                        cols="12"
                        sm="6"
                        md="4"
                      >
                        <v-text-field
                          type="number"
                          v-model="editedItem.item_quantity"
                          label="Quantity"
                          :rules="quantityRule"
                          required
                          autofocus
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-form>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="blue darken-1"
                  text
                  @click="close"
                >
                  Cancel
                </v-btn>
                <v-btn
                  color="blue darken-1"
                  text
                  @click="save"
                >
                  {{ formButton }}
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>

          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon
          small
          class="mr-2"
          @click="editItem(item)"
        >
          fa fa-pencil
        </v-icon>
        <v-icon
          small
          @click="deleteItem(item)"
        >
          fa fa-trash
        </v-icon>
      </template>
      <template v-slot:item.unit_price="{ item }">
        {{ formatCurrency(item.unit_price) }}
      </template>
      <template v-slot:item.total="{ item }">
        <strong>{{ formatCurrency(item.total) }}</strong>
      </template>
    </v-data-table>
    <div class="mt-5">
      <h5>Subtotal: {{ formatCurrency(subtotal) }}</h5>
      <h5>Including 12% tax: {{ formatCurrency(tax) }}</h5>
      <v-divider></v-divider>
      <h3>
        <strong>Total: ₱ {{ getTotal() }}</strong>
      </h3>
    </div>

    <snackbar
      :show="snackbarShow"
      :message="message"
    />
  </div>
</template>

<script>
  import Snackbar from '../../../templates/Snackbar.vue'

  export default {
    components: {
      Snackbar,
    },
    data: () => ({
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          text: 'SKU',
          align: 'start',
          sortable: false,
          value: 'SKU',
        },
        { text: 'Product Name', value: 'product_name' },
        { text: 'Quantity', value: 'item_quantity' },
        { text: 'Unit Price', value:'unit_price' },
        { text: 'Total Amount', value:'total' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      products: [],
      items: [],
      editedIndex: -1,
      editedItem: {
        id: 0,
        product_name: '',
        serial_code: '',
        item_quantity: "1",
        total: "0",
      },
      defaultItem: {
        id: 0,
        product_name: '',
        serial_code: '',
        item_quantity: "1",
        total: "0",
      },
      quantityRule: [
        v => !!v || 'Quantity is required',
        v => (v && v > 0) || 'Item must have quantity',
      ],
      snackbarShow: false,
      message: '',
      subtotal: 0,
      tax: 0,
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
      },
      formButton () {
        return this.editedIndex === -1 ? 'Add Item' : 'Update Item'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
      this.fetchProducts()
    },

    methods: {
      fetchProducts() {
        axios.get(`/api/inventory/product/items`)
          .then(response => {
            this.products = response.data.data
          })
          .catch(error => console.log(error.response.data.message))
      },

      editItem (item) {
        this.editedIndex = this.items.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.items.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.items.splice(this.editedIndex, 1)
        this.$emit('get-item', this.items)
        this.closeDelete()
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        if(this.$refs.form.validate()) {
          if (this.editedIndex > -1) {
            this.editedItem.total = (Math.round((this.editedItem.unit_price * this.editedItem.item_quantity) * 100) / 100).toFixed(2)
            Object.assign(this.items[this.editedIndex], this.editedItem)
          } else {
            this.products.find((element) => {
              if(element.id === this.editedItem.id) {
                if((this.editedItem.item_quantity - element.quantity) > 0) {
                  this.snackbarShow = true
                  this.message = 'Added Item is failed, Quantity is invalid.'
                } else {
                  this.editedItem.SKU = element.SKU
                  this.editedItem.product_name = element.product_name
                  this.editedItem.unit_price = (Math.round(element.unit_price * 100) / 100).toFixed(2)
                  this.editedItem.total = (Math.round((element.unit_price * this.editedItem.item_quantity) * 100) / 100).toFixed(2)

                  this.items.push(this.editedItem)
                }
              }
            })
          }
          
          this.$emit('get-item', this.items)
          this.$refs.form.resetValidation()
          this.close()
        }
      },
      formatCurrency (value) {
        return '₱ ' + (Math.round(value * 100) / 100).toFixed(2)
      },
      getTotal() {
        let subtotal = 0
        let total = 0

        this.items.forEach(element => {
          subtotal = parseFloat(subtotal) + parseFloat(element.total)
          this.tax = subtotal * .12
          this.subtotal = subtotal
          total = subtotal + this.tax
        });

        return (Math.round(total * 100) / 100).toFixed(2)
      },
    },
  }
</script>
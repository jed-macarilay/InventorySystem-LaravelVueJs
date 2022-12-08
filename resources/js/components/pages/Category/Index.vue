<template>
    <div>
      <v-toolbar flat class="mt-n5">
        <v-toolbar-title>Product Category</v-toolbar-title>
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
                        href="/category/create"
                      >
                        <v-list-item-content>
                          <div class="mb-4">
                              <v-icon  x-large :color="active ? 'white' : '#49D9A0'">fa fa-plus-square</v-icon>
                          </div>
                          <v-list-item-subtitle :class="active ? 'white--text' : 'black--text'">Add new Category</v-list-item-subtitle>
                          <v-list-item-title class="headline mb-1" :class="active ? 'white--text' : 'black--text'">
                            <strong>{{ category.length }}</strong>
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
      <v-col cols="12" md="6">
        <v-data-table
          :headers="headers"
          :items="category"
          :items-per-page="5"
          class="mt-10 ml-5"
        ></v-data-table>
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
    name: "Inventory",
    components: {
      Snackbar,
    },
    data () {
      return {
        toggle_exclusive: 1,
        headers: [
          {
            text: 'Category',
            align: 'start',
            sortable: false,
            value: 'category',
          },
        ],
        category: [],
        message: '',
        snackbarShow: false,
      }
    },
    mounted() {
      this.fetchCategory()
    },
    methods: {
      fetchCategory() {
        axios.get(`/api/category`)
          .then(response => {
            this.category = response.data.data
          })
          .catch(error => console.log(error.response.data.message))
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
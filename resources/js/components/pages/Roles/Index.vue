<template>
  <div>
    <v-toolbar flat class="mt-n5">
      <v-toolbar-title>Roles</v-toolbar-title>
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
                      href="/roles/create"
                    >
                      <v-list-item-content>
                        <div class="mb-4">
                            <v-icon  x-large :color="active ? 'white' : '#218c74'">fa fa-plus-square</v-icon>
                        </div>
                        <v-list-item-subtitle :class="active ? 'white--text' : 'black--text'">Add new Role</v-list-item-subtitle>
                        <v-list-item-title class="headline mb-1" :class="active ? 'white--text' : 'black--text'">
                          <strong>{{ roles.length }}</strong>
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
    <v-row>
      <v-col
        cols="12"
        md="8"
      >
        <v-card class="pa-4 ml-5 elavation-0">
          <v-card-title>
            <v-toolbar-title class="ml-3">
              <strong>Role List</strong>
            </v-toolbar-title>
          </v-card-title>
          <v-data-table
            :search="search"
            :headers="headers"
            :items="roles"
            :items-per-page="5"
            class="mt-10 ml-5"
          ></v-data-table>
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
  name: "Role",
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
          text: 'Roles',
          align: 'start',
          sortable: false,
          value: 'role',
        },
      ],
      roles: [],
      message: '',
      snackbarShow: false,
    }
  },
  mounted() {
    this.fetchRole()
  },
  methods: {
    fetchRole() {
      axios.get(`/api/roles`)
        .then(response => {
          this.roles = response.data.data
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